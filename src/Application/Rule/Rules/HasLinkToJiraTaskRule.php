<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;

/**
 * The description must have a link to Jira on a {domain} with {projectCode}.
 */
final class HasLinkToJiraTaskRule extends AbstractRule
{
    public const NAME = '@mr-linter/jira/has_issue_link';

    public function __construct(
        #[Description('Domain of Jira instance')]
        #[Example('jira.my-company.com')]
        private readonly string $domain,
        #[Description('Project code')]
        #[Example('VIP')]
        #[Example('SBD')]
        private readonly string $projectCode,
    ) {
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
