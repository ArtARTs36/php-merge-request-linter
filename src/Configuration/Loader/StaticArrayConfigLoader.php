<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

final class StaticArrayConfigLoader extends AbstractArrayConfigLoader
{
    public function __construct(
        private array $config,
        CredentialMapper $credentialMapper,
        RulesMapper $rulesMapper,
    ) {
        parent::__construct($credentialMapper, $rulesMapper);
    }

    protected function loadConfigArray(string $path): array
    {
        return $this->config;
    }
}
