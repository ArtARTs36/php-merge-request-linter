<?php

namespace ArtARTs36\MergeRequestLinter\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Definition\Definition;
use ArtARTs36\MergeRequestLinter\Domain\Note\LintNote;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Domain\Rule\RuleDefinition;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Description;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Example;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;

#[Description('The description must have a link to YouTrack issue on a {domain} with {projectCode}.')]
final class HasLinkToYouTrackIssueRule extends NamedRule
{
    public const NAME = '@mr-linter/youtrack/has_issue_link';

    /**
     * @param Arrayee<int, string> $projectCodes
     */
    public function __construct(
        #[Description('Domain hosting the YouTrack instance')]
        #[Example('yt.my-company.ru')]
        private readonly string  $domain,
        #[Generic(Generic::OF_STRING)]
        #[Description('Project code')]
        #[Example('PORTAL')]
        private readonly Arrayee $projectCodes = new Arrayee([]),
    ) {
        //
    }

    public function lint(MergeRequest $request): array
    {
        $domain = str_replace(['.'], ['\.'], $this->domain);

        $projectCode = $request
            ->description
            ->match("#$domain\/issue/(\w+)-\d#");

        if ($projectCode->isEmpty()) {
            return [
                new LintNote(sprintf(
                    'Description must contains link with task number of projects [%s]',
                    $this->projectCodes->implode(', '),
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
            'The description must have a link to YouTrack on domain "%s"',
            $this->domain,
        ));
    }
}
