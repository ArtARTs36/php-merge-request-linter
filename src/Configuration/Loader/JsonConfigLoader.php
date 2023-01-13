<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\Text\JsonDecoder;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Exception\TextDecodingException;

class JsonConfigLoader extends AbstractArrayConfigLoader implements ConfigLoader
{
    public function __construct(
        private FileSystem $files,
        private JsonDecoder $json,
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

        try {
            $data = $this->json->decode($json);
        } catch (TextDecodingException $e) {
            throw new ConfigInvalidException(sprintf('JSON invalid: %s', $e->getMessage()));
        }

        return $data;
    }
}
