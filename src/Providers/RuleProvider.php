<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\PrivateKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;

/**
 * @codeCoverageIgnore
 */
class RuleProvider extends Provider
{
    public function provide(): void
    {
        $this->container->bind(SshKeyFinder::class, static function () {
            return new CompositeKeyFinder([
                new RsaKeyFinder(),
                new PrivateKeyFinder(),
            ]);
        });
    }
}
