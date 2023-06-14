<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API;

use ArtARTs36\ContextLogger\Contracts\ContextLogger;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\AddCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\AddCommentSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema\ViewerSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\Change;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\ChangeSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\FetchTagsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GivenInvalidPullRequestDataException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GithubClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client as HttpClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
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
        private readonly AddCommentSchema $addCommentSchema = new AddCommentSchema(),
        private readonly ViewerSchema      $viewerSchema = new ViewerSchema(),
        private readonly TagHydrator $tagHydrator = new TagHydrator(),
    ) {
        //
    }

    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $this->logger->info(sprintf('[GithubClient] Fetching Pull Request with id %d', $input->requestId));

        $prResponse = $this->runQuery($input->graphqlUrl, $this->pullRequestSchema->createQuery($input));

        $pullRequest = $this->pullRequestSchema->createPullRequest($prResponse);

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

        return $this->tagHydrator->hydrate(
            $this->textDecoder->decode($response->getBody()->getContents()),
        );
    }

    public function postCommentOnPullRequest(AddCommentInput $input): string
    {
        $comment = $this
            ->addCommentSchema
            ->createComment(
                $this->runQuery($input->graphqlUrl, $this->addCommentSchema->createMutation($input)),
            );

        $this->logger->info(sprintf('Comment for PR with id "%s" was  d', $input->subjectId), [
            'pull_request_id' => $input->subjectId,
            'comment_message' => $input->message,
            'comment_id' => $comment->id,
        ]);

        return $comment->id;
    }

    public function getCurrentUser(string $graphqlUrl): Viewer
    {
        return $this
            ->viewerSchema
            ->createViewer($this->runQuery($graphqlUrl, $this->viewerSchema->createQuery()));
    }

    private function runQuery(string $graphqlUrl, Query $query): array
    {
        $body = json_encode([
            'query' => $query->query,
            'variables' => $query->variables,
        ]);

        $request = (new Request('POST', $graphqlUrl))
            ->withBody(StreamBuilder::streamFor($body));

        $request = $this->credentials->authenticate($request);

        return $this
            ->textDecoder
            ->decode($this->client->sendRequest($request)->getBody()->getContents());
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
}
