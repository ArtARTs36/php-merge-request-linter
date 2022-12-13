<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;
use GuzzleHttp\Client;

class JsonConfigLoader implements ConfigLoader
{
    public function __construct(
        private FileSystem $files,
        private CredentialMapper $credentialMapper,
        private RulesMapper $rulesMapper,
    ) {
        //
    }

    public function load(string $path): Config
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

        if (! isset($data['rules']) || ! is_array($data['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        $rules = $this->rulesMapper->map($data['rules']);

        if (! class_exists('\GuzzleHttp\Client')) {
            throw new ConfigInvalidException('HTTP Client unavailable');
        }

        return new Config($rules, $this->credentialMapper->map($data['credentials']), static function () {
            return new Client();
        });
    }
}
