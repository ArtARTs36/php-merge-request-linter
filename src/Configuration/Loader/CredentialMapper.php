<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Ci\System\SystemFactory;
use ArtARTs36\MergeRequestLinter\Contracts\CiSystem;
use ArtARTs36\MergeRequestLinter\Contracts\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Contracts\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Map;

class CredentialMapper
{
    /**
     * @param iterable<ConfigValueTransformer> $valueTransformers
     * @param Map<string, class-string<CiSystem>> $ciSystemMap
     */
    public function __construct(
        private iterable $valueTransformers,
        private Map $ciSystemMap,
    ) {
        //
    }

    /**
     * @param array<key-of<SystemFactory::CI_MAP>, string> $credentials
     * @return Map<class-string<CiSystem>, RemoteCredentials>
     */
    public function map(array $credentials): Map
    {
        /** @var array<class-string<CiSystem>, RemoteCredentials> $mapped */
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
