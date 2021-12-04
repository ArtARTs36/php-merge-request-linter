# Creating custom rule

You can create self rules for requests' validate.

You need to implement the interface [ArtARTs36\MergeRequestLinter\Contracts\Rule](../src/Contracts/Rule.php) and add to "rules" in `.mr-linter.php`.
```php
/**
 * Rule for lint merge request
 */
interface Rule
{
    /**
     * Lint merge request by specifics rules
     * Returns empty array if notes not found.
     * @return array<Note>
     * @throws StopLintException
     * @throws LintException
     */
    public function lint(MergeRequest $request): array;

    /**
     * Get rule definition
     */
    public function getDefinition(): RuleDefinition;
}
```

### Example

```php
<?php

use ArtARTs36\MergeRequestLinter\Contracts\Rule;
use ArtARTs36\MergeRequestLinter\Contracts\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Rule\Definition;

class ExampleRule implements Rule
{
    public function lint(MergeRequest $request): array
    {
        if (! $request->title->startsWith('TASK-')) {
            return [new LintNote("Prefix 'TASK' not found!")];
        }
        
        return [];
    }
    
    public function getDefinition(): RuleDefinition
    {
        return new Definition("Title must have prefix 'task'");
    }
}
```

