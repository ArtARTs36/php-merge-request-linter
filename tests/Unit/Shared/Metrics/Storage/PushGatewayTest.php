<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Metrics\Storage;

use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Client;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway;
use ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\Renderer;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class PushGatewayTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway::commit
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Metrics\Storage\PrometheusPushGateway\PushGateway::__construct
     */
    public function testCommit(): void
    {
        $id = '12432-4343';
        $renderedVal = 'metric-content';

        $client = $this->createMock(Client::class);
        $client
            ->expects(new InvokedCount(1))
            ->method('replace')
            ->with($id, $renderedVal);

        $renderer = $this->createMock(Renderer::class);
        $renderer
            ->expects(new InvokedCount(1))
            ->method('render')
            ->willReturn($renderedVal);

        $gateway = new PushGateway($client, $renderer);

        $gateway->commit($id, []);
    }
}
