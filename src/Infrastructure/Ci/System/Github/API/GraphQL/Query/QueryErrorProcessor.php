<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\GraphqlException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException;

class QueryErrorProcessor
{
    private const ERROR_TYPE_NOT_FOUND = 'NOT_FOUND';

    /**
     * @param array<mixed> $response
     * @throws GraphqlException
     */
    public function processQuery(array $response): array
    {
        if (array_key_exists('errors', $response) && is_array($response['errors'])) {
            foreach ($response['errors'] as $error) {
                if (is_array($error) &&
                    array_key_exists('type', $error) &&
                    is_string($error['type']) &&
                    array_key_exists('message', $error) &&
                    is_string($error['message'])
                ) {
                    throw $this->createException($error);
                }
            }
        }

        return $response;
    }

    /**
     * @param array{type: string, message: string} $error
     */
    private function createException(array $error): GraphqlException
    {
        if ($error['type'] === self::ERROR_TYPE_NOT_FOUND) {
            return new NotFoundException($error['message']);
        }

        return new GraphqlException(sprintf('%s: %s', $error['type'], $error['message']));
    }
}
