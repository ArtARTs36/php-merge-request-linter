<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\GetCommentsInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\Input;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Input\UpdateCommentInput;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\GetCurrentUserSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema\MergeRequestSchema;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextProcessor;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;

class Client implements GitlabClient
{
    public function __construct(
        private readonly Authenticator      $credentials,
        private readonly ClientInterface    $client,
        private readonly MergeRequestSchema $schema,
        private readonly LoggerInterface    $logger,
        private readonly TextProcessor      $textProcessor,
        private readonly CommentSchema      $commentSchema = new CommentSchema(),
        private readonly GetCurrentUserSchema $currentUserSchema = new GetCurrentUserSchema(),
    ) {
    }

    public function getMergeRequest(MergeRequestInput $input): MergeRequest
    {
        $this->logger->info(sprintf('[GitlabClient] Fetching Merge Request with id %d', $input->requestId));

        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/changes",
            $input->apiUrl,
            $input->projectId,
            $input->requestId,
        );

        $request = new Request('GET', $url);
        $request = $this->credentials->authenticate($request);

        $resp = $this->client->sendRequest($request);

        $response = $this->textProcessor->decode($resp->getBody()->getContents());

        $mergeRequest = $this->schema->createMergeRequest($response);

        $this->logger->info(sprintf('[GitlabClient] Merge Request with id %d was fetched', $input->requestId));

        return $mergeRequest;
    }

    public function postComment(CommentInput $input): void
    {
        $this->logger->info(sprintf('[GitlabClient] Post comment for Merge Request with id %d', $input->requestNumber));

        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/notes",
            $input->apiUrl,
            $input->projectId,
            $input->requestNumber,
        );

        $body = $this->textProcessor->encode($this->commentSchema->createForm($input)->body);

        $request = new Request('POST', $url, headers: [
            'content-type' => 'application/json',
        ]);
        $request = $request->withBody(StreamBuilder::streamFor($body));
        $request = $this->credentials->authenticate($request);

        $createdComment = $this
            ->commentSchema
            ->createComment(
                $this
                    ->textProcessor
                    ->decode(
                        $this->client->sendRequest($request)->getBody()->getContents(),
                    ),
            );

        $this
            ->logger
            ->info(sprintf(
                '[GitlabClient] Post comment for Merge Request with id %d was created with id %d',
                $input->requestNumber,
                $createdComment->id,
            ));
    }

    public function getCurrentUser(Input $input): User
    {
        $this->logger->info('[GitlabClient] Get info about current user');

        $url = sprintf(
            "%s/api/v4/user",
            $input->apiUrl,
        );

        $request = new Request('GET', $url);
        $request = $this->credentials->authenticate($request);

        $user = $this
            ->currentUserSchema
            ->createUser(
                $this->textProcessor->decode($this->client->sendRequest($request)->getBody()->getContents()),
            );

        $this->logger->info(sprintf(
            '[GitlabClient] Info about current user was given: user with id %s',
            $user->id,
        ));

        return $user;
    }

    public function getCommentsOnMergeRequest(GetCommentsInput $input): Arrayee
    {
        $this->logger->info(sprintf('[GitlabClient] Post comment for Merge Request with id %d', $input->requestNumber));

        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/notes",
            $input->apiUrl,
            $input->projectId,
            $input->requestNumber,
        );

        $request = new Request('GET', $url);
        $request = $this->credentials->authenticate($request);

        return $this
            ->commentSchema
            ->createComments(
                $this
                    ->textProcessor
                    ->decode(
                        $this->client->sendRequest($request)->getBody()->getContents(),
                    ),
            );
    }

    public function updateComment(UpdateCommentInput $input): void
    {
        $this->logger->info(sprintf('[GitlabClient] Post comment for Merge Request with id %d', $input->requestNumber));

        $url = sprintf(
            "%s/api/v4/projects/%d/merge_requests/%d/notes/%d",
            $input->apiUrl,
            $input->projectId,
            $input->requestNumber,
            $input->commentId,
        );

        $body = $this->textProcessor->encode($this->commentSchema->createForm($input)->body);

        $request = new Request('PUT', $url, headers: [
            'content-type' => 'application/json',
        ]);
        $request = $request->withBody(StreamBuilder::streamFor($body));
        $request = $this->credentials->authenticate($request);

        $this->client->sendRequest($request);
    }
}
