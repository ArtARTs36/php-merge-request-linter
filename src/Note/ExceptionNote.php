<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;

final class ExceptionNote extends AbstractNote implements Note
{
    protected const SEVERITY = NoteSeverity::Fatal;

    public function __construct(
        protected \Throwable $exception,
    ) {
        //
    }

    public function getDescription(): string
    {
        if ($this->exception->getMessage() !== '') {
            return sprintf('%s (exception %s)', $this->exception->getMessage(), $this->exception::class);
        }

        return sprintf('Exception %s', $this->exception::class);
    }
}
