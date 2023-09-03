<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYouTrackIssueRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasLinkToYouTrackIssueRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                'ruleParams' => [
                    'domain' => 'yt.my-company.ru',
                    'projectCodes' => new Arrayee(['PORTAL']),
                ],
                'expectedNotes' => ['Description must contains link with task number of projects [PORTAL]'],
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'solve yt.my-company.ru/issue/PORTAL-1',
                ]),
                'ruleParams' => [
                    'domain' => 'yt.my-company.ru',
                    'projectCodes' => new Arrayee(['PORTAL']),
                ],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'solve yt.my-company.ru/issue/PORTAL-1',
                ]),
                'ruleParams' => [
                    'domain' => 'yt.my-company.ru',
                    'projectCodes' => new Arrayee(['PORTALA']),
                ],
                'expectedNotes' => ['Description contains link with task number of unknown project "PORTAL"'],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToYoutrackIssueRule::getDefinition
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectedNotes): void
    {
        $rule = new HasLinkToYouTrackIssueRule(...$ruleParams);

        self::assertSame(
            $expectedNotes,
            array_map('strval', $rule->lint($request)),
        );
    }
}
