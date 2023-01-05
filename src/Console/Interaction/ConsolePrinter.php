<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\Printer;
use Symfony\Component\Console\Style\StyleInterface;

class ConsolePrinter implements Printer
{
    public function __construct(
        private readonly StyleInterface $output,
    ) {
        //
    }

    public function printObject(object $object): void
    {
        $props = [];

        $this->buildProps($object, $props, '');

        $this->output->table(
            ['property', 'value'],
            $props,
        );
    }

    /**
     * @param array<mixed> $props
     */
    private function buildProps(object $object, array &$props, string $prefix): void
    {
        foreach (get_object_vars($object) as $key => $value) {
            if ($prefix === '') {
                $k = $key;
            } else {
                $k = $prefix . '.' . $key;
            }

            if (is_bool($value)) {
                $props[] = [$k, $value ? 'true' : 'false'];
            } elseif (is_string($value) || $value instanceof \Stringable) {
                $props[] = [$k, sprintf('"%s"', $value)];
            } elseif (is_scalar($value)) {
                $props[] = [$k, $value];
            } elseif(is_object($value)) {
                if ($prefix === '') {
                    $prefix = $key;
                } else {
                    $prefix .= '.' . $key;
                }

                $this->buildProps($value, $props, $prefix);
            }
        }
    }
}
