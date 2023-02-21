<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env;

/**
 * @codeCoverageIgnore
 */
enum VarName: string
{
    case Identity = 'GITHUB_ACTIONS';
    case GraphqlURL = 'GITHUB_GRAPHQL_URL';
    case Repository = 'GITHUB_REPOSITORY';
    case RefName = 'GITHUB_REF_NAME';
}
