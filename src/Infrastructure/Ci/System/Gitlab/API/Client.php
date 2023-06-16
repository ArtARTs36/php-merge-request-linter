<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextProcessor;
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
    ) {
        //
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
}
