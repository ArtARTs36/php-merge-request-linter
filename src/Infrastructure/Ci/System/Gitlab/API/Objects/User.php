<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects;

use ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive\Scrubber;

readonly class User
{
    public function __construct(
        public int    $id,
        public string $login,
    ) {
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
