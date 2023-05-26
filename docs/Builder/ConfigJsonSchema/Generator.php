<?php

namespace ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema;

use ArtARTs36\MergeRequestLinter\DocBuilder\ConfigJsonSchema\Schema\JsonSchema;
use ArtARTs36\MergeRequestLinter\DocBuilder\EventFinder;
use ArtARTs36\MergeRequestLinter\Domain\Notifications\ChannelType;
use ArtARTs36\MergeRequestLinter\Domain\Request\MergeRequest;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\ClassSummary;
use ArtARTs36\MergeRequestLinter\Shared\Reflector\Reflector;

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

        $schema->addProperty('ci', [
            'type' => 'object',
            'properties' => [
                'gitlab_ci' => [
                    'description' => 'Gitlab CI settings',
                    'type' => 'object',
                    'properties' => [
                        'credentials' => [
                            'type' => 'object',
                            'properties' => [
                                'token' => [
                                    'type' => 'string',
                                    'description' => 'API Token',
                                ],
                            ],
                        ],
                    ],
                ],
                'github_actions' => [
                    'description' => 'Github Actions settings',
                    'type' => 'object',
                    'properties' => [
                        'credentials' => [
                            'type' => 'object',
                            'properties' => [
                                'token' => [
                                    'type' => 'string',
                                    'description' => 'API Token',
                                ],
                            ],
                        ],
                    ],
                ],
                'bitbucket_pipelines' => [
                    'description' => 'Bitbucket Pipelines settings',
                    'type' => 'object',
                    'properties' => [
                        'credentials' => [
                            'type' => 'object',
                            'properties' => [
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
                                'host' => [
                                    'type' => 'string',
                                    'description' => 'API Host',
                                ],
                            ],
                        ],
                        'labels' => [
                            'type' => 'object',
                            'properties' => [
                                'of_description' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'line_starts_with' => [
                                            'type' => 'string',
                                            'description' => 'Line Prefix',
                                        ],
                                        'separator' => [
                                            'type' => 'string',
                                            'description' => 'Labels separator',
                                        ],
                                    ],
                                ],
                            ],
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
                'sound_at' => [
                    'type' => 'string',
                    'description' => 'Time Period for enable sound. Example: 09:00-21:00',
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

        $schema->addProperty('linter', [
            'type' => 'object',
            'properties' => [
                'options' => [
                    'type' => 'object',
                    'properties' => [
                        'stop_on_first_failure' => [
                            'type' => 'boolean',
                            'default' => false,
                        ],
                    ],
                ],
            ],
        ]);

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

            $reflector = new \ReflectionClass($class);
            $description = Reflector::findPHPDocSummary($reflector);

            if (! empty($description)) {
                $map[$eventName]['description'] = $description;
            }
        }

        return $map;
    }
}
