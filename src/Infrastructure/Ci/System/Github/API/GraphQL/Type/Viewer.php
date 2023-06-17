<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Type;

use ArtARTs36\Str\Str;

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
        $login = Str::make($this->login);
        $length = $login->length();

        $hidden = $login->firstSymbol();

        for ($i = 1; $i < $length - 1; $i++) {
            $hidden .= '*';
        }

        return $hidden . $login->lastSymbol();
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
