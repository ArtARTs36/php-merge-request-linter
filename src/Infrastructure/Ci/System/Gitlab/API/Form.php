<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\API;

class Form
{
    public function __construct(
        public readonly array $body,
    ) {
        //
    }
}
