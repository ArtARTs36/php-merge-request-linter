<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Query\ViewerQuery;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Type\Viewer;

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
     */
    public function createViewer(array $response): Viewer
    {
        return new Viewer(
            $response['data']['viewer']['login'],
        );
    }
}
