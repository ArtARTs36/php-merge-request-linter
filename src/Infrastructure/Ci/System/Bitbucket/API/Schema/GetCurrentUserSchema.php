<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\User;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class GetCurrentUserSchema
{
    /**
     * @param array<mixed> $data
     */
    public function createResponse(array $data): User
    {
        $raw = new RawArray($data);

        return new User(
            $raw->string('display_name'),
            $raw->string('account_id'),
        );
    }
}
