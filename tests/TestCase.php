<?php

namespace ArtARTs36\MergeRequestLinter\Tests;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintResult;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintState;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\Author;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\RequestException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\HttpRequestException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;
use ArtARTs36\MergeRequestLinter\Shared\Time\Duration;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\CounterLogger;
use ArtARTs36\Str\Str;
use GuzzleHttp\Psr7\Request;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @param array<Rule> $rules
     */
    protected function makeConfig(array $rules): Config
    {
        return new Config(
            new Rules($rules),
            new ArrayMap([]),
            new HttpClientConfig(HttpClientConfig::TYPE_NULL, []),
            new NotificationsConfig(new ArrayMap([]), new ArrayMap([])),
            new LinterConfig(
                new LinterOptions(false),
            ),
            new CommentsConfig(
                CommentsPostStrategy::Null,
                [],
            ),
        );
    }

    protected function makeMergeRequest(array $request = []): MergeRequest
    {
        return new MergeRequest(
            Str::make($request['title'] ?? ''),
            Str::make($request['description'] ?? '')->markdown(),
            Str::make($request['description'] ?? ''),
            Set::fromList($request['labels'] ?? []),
            (bool) ($request['has_conflicts'] ?? false),
            Str::make($request['source_branch'] ?? ''),
            Str::make($request['target_branch'] ?? ''),
            new Author(Str::make($request['author_login'] ?? '')),
            $request['is_draft'] ?? false,
            false,
            new ArrayMap($request['changes'] ?? []),
            new \DateTimeImmutable(),
            Str::fromEmpty(),
            $request['id'] ?? '',
        );
    }

    protected function makeSuccessLintResult(): LintResult
    {
        return new LintResult(LintState::Success, new Arrayee([]), new Duration(1));
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

    protected function mockLogger(): CounterLogger
    {
        return new CounterLogger();
    }

    protected function createHttpRequestException(): RequestException
    {
        return new HttpRequestException(new Request('GET', 'http://google.com'));
    }
}
