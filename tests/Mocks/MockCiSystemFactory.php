<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;

final class MockCiSystemFactory implements CiSystemFactory
{
    public function __construct(private CiSystem $system)
    {
        //
    }

    public function createCurrently(): CiSystem
    {
        return $this->system;
    }
}
