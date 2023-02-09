<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Contracts\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

/**
 * The description must have a link to Jira on a {domain} with {projectCode}.
 */
class HasLinkToJiraTaskRule extends AbstractRule
{
    public const NAME = '@mr-linter/jira/has_issue_link';

    public function __construct(protected string $domain, protected string $projectCode)
    {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        return $request->description->match("#$domain\/browse\/$this->projectCode-\d#")->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'The description must have a link to Jira on domain "%s"',
            $this->domain,
        ));
    }
}
