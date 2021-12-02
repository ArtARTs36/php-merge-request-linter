<?php

use ArtARTs36\MergeRequestLinter\Ci\Credentials\Token;
use ArtARTs36\MergeRequestLinter\Ci\System\GithubActions;
use ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi;
use ArtARTs36\MergeRequestLinter\Contracts\Environment;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule;
use ArtARTs36\MergeRequestLinter\Rule\DescriptionNotEmptyRule;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithAnyPrefixRule;

return [
    'rules' => [
        new DescriptionNotEmptyRule(),
        new HasAnyLabelsRule(),
        HasAnyLabelsOfRule::make([
            'Feature',
        ]),
        TitleStartsWithAnyPrefixRule::make([
            '[Feature]',
            '[Bug]',
            '[Docs]',
        ]),
    ],
    'credentials' => [
        GitlabCi::class => new Token(getenv('GITLAB_HTTP_TOKEN')),
        GithubActions::class => new Token(getenv('GITHUB_HTTP_TOKEN')),
    ],
    'http_client' => fn (string $ciName, Environment $environment, string $ciSystemClass) => new \GuzzleHttp\Client(),
];
