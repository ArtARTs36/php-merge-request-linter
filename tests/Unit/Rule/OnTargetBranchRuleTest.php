<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\OnTargetBranchRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\FailRule;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\SuccessRule;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class OnTargetBranchRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                'dev',
                new SuccessRule(),
                false,
            ],
            [
                $this->makeMergeRequest([
                    'target_branch' => 'dev',
                ]),
                'dev',
                new SuccessRule(),
                false,
            ],
            [
                $this->makeMergeRequest([
                    'target_branch' => 'dev',
                ]),
                'dev',
                new FailRule(),
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestLint
     * @covers \ArtARTs36\MergeRequestLinter\Rule\OnTargetBranchRule::lint
     */
    public function testLint(MergeRequest $request, string $targetBranch, Rule $rule, bool $hasNotes): void
    {
        self::assertHasNotes(
            $request,
            new OnTargetBranchRule($targetBranch, $rule),
            $hasNotes,
        );
    }
}
