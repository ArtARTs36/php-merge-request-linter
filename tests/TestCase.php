<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\NullClient;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array<Rule> $rules
     */
    protected function makeConfig(array $rules): Config
    {
        return new Config(
            Rules::make($rules),
            new Map([]),
            function () {
                return new NullClient();
            },
        );
    }

    protected function makeMergeRequest(array $data = []): MergeRequest
    {
        return MergeRequest::fromArray([
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'labels' => $data['labels'] ?? [],
            'has_conflicts' => false,
            'source_branch' => $data['source_branch'] ?? '',
            'target_branch' => $data['target_branch'] ?? '',
            'changed_files_count' => $data['changed_files_count'] ?? 1,
        ]);
    }

    protected function makeEnvironment(array $env): Environment
    {
        return new MapEnvironment(new Map($env));
    }

    protected function assertHasNotes(MergeRequest $request, Rule $rule, bool $expected): void
    {
        self::assertEquals($expected, count($rule->lint($request)) > 0);
    }

    protected function getPropertyValue(object $obj, string $prop): mixed
    {
        return (fn ($prop) => $this->$prop)->call($obj, $prop);
    }
}
