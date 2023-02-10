<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\Rules;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Common\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
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
            new Author(Str::make($request['author_login'] ?? '')),
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
