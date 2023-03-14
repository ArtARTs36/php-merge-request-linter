<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\DescriptionLabelsResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\BitbucketPR;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class DescriptionLabelsResolverTest extends TestCase
{
    public function providerForTestResolve(): array
    {
        return [
            [
                BitbucketPR::create(
                    description: Str::make("Text \nSuperPrefix: Feature, Bug"),
                ),
                ['line_starts_with' => 'SuperPrefix: ', 'separator' => ', '],
                ['Feature', 'Bug'],
            ],
            [
                BitbucketPR::create(
                    description: Str::make("Text \nSuperPrefix: Feature, Bug"),
                ),
                null,
                [],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\DescriptionLabelsResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels\DescriptionLabelsResolver::findLabels
     * @dataProvider providerForTestResolve
     */
    public function testResolve(PullRequest $pr, ?array $settings, array $expected): void
    {
        $resolver = new DescriptionLabelsResolver();

        self::assertEquals($expected, $resolver->resolve($pr, new LabelsSettings($settings)));
    }
}
