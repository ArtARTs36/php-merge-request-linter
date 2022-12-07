<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\FileSystem\Contracts\FileSystem;
use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Exception\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Facade\Str;
use GuzzleHttp\Client;

class JsonConfigLoader implements ConfigLoader
{
    public function __construct(
        private Resolver $ruleResolver,
        private Environment $environment,
        private FileSystem $files,
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
     * @return Map<string, RemoteCredentials>
     */
    private function mapCredentials(array $credentials): Map
    {
        foreach ($credentials as &$token) {
            if (str_starts_with($token, '$')) {
                $var = Str::cut($token, null, 1);
                $token = new Token($this->environment->getString($var));
            }

        }

        return new Map($credentials);
    }
}
