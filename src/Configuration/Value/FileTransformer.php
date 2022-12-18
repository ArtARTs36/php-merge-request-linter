<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Value;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigValueTransformer;
use ArtARTs36\Str\Facade\Str;

class FileTransformer implements ConfigValueTransformer
{
    private const EXPRESSION_LEFT = 'file(';
    private const EXPRESSION_RIGHT = ')';
    private const EXPRESSION_LEFT_OFFSET = 5;
    private const EXPRESSION_RIGHT_OFFSET = -1;

    public function __construct(
        protected FileSystem $files,
    ) {
        //
    }

    public function supports(string $value): bool
    {
        return str_starts_with($value, self::EXPRESSION_LEFT) && str_ends_with($value, self::EXPRESSION_RIGHT);
    }

    public function transform(string $value): string
    {
        $file = Str::substring($value, self::EXPRESSION_LEFT_OFFSET, self::EXPRESSION_RIGHT_OFFSET);

        return $this->files->getFileContent($file);
    }
}
