<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Request;

use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\Str\Exceptions\InvalidRegexException;

readonly class Diff
{
    /**
     * @param Arrayee<int, DiffFragment> $oldFragments
     * @param Arrayee<int, DiffFragment> $newFragments
     * @param Arrayee<int, DiffFragment> $notChangedFragments
     * @param Arrayee<int, DiffFragment> $allFragments
     */
    public function __construct(
        public Arrayee $oldFragments,
        public Arrayee $newFragments,
        public Arrayee $notChangedFragments,
        public Arrayee $allFragments,
    ) {
    }

    public static function empty(): self
    {
        return self::fromList([]);
    }

    /**
     * @param array<DiffFragment> $fragmentList
     */
    public static function fromList(array $fragmentList): self
    {
        $fragments = [
            DiffType::OLD->value => [],
            DiffType::NEW->value => [],
            DiffType::NOT_CHANGES->value => [],
            'all' => [],
        ];

        foreach ($fragmentList as $fragment) {
            $fragments[$fragment->type->value][] = $fragment;
            $fragments['all'][] = $fragment;
        }

        return new self(
            new Arrayee($fragments[DiffType::OLD->value]),
            new Arrayee($fragments[DiffType::NEW->value]),
            new Arrayee($fragments[DiffType::NOT_CHANGES->value]),
            new Arrayee($fragments['all']),
        );
    }

    public function hasChangeByContentContains(string $content): bool
    {
        foreach ($this->newFragments as $fragment) {
            if ($fragment->content->contains($content)) {
                return true;
            }
        }

        foreach ($this->oldFragments as $fragment) {
            if ($fragment->content->contains($content)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws InvalidRegexException
     */
    public function hasChangeByContentContainsByRegex(string $regex): bool
    {
        foreach ($this->newFragments as $fragment) {
            if ($fragment->content->match($regex)->isNotEmpty()) {
                return true;
            }
        }

        foreach ($this->oldFragments as $fragment) {
            if ($fragment->content->match($regex)->isNotEmpty()) {
                return true;
            }
        }

        return false;
    }

    public function changesCount(): int
    {
        return $this->newFragments->count() + $this->oldFragments->count();
    }

    public function hasChanges(): bool
    {
        return $this->changesCount() > 0;
    }
}
