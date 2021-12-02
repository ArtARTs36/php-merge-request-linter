<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Support\Map;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function makeMergeRequest(array $data = []): MergeRequest
    {
        return MergeRequest::fromArray([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'labels' => $data['labels'] ?? [],
            'has_conflicts' => false,
        ]);
    }

    protected function makeEnvironment(array $env): Environment
    {
        return new MapEnvironment(new Map($env));
    }
}
