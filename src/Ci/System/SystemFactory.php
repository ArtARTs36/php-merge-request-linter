<?php

namespace ArtARTs36\MergeRequestLinter\Ci\System;

use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Exception\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Exception\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Support\Map;
use OndraM\CiDetector\CiDetector;

class SystemFactory
{
    /** @var array<string, class-string<CiSystem>> */
    protected array $ciMap = [
        CiDetector::CI_GITLAB => GitlabCi::class,
    ];

    public function __construct(
        protected Map $credentials,
        protected Environment $environment,
    ) {
        //
    }

    public function create(string $ciName): CiSystem
    {
        $targetClass = $this->ciMap[$ciName] ?? null;

        if ($targetClass === null) {
            throw new CiNotSupported();
        }

        if (! $this->credentials->has($targetClass)) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        $credentialsClass = $this->getRequiredCredentialsClass($targetClass);

        if (! is_a($this->credentials->get($targetClass), $credentialsClass, true)) {
            throw InvalidCredentialsException::fromCiName($ciName);
        }

        return new $targetClass($this->credentials->get($targetClass), $this->environment);
    }

    protected function getRequiredCredentialsClass(string $systemClass): string
    {
        $reflection = new \ReflectionClass($systemClass);
        $constructor = $reflection->getConstructor();

        foreach ($constructor->getParameters() as $parameter) {
            if ($parameter?->getName() === 'credentials') {
                return $parameter->getType()->getName();
            }
        }

        throw new \RuntimeException('Cannot be constructed Ci System');
    }
}
