<?php

namespace ArtARTs36\MergeRequestLinter\Console\Interaction;

use ArtARTs36\MergeRequestLinter\Contracts\IO\Printer;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class ConsolePrinter implements Printer
{
    public function __construct(
        private readonly OutputInterface $output,
    ) {
        //
    }

    public function printObject(object $object): void
    {
        $props = [];

        $this->buildProps($object, $props, '');

        $props = $this->separateProps($props);

        $table = (new Table($this->output))
            ->setHeaders(['Property', 'Value'])
            ->setRows($props);

        $table->render();

        $this->output->write("\n");
    }

    /**
     * @param array<array{string, string}> $props
     * @return array<array{string, string}|TableSeparator>
     */
    private function separateProps(array $props): array
    {
        $separated = [];

        foreach ($props as $prop) {
            $separated[] = $prop;

            if (next($props) !== false) {
                $separated[] = new TableSeparator();
            }
        }

        return $separated;
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
            } elseif (is_object($value)) {
                $prefix = $k;

                $this->buildProps($value, $props, $prefix);
            }
        }
    }
}
