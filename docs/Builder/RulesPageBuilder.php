<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

use ArtARTs36\Str\Str;

class RulesPageBuilder
{
    protected string $namespace = 'ArtARTs36\MergeRequestLinter\\Rule\\';

    protected string $dir = __DIR__ . '/../../src/Rule/';

    public function build(): string
    {
        $files = glob(realpath($this->dir) . '/*Rule.php');
        $descriptions = Str::fromEmpty();

        $id = 0;

        foreach ($files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $class = $this->namespace . $filename;
            $comment = $this->getFirstDocCommentWhenNotAbstract($file);

            if ($comment === null) {
                continue;
            }

            if (! defined("$class::NAME")) {
                continue;
            }

            $ruleName = $class::NAME;

            $id++;

            $comment = trim(preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]?(.*)?#u', '$1', $comment));

            if ($id === 1) {
                $descriptions = $descriptions->append("| $id | $ruleName | $class | $comment |");
            } else {
                $descriptions = $descriptions->appendLine("| $id | $ruleName | $class | $comment |");
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
