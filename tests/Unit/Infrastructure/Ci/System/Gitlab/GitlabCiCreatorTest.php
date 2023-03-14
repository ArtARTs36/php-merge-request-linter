<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCiCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\NullClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use Psr\Log\NullLogger;

final class GitlabCiCreatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCiCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCiCreator::__construct
     */
    public function testCreate(): void
    {
        $creator = new GitlabCiCreator(
            new NullEnvironment(),
            new NullClient(),
            new NullLogger(),
        );

        self::assertInstanceOf(GitlabCi::class, $creator->create(new CiSettings(new NullAuthenticator(), [])));
    }
}
