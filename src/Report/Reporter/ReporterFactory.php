<?php

namespace ArtARTs36\MergeRequestLinter\Report\Reporter;

use ArtARTs36\MergeRequestLinter\Configuration\ReporterConfig;
use ArtARTs36\MergeRequestLinter\Contracts\Report\Reporter;
use ArtARTs36\MergeRequestLinter\Support\Http\ClientFactory;
use Psr\Log\LoggerInterface;

class ReporterFactory
{
    public function __construct(
        private readonly ClientFactory $client,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function create(ReporterConfig $params): Reporter
    {
        if ($params->uri !== null) {
            $httpReporter = new HttpReporter(
                $this->client->create($params->httpClient),
                $params->uri,
            );

            if ($params->suppressExceptions) {
                return new SuppressReporter($httpReporter, $this->logger);
            }

            return $httpReporter;
        }

        return new NullReporter();
    }
}
