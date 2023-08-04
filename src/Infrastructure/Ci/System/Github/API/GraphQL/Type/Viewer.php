<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\MergeRequestLinter\Shared\Text\Sensitive\Scrubber;

class Viewer
{
    private const OVERWRITE_LOGINS = [
        'github-actions[bot]' => 'github-actions',
    ];

    private function __construct(
        public readonly string $login
    ) {
        //
    }

    public static function make(string $login): self
    {
        if (isset(self::OVERWRITE_LOGINS[$login])) {
            $login = self::OVERWRITE_LOGINS[$login];
        }

        return new self($login);
    }

    public function getHiddenLogin(): string
    {
        return Scrubber::scrub($this->login);
    }

    /**
     * @return array<string, string>
     */
    public function __debugInfo(): array
    {
        return [
            'login' => $this->getHiddenLogin(),
        ];
    }
}
