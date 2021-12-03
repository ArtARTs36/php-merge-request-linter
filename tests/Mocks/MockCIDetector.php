<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use OndraM\CiDetector\Ci\CiInterface;
use OndraM\CiDetector\CiDetectorInterface;
use OndraM\CiDetector\Exception\CiNotDetectedException;

final class MockCIDetector implements CiDetectorInterface
{
    private function __construct(private ?CiInterface $ci)
    {
        //
    }

    public static function fromCi(CiInterface $ci): self
    {
        return new self($ci);
    }

    public static function null(): self
    {
        return new self(null);
    }

    public function isCiDetected(): bool
    {
        return $this->ci !== null;
    }

    public function detect(): CiInterface
    {
        if ($this->ci === null) {
            throw new CiNotDetectedException();
        }

        return $this->ci;
    }
}
