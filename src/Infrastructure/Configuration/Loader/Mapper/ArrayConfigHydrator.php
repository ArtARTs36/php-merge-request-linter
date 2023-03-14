<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;

class ArrayConfigHydrator
{
    public function __construct(
        private readonly CiSettingsMapper    $credentialMapper,
        private readonly RulesMapper         $rulesMapper,
        private readonly NotificationsMapper $notificationsMapper,
    ) {
        //
    }

    /**
     * Hydrate raw array to Config object.
     * @param array<mixed> $data
     */
    public function hydrate(array $data): Config
    {
        if (! isset($data['rules']) || ! is_array($data['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        $rules = $this->rulesMapper->map($data['rules']);

        $ciSettings = new MapProxy(function () use ($data) {
            // For save compatibility. Will be removed in next version.
            $settings = $data['ci'] ?? [];

            if (empty($settings) && ! empty($data['credentials'])) {
                foreach ($data['credentials'] as $ciName => $token) {
                    $settings[$ciName]['credentials']['token'] = $token;
                }
            }

            return $this->credentialMapper->map($settings);
        });

        if (isset($data['notifications'])) {
            $notifications = $this->notificationsMapper->map($data['notifications']);
        } else {
            $notifications = new NotificationsConfig(new ArrayMap([]), new ArrayMap([]));
        }

        return new Config($rules, $ciSettings, new HttpClientConfig(
            $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
            $data['http_client']['params'] ?? [],
        ), $notifications);
    }
}
