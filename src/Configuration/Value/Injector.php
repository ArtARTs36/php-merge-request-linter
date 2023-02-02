<?php

namespace ArtARTs36\MergeRequestLinter\Configuration\Value;

use ArtARTs36\MergeRequestLinter\Contracts\Config\ConfigValueTransformer;

class Injector
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    /**
     * @param array<mixed> $data
     * @return array<mixed>
     */
    public function inject(array $data): array
    {
        $this->doInject($data);

        return $data;
    }

    /**
     * @param array<mixed> $data
     */
    private function doInject(array &$data): void
    {
        foreach ($data as &$param) {
            if (is_array($param)) {
                $this->doInject($param);
            } elseif (is_string($param)) {
                $param = $this->valueTransformer->transform($param);
            }
        }
    }
}
