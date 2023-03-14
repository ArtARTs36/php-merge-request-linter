<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

class CiSettingsMapper
{
    /**
     * @param array<string, AuthenticatorMapper> $authMappers
     * @param Map<string, class-string<CiSystem>> $ciSystemMap
     */
    public function __construct(
        private readonly array $authMappers,
        private readonly Map   $ciSystemMap,
    ) {
        //
    }

    /**
     * @param array<string, array<string, array{credentials: array<string, mixed>}>> $settings
     * @return ArrayMap<class-string<CiSystem>, CiSettings>
     */
    public function map(array $settings): ArrayMap
    {
        /** @var array<class-string<CiSystem>, Authenticator> $mapped */
        $mapped = [];

        foreach ($settings as $ciName => $bag) {
            /** @var class-string<CiSystem> $ciClass */
            $ciClass = $this->ciSystemMap->get($ciName);

            $params = $bag;
            unset($params['credentials']);

            $mapped[$ciClass] = new CiSettings(
                new AuthenticatorProxy(function () use ($ciName, $bag) {
                    return $this->authMappers[$ciName]->map($bag['credentials']);
                }),
                $params,
            );
        }

        return new ArrayMap($mapped);
    }
}
