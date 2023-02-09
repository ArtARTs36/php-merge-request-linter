<?php

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\TitleStartsWithAnyPrefixRule;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Support\DataStructure\Set;

return [
    'rules' => [
        new DescriptionNotEmptyRule(),
        new HasAnyLabelsOfRule(Set::fromList([
            'Feature',
            'Bug',
            'Docs',
            'Tests',
        ])),
        new TitleStartsWithAnyPrefixRule([
            '[Feature]',
            '[Bug]',
            '[Docs]',
            '[Tests]',
        ]),
    ],
    'credentials' => [
        GitlabCi::class => new Token(getenv('MR_LINTER_GITLAB_HTTP_TOKEN')),
        GithubActions::class => new Token(getenv('MR_LINTER_GITHUB_HTTP_TOKEN')),
    ],
    'http_client' => [
        'type' => 'guzzle',
        'params' => [],
    ],
];
