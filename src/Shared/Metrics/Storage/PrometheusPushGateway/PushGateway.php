<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Value\Record;

class PushGateway implements MetricStorage
{
    public function __construct(
        private readonly Client   $client,
        private readonly Renderer $renderer,
    ) {
    }

    /**
     * @param iterable<Record> $records
     */
    public function commit(string $id, iterable $records): void
    {
        $data = $this->renderer->render($records);

        $this->client->replace($id, $data);
    }
}
