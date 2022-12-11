<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\Str\Str;

class PropertyExtractor
{
    /**
     * @throws \Exception
     */
    public function scalar(object $object, string $property): int|string|float|bool
    {
        $val = $this->extract($object, $property);

        if (! is_scalar($val) && ! $val instanceof Str) {
            throw new \Exception();
        }

        return $val;
    }

    /**
     * @throws \Exception
     */
    private function extract(object $object, string $property): mixed
    {
        if (! property_exists($object, $property)) {
            throw new \Exception();
        }

        $extractor = function () use ($property) {
            return $this->$property;
        };

        return $extractor->call($object);
    }
}
