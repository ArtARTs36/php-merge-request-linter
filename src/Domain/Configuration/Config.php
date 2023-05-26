<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * @phpstan-type CiName = string
 */
class Config
{
    /**
     * @param Map<CiName, CiSettings> $settings
     */
    public function __construct(
        private readonly Rules      $rules,
        private readonly Map                 $settings,
        private readonly HttpClientConfig    $httpClient,
        private readonly NotificationsConfig $notifications,
        private readonly LinterConfig $linterConfig,
    ) {
        //
    }

    public function getRules(): Rules
    {
        return $this->rules;
    }

    /**
     * @return Map<CiName, CiSettings>
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

    public function getLinter(): LinterConfig
    {
        return $this->linterConfig;
    }
}
