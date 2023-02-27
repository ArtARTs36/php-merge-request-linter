<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\TelegramBot;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\TelegramMessage;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TelegramBotTest extends TestCase
{
    public function providerForTestMessage(): array
    {
        return [
            [
                'message' => new TelegramMessage('secretToken', '-123', 'Test'),
                'expectedUri' => 'https://api.telegram.org/botsecretToken/sendMessage?chat_id=-123&text=Test',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\TelegramBot::sendMessage
     * @dataProvider providerForTestMessage
     */
    public function testSendMessage(TelegramMessage $message, string $expectedUri): void
    {
        $bot = new TelegramBot($client = new MockClient());

        $bot->sendMessage($message);

        self::assertEquals($expectedUri, $client->lastRequest()->getUri()->__toString());
    }
}
