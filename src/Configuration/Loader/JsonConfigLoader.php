<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use GuzzleHttp\Client;

class JsonConfigLoader implements ConfigLoader
{
    /**
     * @param iterable<ConfigValueTransformer> $valueTransformers
     */
    public function __construct(
        private Resolver   $ruleResolver,
        private FileSystem $files,
        private iterable   $valueTransformers,
    ) {
        //
    }

    public function load(string $path): Config
    {
        $data = json_decode($this->files->getFileContent($path), true);
        $rules = new Rules([]);

        foreach ($data['rules'] as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, $ruleParams ?? []));
        }

        if (! class_exists('\GuzzleHttp\Client')) {
            throw new ConfigInvalidException('HTTP Client unavailable');
        }

        return new Config($rules, $this->mapCredentials($data['credentials']), static function () {
            return new Client();
        });
    }

    /**
     * @param array<string> $credentials
     * @return Map<string, RemoteCredentials>
     */
    private function mapCredentials(array $credentials): Map
    {
        foreach ($credentials as &$token) {
            foreach ($this->valueTransformers as $transformer) {
                if ($transformer->supports($token)) {
                    $token = new Token($transformer->transform($token));

                    continue 2;
                }
            }
        }

        return new Map($credentials);
    }
}
