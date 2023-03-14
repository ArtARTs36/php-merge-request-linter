<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\BitbucketPR;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockBitbucketLabelsResolver;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CompositeResolverTest extends TestCase
{
    public function providerForTestResolve(): array
    {
        return [
            [
                [
                    ['tag1', 'tag2'],
                    ['tag3', 'tag4'],
                ],
                ['tag1', 'tag2'],
            ],
            [
                [
                    [],
                    [],
                ],
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\CompositeResolver::__construct
     * @dataProvider providerForTestResolve
     */
    public function testResolve(array $resolversData, array $expected): void
    {
        $subResolvers = [];

        foreach ($resolversData as $data) {
            $subResolvers[] = new MockBitbucketLabelsResolver($data);
        }

        $resolver = new CompositeResolver($subResolvers);

        self::assertEquals($expected, $resolver->resolve(BitbucketPR::create(), new LabelsSettings(null)));
    }
}
