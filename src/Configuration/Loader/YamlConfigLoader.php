<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Text\YamlDecoder;

class YamlConfigLoader extends AbstractArrayConfigLoader
{
    public function __construct(
        private readonly FileSystem  $files,
        private readonly YamlDecoder $yaml,
        CredentialMapper             $credentialMapper,
        RulesMapper                  $rulesMapper,
    ) {
        parent::__construct($credentialMapper, $rulesMapper);
    }

    protected function loadConfigArray(string $path): array
    {
        return $this->yaml->decode($this->files->getFileContent($path));
    }
}
