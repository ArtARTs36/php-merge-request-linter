<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\GraphqlException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayPathInvalidException;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\RawArray;

class QueryErrorProcessor
{
    private const ERROR_TYPE_NOT_FOUND = 'NOT_FOUND';

    /**
     * @param array<mixed> $response
     * @return array<mixed>
     * @throws GraphqlException
     */
    public function processQuery(array $response): array
    {
        $this->processErrors($response);

        return $response;
    }

    /**
     * @param array<mixed> $response
     * @throws GraphqlException
     */
    private function processErrors(array $response): void
    {
        if (! array_key_exists('errors', $response)) {
            return;
        }

        if (! is_array($response['errors'])) {
            throw new GraphqlException('Value of "response.errors" must be array');
        }

        $errorsBag = new RawArray($response['errors']);

        foreach ($errorsBag as $index => $error) {
            if (! is_array($error)) {
                throw new GraphqlException(sprintf('Value of "response.errors.%d" must be array', $index));
            }

            $errorRaw = new RawArray($error);

            try {
                $errorData = [
                    'type' => $errorRaw->string('type'),
                    'message' => $errorRaw->string('message'),
                ];
            } catch (ArrayPathInvalidException $e) {
                throw new GraphqlException(sprintf('Given invalid response: %s', $e->getMessage()), previous: $e);
            }

            throw $this->createException($errorData);
        }
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
