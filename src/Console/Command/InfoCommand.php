<?php

namespace ArtARTs36\MergeRequestLinter\Console\Command;

use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Console\Application\Application;
use ArtARTs36\MergeRequestLinter\Support\ToolInfo\ToolInfoFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    protected static $defaultName = 'info';

    protected static $defaultDescription = 'Print info about Application';

    public function __construct(
        private readonly ToolInfoFactory $toolInfoFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(' <info>Merge Request Linter</info> - tool for validating merge/pull requests');
        $output->write("\n");
        $output->write("\n");

        $toolInfo = $this->toolInfoFactory->create();

        $this->printList($output, [
            fn () => 'Repository: https://github.com/ArtARTs36/php-merge-request-linter',
            fn () => sprintf('Current version: %s', Application::VERSION),
            fn () => sprintf('Latest version: %s', $toolInfo->getLatestVersion()?->digit() ?? 'undefined'),
            fn () => sprintf('Used as PHAR: %s', $toolInfo->usedAsPhar() ? 'true' : 'false'),
            fn () => sprintf('Supported CI Systems: %s', DefaultSystems::map()->keys()->implode(', ')),
        ]);

        return self::SUCCESS;
    }

    /**
     * @param array<callable(): string> $lines
     */
    private function printList(OutputInterface $output, array $lines): void
    {
        foreach ($lines as $line) {
            $output->write('- '. $line());
            $output->write("\n");
        }
    }
}
