<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Bitbucket\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\BasicBase64Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\CompositeAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HostAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\TokenAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\CompositeTransformer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class BitbucketCredentialsMapperTest extends TestCase
{
    public function providerForTestMap(): array
    {
        return [
            [
                [
                    'token' => '12',
                ],
                [
                    TokenAuthenticator::class,
                ],
            ],
            [
                [
                    'host' => '12',
                ],
                [
                    HostAuthenticator::class,
                ],
            ],
            [
                [
                    'app_password' => [
                        'user' => 'user',
                        'password' => 'password',
                    ],
                ],
                [
                    BasicBase64Authenticator::class,
                ],
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::createTokenAuthenticator
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::createHostAuthenticator
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::createAppPasswordAuthenticator
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::getAppPasswordSubject
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Credentials\BitbucketCredentialsMapper::__construct
     * @dataProvider providerForTestMap
     */
    public function testMap(array $credentials, array $authenticatorClasses): void
    {
        $mapper = new BitbucketCredentialsMapper(new CompositeTransformer([]));

        $result = $mapper->map($credentials);

        self::assertInstanceOf(CompositeAuthenticator::class, $result);
        self::assertEquals($authenticatorClasses, array_map(function (Authenticator $authenticator) {
            return get_class($authenticator);
        }, $result->getAuthenticators()));
    }
}
