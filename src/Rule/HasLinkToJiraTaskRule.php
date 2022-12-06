<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * The description must have a link to Jira on a {domain} with {projectCode}.
 */
class HasLinkToJiraTaskRule extends SimpleRule
{
    public const NAME = '@mr-linter/jira/has_issue_link';

    public function __construct(protected string $domain, protected string $projectCode)
    {
        parent::__construct('The description must have a link to Jira on '. $this->domain);
    }

    protected function doLint(MergeRequest $request): bool|array|null
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        return $request->description->match("#$domain\/browse\/$this->projectCode-\d#")->isNotEmpty();
    }
}
