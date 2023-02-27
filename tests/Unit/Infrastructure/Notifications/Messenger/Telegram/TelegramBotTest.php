<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Notifications\Messenger\Telegram;

use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\HttpBot;
use ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\BotMessage;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\MockClient;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class TelegramBotTest extends TestCase
{
    public function providerForTestMessage(): array
    {
        return [
            [
                'message' => new BotMessage('secretToken', '-123', 'Test'),
                'expectedUri' => 'https://api.telegram.org/botsecretToken/sendMessage?chat_id=-123&text=Test',
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\HttpBot::sendMessage
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\HttpBot::createUriForSendMessage
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Notifications\Messenger\Telegram\HttpBot::__construct
     * @dataProvider providerForTestMessage
     */
    public function testSendMessage(BotMessage $message, string $expectedUri): void
    {
        $bot = new HttpBot($client = new MockClient());

        $bot->sendMessage($message);

        self::assertEquals($expectedUri, $client->lastRequest()->getUri()->__toString());
    }
}
