<?php

namespace ArtARTs36\MergeRequestLinter\Configuration;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigLoader;
use ArtARTs36\MergeRequestLinter\Rule\Factory\Resolver;
use ArtARTs36\MergeRequestLinter\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Support\Map;

class JsonConfigLoader implements ConfigLoader
{
    public function __construct(
        private Resolver $ruleResolver,
    ) {
        //
    }

    public function load(string $path): Config
    {
        $data = json_decode(file_get_contents($path), true);
        $rules = new Rules([]);

        foreach ($data['rules'] as $ruleName => $ruleParams) {
            $rules->add($this->ruleResolver->resolve($ruleName, $ruleParams ?? []));
        }

        return new Config($rules, new Map([]), function () {});
    }
}
