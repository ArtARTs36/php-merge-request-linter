<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class NoSshKeysRule extends NamedRule
{
    public const NAME = '@mr-linter/no_ssh_rule';

    private const REGEXES = [
        'ssh-rsa' => '/ssh-rsa AAAA[0-9A-Za-z+\/]+[=]{0,3} ([^@]+@[^@]+)/',
    ];

    public function __construct(
        private readonly bool $stopOnFirstFailure = false,
    ) {
    }

    public function lint(MergeRequest $request): array
    {
        $notes = [];

        foreach ($request->changes as $change) {
            foreach (self::REGEXES as $keyType => $regex) {
                foreach ($change->diff as $line) {
                    if ($line->hasChanges() && $line->content->match($regex)->isNotEmpty()) {
                        $notes[] = new LintNote(sprintf(
                            'File "%s" contains ssh key (%s)',
                            $change->file,
                            $keyType,
                        ));

                        if ($this->stopOnFirstFailure) {
                            break 2;
                        }
                    }
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
