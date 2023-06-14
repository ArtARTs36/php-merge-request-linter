<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\GraphQL\Change;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\Status;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class StatusTest extends TestCase
{
    public function providerForTestCreate(): array
    {
        return [
            ['modified', Status::Modified],
            ['non-exists-status', Status::Unknown],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Change\Status::create
     * @dataProvider providerForTestCreate
     */
    public function testCreate(string $value, Status $status): void
    {
        self::assertEquals($status, Status::create($value));
    }
}
