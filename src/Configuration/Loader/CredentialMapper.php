<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Loader;

use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Condition\Evaluator\DefaultEvaluators;
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
     * @param array<string, string> $credentials
     * @return Map<class-string<CiSystem>, RemoteCredentials>
     */
    public function map(array $credentials): Map
    {
        /** @var array<class-string<CiSystem>, RemoteCredentials> $mapped */
        $mapped = [];

        foreach ($credentials as $ciName => $token) {
            foreach ($this->valueTransformers as $transformer) {
                if ($transformer->supports($token)) {
                    /** @var class-string<CiSystem> $ciClass */
                    $ciClass = $this->ciSystemMap->get($ciName);

                    $mapped[$ciClass] = new Token($transformer->transform($token));

                    continue 2;
                }
            }
        }

        return new Map($mapped);
    }
}
