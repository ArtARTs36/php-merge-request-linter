<?php

namespace ArtARTs36\MergeRequestLinter\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Contracts\HTTP\Client;
use ArtARTs36\MergeRequestLinter\Contracts\Report\Reporter;
use ArtARTs36\MergeRequestLinter\Exception\ReportSendingFailed;
use ArtARTs36\MergeRequestLinter\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Report\Metrics\Record;
use ArtARTs36\MergeRequestLinter\Report\Reporter\Http\RecordMapper;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Utils as StreamBuilder;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;

class HttpReporter implements Reporter
{
    public function __construct(
        private readonly Client $client,
        private readonly string $uri,
        private readonly RecordMapper $recordMapper = new RecordMapper(),
    ) {
        //
    }

    public function report(LintResult $result, Arrayee $records): void
    {
        $data = [
            'result' => $result->state,
            'duration' => $result->duration->seconds,
            'notes' => [],
            'metrics' => [],
        ];

        /** @var LintNote $note */
        foreach ($result->notes as $note) {
            $data['notes'] = [
                'severity' => $note->getSeverity()->value,
                'description' => $note->getDescription(),
            ];
        }

        /** @var Record $record */
        foreach ($records as $record) {
            $data['metrics'][] = $this->recordMapper->map($record);
        }

        try {
            $this->client->sendRequest(
                $this->createRequest($data),
            );
        } catch (ClientExceptionInterface $e) {
            throw new ReportSendingFailed($e->getMessage(), previous: $e);
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function createRequest(array $data): RequestInterface
    {
        return (new Request('POST', $this->uri))
            ->withBody(StreamBuilder::streamFor(json_encode($data)));
    }
}
