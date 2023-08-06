<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\Rest\Tag;

use ArtARTs36\Str\Str;

class TagHydrator
{
    /**
     * @param array<mixed> $response
     */
    public function hydrate(array $response): TagCollection
    {
        $tags = [];

        foreach ($response as $resp) {
            if (! is_array($resp) || ! array_key_exists('name', $resp) || ! is_string($resp['name'])) {
                throw new FetchTagsException('Tag name not found in response');
            }

            $name = Str::make($resp['name']);

            if ($name->startsWith('v')) {
                $name = $name->cut(null, 1);
            }

            [$major, $minor, $patch] = $name->explode('.')->toIntegers();

            $tags[] = new Tag(
                $resp['name'],
                $major,
                $minor,
                $patch,
            );
        }

        return new TagCollection($tags);
    }
}
