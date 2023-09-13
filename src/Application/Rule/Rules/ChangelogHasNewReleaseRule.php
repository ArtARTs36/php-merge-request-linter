<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule\ChangesConfig;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule\Release;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\ChangelogHasNewReleaseRule\ReleaseParser;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Domain\Request\Diff;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Set;

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
        #[Description('Configuration for changes reading')]
        private readonly ChangesConfig $changes,
        private readonly ReleaseParser $releaseParser,
    ) {
    }

    public function lint(MergeRequest $request): array
    {
        $change = $this->getChangelog($request);

        if ($change === null) {
            if ($this->file !== null) {
                return [
                    new LintNote(sprintf(
                        'Changelog(file: %s) must be contained new release. Changelog not modified',
                        $this->file,
                    )),
                ];
            }

            return [
                new LintNote('Changelog must be contained new release. Changelog not modified'),
            ];
        }

        $notes = [];
        $oldTags = $this->collectOldTagsSet($change->diff);

        foreach ($change->diff->newFragments as $diffFragment) {
            $releases = $this->releaseParser->parse($diffFragment->content);

            foreach ($releases as $release) {
                if ($oldTags->contains($release->tag)) {
                    $notes[] = new LintNote(sprintf(
                        'Changelog(file: %s): old release %s was modified',
                        $change->file,
                        $release->tag,
                    ));

                    continue;
                }

                if (count($release->changes) > 0) {
                    $releaseChangesNotes = $this->lintReleaseChanges($release, $change);

                    if (count($releaseChangesNotes) === 0) {
                        return [];
                    }

                    array_push($notes, ...$releaseChangesNotes);

                    continue;
                }

                $notes[] = new LintNote(sprintf(
                    'Changelog(file: %s): release %s not contains changes',
                    $change->file,
                    $release->tag,
                ));
            }
        }

        if (count($notes) > 0) {
            return $notes;
        }

        if ($change->diff->hasChanges()) {
            return [
                new LintNote(sprintf('Changelog(file: %s) was modified, but no has new release', $change->file)),
            ];
        }

        return [
            new LintNote(sprintf(
                'Changelog(file: %s) must be contained new release',
                $change->file,
            )),
        ];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Changelog must be contained new release');
    }

    /**
     * @return array<LintNote>
     */
    private function lintReleaseChanges(Release $release, Change $changelog): array
    {
        $notes = [];

        foreach ($release->changes as $changes) {
            if (! $this->changes->types->contains($changes->type)) {
                $notes[] = new LintNote(sprintf(
                    'Changelog(file: %s): release %s contains unknown change type "%s"',
                    $changelog->file,
                    $release->tag,
                    $changes->type,
                ));
            }
        }

        return $notes;
    }

    /**
     * @return Set<string>
     */
    private function collectOldTagsSet(Diff $diff): Set
    {
        /** @var Set<string> $tags */
        $tags = Set::empty();

        foreach ($diff->oldFragments as $fragment) {
            $tags = $tags->merge($this->releaseParser->parseTags($fragment->content));
        }

        return $tags;
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
