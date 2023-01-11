<?php

namespace ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL;

use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Change\Change;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Change\Status;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\PullRequest\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\Tag;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GraphQL\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\CI\System\InteractsWithResponse;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Contracts\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Request\Data\Diff\DiffMapper;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\MapProxy;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Message\RequestInterface;

class Client implements GithubClient
{
    use InteractsWithResponse;

    private const PAGE_ITEMS_LIMIT = 30;

    public function __construct(
        private readonly HttpClient        $client,
        private readonly RemoteCredentials $credentials,
        private readonly PullRequestSchema $pullRequestSchema,
        private readonly DiffMapper        $diffMapper,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $pullRequest = $this->pullRequestSchema->createPullRequest(
            $this->responseToJsonArray($this->client->sendRequest($this->createGetPullRequest($input))),
        );

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
        $changesPages = (int) round($pullRequest->changedFiles / self::PAGE_ITEMS_LIMIT);
        $reqs = [];

        for ($page = 0; $page < $changesPages; $page++) {
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

        return new ArrayMap($changes);
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
            $this->diffMapper->map([$respChange['patch']]),
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
