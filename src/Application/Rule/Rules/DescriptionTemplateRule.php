<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\Str\Facade\Str;

final class DescriptionTemplateRule extends AbstractRule
{
    public const NAME = '@mr-linter/description_template';

    public function __construct(
        #[Description('Template for description')]
        private readonly string $template,
        #[Description('Custom definition')]
        private readonly ?string $definition = null,
    ) {
    }

    protected function doLint(MergeRequest $request): bool
    {
        return $request
            ->descriptionMarkdown
            ->str()
            ->trim()
            ->replace([
                "\r\n" => "\n",
            ])
            ->matchTemplate(Str::trim($this->template))
            ->matched;
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'Description template: %s',
            $this->definition ?? 'the description must match template',
        ));
    }
}
