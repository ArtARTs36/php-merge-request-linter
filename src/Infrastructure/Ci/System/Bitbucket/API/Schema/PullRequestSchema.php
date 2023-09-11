<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Schema;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\Objects\PullRequestState;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Exceptions\GivenInvalidPullRequestDataException;
use ArtARTs36\MergeRequestLinter\Shared\Time\Clock;
use ArtARTs36\Str\Str;

class PullRequestSchema
{
    public function __construct(
        private readonly Clock $clock,
    ) {
    }

    /**
     * @param array<mixed> $data
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Exceptions\GivenInvalidPullRequestDataException
     */
    public function createPullRequest(array $data): PullRequest
    {
        return new PullRequest(
            $this->getInt($data, 'id'),
            $this->getString($data, 'title'),
            $this->getAuthorNickname($data),
            $this->getBranch($data, 'source'),
            $this->getBranch($data, 'destination'),
            $this->getDate($data, 'created_on'),
            $this->getLink($data, 'html'),
            Str::make($this->getString($data, 'description')),
            PullRequestState::create($this->getString($data, 'state')),
            $this->getLink($data, 'diff'),
        );
    }

    /**
     * @param array<mixed> $data
     */
    private function getLink(array $data, string $type): string
    {
        if (! array_key_exists('links', $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound('links');
        }

        if (! is_array($data['links'])) {
            throw GivenInvalidPullRequestDataException::invalidType('links', 'array');
        }

        if (! array_key_exists($type, $data['links'])) {
            throw GivenInvalidPullRequestDataException::keyNotFound('links.' . $type);
        }

        if (! is_array($data['links'][$type])) {
            throw GivenInvalidPullRequestDataException::invalidType('links.' . $type, 'array');
        }

        if (! array_key_exists('href', $data['links'][$type])) {
            throw GivenInvalidPullRequestDataException::keyNotFound('links.' . $type . '.href');
        }

        if (! is_string($data['links'][$type]['href'])) {
            throw GivenInvalidPullRequestDataException::invalidType('links.' . $type . '.href', 'string');
        }

        return $data['links'][$type]['href'];
    }

    /**
     * @param array<mixed> $data
     */
    private function getDate(array $data, string $key): \DateTimeImmutable
    {
        if (! array_key_exists($key, $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound($key);
        }

        if (! is_string($data[$key])) {
            throw GivenInvalidPullRequestDataException::invalidType($key, 'string of date');
        }

        try {
            return $this->clock->create($data[$key]);
        } catch (\Exception $e) {
            throw GivenInvalidPullRequestDataException::invalidType($key, 'string of date', $e);
        }
    }

    /**
     * @param array<mixed> $data
     */
    private function getBranch(array $data, string $type): string
    {
        if (! array_key_exists($type, $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound($type);
        }

        if (! is_array($data[$type])) {
            throw GivenInvalidPullRequestDataException::invalidType($type, 'array');
        }

        if (! array_key_exists('branch', $data[$type])) {
            throw GivenInvalidPullRequestDataException::keyNotFound($type . '.branch');
        }

        if (! is_array($data[$type]['branch'])) {
            throw GivenInvalidPullRequestDataException::invalidType($type . '.branch', 'array');
        }

        if (! array_key_exists('name', $data[$type]['branch'])) {
            throw GivenInvalidPullRequestDataException::keyNotFound($type . '.branch.name');
        }

        if (! is_string($data[$type]['branch']['name'])) {
            throw GivenInvalidPullRequestDataException::invalidType($type . '.branch.name', 'string');
        }

        return $data[$type]['branch']['name'];
    }

    /**
     * @param array<mixed> $data
     */
    private function getAuthorNickname(array $data): string
    {
        if (! array_key_exists('author', $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound('author');
        }

        if (! is_array($data['author'])) {
            throw GivenInvalidPullRequestDataException::invalidType('author', 'array');
        }

        return $this->getString($data['author'], 'nickname');
    }

    /**
     * @param array<mixed> $data
     */
    private function getString(array $data, string $key): string
    {
        if (! array_key_exists($key, $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound($key);
        }

        if (! is_string($data[$key])) {
            throw GivenInvalidPullRequestDataException::invalidType($key, 'string');
        }

        return $data[$key];
    }

    /**
     * @param array<mixed> $data
     */
    private function getInt(array $data, string $key): int
    {
        if (! array_key_exists($key, $data)) {
            throw GivenInvalidPullRequestDataException::keyNotFound($key);
        }

        if (! is_int($data[$key])) {
            throw GivenInvalidPullRequestDataException::invalidType($key, 'int');
        }

        return $data[$key];
    }
}
