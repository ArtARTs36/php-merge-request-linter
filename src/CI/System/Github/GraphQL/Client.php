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
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;

class Client implements GithubClient
{
    use InteractsWithResponse;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly RemoteCredentials $credentials,
        private readonly PullRequestSchema $pullRequestSchema,
        private readonly DiffMapper $diffMapper,
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $query = json_encode([
            'query' => $this->pullRequestSchema->createQuery($input),
        ]);

        $request = (new Request('POST', $input->graphqlUrl))
            ->withBody(StreamBuilder::streamFor($query));

        $request = $this->applyCredentials($request);

        $response = $this->client->sendRequest($request);

        $this->validateResponse($response, $input->graphqlUrl);

        $pullRequest = $this->pullRequestSchema->createPullRequest($this->responseToJsonArray($response));

        $pullRequest->changes = $this->getPullRequestFiles($input);

        return $pullRequest;
    }

    public function getTags(TagsInput $input): TagCollection
    {
        $url = sprintf('https://api.github.com/repos/%s/%s/tags', $input->owner, $input->repo);

        $request = new Request('GET', $url);
        $request = $this->applyCredentials($request);

        $response = $this->client->sendRequest($request);

        $this->validateResponse($response, $url);

        return $this->hydrateTags($this->responseToJsonArray($response));
    }

    /**
     * @return Change[]
     */
    private function getPullRequestFiles(PullRequestInput $input): array
    {
        $url = sprintf(
            'https://api.github.com/repos/%s/%s/pulls/%d/files',
            $input->owner,
            $input->repository,
            $input->requestId,
        );

        $request = new Request('GET', $url);
        $request = $this->applyCredentials($request);

        $response = $this->client->sendRequest($request);

        $this->validateResponse($response, $url);

        return $this->mapChanges($this->responseToJsonArray($response));
    }

    /**
     * @param array<array{filename: string, patch: string, status: string} $response
     * @return array<string, Change>
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
