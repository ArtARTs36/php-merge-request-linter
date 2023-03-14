<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;

/**
 * Labels Resolver.
 */
interface LabelsResolver
{
    /**
     * Resolve labels.
     * @return array<string>
     */
    public function resolve(PullRequest $pr, LabelsSettings $settings): array;
}
