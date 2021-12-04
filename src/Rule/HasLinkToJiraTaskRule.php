<?php

namespace ArtARTs36\MergeRequestLinter\Rule;

use ArtARTs36\MergeRequestLinter\Request\MergeRequest;

/**
 * Description must have link to jira on {domain} with {projectCode}.
 */
class HasLinkToJiraTaskRule extends SimpleRule
{
    public function __construct(protected string $domain, protected string $projectCode)
    {
        parent::__construct('Description must have link to jira on '. $this->domain);
    }

    protected function doLint(MergeRequest $request): bool|array|null
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        return $request->description->match("#$domain\/browse\/$this->projectCode-\d#")->isNotEmpty();
    }
}
