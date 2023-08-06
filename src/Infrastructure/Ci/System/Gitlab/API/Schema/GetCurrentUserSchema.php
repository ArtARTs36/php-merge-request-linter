<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class GetCurrentUserSchema
{
    /**
     * @param array<string, mixed> $response
     */
    public function createUser(array $response): User
    {
        $responseArray = new RawArray($response);

        return new User(
            $responseArray->int('id'),
            $responseArray->string('username'),
        );
    }
}
