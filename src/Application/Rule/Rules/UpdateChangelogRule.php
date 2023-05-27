<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\UpdateChangelogRule\Tags;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;

/**
 * Changelog must be contained new tag.
 */
class UpdateChangelogRule extends NamedRule implements Rule
{
    public const NAME = '@mr-linter/update_changelog';

    private const FILENAMES = [
        'CHANGELOG',
        'CHANGELOG.md',
    ];

    public function __construct(
        #[Description('Relative path to changelog file')]
        private readonly ?string $file,
        #[Description('Tags parsing options')]
        private readonly Tags $tags,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $change = $this->getChangelog($request);

        if ($change === null) {
            return [
                new LintNote($this->getDefinition()->getDescription()),
            ];
        }

        $hasChanges = false;
        $newTagFound = false;
        $hasHeadingsWithoutRegexMatch = false;

        foreach ($change->diff as $line) {
            if (! $line->hasChanges()) {
                continue;
            }

            $hasChanges = true;

            $headings = $line
                ->content
                ->markdown()
                ->headings(true)
                ->filterByLevel($this->tags->heading->level);

            if ($headings->isEmpty()) {
                continue;
            }

            if ($this->tags->heading->regex !== null) {
                foreach ($headings as $heading) {
                    if ($heading->title->contains($this->tags->heading->regex->expression, true)) {
                        $newTagFound = true;

                        break;
                    } else {
                        $hasHeadingsWithoutRegexMatch = true;
                    }
                }

                continue;
            }

            $newTagFound = true;
        }

        if ($newTagFound) {
            return [];
        }

        if ($hasHeadingsWithoutRegexMatch && $this->tags->heading->regex?->example !== null) {
            return [
                new LintNote(sprintf(
                    'Changelog has new headings, but no matched by regex "%s", example: "%s"',
                    $this->tags->heading->regex->expression,
                    $this->tags->heading->regex->example,
                )),
            ];
        }

        if ($hasChanges) {
            return [
                new LintNote('Changelog has changes, but hasn\'t new tag'),
            ];
        }

        return [
            new LintNote($this->getDefinition()->getDescription()),
        ];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Changelog must be contained new tag');
    }

    private function getChangelog(MergeRequest $request): ?Change
    {
        if ($this->file !== null) {
            return $request->changes->get($this->file);
        }

        foreach (self::FILENAMES as $filename) {
            $cl = $request->changes->get($filename);

            if ($cl !== null) {
                return $cl;
            }
        }

        return null;
    }
}
