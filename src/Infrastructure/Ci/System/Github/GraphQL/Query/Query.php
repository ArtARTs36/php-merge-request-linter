<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Query;

class Query
{
    /**
     * @param array<string, mixed> $variables
     */
    public function __construct(
        public readonly string $query,
        public readonly array $variables,
    ) {
        //
    }

    public static function withoutVariables(string $query): self
    {
        return new self($query, []);
    }
}
