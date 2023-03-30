<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\CiSettings;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\NullAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActionsCreator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\NullEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Client\NullClient;
use ArtARTs36\MergeRequestLinter\Infrastructure\Logger\NullContextLogger;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class GithubActionsCreatorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActionsCreator::create
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActionsCreator::__construct
     */
    public function testCreate(): void
    {
        $creator = new GithubActionsCreator(
            new NullEnvironment(),
            new NullClient(),
            new NullContextLogger(),
        );

        self::assertInstanceOf(GithubActions::class, $creator->create(new CiSettings(new NullAuthenticator(), [])));
    }
}
