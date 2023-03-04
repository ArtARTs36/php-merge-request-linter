<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder;

class EventFinder
{
    public function find(): array
    {
        return (new ClassFinder())->find('Event');
    }
}
