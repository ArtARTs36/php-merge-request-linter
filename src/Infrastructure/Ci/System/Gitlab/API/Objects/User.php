<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

use ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive\Scrubber;

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
        return [
            'login' => Scrubber::scrub($this->login),
        ];
    }
}
