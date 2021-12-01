<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Linter\LintError;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

class TitleStartsWithRule implements Rule
{
    /**
     * @param array<string> $prefixes
     */
    public function __construct(protected array $prefixes)
    {
        //
    }

    public static function make(string $prefix): self
    {
        return new self([$prefix]);
    }

    public function lint(MergeRequest $request): array
    {
        $starts = false;

        foreach ($this->prefixes as $prefix) {
            if ($request->title->startsWith($prefix)) {
                $starts = true;

                break;
            }
        }

        if ($starts) {
            return [];
        }

        return [
            new LintError('Title need starts with of one: ' . implode(',', $this->prefixes)),
        ];
    }
}
