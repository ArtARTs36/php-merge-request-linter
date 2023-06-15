<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class ViewerSchema
{
    private const QUERY = 'query { 
  viewer { 
    login
  }
}';

    public function createQuery(): Query
    {
        return Query::withoutVariables(self::QUERY);
    }

    /**
     * @param array<string, mixed> $response
     * @throws \Exception
     */
    public function createViewer(array $response): Viewer
    {
        $login = RawArray::path($response, 'data.viewer.login');

        if (! is_string($login)) {
            throw new \Exception('Viewer login must be string');
        }

        return new Viewer(
            $login,
        );
    }
}
