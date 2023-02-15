<?php

namespace ArtARTs36\MergeRequestLinter\Application\ToolInfo\InfoSubject;

/**
 * Interface for ToolInfo subjects.
 */
interface InfoSubject
{
    /**
     * Describe the subject.
     */
    public function describe(): string;
}
