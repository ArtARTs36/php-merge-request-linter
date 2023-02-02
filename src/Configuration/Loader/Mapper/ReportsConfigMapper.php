<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Configuration\ReporterConfig;
use ArtARTs36\MergeRequestLinter\Configuration\ReportsConfig;

class ReportsConfigMapper
{
    /**
     * @param array<mixed> $array
     */
    public function map(array $array): ReportsConfig
    {
        $c = new ReporterConfig(
            $array['reporter']['uri'] ?? null,
            $array['reporter']['suppress_exceptions'] ?? false,
            new HttpClientConfig(
                $array['reporter']['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
                $array['reporter']['http_client']['params'] ?? [],
            ),
        );

        return new ReportsConfig($c);
    }
}
