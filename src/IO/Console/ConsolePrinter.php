<?php

namespace ArtARTs36\MergeRequestLinter\IO\Console;

use ArtARTs36\MergeRequestLinter\Contracts\HasDebugInfo;
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

    public function printTitle(string $title): void
    {
        $this->output->write($title, true);
        $this->output->write("\n");
    }

    public function printObject(object $object): void
    {
        $props = [];

        $this->buildProps($object, $props, '');

        $props = $this->separateProps($props);

        $table = (new Table($this->output))
            ->setHeaders(['Property', 'Value'])
            ->setRows($props);

        $table->setColumnMaxWidth(1, 100);

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

            if ($value instanceof HasDebugInfo) {
                $debugInfo = '';
                $debugBag = $value->__debugInfo();

                foreach ($debugBag as $field => $debugVal) {
                    $debugInfo .= sprintf(
                        '- %s: %s',
                        $field,
                        $this->prepareValue($debugVal),
                    );

                    if (next($debugBag) !== false) {
                        $debugInfo .= "\n";
                    }
                }

                $props[] = [$k, $debugInfo];
            } elseif (is_object($value) && ! $value instanceof \Stringable) {
                $prefix = $k;

                $this->buildProps($value, $props, $prefix);
            } else {
                $props[] = [$k, $this->prepareValue($value)];
            }

            $prefix = '';
        }
    }

    private function prepareValue(mixed $value): string
    {
        if (is_array($value)) {
            return json_encode($value);
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_string($value) || $value instanceof \Stringable) {
            return sprintf('"%s"', $value);
        }

        if ($value === null) {
            return 'null';
        }

        return '' . $value;
    }
}
