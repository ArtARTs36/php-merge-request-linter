<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GraphQL\Tag;

use ArtARTs36\MergeRequestLinter\Common\DataStructure\Arrayee;

/**
 * @template-extends Arrayee<int, Tag>
 */
class TagCollection extends Arrayee
{
    public function sortByMajority(): TagCollection
    {
        $tags = $this->items;

        usort($tags, function (Tag $tag1, Tag $tag2) {
            if ($tag1->major > $tag2->major) {
                return -1;
            }

            if ($tag1->major < $tag2->major) {
                return 1;
            }

            if ($tag1->minor > $tag2->minor) {
                return -1;
            }

            if ($tag1->minor < $tag2->minor) {
                return 1;
            }

            if ($tag1->patch > $tag2->patch) {
                return -1;
            }

            if ($tag1->patch < $tag2->patch) {
                return 1;
            }

            return 0;
        });

        return new TagCollection($tags);
    }
}
