<?php

use ArtARTs36\MergeRequestLinter\Ci\Credentials\GitlabCredentials;
use ArtARTs36\MergeRequestLinter\Ci\System\GitlabCi;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsOfRule;
use ArtARTs36\MergeRequestLinter\Rule\HasAnyLabelsRule;
use ArtARTs36\MergeRequestLinter\Rule\NotEmptyDescriptionRule;
use ArtARTs36\MergeRequestLinter\Rule\TitleStartsWithRule;

return [
    'rules' => [
        new NotEmptyDescriptionRule(),
        new HasAnyLabelsRule(),
        HasAnyLabelsOfRule::make([
            'Feature',
        ]),
        TitleStartsWithRule::make([
            '[Feature]',
            '[Bug]',
            '[Docs]',
        ]),
    ],
    'credentials' => [
        GitlabCi::class => GitlabCredentials::fromHttpToken(getenv('GITLAB_HTTP_TOKEN')),
    ],
];
