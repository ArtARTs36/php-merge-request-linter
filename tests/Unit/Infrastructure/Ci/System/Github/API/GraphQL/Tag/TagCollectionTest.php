<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Tag;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\Tag;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TagCollectionTest extends TestCase
{
    public function providerForTestSortByMajority(): array
    {
        return [
            'patch comparison' => [
                'tags' => [
                    $t5 = new Tag('1.0.5', 1, 0, 5),
                    $t1 = new Tag('1.0.0', 1, 0, 0),
                    $t2 = new Tag('1.0.3', 1, 0, 3),
                    $t4 = new Tag('1.0.4', 1, 0, 4),
                    $t3 = new Tag('1.0.1', 1, 0, 1),
                ],
                'expected' => [
                    $t5,
                    $t4,
                    $t2,
                    $t3,
                    $t1,
                ],
            ],
            'minor comparison' => [
                'tags' => [
                    $t1 = new Tag('1.0.0', 1, 0, 0),
                    $t4 = new Tag('1.0.0', 1, 4, 0),
                    $t2 = new Tag('1.2.3', 1, 2, 3),
                    $t5 = new Tag('1.2.3', 1, 5, 3),
                    $t3 = new Tag('1.1.1', 1, 1, 1),
                ],
                'expected' => [
                    $t5,
                    $t4,
                    $t2,
                    $t3,
                    $t1,
                ],
            ],
            'major comparison' => [
                'tags' => [
                    $t5 = new Tag('5.0.0', 5, 0, 0),
                    $t1 = new Tag('1.0.0', 1, 0, 0),
                    $t2 = new Tag('3.2.3', 3, 2, 3),
                    $t3 = new Tag('2.1.1', 2, 1, 1),
                    $t4 = new Tag('4.1.1', 4, 1, 1),
                ],
                'expected' => [
                    $t5,
                    $t4,
                    $t2,
                    $t3,
                    $t1,
                ],
            ],
            'equals comparison' => [
                'tags' => [
                    $t1 = new Tag('1.0.0', 1, 0, 0),
                    $t2 = new Tag('1.0.0', 1, 0, 0),
                ],
                'expected' => [
                    $t1,
                    $t2,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection::sortByMajority
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag\TagCollection::__construct
     * @dataProvider providerForTestSortByMajority
     */
    public function testSortByMajority(array $tags, array $expected): void
    {
        $collection = new TagCollection($tags);

        self::assertEquals($expected, $collection->sortByMajority()->mapToArray(fn (Tag $tag) => $tag));
    }
}
