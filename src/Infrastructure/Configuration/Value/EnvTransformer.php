<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\InvalidConfigValueException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\Environment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Environment\EnvironmentVariableNotFoundException;

final class EnvTransformer extends StringFuncTransformer
{
    protected const FUNC_NAME = 'env';

    public function __construct(
        private readonly Environment $environment,
    ) {
    }

    protected function doTransform(string $preparedValue): string
    {
        try {
            return $this->environment->getString($preparedValue);
        } catch (EnvironmentVariableNotFoundException $e) {
            throw new InvalidConfigValueException($e->getMessage(), previous: $e);
        }
    }
}
