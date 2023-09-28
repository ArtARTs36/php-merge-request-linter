<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway;

/**
 * Interface for PushGateway Client.
 */
interface Client
{
    /**
     * Replace job metrics data.
     *
     * @param non-empty-string $job
     */
    public function replace(string $job, string $data): void;
}
