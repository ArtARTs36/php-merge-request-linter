<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API\Objects\MergeRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Exceptions\GivenInvalidMergeRequestDataException;
use ArtARTs36\MergeRequestLinter\Infrastructure\Request\DiffMapper;

class MergeRequestSchema
{
    public function __construct(
        private readonly DiffMapper $diffMapper = new DiffMapper(),
    ) {
        //
    }

    /**
     * @param array<string, mixed> $response
     */
    public function createMergeRequest(array $response): MergeRequest
    {
        if (! array_key_exists('id', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('id');
        }

        if (! is_int($response['id'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('id', 'int');
        }

        if (! array_key_exists('iid', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('iid');
        }

        if (! is_int($response['iid'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('iid', 'int');
        }

        if (! array_key_exists('title', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('title');
        }

        if (! is_string($response['title'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('title', 'string');
        }

        if (! array_key_exists('description', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('description');
        }

        if (! is_string($response['description'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('description', 'string');
        }

        if (! array_key_exists('labels', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('labels');
        }

        if (! is_array($response['labels'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('labels', 'array<string>');
        }

        if (! array_key_exists('has_conflicts', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('has_conflicts');
        }

        if (! is_bool($response['has_conflicts'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('has_conflicts', 'bool');
        }

        if (! array_key_exists('source_branch', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('source_branch');
        }

        if (! is_string($response['source_branch'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('source_branch', 'string');
        }

        if (! array_key_exists('target_branch', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('target_branch');
        }

        if (! is_string($response['target_branch'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('target_branch', 'string');
        }

        if (! array_key_exists('author', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('author');
        }

        if (! is_array($response['author'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('author', 'array{username: string}');
        }

        if (! array_key_exists('username', $response['author'])) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('author.username');
        }

        if (! is_string($response['author']['username'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('author.username', 'string');
        }

        $draft = false;

        if (array_key_exists('draft', $response) && is_bool($response['draft'])) {
            $draft = $response['draft'];
        }

        if (! array_key_exists('merge_status', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('merge_status');
        }

        if (! is_string($response['merge_status'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('merge_status', 'string');
        }

        if (! array_key_exists('changes', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('changes');
        }

        if (! is_array($response['changes'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('changes', 'array');
        }

        $changes = $this->mapChanges($response['changes']);

        if (! array_key_exists('created_at', $response)) {
            throw GivenInvalidMergeRequestDataException::keyNotFound('created_at');
        }

        if (! is_string($response['created_at'])) {
            throw GivenInvalidMergeRequestDataException::invalidType('created_at', 'string');
        }

        try {
            $createdAt = new \DateTimeImmutable($response['created_at']);
        } catch (\Exception) {
            throw GivenInvalidMergeRequestDataException::invalidType('created_at', 'string of datetime');
        }

        $webUrl = '';

        if (array_key_exists('web_url', $response) && is_string($response['web_url'])) {
            $webUrl = $response['web_url'];
        }

        return new MergeRequest(
            $response['id'],
            $response['iid'],
            $response['title'],
            $response['description'],
            $response['labels'],
            $response['has_conflicts'],
            $response['source_branch'],
            $response['target_branch'],
            $response['author']['username'],
            $draft,
            $response['merge_status'],
            $changes,
            $createdAt,
            $webUrl,
        );
    }

    /**
     * @param array<array{new_path: string, old_path: string, diff: string|null}> $response
     * @return array<Change>
     */
    private function mapChanges(array $response): array
    {
        $changes = [];

        foreach ($response as $change) {
            $changes[] = new Change(
                $change['new_path'],
                $change['old_path'],
                $this->diffMapper->map($change['diff'] ?? ''),
            );
        }

        return $changes;
    }
}
