<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Loader\Mapper;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\MapProxy;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\Config;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\HttpClientConfig;
use ArtARTs36\MergeRequestLinter\Infrastructure\Configuration\Exceptions\ConfigInvalidException;

class ArrayConfigHydrator
{
    public function __construct(
        private readonly CredentialMapper $credentialMapper,
        private readonly RulesMapper $rulesMapper,
        private readonly NotificationsMapper $notificationsMapper,
    ) {
        //
    }

    /**
     * Hydrate raw array to Config object.
     * @param array<mixed> $data
     */
    public function hydrate(array $data): Config
    {
        if (! isset($data['rules']) || ! is_array($data['rules'])) {
            throw ConfigInvalidException::fromKey('rules');
        }

        $rules = $this->rulesMapper->map($data['rules']);

        $credentials = new MapProxy(function () use ($data) {
            return $this->credentialMapper->map($data['credentials']);
        });

        $notifications = $this->notificationsMapper->map($data['notifications'] ?? []);

        return new Config($rules, $credentials, new HttpClientConfig(
            $data['http_client']['type'] ?? HttpClientConfig::TYPE_DEFAULT,
            $data['http_client']['params'] ?? [],
        ), $notifications);
    }
}
