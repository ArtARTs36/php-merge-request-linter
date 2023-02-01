<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Configuration\ReporterConfig;
use ArtARTs36\MergeRequestLinter\Configuration\ReportsConfig;
use ArtARTs36\MergeRequestLinter\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Environment\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Request\Data\Author;
use ArtARTs36\MergeRequestLinter\Request\Data\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;
use ArtARTs36\Str\Str;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array<Rule> $rules
     */
    protected function makeConfig(array $rules): Config
    {
        return new Config(
            Rules::make($rules),
            new ArrayMap([]),
            new HttpClientConfig(HttpClientConfig::TYPE_NULL),
            new ReportsConfig(new ReporterConfig('', false, new HttpClientConfig(HttpClientConfig::TYPE_NULL))),
        );
    }

    protected function makeMergeRequest(array $request = []): MergeRequest
    {
        return new MergeRequest(
            Str::make($request['title'] ?? ''),
            Str::make($request['description'] ?? ''),
            Set::fromList($request['labels'] ?? []),
            (bool) ($request['has_conflicts'] ?? false),
            Str::make($request['source_branch'] ?? ''),
            Str::make($request['target_branch'] ?? ''),
            new Author($request['author_login'] ?? ''),
            $request['is_draft'] ?? false,
            false,
            new ArrayMap($request['changes'] ?? []),
        );
    }

    protected function makeEnvironment(array $env): Environment
    {
        return new MapEnvironment(new ArrayMap($env));
    }

    protected function assertHasNotes(MergeRequest $request, Rule $rule, bool $expected): void
    {
        $notes = $rule->lint($request);

        self::assertEquals($expected, count($notes) > 0, sprintf(
            'Given %d notes: %s',
            count($notes),
            implode(', ', array_map(function (Note $note) {
                return $note->getDescription();
            }, $notes)),
        ));
    }

    protected function getPropertyValue(object $obj, string $prop): mixed
    {
        return (fn ($prop) => $this->$prop)->call($obj, $prop);
    }
}
