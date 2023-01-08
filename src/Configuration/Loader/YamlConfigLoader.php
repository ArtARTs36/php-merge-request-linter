<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use Symfony\Component\Yaml\Yaml;

class YamlConfigLoader extends AbstractArrayConfigLoader
{
    public function __construct(
        private readonly FileSystem $files,
        CredentialMapper $credentialMapper,
        RulesMapper $rulesMapper,
    ) {
        parent::__construct($credentialMapper, $rulesMapper);
    }

    protected function loadConfigArray(string $path): array
    {
        return Yaml::parse($this->files->getFileContent($path));
    }
}
