<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Mocks;

class Cwd
{
    private string $prevCwd;

    private string $cwd;

    public function __construct()
    {
        $this->prevCwd = getcwd();
        $this->cwd = $this->prevCwd;
    }

    public function set(string $cwd): self
    {
        $this->prevCwd = $this->cwd;
        $this->cwd = $cwd;

        return $this->update();
    }

    public function revert(): self
    {
        $this->set($this->prevCwd);

        return $this;
    }

    private function update(): self
    {
        chdir($this->cwd);

        return $this;
    }
}
