<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use GuzzleHttp\Client;

class JsonConfigLoader implements ConfigLoader
{
    public function __construct(
        private Resolver   $ruleResolver,
        private FileSystem $files,
        private CredentialMapper $credentialMapper,
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

        $rules = $this->createRules($data['rules']);

        if (! class_exists('\GuzzleHttp\Client')) {
            throw new ConfigInvalidException('HTTP Client unavailable');
        }

        return new Config($rules, $this->credentialMapper->map($data['credentials']), static function () {
            return new Client();
        });
    }

    /**
     * @param array<string, mixed> $rulesData
     */
    private function createRules(array $rulesData): Rules
    {
        $rules = new Rules([]);

        foreach ($rulesData as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, is_array($ruleParams) ? $ruleParams : []));
        }

        return $rules;
    }
}
