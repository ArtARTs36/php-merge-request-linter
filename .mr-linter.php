<?php

use ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials;
use ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi;
use ArtARTs36\MergeRequestLinter\Rule\HasLabelsRule;
use ArtARTs36\MergeRequestLinter\Rule\NotEmptyDescriptionRule;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithRule;

return [
    'rules' => [
        new NotEmptyDescriptionRule(),
        new HasLabelsRule(['Feature']),
        TitleStartsWithRule::make('Task-'),
    ],
    'credentials' => [
        GitlabCi::class => GitlabCredentials::fromHttpToken(getenv('GITLAB_HTTP_TOKEN')),
    ],
];
