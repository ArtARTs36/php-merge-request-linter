<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

class User
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
    ) {
        //
    }

    /**
     * @return array<mixed>|null
     */
    public function __debugInfo(): ?array
    {
        return null;
    }
}
