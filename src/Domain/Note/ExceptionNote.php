<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Note;

final class ExceptionNote extends AbstractNote implements Note
{
    protected NoteSeverity $severity = NoteSeverity::Fatal;

    public function __construct(
        private readonly \Throwable $exception,
    ) {
    }

    public function getDescription(): string
    {
        if ($this->exception->getMessage() !== '') {
            return sprintf(
                '%s (exception %s on %s#%d)',
                $this->exception->getMessage(),
                $this->exception::class,
                $this->exception->getFile(),
                $this->exception->getLine(),
            );
        }

        return sprintf('Exception %s', $this->exception::class);
    }

    public function withSeverity(NoteSeverity $severity): Note
    {
        $note = new ExceptionNote(
            $this->exception,
        );

        $note->severity = $severity;

        return $note;
    }
}
