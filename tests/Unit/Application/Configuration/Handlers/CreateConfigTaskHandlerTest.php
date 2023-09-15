<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Application\Configuration\Handlers;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler;
use ArtARTs36\MergeRequestLinter\Application\Configuration\Tasks\CreateConfigTask;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Shared\File\Directory;
use ArtARTs36\MergeRequestLinter\Shared\File\File;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use PHPUnit\Framework\MockObject\Rule\InvokedCount;

final class CreateConfigTaskHandlerTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler::handle
     * @covers \ArtARTs36\MergeRequestLinter\Application\Configuration\Handlers\CreateConfigTaskHandler::__construct
     */
    public function testHandle(): void
    {
        $copier = $this->createMock(Copier::class);
        $copier
            ->expects(new InvokedCount(1))
            ->method('copy')
            ->willReturn($file = new File('config.yaml'));

        $handler = new CreateConfigTaskHandler($copier);

        self::assertEquals(
            $file,
            $handler->handle(new CreateConfigTask(ConfigFormat::YAML, new Directory(''))),
        );
    }
}
