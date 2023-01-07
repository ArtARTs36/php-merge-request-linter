<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Ci\System;

use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequest;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\API\MergeRequestInput;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\Env\GitlabEnvironment;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Contracts\CI\GitlabClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GitlabCiTest extends TestCase
{
    public function providerForTestIs(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['GITLAB_CI' => 'true'],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIs
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\GitlabCi::is
     */
    public function testIs(array $env, bool $expected): void
    {
        self::assertEquals($expected, GitlabCi::is($this->makeEnvironment($env)));
    }

    public function providerForTestIsMergeRequest(): array
    {
        return [
            [
                [],
                false,
            ],
            [
                ['CI_MERGE_REQUEST_IID' => 1],
                true,
            ],
        ];
    }

    /**
     * @dataProvider providerForTestIsMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\GitlabCi::isMergeRequest
     * @covers \ArtARTs36\MergeRequestLinter\Ci\System\Gitlab\GitlabCi::__construct
     */
    public function testIsMergeRequest(array $env, bool $expected): void
    {
        self::assertEquals($expected, $this->makeCi($env)->isMergeRequest());
    }

    private function makeCi(array $env): GitlabCi
    {
        return new GitlabCi(new GitlabEnvironment($this->makeEnvironment($env)), new class () implements GitlabClient {
            public function getMergeRequest(MergeRequestInput $input): MergeRequest
            {
                // TODO: Implement getMergeRequest() method.
            }
        });
    }
}
