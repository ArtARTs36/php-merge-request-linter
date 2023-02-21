<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Rule\Exceptions;

use ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\RuleNotFound;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class RuleNotFoundTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Rule\Exceptions\RuleNotFound::fromRuleName
     */
    public function testFromRuleName(): void
    {
        $e = RuleNotFound::fromRuleName('test-rule');

        self::assertEquals('Rule with name test-rule not found', $e->getMessage());
    }
}
