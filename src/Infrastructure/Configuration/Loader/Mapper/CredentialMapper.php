<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

class CredentialMapper
{
    /**
     * @param array<string, AuthenticatorMapper> $mappers
     * @param Map<string, class-string<CiSystem>> $ciSystemMap
     */
    public function __construct(
        private readonly array $mappers,
        private readonly Map   $ciSystemMap,
    ) {
        //
    }

    /**
     * @param array<string, string|array<string, string>> $credentials
     * @return ArrayMap<class-string<CiSystem>, Authenticator>
     */
    public function map(array $credentials): ArrayMap
    {
        /** @var array<class-string<CiSystem>, Authenticator> $mapped */
        $mapped = [];

        foreach ($credentials as $ciName => $bag) {
            /** @var class-string<CiSystem> $ciClass */
            $ciClass = $this->ciSystemMap->get($ciName);

            $mapped[$ciClass] = $this->mappers[$ciName]->map($bag['credentials']);
        }

        return new ArrayMap($mapped);
    }
}
