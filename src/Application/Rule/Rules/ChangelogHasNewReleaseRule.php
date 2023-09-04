<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ChangesConfig;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\Release;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\KeepChangelogRule\ReleaseParser;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;

#[Description('Changelog must be contained new release.')]
final class ChangelogHasNewReleaseRule extends NamedRule implements Rule
{
    public const NAME = '@mr-linter/changelog_has_new_release';

    private const FILENAMES = [
        'CHANGELOG',
        'CHANGELOG.md',
    ];

    public function __construct(
        #[Description('Relative path to changelog file')]
        #[Example('CHANGELOG.md')]
        private readonly ?string       $file,
        #[Description('Tags parsing options')]
        private readonly ChangesConfig $changes,
        private readonly ReleaseParser $releaseParser,
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $change = $this->getChangelog($request);

        if ($change === null) {
            return [
                new LintNote('Changelog must be contained new release. Changelog not modified'),
            ];
        }

        $notes = [];

        foreach ($change->diff->newFragments as $diffFragment) {
            $releases = $this->releaseParser->parse($diffFragment->content);

            foreach ($releases as $release) {
                if (count($release->changes) > 0) {
                    $releaseChangesNotes = $this->lintReleaseChanges($release);

                    if (count($releaseChangesNotes) === 0) {
                        return [];
                    }

                    array_push($notes, ...$releaseChangesNotes);

                    continue;
                }

                $notes[] = new LintNote(sprintf(
                    'Changelog: release %s not contains changes',
                    $release->tag,
                ));
            }
        }

        if (count($notes) > 0) {
            return $notes;
        }

        if (! $change->diff->newFragments->isEmpty()) {
            return [
                new LintNote('Changelog was modified, but no has new release'),
            ];
        }

        return [
            new LintNote($this->getDefinition()->getDescription()),
        ];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Changelog must be contained new release');
    }

    /**
     * @return array<LintNote>
     */
    private function lintReleaseChanges(Release $release): array
    {
        $notes = [];

        foreach ($release->changes as $changes) {
            if (! $this->changes->types->contains($changes->type)) {
                $notes[] = new LintNote(sprintf(
                    'Changelog: release %s contains unknown change type "%s"',
                    $release->tag,
                    $changes->type,
                ));
            }
        }

        return $notes;
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
