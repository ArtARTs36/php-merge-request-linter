<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
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
            if (! isset($data['ci'])) {
                throw ConfigInvalidException::fromKey('ci');
            }

            return $this->credentialMapper->map($data['ci']);
        });

        if (isset($data['notifications'])) {
            $notifications = $this->notificationsMapper->map($data['notifications']);
        } else {
            $notifications = new NotificationsConfig(new ArrayMap([]), new ArrayMap([]));
        }

        return new Config(
            $rules,
            $ciSettings,
            new HttpClientConfig(
                $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
                $data['http_client']['params'] ?? [],
            ),
            $notifications,
            $this->createLinterConfig($data['linter'] ?? [])
        );
    }

    /**
     * @param array<string, mixed> $config
     */
    private function createLinterConfig(array $config): LinterConfig
    {
        $stopOnFailure = false;
        $stopOnWarning = false;

        if (isset($config['options']) && is_array($config['options'])) {
            if (isset($config['options']['stop_on_failure'])) {
                if (!is_bool($config['options']['stop_on_failure'])) {
                    throw ConfigInvalidException::fromKey('linter.options.stop_on_failure');
                }

                $stopOnFailure = $config['options']['stop_on_failure'];
            }

            if (isset($config['options']['stop_on_warning'])) {
                if (!is_bool($config['options']['stop_on_warning'])) {
                    throw ConfigInvalidException::fromKey('linter.options.stop_on_warning');
                }

                $stopOnWarning = $config['options']['stop_on_warning'];
            }
        }

        return new LinterConfig(
            new LinterOptions($stopOnFailure, $stopOnWarning),
        );
    }
}
