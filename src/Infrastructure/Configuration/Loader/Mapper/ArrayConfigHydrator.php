<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\LinterConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\MetricsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\MetricsStorageConfig;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LinterOptions;
use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

class ArrayConfigHydrator
{
    public function __construct(
        private readonly CiSettingsMapper    $credentialMapper,
        private readonly RulesMapper         $rulesMapper,
        private readonly NotificationsMapper $notificationsMapper,
    ) {
    }

    /**
     * Hydrate raw array to Config object.
     * @param array<mixed> $data
     */
    public function hydrate(array $data, int $subjects = Config::SUBJECT_ALL): Config
    {
        if (Config::SUBJECT_RULES === (Config::SUBJECT_RULES & $subjects)) {
            if (! isset($data['rules']) || ! is_array($data['rules'])) {
                throw ConfigInvalidException::fromKey('rules');
            }

            $rules = $this->rulesMapper->map($data['rules']);
        } else {
            $rules = new Rules([]);
        }

        if (Config::SUBJECT_CI_SETTINGS === (Config::SUBJECT_CI_SETTINGS & $subjects)) {
            if (! isset($data['ci'])) {
                throw ConfigInvalidException::fromKey('ci');
            }

            try {
                $ciSettings = $this->credentialMapper->map($data['ci']);
            } catch (InvalidCredentialsException $e) {
                throw new ConfigInvalidException(sprintf(
                    'Config invalid: %s',
                    $e->getMessage(),
                ), previous: $e);
            }
        } else {
            $ciSettings = new ArrayMap([]);
        }

        if ((Config::SUBJECT_NOTIFICATIONS === (Config::SUBJECT_NOTIFICATIONS & $subjects)) && isset($data['notifications'])) {
            $notifications = $this->notificationsMapper->map($data['notifications']);
        } else {
            $notifications = new NotificationsConfig(new ArrayMap([]), new ArrayMap([]));
        }

        if (Config::SUBJECT_HTTP_CLIENT === (Config::SUBJECT_HTTP_CLIENT & $subjects)) {
            $httpClientConfig = new HttpClientConfig(
                $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
                $data['http_client']['params'] ?? [],
            );
        } else {
            $httpClientConfig = new HttpClientConfig(
                HttpClientConfig::TYPE_DEFAULT,
                [],
            );
        }

        return new Config(
            $rules,
            $ciSettings,
            $httpClientConfig,
            $notifications,
            $this->createLinterConfig($data['linter'] ?? []),
            $this->createCommentsConfig($data['comments'] ?? []),
            $this->createMetricsConfig($data),
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
                if (! is_bool($config['options']['stop_on_failure'])) {
                    throw ConfigInvalidException::fromKey('linter.options.stop_on_failure');
                }

                $stopOnFailure = $config['options']['stop_on_failure'];
            }

            if (isset($config['options']['stop_on_warning'])) {
                if (! is_bool($config['options']['stop_on_warning'])) {
                    throw ConfigInvalidException::fromKey('linter.options.stop_on_warning');
                }

                $stopOnWarning = $config['options']['stop_on_warning'];
            }
        }

        return new LinterConfig(
            new LinterOptions($stopOnFailure, $stopOnWarning),
        );
    }

    /**
     * @param array<string, mixed> $config
     */
    private function createCommentsConfig(array $config): CommentsConfig
    {
        if (array_key_exists('strategy', $config)) {
            if (! is_string($config['strategy'])) {
                throw ConfigInvalidException::fromKey('comments.strategy');
            }

            $postStrategy = CommentsPostStrategy::from($config['strategy']);
        } else {
            $postStrategy = CommentsPostStrategy::Null;
        }

        $messages = [];

        if (array_key_exists('messages', $config)) {
            if (! is_array($config['messages'])) {
                throw ConfigInvalidException::fromKey('comments.messages');
            }

            foreach ($config['messages'] as $i => $msg) {
                if (! array_key_exists('template', $msg)) {
                    throw ConfigInvalidException::keyNotSet('comments.messages.' . $i . '.template');
                }

                $messages[] = new CommentsMessage(
                    $msg['template'],
                    $msg['when'] ?? [],
                );
            }
        }

        return new CommentsConfig(
            $postStrategy,
            $messages,
        );
    }

    /**
     * @param array<string, mixed> $config
     */
    private function createMetricsConfig(array $config): MetricsConfig
    {
        if (! array_key_exists('metrics', $config)) {
            return new MetricsConfig(new MetricsStorageConfig('null', 'null'));
        }

        if (! is_array($config['metrics'])) {
            throw ConfigInvalidException::invalidType('metrics', 'array', gettype($config['metrics']));
        }

        if (! array_key_exists('storage', $config['metrics'])) {
            throw ConfigInvalidException::keyNotSet('metrics.storage');
        }

        if (! is_array($config['metrics']['storage'])) {
            throw ConfigInvalidException::invalidType(
                'metrics.storage',
                'array',
                gettype($config['metrics']['storage']),
            );
        }

        if (count($config['metrics']['storage']) === 0) {
            throw new ConfigInvalidException('Config[metrics.storage] must be not empty');
        }

        $storageName = array_key_first($config['metrics']['storage']);
        $storage = $config['metrics']['storage'][$storageName];

        if (empty($storage['address'])) {
            throw new ConfigInvalidException('Config[metrics.storage.address] must be not empty');
        }

        if (! is_string($storage['address'])) {
            throw new ConfigInvalidException('Config[metrics.storage.address] must be string');
        }

        return new MetricsConfig(new MetricsStorageConfig(
            $storageName,
            $storage['address'],
        ));
    }
}
