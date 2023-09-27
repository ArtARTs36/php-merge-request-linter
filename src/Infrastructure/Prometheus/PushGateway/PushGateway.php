<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Prometheus\PushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

class PushGateway
{
    public function __construct(
        private readonly PushGatewayClient $client,
        private readonly Renderer $renderer,
    ) {
    }

    /**
     * @param iterable<Record> $records
     */
    public function push(string $job, iterable $records): void
    {
        $data = $this->renderer->render($records);

        $this->client->replace($job, $data);
    }
}
