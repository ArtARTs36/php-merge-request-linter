<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StringConsoleOutput implements OutputInterface
{
    private string $messages = '';

    public function __construct(
        private OutputFormatterInterface $outputFormatter = new OutputFormatter(),
    ) {
        //
    }

    public function write(iterable|string $messages, bool $newline = false, int $options = 0)
    {
        $messages = is_iterable($messages) ? $messages : [$messages];

        if ($newline) {
            $this->writeln($messages);

            return;
        }

        foreach ($messages as $message) {
            $this->messages .= $message;
        }
    }

    public function writeln(iterable|string $messages, int $options = 0)
    {
        $messages = is_iterable($messages) ? $messages : [$messages];

        foreach ($messages as $message) {
            $this->messages .= "\n" . $message;
        }
    }

    public function setVerbosity(int $level)
    {
        //
    }

    public function getVerbosity(): int
    {
        return 256;
    }

    public function isQuiet(): bool
    {
        return false;
    }

    public function isVerbose(): bool
    {
        return true;
    }

    public function isVeryVerbose(): bool
    {
        return true;
    }

    public function isDebug(): bool
    {
        return false;
    }

    public function setDecorated(bool $decorated)
    {
        //
    }

    public function isDecorated(): bool
    {
        return false;
    }

    public function setFormatter(OutputFormatterInterface $formatter)
    {
        $this->outputFormatter = $formatter;
    }

    public function getFormatter(): OutputFormatterInterface
    {
        return $this->outputFormatter;
    }

    public function assertContainsMessages(array $expect): void
    {
        foreach ($expect as $msg) {
            Assert::assertStringContainsString($msg, $this->messages);
        }
    }
}
