<?php

namespace ArtARTs36\MergeRequestLinter\Note;

use ArtARTs36\MergeRequestLinter\Contracts\Note;
use ArtARTs36\Str\Facade\Str;

final class ExceptionNote extends AbstractNote implements Note
{
    public function __construct(
        protected \Throwable $exception,
        protected string $message = '',
    ) {
        //
    }

    public static function withMessage(\Throwable $e, string $message): self
    {
        if (Str::isEmpty($message)) {
            throw new \InvalidArgumentException('$message is empty');
        }

        return new self($e, $message);
    }

    public function getDescription(): string
    {
        return implode(' :: ', array_filter([
            $this->message,
            $this->exception::class,
            $this->exception->getMessage(),
        ]));
    }
}
