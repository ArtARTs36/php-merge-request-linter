<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;

final class EmptyCredentials implements Authenticator
{
    public function buildHeaders(): string
    {
        return '';
    }
}
