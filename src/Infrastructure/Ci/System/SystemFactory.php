<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System;

use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;
use ArtARTs36\MergeRequestLinter\Domain\CI\CiSystem;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Exceptions\CiNotSupported;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\CredentialsNotSetException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;

class SystemFactory implements CiSystemFactory
{
    /**
     * @param Map<string, SystemCreator> $creators
     */
    public function __construct(
        private readonly Config $config,
        private readonly Map $creators,
    ) {
        //
    }

    public function createCurrently(): CiSystem
    {
        foreach ($this->creators as $name => $ciClass) {
            try {
                $ci = $this->create($name);
            } catch (CredentialsNotSetException) {
                continue;
            }

            if ($ci->isCurrentlyWorking()) {
                return $ci;
            }
        }

        throw new CiNotSupported('CI not detected');
    }

    public function create(string $ciName): CiSystem
    {
        $creator = $this->creators->get($ciName);

        if ($creator === null) {
            throw CiNotSupported::fromCiName($ciName);
        }

        $settings = $this->config->getSettings()->get($ciName);

        if ($settings === null) {
            throw CredentialsNotSetException::create($ciName);
        }

        return $creator->create($settings);
    }
}
