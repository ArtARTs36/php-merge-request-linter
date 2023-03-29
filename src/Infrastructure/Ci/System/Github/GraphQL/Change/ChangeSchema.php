<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Change;

use ArtARTs36\MergeRequestLinter\Domain\Request\DiffLine;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GivenInvalidPullRequestDataException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;

class ChangeSchema
{
    public function __construct(
        private readonly DiffMapper $diffMapper,
    ) {
        //
    }

    /**
     * @param array<mixed> $data
     */
    public function createChange(array $data, int $index): Change
    {
        return new Change(
            $this->getString($data, $index, 'filename'),
            $this->getDiff($data, $index),
            Status::create($this->getString($data, $index, 'status')),
        );
    }

    /**
     * @param array<mixed> $data
     * @return array<DiffLine>
     */
    private function getDiff(array $data, int $index): array
    {
        if (! array_key_exists('patch', $data)) {
            return [];
        }

        if (is_string($data['patch'])) {
            return $this->diffMapper->map($data['patch']);
        }

        return [];
    }

    /**
     * @param array<mixed> $data
     */
    private function getString(array $data, int $index, string $key): string
    {
        if (! array_key_exists($key, $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound('changes.'. $index . '.' . $key);
        }

        if (! is_string($data[$key])) {
            throw GivenInvalidPullRequestDataException::invalidType('changes.' . $index . '.' . $key, 'string');
        }

        return $data[$key];
    }
}
