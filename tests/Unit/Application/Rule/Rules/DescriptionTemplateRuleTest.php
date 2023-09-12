<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionTemplateRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class DescriptionTemplateRuleTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            [
                'request' => $this->makeMergeRequest([
                    'description' => '',
                ]),
                'ruleParams' => [
                    'template' => <<<HTML
## Added
{text_multiline}
HTML,
                ],
                'expectedNotes' => [
                    'Description template: the description must match template',
                ],
            ],
            [
                'request' => $this->makeMergeRequest([
                    'description' => '## Added',
                ]),
                'ruleParams' => [
                    'template' => <<<HTML
## Added
{text_multiline}
HTML,
                ],
                'expectedNotes' => [
                    'Description template: the description must match template',
                ],
            ],
            [
                'request' => $this->makeMergeRequest([
                    'description' => <<<HTML
## Added
abc text
HTML,
                ]),
                'ruleParams' => [
                    'template' => <<<HTML
## Added
{text_multiline}
HTML,
                ],
                'expectedNotes' => [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionTemplateRule::lint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionTemplateRule::doLint
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionTemplateRule::getDefinition
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionTemplateRule::__construct
     *
     * @dataProvider providerForTestLint
     */
    public function testLint(MergeRequest $request, array $ruleParams, array $expectedNotes): void
    {
        $rule = new DescriptionTemplateRule($ruleParams['template']);

        self::assertRuleNotes($request, $rule, $expectedNotes);
    }
}
