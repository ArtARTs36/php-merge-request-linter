<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileNotFound;
use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Exception\ConfigNotFound;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use GuzzleHttp\Client;

class JsonConfigLoader implements ConfigLoader
{
    /**
     * @param iterable<ConfigValueTransformer> $valueTransformers
     * @param Map<string, class-string<CiSystem>> $ciSystemMap
     */
    public function __construct(
        private Resolver   $ruleResolver,
        private FileSystem $files,
        private iterable   $valueTransformers,
        private Map $ciSystemMap,
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

        return new Config($rules, $this->mapCredentials($data['credentials']), static function () {
            return new Client();
        });
    }

    /**
     * @param array<string, array<string, mixed>> $rulesData
     */
    private function createRules(array $rulesData): Rules
    {
        $rules = new Rules([]);

        foreach ($rulesData as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, $ruleParams ?? []));
        }

        return $rules;
    }

    /**
     * @param array<string> $credentials
     * @return Map<class-string<CiSystem>, RemoteCredentials>
     */
    private function mapCredentials(array $credentials): Map
    {
        $mapped = [];

        foreach ($credentials as $ci => $token) {
            foreach ($this->valueTransformers as $transformer) {
                if ($transformer->supports($token)) {
                    $mapped[$this->ciSystemMap->get($ci)] = new Token($transformer->transform($token));

                    continue 2;
                }
            }
        }

        return new Map($mapped);
    }
}
