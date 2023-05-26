<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\Str\Facade\Str;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Tester\CommandTester as SymfonyCommandTester;

final class CommandTester extends SymfonyCommandTester
{
    public function assertDisplayContainsString(string $needle): void
    {
        Assert::assertStringContainsString($needle, Str::deleteUnnecessarySpaces($this->getDisplay()));
    }
}
