<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;

/**
 * The description must have a link to YouTrack issue on a {domain} with {projectCode}.
 */
class HasLinkToYouTrackIssueRule extends AbstractRule
{
    public const NAME = '@mr-linter/youtrack/has_issue_link';

    public function __construct(protected string $domain, protected string $projectCode)
    {
        //
    }

    protected function doLint(MergeRequest $request): bool
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        return $request
            ->description
            ->match("#$domain\/issue/$this->projectCode-\d#")
            ->isNotEmpty();
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'The description must have a link to YouTrack on domain "%s"',
            $this->domain,
        ));
    }
}
