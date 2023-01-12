<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Contracts\YamlParser;

class YamlConfigLoader extends AbstractArrayConfigLoader
{
    public function __construct(
        private readonly FileSystem $files,
        private readonly YamlParser $yaml,
        CredentialMapper $credentialMapper,
        RulesMapper $rulesMapper,
    ) {
        parent::__construct($credentialMapper, $rulesMapper);
    }

    protected function loadConfigArray(string $path): array
    {
        return $this->yaml->parse($this->files->getFileContent($path));
    }
}
