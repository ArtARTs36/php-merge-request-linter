<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\CreateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\PullRequestInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\Comment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\CommentList;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\PullRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema\Schemas;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextDecoder;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Log\LoggerInterface;

class Client
{
    public function __construct(
        private readonly Authenticator                                                      $credentials,
        private readonly \ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client $http,
        private readonly LoggerInterface                                                    $logger,
        private readonly TextDecoder                                                        $textDecoder,
        private readonly PullRequestSchema                                                  $pullRequestSchema,
        private readonly BitbucketDiffMapper                                                $diffMapper = new BitbucketDiffMapper(),
        private readonly Schemas $schemas = new Schemas(),
    ) {
        //
    }

    /**
     * @link https://developer.atlassian.com/cloud/bitbucket/rest/api-group-pullrequests/#api-repositories-workspace-repo-slug-pullrequests-pull-request-id-get
     */
    public function getPullRequest(PullRequestInput $input): PullRequest
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/repositories/%s/%s/pullrequests/%s',
            $input->projectKey,
            $input->repoName,
            $input->requestId,
        );

        $this->logger->info(sprintf(
            '[BitbucketClient] fetching pull request at url "%s"',
            $url,
        ));

        $request = new Request('GET', $url);

        $request = $this->credentials->authenticate($request);

        $response = $this->http->sendRequest($request);
        $responseArray = $this->textDecoder->decode($response->getBody()->getContents());

        $pr = $this->pullRequestSchema->createPullRequest($responseArray);
        $pr->changes = new MapProxy(function () use ($pr) {
            return new ArrayMap($this->fetchChanges($pr->diffUrl));
        });

        return $pr;
    }

    public function getCurrentUser(): User
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/user',
        );

        $request = new Request('GET', $url);
        $request = $this->credentials->authenticate($request);

        return $this
            ->schemas
            ->userGetCurrent
            ->createResponse(
                $this->textDecoder->decode($this->http->sendRequest($request)->getBody()->getContents()),
            );
    }

    public function getComments(PullRequestInput $input): CommentList
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/repositories/%s/%s/pullrequests/%s/comments',
            $input->projectKey,
            $input->repoName,
            $input->requestId,
        );

        $request = new Request('GET', $url);

        $request = $this->credentials->authenticate($request);

        $response = $this->http->sendRequest($request);

        return $this
            ->schemas
            ->commentsGet
            ->createResponse($this->textDecoder->decode($response->getBody()->getContents()));
    }

    public function updateComment(UpdateCommentInput $input): Comment
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/repositories/%s/%s/pullrequests/%s/comments/%s',
            $input->projectKey,
            $input->repoName,
            $input->requestId,
            $input->commentId,
        );

        $request = new Request('PUT', $url, [
            'content-type' => 'application/json',
        ]);

        $request = $this->credentials->authenticate($request);
        $request = $request->withBody(StreamBuilder::streamFor(json_encode([
            'content' => [
                'raw' => $input->comment,
            ],
        ])));

        return $this
            ->schemas
            ->commentCreate
            ->createResponse(
                $this->textDecoder->decode(
                    $this->http->sendRequest($request)->getBody()->getContents(),
                ),
            );
    }

    public function postComment(CreateCommentInput $input): Comment
    {
        $url = sprintf(
            'https://api.bitbucket.org/2.0/repositories/%s/%s/pullrequests/%s/comments',
            $input->projectKey,
            $input->repoName,
            $input->requestId,
        );

        $request = new Request('POST', $url, [
            'content-type' => 'application/json',
        ]);

        $request = $this->credentials->authenticate($request);
        $request = $request->withBody(StreamBuilder::streamFor(json_encode([
            'content' => [
                'raw' => $input->comment,
            ],
        ])));

        return $this
            ->schemas
            ->commentCreate
            ->createResponse(
                $this->textDecoder->decode(
                    $this->http->sendRequest($request)->getBody()->getContents(),
                ),
            );
    }

    /**
     * @return array<string, Diff>
     */
    private function fetchChanges(string $url): array
    {
        $req = $this->credentials->authenticate(new Request('GET', $url));

        $resp = $this->http->sendRequest($req);

        return $this->diffMapper->map($resp->getBody()->getContents());
    }
}
