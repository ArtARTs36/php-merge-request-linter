<?php

namespace ArtARTs36\MergeRequestLinter\Rule\Condition;

use ArtARTs36\MergeRequestLinter\Support\Map;
use ArtARTs36\Str\Str;

class PropertyExtractor
{
    public function numeric(object $object, string $property): int|float
    {
        $val = $this->extract($object, $property);

        if (! is_numeric($val)) {
            throw new \Exception();
        }

        return $val;
    }

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

    public function iterable(object $object, string $property): array|Map
    {
        $val = $this->extract($object, $property);

        if (! is_array($val) && ! $val instanceof Map) {
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
