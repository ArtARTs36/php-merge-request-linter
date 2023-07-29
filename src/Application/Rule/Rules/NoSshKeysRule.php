<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;

final class NoSshKeysRule extends NamedRule
{
    public const NAME = '@mr-linter/no_ssh_rule';

    public function __construct(
        private readonly SshKeyFinder $sshKeyFinder,
        private readonly bool $stopOnFirstFailure = false,
    ) {
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($request->changes as $change) {
            foreach ($change->diff->newFragments as $line) {
                if (! $line->hasChanges()) {
                    continue;
                }

                $foundSshTypes = $this->sshKeyFinder->find($line->content, $this->stopOnFirstFailure);

                if (count($foundSshTypes) === 0) {
                    continue;
                }

                foreach ($foundSshTypes as $keyType) {
                    $notes[] = new LintNote(sprintf(
                        'File "%s" contains ssh key (%s)',
                        $change->file,
                        $keyType,
                    ));
                }

                if ($this->stopOnFirstFailure) {
                    break 2;
                }
            }
        }

        return $notes;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('Request must no contain ssh keys');
    }
}
