<?php

namespace ArtARTs36\MergeRequestLinter\Domain\Linter;

enum LintState: int
{
    case Success = 1;
    case Risky = 2;
    case Fail = 3;
}
