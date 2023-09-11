<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * @phpstan-type CiName = string
 */
readonly class Config
{
    public const SUBJECT_RULES = 1;
    public const SUBJECT_CI_SETTINGS = 2;
    public const SUBJECT_HTTP_CLIENT = 3;
    public const SUBJECT_NOTIFICATIONS = 4;
    public const SUBJECT_LINTER = 5;
    public const SUBJECT_COMMENTS = 6;
    public const SUBJECT_ALL = self::SUBJECT_RULES |
        self::SUBJECT_CI_SETTINGS |
        self::SUBJECT_HTTP_CLIENT |
        self::SUBJECT_NOTIFICATIONS |
        self::SUBJECT_LINTER |
        self::SUBJECT_COMMENTS;

    /**
     * @param Map<CiName, CiSettings> $settings
     */
    public function __construct(
        private Rules               $rules,
        private Map                 $settings,
        private HttpClientConfig    $httpClient,
        private NotificationsConfig $notifications,
        private LinterConfig        $linterConfig,
        private CommentsConfig      $commentsConfig,
    ) {
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

    public function getCommentsConfig(): CommentsConfig
    {
        return $this->commentsConfig;
    }
}
