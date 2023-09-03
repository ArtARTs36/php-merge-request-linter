<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class HasLinkToJiraTaskRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                $this->makeMergeRequest(),
                'ruleParams' => [
                    'domain' => 'jira.my-company.ru',
                    'projectCodes' => new Arrayee([
                        'MY-PROJECT',
                    ]),
                ],
                'expectedNotes' => ['The description must have a link to Jira on domain "jira.my-company.ru"'],
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'link to http://jira.my-company.ru/browse/ABC-1',
                ]),
                'ruleParams' => [
                    'domain' => 'jira.my-company.ru',
                    'projectCodes' => new Arrayee([]),
                ],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'link to http://jira.my-company.ru/browse/ABC-1',
                ]),
                'ruleParams' => [
                    'domain' => 'jira.my-company.ru',
                    'projectCodes' => new Arrayee([
                        'ABC',
                    ]),
                ],
                'expectedNotes' => [],
            ],
            [
                $this->makeMergeRequest([
                    'description' => 'link to http://jira.my-company.ru/browse/ABC-1',
                ]),
                'ruleParams' => [
                    'domain' => 'jira.my-company.ru',
                    'projectCodes' => new Arrayee([
                        'ABCD',
                    ]),
                ],
                'expectedNotes' => [
                    'Description contains link with task number of unknown project "ABC"',
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::__construct
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasLinkToJiraTaskRule::getDefinition
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectedNotes): void
    {
        $rule = new HasLinkToJiraTaskRule(...$ruleParams);

        self::assertSame(
            $expectedNotes,
            array_map('strval', $rule->lint($request)),
        );
    }
}
