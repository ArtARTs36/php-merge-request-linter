<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;

class TelegramBot
{
    private const HOST = 'https://api.telegram.org';

    public function __construct(
        private readonly Client $client,
        private readonly string $host = self::HOST,
    ) {
        //
    }

    public function sendMessage(TelegramMessage $message): void
    {
        $uri = new Uri(sprintf('%s/bot%s/sendMessage', $this->host, $message->token));

        $uri = Uri::withQueryValues(
            $uri,
            [
                'chat_id' => $message->chatId,
                'text' => $message->message,
            ],
        );

        $req = new Request('GET', $uri);

        $this->client->sendRequest($req);
    }
}
