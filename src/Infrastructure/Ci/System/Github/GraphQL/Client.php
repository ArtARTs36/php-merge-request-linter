<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GivenInvalidPullRequestDataException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\FetchTagsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\ContextLogger\ContextLogger;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change\Change;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Message\RequestInterface;

class Client implements GithubClient
{
    private const PAGE_ITEMS_LIMIT = 30;

    public function __construct(
        private readonly HttpClient        $client,
        private readonly Authenticator     $credentials,
        private readonly PullRequestSchema $pullRequestSchema,
        private readonly ContextLogger   $logger,
        private readonly TextDecoder       $textDecoder,
        private readonly ChangeSchema      $changeSchema,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $this->logger->info(sprintf('[GithubClient] Fetching Pull Request with id %d', $input->requestId));

        $prResponse = $this->client->sendRequest($this->createGetPullRequest($input));

        $pullRequest = $this->pullRequestSchema->createPullRequest(
            $this->textDecoder->decode($prResponse->getBody()->getContents()),
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

        $this->logger->shareContext('pull_request_id', $pullRequest->uri);

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

        $index = 0;

        foreach ($changesResponses as $response) {
            foreach ($this->textDecoder->decode($response->getBody()->getContents()) as $respChange) {
                if (! is_array($respChange)) {
                    throw GivenInvalidPullRequestDataException::invalidType('changes.' . $index, 'array');
                }

                $change = $this->changeSchema->createChange($respChange, $index++);

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

        $this->logger->clearContext('pull_request_id');

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
        $request = $this->credentials->authenticate($request);

        $response = $this->client->sendRequest($request);

        return $this->hydrateTags($this->textDecoder->decode($response->getBody()->getContents()));
    }

    private function createGetPullRequest(PullRequestInput $input): RequestInterface
    {
        $query = json_encode([
            'query' => $this->pullRequestSchema->createQuery($input),
        ]);

        $request = (new Request('POST', $input->graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query));

        return $this->credentials->authenticate($request);
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

        return $this->credentials->authenticate($request);
    }

    /**
     * @param array<mixed> $response
     */
    private function hydrateTags(array $response): TagCollection
    {
        $tags = [];

        foreach ($response as $resp) {
            if (! is_array($resp) || ! array_key_exists('name', $resp) || ! is_string($resp['name'])) {
                throw new FetchTagsException('Tag name not found in response');
            }

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
}
