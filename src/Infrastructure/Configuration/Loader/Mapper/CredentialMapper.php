<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\RemoteCredentials;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;

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
            /** @var class-string<CiSystem> $ciClass */
            $ciClass = $this->ciSystemMap->get($ciName);

            foreach ($this->valueTransformers as $transformer) {
                if ($transformer->supports($token)) {
                    $mapped[$ciClass] = $this->createCredentials($transformer->transform($token));

                    continue 2;
                }
            }

            $mapped[$ciClass] = $this->createCredentials($token);
        }

        return new ArrayMap($mapped);
    }

    private function createCredentials(string $token): Token
    {
        return new Token($token);
    }
}
