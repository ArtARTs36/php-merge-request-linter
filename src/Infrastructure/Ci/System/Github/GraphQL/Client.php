<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Domain\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\Change;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\Status;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;

class Client implements GithubClient
{
    use InteractsWithResponse;

    private const PAGE_ITEMS_LIMIT = 30;

    public function __construct(
        private readonly HttpClient        $client,
        private readonly RemoteCredentials $credentials,
        private readonly PullRequestSchema $pullRequestSchema,
        private readonly DiffMapper        $diffMapper,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $this->logger->info(sprintf('[GithubClient] Fetching Pull Request with id %d', $input->requestId));

        $pullRequest = $this->pullRequestSchema->createPullRequest(
            $this->responseToJsonArray($this->client->sendRequest($this->createGetPullRequest($input))),
        );

        $this->logger->info(sprintf('[GithubClient] Pull Request with id %d was fetched', $input->requestId));
        $this->logger->debug(sprintf('[GithubClient] Loading changes delayed until the first request'));

        $pullRequest->changes = new MapProxy(function () use ($input, $pullRequest) {
            return $this->fetchChanges($input, $pullRequest);
        }, $pullRequest->changedFiles);

        return $pullRequest;
    }

    /**
     * @return Map<string, Change>
     */
    private function fetchChanges(PullRequestInput $input, PullRequest $pullRequest): Map
    {
        $changesPages = $this->calculateChangesPages($pullRequest->changedFiles);
        $reqs = [];

        $this->logger->info(
            sprintf(
                '[GithubClient] Fetching changes for Pull Request with id %d. PR has %d changes, defined %d pages for loading changes',
                $input->requestId,
                $pullRequest->changes->count(),
                $changesPages,
            ),
        );

        for ($page = 1; $page < $changesPages + 1; $page++) {
            $reqs[$page] = $this->createGetPullRequestFilesRequest($input, $page);
        }

        $changesResponses = $this->client->sendAsyncRequests($reqs);

        $changes = [];

        foreach ($changesResponses as $response) {
            foreach ($this->responseToJsonArray($response) as $respChange) {
                $change = $this->mapChange($respChange);

                $changes[$change->filename] = $change;
            }
        }

        $this->logger->info(
            sprintf(
                '[GithubClient] Loaded %d changes for PR with id %d',
                count($changes),
                $input->requestId,
            ),
        );

        return new ArrayMap($changes);
    }

    private function calculateChangesPages(int $changes): int
    {
        if ($changes > self::PAGE_ITEMS_LIMIT) {
            return (int) ceil($changes / self::PAGE_ITEMS_LIMIT);
        }

        return 1;
    }

    public function getTags(TagsInput $input): TagCollection
    {
        $url = sprintf('https://api.github.com/repos/%s/%s/tags', $input->owner, $input->repo);

        $request = new Request('GET', $url);
        $request = $this->applyCredentials($request);

        $response = $this->client->sendRequest($request);

        return $this->hydrateTags($this->responseToJsonArray($response));
    }

    private function createGetPullRequest(PullRequestInput $input): RequestInterface
    {
        $query = json_encode([
            'query' => $this->pullRequestSchema->createQuery($input),
        ]);

        $request = (new Request('POST', $input->graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query));

        return $this->applyCredentials($request);
    }

    private function createGetPullRequestFilesRequest(PullRequestInput $input, int $page): RequestInterface
    {
        $url = sprintf(
            'https://api.github.com/repos/%s/%s/pulls/%d/files?page=%d',
            $input->owner,
            $input->repository,
            $input->requestId,
            $page,
        );

        $request = new Request('GET', $url);

        return $this->applyCredentials($request);
    }

    /**
     * @param array{filename: string, patch: string, status: string} $respChange
     */
    private function mapChange(array $respChange): Change
    {
        return new Change(
            $respChange['filename'],
            $this->diffMapper->map([$respChange['patch'] ?? '']),
            Status::from($respChange['status']),
        );
    }

    /**
     * @param array<array{name: string}> $response
     */
    private function hydrateTags(array $response): TagCollection
    {
        $tags = [];

        foreach ($response as $resp) {
            $name = Str::make($resp['name']);

            if ($name->startsWith('v')) {
                $name = $name->cut(null, 1);
            }

            [$major, $minor, $patch] = $name->explode('.')->toIntegers();

            $tags[] = new Tag(
                $resp['name'],
                $major,
                $minor,
                $patch,
            );
        }

        return new TagCollection($tags);
    }

    private function applyCredentials(RequestInterface $request): RequestInterface
    {
        if ($this->credentials->getToken() !== '') {
            $request = $request->withHeader('Authorization', 'bearer ' . $this->credentials->getToken());
        }

        return $request;
    }
}
