<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\LabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;

final class MockBitbucketLabelsResolver implements LabelsResolver
{
    public function __construct(public readonly array $labels)
    {
        //
    }

    public function resolve(PullRequest $pr, LabelsSettings $settings): array
    {
        return $this->labels;
    }
}
