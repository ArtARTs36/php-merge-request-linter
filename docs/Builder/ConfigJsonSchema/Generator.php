<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\DocBuilder\EventFinder;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;

class Generator
{
    public function __construct(
        private RuleSchemaGenerator $ruleSchemaGenerator = new RuleSchemaGenerator(),
        private OperatorSchemaArrayGenerator $operatorSchemaArrayGenerator = new OperatorSchemaArrayGenerator(),
    ) {
        //
    }

    public function generate(): JsonSchema
    {
        $schema = new JsonSchema();

        $schema->addDefinition('rule_conditions', $this->operatorSchemaArrayGenerator->generate(MergeRequest::class));

        $schema->addProperty('rules', [
            'type' => 'object',
            'properties' => $this->ruleSchemaGenerator->generate($schema),
            'additionalProperties' => false,
        ]);

        $schema->addProperty('credentials', [
            'type' => 'object',
            'properties' => [
                'gitlab_ci' => [
                    'description' => 'Token',
                    'type' => 'string',
                ],
                'github_actions' => [
                    'description' => 'Token',
                    'type' => 'string',
                ],
                'bitbucket_pipelines' => [
                    'oneOf' => [
                        [
                            'type' => 'object',
                            'properties' => [
                                'host' => [
                                    'type' => 'string',
                                    'description' => 'API Host',
                                ],
                                'token' => [
                                    'type' => 'string',
                                    'description' => 'API Token',
                                ],
                                'app_password' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'user' => [
                                            'type' => 'string',
                                        ],
                                        'password' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        [
                            'type' => 'string',
                            'description' => 'token',
                        ],
                    ],
                ],
            ],
            'additionalProperties' => false,
        ]);

        $notificationsChannelTgBotRef = $schema->addDefinition('notifications_channel_telegram_bot', [
            'properties' => [
                'type' => [
                    'type' => 'string',
                    'const' => ChannelType::TelegramBot->value,
                ],
                'bot_token' => [
                    'type' => 'string',
                ],
                'chat_id' => [
                    'type' => 'string',
                ],
            ],
        ]);

        $notificationsChannelRef = $schema->addDefinition('notifications_channel', [
            'type' => 'object',
            'oneOf' => [
                [
                    '$ref' => $notificationsChannelTgBotRef,
                ],
            ],
        ]);

        $schema->addProperty('notifications', [
            'type' => 'object',
            'properties' => [
                'channels' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        '$ref' => $notificationsChannelRef,
                    ],
                ],
                'on' => [
                    'type' => 'object',
                    'properties' => $this->mapEvents(),
                ],
            ],
        ], false);

        return $schema;
    }

    private function mapEvents(): array
    {
        $eventFinder = new EventFinder();

        $eventClasses = $eventFinder->find();

        $map = [];

        foreach ($eventClasses as $class) {
            if (! defined("$class::NAME")) {
                continue;
            }

            $eventName = $class::NAME;

            $map[$eventName] = [
                'type' => 'object',
                'properties' => [
                    'template' => [
                        'type' => 'string',
                    ],
                    'channel' => [
                        'type' => 'string',
                    ],
                    'when' => $this->operatorSchemaArrayGenerator->generate($class),
                ],
            ];
        }

        return $map;
    }
}
