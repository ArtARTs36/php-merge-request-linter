<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleConventionalRule;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Regex\ProjectCode;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NamedRule;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\Str\Str;

#[Description('The title must match conventional commit pattern https://www.conventionalcommits.org/en/v1.0.0.')]
final class TitleConventionalRule extends NamedRule
{
    public const NAME = '@mr-linter/title_conventional';

    private const REGEX = '/^(?<type>([a-z]+)){1}(?<module>\([\w\-\.]+\))?(!)?: (?<description>([\w ])+([\s\S]*))/mis';

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
        private readonly ?TitleConventionalTask $task,
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
        #[Description('Check if title contains task number')]
        ?TitleConventionalTask $task = null,
    ): self {
        $types ??= new Arrayee(self::DEFAULT_TYPES);

        return new self($types, $task);
    }

    public function lint(MergeRequest $request): array
    {
        $matches = [];

        preg_match(self::REGEX, $request->title, $matches);

        if (! array_key_exists('type', $matches) || ! is_string($matches['type'])) {
            return [new LintNote('The title must matches with conventional commit')];
        }

        $type = $matches['type'];
        $description = Str::make($matches['description']);

        $notes = [];

        if (($taskNotes = $this->checkTask($description))) {
            $notes = $taskNotes;
        }

        if (! $this->types->contains($type)) {
            $notes[] = new LintNote(sprintf('Title conventional: type "%s" is unknown', $type));
        }

        return $notes;
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

    /**
     * @return array<Note>
     */
    private function checkTask(Str $description): array
    {
        if ($this->task === null) {
            return [];
        }

        $projectCode = ProjectCode::findInStartWithTaskNumber($description);

        if ($projectCode === null) {
            if (! $this->task->projectCodes->isEmpty()) {
                return [new LintNote(
                    sprintf(
                        'Description of title must starts with task number of projects ["%s"]',
                        $this->task->projectCodes->implode(', '),
                    )
                ),
                ];
            }

            return [new LintNote('Description of title must starts with task number')];
        }

        if (! $this->task->projectCodes->isEmpty() && ! $this->task->projectCodes->contains($projectCode->__toString())) {
            return [new LintNote(sprintf(
                'The title contains unknown project code "%s"',
                $projectCode,
            ))];
        }

        return [];
    }
}
