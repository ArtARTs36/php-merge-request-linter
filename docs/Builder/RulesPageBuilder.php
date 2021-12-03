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
            $name = pathinfo($file, PATHINFO_FILENAME);
            $class = $this->namespace . $name;
            $comment = $this->getFirstDocCommentWhenNotAbstract($file);

            if ($comment === null) {
                continue;
            }

            $id++;

            $comment = trim(preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ \t]?(.*)?#u', '$1', $comment));

            if ($id === 1) {
                $descriptions = $descriptions->append("| $id | $class | $comment |");
            } {
                $descriptions = $descriptions->appendLine("| $id | $class | $comment |");
            }
        }

        return <<<HTML
# Available Rules

Currently is available that rules:

| # | Class | Description |
| ------------ | ------------ | ------------ |
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
