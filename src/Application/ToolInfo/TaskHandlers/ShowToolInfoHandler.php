<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\TaskHandlers;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DefaultRules;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\BoolSubject;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\CollectionSubject;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\InfoSubject;
use ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject\StringSubject;
use ArtARTs36\MergeRequestLinter\Domain\ToolInfo\ToolInfo;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\ConfigFormat;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\DefaultSystems;
use ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfoFactory;
use ArtARTs36\MergeRequestLinter\Version;

class ShowToolInfoHandler
{
    public function __construct(
        private readonly ToolInfoFactory $toolInfoFactory,
    ) {
        //
    }

    /**
     * @return Arrayee<int, InfoSubject>
     */
    public function handle(): Arrayee
    {
        $toolInfo = $this->toolInfoFactory->create();

        return $this->createSubjects($toolInfo);
    }

    /**
     * @return Arrayee<int, InfoSubject>
     */
    private function createSubjects(ToolInfo $toolInfo): Arrayee
    {
        /** @var Arrayee<int, InfoSubject> $subjects */
        $subjects = new Arrayee([
            new StringSubject('Repository', \ArtARTs36\MergeRequestLinter\Infrastructure\ToolInfo\ToolInfo::REPO_URI),
            new StringSubject('Current version', Version::VERSION),
            new StringSubject('Latest version', $toolInfo->getLatestVersion()?->digit() ?? 'undefined'),
            new CollectionSubject('Supported config formats', ConfigFormat::list()),
            new StringSubject('Runtime', sprintf(
                'PHP %s with extensions: [%s]',
                PHP_VERSION,
                implode(', ', get_loaded_extensions()),
            )),
            new BoolSubject('Used as PHAR', $toolInfo->usedAsPhar()),
            new CollectionSubject('Supported CI Systems', DefaultSystems::map()->keys()),
            new CollectionSubject('Available rules', DefaultRules::map()->keys()),
        ]);

        return $subjects;
    }
}
