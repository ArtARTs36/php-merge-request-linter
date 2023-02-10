<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI;

/**
 * Remote credentials for remote git hosting
 */
interface RemoteCredentials
{
    /**
     * Get token for remote git hosting
     */
    public function getToken(): string;
}
