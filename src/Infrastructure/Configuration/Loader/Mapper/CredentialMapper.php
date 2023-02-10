<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Common\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\ArrayMap;

class CredentialMapper
{
    /**
     * @param iterable<ConfigValueTransformer> $valueTransformers
     * @param Map<string, class-string<CiSystem>> $ciSystemMap
     */
    public function __construct(
        private readonly iterable $valueTransformers,
        private readonly Map $ciSystemMap,
    ) {
        //
    }

    /**
     * @param array<string, string> $credentials
     * @return ArrayMap<class-string<CiSystem>, RemoteCredentials>
     */
    public function map(array $credentials): ArrayMap
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

        return new ArrayMap($mapped);
    }
}
