<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use JetBrains\PhpStorm\ArrayShape;
use OndraM\CiDetector\Ci\CiInterface;
use OndraM\CiDetector\Env;
use OndraM\CiDetector\TrinaryLogic;

final class MockCi implements CiInterface
{
    /**
     * @param array<string, bool|string> $values
     */
    public function __construct(
        #[ArrayShape([
            'is_pull_request' => 'bool',
        ])]
        private array $values
    ) {
        //
    }

    public static function isDetected(Env $env): bool
    {
        return true;
    }

    public function getCiName(): string
    {
        return 'MockCi';
    }

    public function describe(): array
    {
        return $this->values;
    }

    public function getBuildNumber(): string
    {
        // TODO: Implement getBuildNumber() method.
    }

    public function getBuildUrl(): string
    {
        // TODO: Implement getBuildUrl() method.
    }

    public function getCommit(): string
    {
        // TODO: Implement getCommit() method.
    }

    public function getBranch(): string
    {
        // TODO: Implement getBranch() method.
    }

    public function getTargetBranch(): string
    {
        // TODO: Implement getTargetBranch() method.
    }

    public function getRepositoryName(): string
    {
        // TODO: Implement getRepositoryName() method.
    }

    public function getRepositoryUrl(): string
    {
        // TODO: Implement getRepositoryUrl() method.
    }

    public function isPullRequest(): TrinaryLogic
    {
        return TrinaryLogic::createFromBoolean($this->values['is_pull_request'] ?? false);
    }
}
