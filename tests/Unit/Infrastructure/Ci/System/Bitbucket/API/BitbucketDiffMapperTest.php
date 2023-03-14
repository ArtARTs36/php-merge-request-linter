<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\BitbucketDiffMapper;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BitbucketDiffMapperTest extends TestCase
{
    public function providerForTestMap(): array
    {
        return [
            require __DIR__ . '/data/1.php',
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\BitbucketDiffMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\BitbucketDiffMapper::__construct
     * @dataProvider providerForTestMap
     */
    public function testMap(string $response, array $expected): void
    {
        $mapper = new BitbucketDiffMapper();

        self::assertEquals($expected, $mapper->map($response));
    }
}
