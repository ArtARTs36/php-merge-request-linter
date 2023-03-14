<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\AuthenticatorProxy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class CiSettingsMapper
{
    /**
     * @param array<string, AuthenticatorMapper> $authMappers
     */
    public function __construct(
        private readonly array $authMappers,
    ) {
        //
    }

    /**
     * @param array<string, array<string, array{credentials: array<string, mixed>}>> $settings
     * @return ArrayMap<string, CiSettings>
     */
    public function map(array $settings): ArrayMap
    {
        /** @var array<string, CiSettings> $mapped */
        $mapped = [];

        foreach ($settings as $ciName => $bag) {
            $params = $bag;
            unset($params['credentials']);

            $mapped[$ciName] = new CiSettings(
                new AuthenticatorProxy(function () use ($ciName, $bag) {
                    return $this->authMappers[$ciName]->map($bag['credentials']);
                }),
                $params,
            );
        }

        return new ArrayMap($mapped);
    }
}
