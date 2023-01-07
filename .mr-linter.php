<?php

use ArtARTs36\MergeRequestLinter\CI\Credentials\Token;
use ArtARTs36\MergeRequestLinter\CI\System\Github\GithubActions;
use ArtARTs36\MergeRequestLinter\CI\System\Gitlab\GitlabCi;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule;

return [
    'rules' => [
        new DescriptionNotEmptyRule(),
        HasAnyLabelsOfRule::make([
            'Feature',
            'Bug',
            'Docs',
            'Tests',
        ]),
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
