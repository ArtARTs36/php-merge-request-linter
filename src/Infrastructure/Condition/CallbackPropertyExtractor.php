<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition;

use ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Exceptions\PropertyNotExists;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\PropertyExtractor;

class CallbackPropertyExtractor implements PropertyExtractor
{
    public function __construct(
        private readonly TypeCaster $caster = new TypeCaster(),
    ) {
    }

    public function scalar(object $object, string $property): int|string|float|bool
    {
        return $this->caster->scalar($this->extract($object, $property));
    }

    public function interface(object $object, string $property, string $interface): mixed
    {
        return $this->caster->interface($interface, $this->extract($object, $property));
    }

    /**
     * @throws PropertyNotExists
     */
    private function extract(object $object, string $property): mixed
    {
        $properties = explode('.', $property);
        $obj = $object;
        $val = null;

        foreach ($properties as $prop) {
            $val = $this->doExtract($obj, $prop);

            if (is_object($val)) {
                $obj = $val;
            }
        }

        return $val;
    }

    /**
     * @throws PropertyNotExists
     */
    private function doExtract(object $object, string $property): mixed
    {
        if (! property_exists($object, $property)) {
            throw PropertyNotExists::make($property);
        }

        $extractor = function () use ($property) {
            return $this->$property;
        };

        return $extractor->call($object);
    }
}
