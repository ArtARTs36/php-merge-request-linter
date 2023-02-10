<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\CompositeChecker;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\ContainsChecker;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\ContainsRegexChecker;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\DiffChecker;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\NeedFileChange;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasChangesRule\UpdatedPhpConstantChecker;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Support\Reflector\Generic;

/**
 * Merge Request must have changes in {files}.
 */
class HasChangesRule implements Rule
{
    public const NAME = '@mr-linter/has_changes';

    /**
     * @param Arrayee<int, NeedFileChange> $changes
     */
    public function __construct(
        private readonly Arrayee $changes,
        private readonly DiffChecker $diffChecker,
    ) {
        //
    }

    /**
     * @param Arrayee<int, NeedFileChange> $changes
     */
    public static function make(#[Generic(NeedFileChange::class)] Arrayee $changes): self
    {
        return new self($changes, new CompositeChecker([
            new ContainsChecker(),
            new ContainsRegexChecker(),
            new UpdatedPhpConstantChecker(),
        ]));
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($this->changes as $needChange) {
            $requestChange = $request->changes->get($needChange->file);

            if ($requestChange === null) {
                $notes[] = new LintNote(
                    sprintf('Request must contain change in file: %s', $needChange->file),
                );

                continue;
            }

            if (! $needChange->hasConditions()) {
                continue;
            }

            array_push($notes, ...$this->diffChecker->check($needChange, $requestChange));
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        if ($this->changes->once()) {
            return new Definition(sprintf('Merge Request must have changes in file: %s', $this->changes->first()?->file));
        }

        return new Definition(
            sprintf('Merge Request must have changes in files: [%s]', $this->changes->implode(', ')),
        );
    }
}
