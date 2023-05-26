<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\Note;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rule;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

final class MockRule implements Rule
{
    /**
     * @param array<Note> $notes
     */
    public function __construct(
        private readonly array $notes,
    ) {
        //
    }

    public function getName(): string
    {
        return 'mock_note';
    }

    public function lint(MergeRequest $request): array
    {
        return $this->notes;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition('mock_rule');
    }
}
