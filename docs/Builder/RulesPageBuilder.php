<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ClassSummary;
use ArtARTs36\Str\Str;

class RulesPageBuilder
{
    protected string $namespace = 'ArtARTs36\MergeRequestLinter\\Application\\Rule\\Rules\\';

    protected string $dir = __DIR__ . '/../../src/Application/Rule/Rules';

    public function build(): string
    {
        $descriptions = Str::fromEmpty();

        $id = 0;

        foreach (DefaultRules::map() as $ruleName => $ruleClass) {
            $reflector = new \ReflectionClass($ruleClass);

            $id++;

            $comment = ClassSummary::findInPhpDocComment($reflector->getDocComment());

            if ($id === 1) {
                $descriptions = $descriptions->append("| $id | $ruleName | $ruleClass | $comment |");
            } else {
                $descriptions = $descriptions->appendLine("| $id | $ruleName | $ruleClass | $comment |");
            }
        }

        return <<<HTML
# Available Rules

Currently is available that rules:

| # | Name | Class | Description |
| ------------ | ------------ | ------------ | ------------ |
$descriptions
HTML;
    }

    protected function getFirstDocCommentWhenNotAbstract(string $filePath): ?string
    {
        $tokens = token_get_all(file_get_contents($filePath));

        foreach ($tokens as [$tokenIndex, $value]) {
            if ($tokenIndex === T_ABSTRACT) {
                return null;
            }

            if ($tokenIndex === T_DOC_COMMENT) {
                return $value;
            }
        }

        return null;
    }
}
