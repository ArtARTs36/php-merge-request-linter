<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\MetricStorage;

final class PushGateway implements MetricStorage
{
    public function __construct(
        private readonly Client $client,
        private readonly Renderer   $renderer,
    ) {
    }

    public function commit(string $id, iterable $collectors): void
    {
        $data = $this->renderer->render($collectors);

        $this->client->replace($id, $data);
    }
}
