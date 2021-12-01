<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

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
}
