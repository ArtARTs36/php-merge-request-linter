<?php

namespace ArtARTs36\MergeRequestLinter\Contracts;

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
