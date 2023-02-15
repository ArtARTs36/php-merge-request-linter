<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\ToolInfo\TaskHandlers\ShowToolInfoHandler;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\InfoSubject;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Printers\ListPrinter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InfoCommand extends Command
{
    protected static $defaultName = 'info';

    protected static $defaultDescription = 'Print info about Application';

    public function __construct(
        private readonly ShowToolInfoHandler $handler,
        private readonly ListPrinter $listPrinter = new ListPrinter(),
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(' <info>Merge Request Linter</info> - tool for validating merge/pull requests');
        $output->write("\n");
        $output->write("\n");

        $this->listPrinter->print($output, $this->handler->handle()->mapToArray(function (InfoSubject $subject) {
            return $subject->describe();
        }));

        return self::SUCCESS;
    }
}
