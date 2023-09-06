<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Map;

class SystemFactory implements CiSystemFactory
{
    /**
     * @param Map<string, SystemCreator> $creators
     */
    public function __construct(
        private readonly Config $config,
        private readonly Map $creators,
    ) {
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->config->getSettings() as $ciName => $ciSettings) {
            $creator = $this->creators->get($ciName);

            if ($creator === null) {
                throw CiNotSupported::fromCiName($ciName);
            }

            $ci = $creator->create($ciSettings);

            if ($ci->isCurrentlyWorking()) {
                return $ci;
            }
        }

        throw new CiNotSupported('CI not detected');
    }
}
