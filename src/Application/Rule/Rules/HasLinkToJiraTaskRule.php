<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

/**
 * The description must have a link to Jira on a {domain} with {projectCode}.
 */
final class HasLinkToJiraTaskRule extends NamedRule
{
    public const NAME = '@mr-linter/jira/has_issue_link';

    /**
     * @param Arrayee<int, string> $projectCodes
     */
    public function __construct(
        #[Description('Domain of Jira instance')]
        #[Example('jira.my-company.com')]
        private readonly string $domain,
        #[Description('Project code')]
        #[Example('ABC')]
        private readonly Arrayee $projectCodes = new Arrayee([]),
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        $projectCode = $request->description->match("#$domain\/browse\/(\w+)-\d#");

        if ($projectCode->isEmpty()) {
            return [
                new LintNote(sprintf(
                    'The description must have a link to Jira on domain "%s"',
                    $this->domain,
                )),
            ];
        }

        if (! $this->projectCodes->isEmpty() && ! $this->projectCodes->contains((string) $projectCode)) {
            return [
                new LintNote(sprintf(
                    'Description contains link with task number of unknown project "%s"',
                    $projectCode,
                )),
            ];
        }

        return [];
    }

    public function getDefinition(): RuleDefinition
    {
        return new Definition(sprintf(
            'The description must have a link to Jira on domain "%s"',
            $this->domain,
        ));
    }
}
