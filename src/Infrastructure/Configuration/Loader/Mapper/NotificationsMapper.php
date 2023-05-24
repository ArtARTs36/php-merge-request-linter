<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Shared\Time\TimePeriod;

class NotificationsMapper
{
    /**
     * @param iterable<ConfigValueTransformer> $valueTransformers
     */
    public function __construct(
        private readonly iterable $valueTransformers,
    ) {
        //
    }

    /**
     * @param array<string, mixed> $data
     */
    public function map(array $data): NotificationsConfig
    {
        if (! isset($data['channels'])) {
            throw ConfigInvalidException::keyNotSet('notifications.channels');
        }

        if (! is_array($data['channels'])) {
            throw ConfigInvalidException::invalidType('notifications.channels', 'array', gettype($data['channels']));
        }

        if (! isset($data['on'])) {
            throw ConfigInvalidException::keyNotSet('notifications.on');
        }

        if (! is_array($data['on'])) {
            throw ConfigInvalidException::invalidType('notifications.on', 'array', gettype($data['channels']));
        }

        $channels = $this->mapChannels($data['channels']);
        $notifications = $this->mapNotifications($channels, $data['on']);

        return new NotificationsConfig($channels, $notifications);
    }

    /**
     * @param Map<string, Channel> $channels
     * @param array<string, string> $data
     * @return Map<string, array<NotificationEventMessage>>
     */
    private function mapNotifications(Map $channels, array $data): Map
    {
        /** @var array<string, array<NotificationEventMessage>> $notifications */
        $notifications = [];

        /**
         * @var string $eventName
         * @var array<string, mixed> $notification
         */
        foreach ($data as $eventName => $notification) {
            $channelName = $notification['channel'] ?? null;

            if ($channelName === null) {
                throw ConfigInvalidException::keyNotSet(sprintf('notifications.on.%s.channel', $eventName));
            }

            if (! is_string($channelName)) {
                throw ConfigInvalidException::invalidType(
                    sprintf('notifications.on.%s.channel', $eventName),
                    'string',
                    get_debug_type($channelName),
                );
            }

            $template = $notification['template'] ?? null;

            if ($template === null) {
                throw ConfigInvalidException::keyNotSet(sprintf('notifications.on.%s.template', $eventName));
            }

            if (! is_string($template)) {
                throw ConfigInvalidException::invalidType(sprintf('notifications.on.%s.template', $eventName), 'string', gettype($template));
            }

            $when = [];

            if (array_key_exists('when', $notification)) {
                if (is_array($notification['when'])) {
                    $when = $notification['when'];
                } else {
                    throw ConfigInvalidException::invalidType(sprintf('notifications.on.%s.when', $eventName), 'array', gettype($when));
                }
            }

            $channel = $channels->get($channelName);

            if ($channel === null) {
                throw ConfigInvalidException::fromKey(sprintf(
                    'notifications.on.%s.channel',
                    $eventName,
                ));
            }

            $notifications[$eventName][] = new NotificationEventMessage(
                $eventName,
                $channel,
                $template,
                $when,
            );
        }

        return new ArrayMap($notifications);
    }

    /**
     * @param array<string, array<string, string>> $data
     * @return Map<string, Channel>
     */
    private function mapChannels(array $data): Map
    {
        /** @var array<string, Channel> $channels */
        $channels = [];

        foreach ($data as $name => $channel) {
            $type = ChannelType::from($channel['type']);

            if (array_key_exists('sound_at', $channel) && $channel['sound_at'] !== '') {
                $sound = TimePeriod::make($channel['sound_at']);

                unset($channel['sound_at']);
            } else {
                $sound = TimePeriod::day();
            }

            unset($channel['type']);

            $channels[$name] = new Channel(
                $type,
                new ArrayMap($this->transformValues($channel)),
                $sound,
            );
        }

        return new ArrayMap($channels);
    }

    /**
     * @param array<string, mixed> $values
     * @return array<string, mixed>
     */
    private function transformValues(array $values): array
    {
        foreach ($values as &$v) {
            if (! is_string($v)) {
                continue;
            }

            foreach ($this->valueTransformers as $transformer) {
                if ($transformer->supports($v)) {
                    $v = $transformer->transform($v);

                    continue 2;
                }
            }
        }

        return $values;
    }
}
