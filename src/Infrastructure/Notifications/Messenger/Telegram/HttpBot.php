<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Http\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class HttpBot implements Bot
{
    private const HOST = 'https://api.telegram.org';

    public function __construct(
        private readonly Client $client,
        private readonly string $host = self::HOST,
    ) {
        //
    }

    public function sendMessage(BotMessage $message): void
    {
        $req = new Request('GET', $this->createUriForSendMessage($message));

        $this->client->sendRequest($req);
    }

    private function createUriForSendMessage(BotMessage $message): UriInterface
    {
        $uri = new Uri(sprintf('%s/bot%s/sendMessage', $this->host, $message->token));

        return Uri::withQueryValues(
            $uri,
            [
                'chat_id' => $message->chatId,
                'text' => $message->message,
            ],
        );
    }
}
