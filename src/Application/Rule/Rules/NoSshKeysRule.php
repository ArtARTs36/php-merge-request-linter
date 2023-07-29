<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;
use ArtARTs36\Str\Str;

/**
 * Prevent ssh keys from being included in the merge request.
 * @phpstan-import-type SshKeyType from SshKeyFinder
 */
final class NoSshKeysRule extends NamedRule
{
    public const NAME = '@mr-linter/no_ssh_keys';

    public function __construct(
        private readonly SshKeyFinder $sshKeyFinder,
        private readonly bool $stopOnFirstFailure,
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

                $foundTypes = $this->findSshKeysTypes($line->content);

                if (count($foundTypes) === 0) {
                    continue;
                }

                foreach ($foundTypes as $keyType) {
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

    /**
     * @return array<SshKeyType>
     */
    private function findSshKeysTypes(Str $content): array
    {
        if ($this->stopOnFirstFailure) {
            $foundSshTypes = [];

            $foundSshType = $this->sshKeyFinder->findFirst($content);

            if ($foundSshType !== null) {
                $foundSshTypes = [$foundSshType];
            }

            return $foundSshTypes;
        }

        return $this->sshKeyFinder->findAll($content);
    }
}
