<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;

class JsonConfigLoader extends AbstractArrayConfigLoader implements ConfigLoader
{
    public function __construct(
        private FileSystem $files,
        CredentialMapper $credentialMapper,
        RulesMapper $rulesMapper,
    ) {
        parent::__construct($credentialMapper, $rulesMapper);
    }

    protected function loadConfigArray(string $path): array
    {
        try {
            $json = $this->files->getFileContent($path);
        } catch (FileNotFound $e) {
            throw ConfigNotFound::fromPath($path, $e);
        }

        $data = json_decode($json, true);

        if (! is_array($data)) {
            throw new ConfigInvalidException('json invalid');
        }

        return $data;
    }
}
