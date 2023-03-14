<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\CiSettings;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

class Config
{
    /**
     * @param Map<class-string<CiSystem>, CiSettings> $settings
     */
    public function __construct(
        private readonly Rules               $rules,
        private readonly Map                 $settings,
        private readonly HttpClientConfig    $httpClient,
        private readonly NotificationsConfig $notifications,
    ) {
        //
    }

    public function getRules(): Rules
    {
        return $this->rules;
    }

    /**
     * @return Map<class-string<CiSystem>, CiSettings>
     */
    public function getSettings(): Map
    {
        return $this->settings;
    }

    public function getHttpClient(): HttpClientConfig
    {
        return $this->httpClient;
    }

    public function getNotifications(): NotificationsConfig
    {
        return $this->notifications;
    }
}
