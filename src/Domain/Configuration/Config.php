<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Configuration;

use ArtARTs36\MergeRequestLinter\Domain\Rule\Rules;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

/**
 * @phpstan-type CiName = string
 * @codeCoverageIgnore
 */
readonly class Config
{
    public const SUBJECT_RULES = 1;
    public const SUBJECT_CI_SETTINGS = 2;
    public const SUBJECT_HTTP_CLIENT = 3;
    public const SUBJECT_NOTIFICATIONS = 4;
    public const SUBJECT_LINTER = 5;
    public const SUBJECT_COMMENTS = 6;
    public const SUBJECT_METRICS = 7;
    public const SUBJECT_ALL = self::SUBJECT_RULES |
        self::SUBJECT_CI_SETTINGS |
        self::SUBJECT_HTTP_CLIENT |
        self::SUBJECT_NOTIFICATIONS |
        self::SUBJECT_LINTER |
        self::SUBJECT_COMMENTS |
        self::SUBJECT_METRICS;

    /**
     * @param Map<CiName, CiSettings> $settings
     */
    public function __construct(
        public Rules               $rules,
        public Map                 $settings,
        public HttpClientConfig    $httpClient,
        public NotificationsConfig $notifications,
        public LinterConfig        $linter,
        public CommentsConfig      $comments,
        public MetricsConfig       $metrics,
    ) {
    }
}
