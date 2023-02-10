<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;

final class EnvTransformer extends StringFuncTransformer
{
    protected const FUNC_NAME = 'env';

    public function __construct(
        private readonly Environment $environment,
    ) {
        //
    }

    protected function doTransform(string $preparedValue): string
    {
        return $this->environment->getString($preparedValue);
    }
}
