<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Note;

final class ExceptionNote implements Note
{
    public function __construct(
        protected \Throwable $exception,
        protected string $message = '',
    ) {
        //
    }

    public static function withMessage(\Throwable $e, string $message): self
    {
        return new self($e, $message);
    }

    public function getDescription(): string
    {
        return implode(' -> ', [
            $this->message,
            $this->exception->getMessage(),
        ]);
    }
}
