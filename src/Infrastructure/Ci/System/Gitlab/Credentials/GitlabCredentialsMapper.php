<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Gitlab\Credentials;

use ArtARTs36\MergeRequestLinter\Domain\CI\Authenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\Header;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\Credentials\HeaderAuthenticator;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\AuthenticatorMapper;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Configuration\ConfigValueTransformer;
use ArtARTs36\MergeRequestLinter\Infrastructure\Http\Exceptions\InvalidCredentialsException;

class GitlabCredentialsMapper implements AuthenticatorMapper
{
    public function __construct(
        private readonly ConfigValueTransformer $valueTransformer,
    ) {
        //
    }

    public function map(array $credentials): Authenticator
    {
        $tokenFetchMap = [
            'token' => 'PRIVATE-TOKEN',
            'job_token' => 'JOB-TOKEN',
        ];

        $header = null;

        foreach ($tokenFetchMap as $key => $headerName) {
            if (! empty($credentials[$key]) || ! is_string($credentials[$key])) {
                $header = new Header(
                    $headerName,
                    $this->valueTransformer->tryTransform($credentials[$key]),
                );
            }
        }

        if ($header === null) {
            throw new InvalidCredentialsException(
                'Credentials for Gitlab CI not provided. Must be provided access token or job token',
            );
        }

        return new HeaderAuthenticator($header);
    }
}
