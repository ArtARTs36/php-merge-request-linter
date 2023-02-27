<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Exceptions;

use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Shared\Exceptions\MergeRequestLinterException;

class MessengerNotFoundException extends MergeRequestLinterException
{
    public static function create(ChannelType $type): self
    {
        return new self(
            sprintf('Messenger for channel with type "%s" not found', $type->value),
        );
    }
}
