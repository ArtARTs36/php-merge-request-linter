<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Linter\Note;
use ArtARTs36\Str\Facade\Str;

final class ExceptionNote extends AbstractNote implements Note
{
    protected const SEVERITY = NoteSeverity::Fatal;

    public function __construct(
        protected \Throwable $exception,
        protected string $message = '',
    ) {
        //
    }

    public function getDescription(): string
    {
        return sprintf('%s (exception %s)', $this->getMessage(), $this->exception::class);
    }

    private function getMessage(): string
    {
        return Str::isNotEmpty($this->message) ?
            $this->message :
            $this->exception->getMessage();
    }
}
