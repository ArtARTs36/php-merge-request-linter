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
use ArtARTs36\MergeRequestLinter\Support\DiffMapper;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Message\RequestInterface;
use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client as HttpClient;

class Client implements GithubClient
{
    use InteractsWithResponse;

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
        $prRequest = $this->createGetPullRequest($input);
        $changesRequest = $this->createGetPullRequestFilesRequest($input);

        $reqs = [
            'pullRequest' => $prRequest,
            'changes' => $changesRequest,
        ];

        $responses = $this->client->sendAsyncRequests($reqs);

        $pullRequest = $this->pullRequestSchema->createPullRequest(
            $this->responseToJsonArray($responses['pullRequest']),
        );

        $pullRequest->changes = $this->mapChanges($this->responseToJsonArray($responses['changes']));

        return $pullRequest;
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

    private function createGetPullRequestFilesRequest(PullRequestInput $input): RequestInterface
    {
        $url = sprintf(
            'https://api.github.com/repos/%s/%s/pulls/%d/files',
            $input->owner,
            $input->repository,
            $input->requestId,
        );

        $request = new Request('GET', $url);

        return $this->applyCredentials($request);
    }

    /**
     * @param array<array{filename: string, patch: string, status: string}> $response
     * @return array<Change>
     */
    private function mapChanges(array $response): array
    {
        $changes = [];

        foreach ($response as $respChange) {
            $changes[] = new Change(
                $respChange['filename'],
                $this->diffMapper->map([$respChange['patch']]),
                Status::from($respChange['status']),
            );
        }

        return $changes;
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
