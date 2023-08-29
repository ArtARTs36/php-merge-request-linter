<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0.
 * @link https://www.conventionalcommits.org/en/v1.0.0
 */
final class TitleConventionalRule extends NamedRule
{
    public const NAME = '@mr-linter/title_conventional';

    private const REGEX = '/^([a-z]+){1}(\([\w\-\.]+\))?(!)?: ([\w ])+([\s\S]*)/mis';

    private const DEFAULT_TYPES = [
        'build',
        'chore',
        'ci',
        'docs',
        'feat',
        'fix',
        'perf',
        'refactor',
        'revert',
        'style',
        'test',
    ];

    /**
     * @param Arrayee<int, string> $types
     */
    public function __construct(
        #[Generic(Generic::OF_STRING)]
        private readonly Arrayee $types,
    ) {
    }

    /**
     * @param Arrayee<int, string>|null $types
     */
    public static function make(
        #[Generic(Generic::OF_STRING)]
        #[Description('Commit types')]
        #[Example('build')]
        #[Example('chore')]
        #[Example('ci')]
        #[Example('docs')]
        #[Example('feat')]
        #[Example('fix')]
        #[Example('perf')]
        #[Example('refactor')]
        #[Example('revert')]
        #[Example('style')]
        #[Example('test')]
        ?Arrayee $types = null,
    ): self {
        $types ??= new Arrayee(self::DEFAULT_TYPES);

        return new self($types);
    }

    public function lint(MergeRequest $request): array
    {
        $matches = [];

        preg_match(self::REGEX, $request->title, $matches);

        if (! array_key_exists(1, $matches) || ! is_string($matches[1])) {
            return [new LintNote('The title must matches with conventional commit')];
        }

        $type = $matches[1];

        if (! $this->types->contains($type)) {
            return [new LintNote(sprintf('Title conventional: type "%s" is unknown', $type))];
        }

        return [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'The title must matches with conventional commit with types: [%s]',
            $this->types->implode(', '),
        ));
    }
}
