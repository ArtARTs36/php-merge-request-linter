<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\SshKeyFinder;

class RuleProvider extends Provider
{
    public function provide(): void
    {
        $this->container->set(SshKeyFinder::class, new CompositeKeyFinder([
            new RsaKeyFinder(),
        ]));
    }
}
