<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Application\Application;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\ListPrinter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    protected static $defaultName = 'info';

    protected static $defaultDescription = 'Print info about Application';

    public function __construct(
        private readonly ToolInfoFactory $toolInfoFactory,
        private readonly ListPrinter $listPrinter = new ListPrinter(),
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(' <info>Merge Request Linter</info> - tool for validating merge/pull requests');
        $output->write("\n");
        $output->write("\n");

        $toolInfo = $this->toolInfoFactory->create();

        $this->listPrinter->print($output, [
            sprintf('Repository: %s', ToolInfo::REPO_URI),
            sprintf('Current version: %s', Application::VERSION),
            fn () => sprintf('Latest version: %s', $toolInfo->getLatestVersion()?->digit() ?? 'undefined'),
            sprintf('Supported config formats: [%s]', ConfigFormat::list()->implode(', ')),
            sprintf('Used as PHAR: %s', $toolInfo->usedAsPhar() ? 'true' : 'false'),
            sprintf('Supported CI Systems: %s', DefaultSystems::map()->keys()->implode(', ')),
            sprintf('Available rules: [%s]', DefaultRules::map()->keys()->implode(', ')),
        ]);

        return self::SUCCESS;
    }
}
