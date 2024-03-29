<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Loaders;

use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper\ArrayConfigHydrator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigLoader;

final class StaticLoader implements ConfigLoader
{
    /**
     * @param array<mixed> $config
     */
    public function __construct(
        private readonly ArrayConfigHydrator $hydrator,
        private readonly array               $config,
    ) {
    }

    public function load(string $path, int $subjects = Config::SUBJECT_ALL): Config
    {
        return $this->hydrator->hydrate($this->config, $subjects);
    }
}
