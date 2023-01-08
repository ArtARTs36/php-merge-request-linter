<?php

namespace ArtARTs36\MergeRequestLinter\Console\Command;

use ArtARTs36\MergeRequestLinter\CI\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Console\Application\Application;
use ArtARTs36\MergeRequestLinter\Rule\DefaultRules;
use ArtARTs36\MergeRequestLinter\Support\ToolInfo\ToolInfo;
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
            sprintf('Repository: %s', ToolInfo::REPO_URI),
            sprintf('Current version: %s', Application::VERSION),
            fn () => sprintf('Latest version: %s', $toolInfo->getLatestVersion()?->digit() ?? 'undefined'),
            sprintf('Used as PHAR: %s', $toolInfo->usedAsPhar() ? 'true' : 'false'),
            sprintf('Supported CI Systems: %s', DefaultSystems::map()->keys()->implode(', ')),
            sprintf('Available rules: [%s]', DefaultRules::map()->keys()->implode(', ')),
        ]);

        return self::SUCCESS;
    }

    /**
     * @param array<string|callable(): string> $lines
     */
    private function printList(OutputInterface $output, array $lines): void
    {
        foreach ($lines as $line) {
            $line = is_callable($line) ? $line() : $line;

            $output->write('- '. $line);
            $output->write("\n");
        }
    }
}
