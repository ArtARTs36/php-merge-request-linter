<?php

namespace ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Reflector;

class ArrayObjectConverter
{
    public function __construct(
        private readonly TypeResolver $typeResolver,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @param class-string $class
     */
    public function convert(array $data, string $class): object
    {
        $reflector = new \ReflectionClass($class);
        $params = $this->mapParams($reflector, $data);

        return $reflector->newInstanceArgs($params);
    }

    /**
     * Map object param values.
     * @param \ReflectionClass<object> $reflector
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function mapParams(\ReflectionClass $reflector, array $data): array
    {
        $params = $data;

        $constructor = $reflector->getConstructor();

        if ($constructor === null) {
            return [];
        }

        foreach (Reflector::mapParamNameOnParam($constructor) as $parameter) {
            if (isset($params[$parameter->name])) {
                $paramValue = $params[$parameter->name];

                if ($this->typeResolver->canResolve($parameter->type, $paramValue)) {
                    $params[$parameter->name] = $this->typeResolver->resolve($parameter->type, $paramValue);
                }

                continue;
            }

            if ($parameter->hasDefaultValue) {
                $params[$parameter->name] = $parameter->getDefaultValue();
            } elseif ($parameter->type->class !== null &&
                class_exists($parameter->type->class) &&
                ! enum_exists($parameter->type->class) &&
                ! interface_exists($parameter->type->class) &&
                Reflector::canConstructWithoutParameters($parameter->type->class)
            ) {
                $params[$parameter->name] = $this->convert([], $parameter->type->class);
            } elseif ($parameter->type->nullable) {
                $params[$parameter->name] = null;
            } else {
                if ($parameter->hasExamples()) {
                    throw new ValueInvalidException(sprintf(
                        'Required parameter "%s" is missing. Example values: [%s]',
                        $parameter->name,
                        implode(', ', array_map(fn (Example $example) => $example->__toString(), $parameter->examples)),
                    ));
                }

                throw new ValueInvalidException(sprintf(
                    'Required parameter "%s" is missing',
                    $parameter->name,
                ));
            }
        }

        return $params;
    }
}
