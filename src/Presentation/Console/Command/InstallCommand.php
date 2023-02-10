<?php

namespace ArtARTs36\MergeRequestLinter\Presentation\Console\Command;

use ArtARTs36\MergeRequestLinter\Application\Configuration\Copier;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Support\File\Directory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InstallCommand extends Command
{
    protected static $defaultName = 'install';

    protected static $defaultDescription = 'Install this tool';

    public function __construct(
        private readonly Copier $configCopier,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->getDefinition()
            ->addOption(new InputOption('format', mode: InputOption::VALUE_OPTIONAL));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $dir = $this->getWorkDir($input);
        $format = $this->resolveConfigFormat($input);

        $createdFile = $this->configCopier->copy($format, new Directory($dir));

        $style->info(sprintf('Was copied configuration file to: %s [%s]', $createdFile, $createdFile->getSizeString()));

        return self::SUCCESS;
    }

    private function resolveConfigFormat(InputInterface $input): ConfigFormat
    {
        if ($input->getOption('format') !== null) {
            return ConfigFormat::from($input->getOption('format'));
        }

        return ConfigFormat::PHP;
    }
}
