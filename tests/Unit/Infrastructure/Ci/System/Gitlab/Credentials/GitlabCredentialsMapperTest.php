<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Gitlab\Credentials;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Value\CompositeTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\InvalidCredentialsException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class GitlabCredentialsMapperTest extends TestCase
{
    public function providerForTestMap(): array
    {
        return [
            [
                'credentials' => [
                    'token' => '123',
                ],
                'expectedHeaderName' => 'PRIVATE-TOKEN',
            ],
            [
                'credentials' => [
                    'job_token' => '123',
                ],
                'expectedHeaderName' => 'JOB-TOKEN',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::__construct
     *
     * @dataProvider providerForTestMap
     */
    public function testMap(array $credentials, string $expectedHeaderName): void
    {
        $mapper = new GitlabCredentialsMapper(new CompositeTransformer([]));

        $authenticator = $mapper->map($credentials);

        self::assertInstanceOf(HeaderAuthenticator::class, $authenticator);
        self::assertEquals($expectedHeaderName, $authenticator->__debugInfo()['header']['name']);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::map
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::__construct
     */
    public function testMapOnInvalidCredentials(): void
    {
        $mapper = new GitlabCredentialsMapper(new CompositeTransformer([]));

        self::expectException(InvalidCredentialsException::class);

        $mapper->map([]);
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials\GitlabCredentialsMapper::map
     */
    public function testMapOnTransformReturnsEmptyValue(): void
    {
        $transformer = $this->createMock(ConfigValueTransformer::class);
        $transformer
            ->expects(new InvokedCount(1))
            ->method('tryTransform')
            ->willReturn('');

        $mapper = new GitlabCredentialsMapper($transformer);

        self::expectExceptionMessage('Failed to resolve gitlab token: value is empty');

        $mapper->map([
            'token' => '${}',
        ]);
    }
}
