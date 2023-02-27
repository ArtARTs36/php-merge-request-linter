<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationEventMessage;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\NotificationsConfig;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\Channel;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;

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

    public function map(array $data): NotificationsConfig
    {
        $channels = [];

        foreach ($data['channels'] as $name => $channel) {
            $type = ChannelType::from($channel['type']);

            unset($channel['type']);

            $channels[$name] = new Channel($type, new ArrayMap($this->transformValues($channel)));
        }

        $notifications = [];

        foreach ($data['on'] as $eventName => $notification) {
            $notifications[$eventName][] = new NotificationEventMessage(
                $eventName,
                $channels[$notification['channel']],
                $notification['template'],
            );
        }

        return new NotificationsConfig(new ArrayMap($channels), new ArrayMap($notifications));
    }

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
