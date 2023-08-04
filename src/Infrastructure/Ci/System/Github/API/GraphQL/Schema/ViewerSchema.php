<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Exceptions\InvalidResponseException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\Query;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type\Viewer;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayPathInvalidException;
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
     * @throws InvalidResponseException
     */
    public function createViewer(array $response): Viewer
    {
        $responseArray = new RawArray($response);

        try {
            $login = $responseArray->string('data.viewer.login');
        } catch (ArrayPathInvalidException $e) {
            throw InvalidResponseException::make(
                $e->getMessage(),
                $e,
            );
        }

        return Viewer::make($login);
    }
}
