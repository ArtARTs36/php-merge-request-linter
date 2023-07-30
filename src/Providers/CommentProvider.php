<?php

namespace ArtARTs36\MergeRequestLinter\Providers;

use ArtARTs36\MergeRequestLinter\Application\Comments\Commenter\Factory;
use ArtARTs36\MergeRequestLinter\Application\Comments\CommentProducer;
use ArtARTs36\MergeRequestLinter\Application\Comments\Listener\LintFinishedListener;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\TextMessageRenderer;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageSelector;
use ArtARTs36\MergeRequestLinter\Application\Linter\Events\ConfigResolvedEvent;
use ArtARTs36\MergeRequestLinter\Domain\Linter\LintFinishedEvent;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\CachedSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use ArtARTs36\MergeRequestLinter\Shared\Events\CallbackListener;
use ArtARTs36\MergeRequestLinter\Shared\Events\EventManager;
use Psr\Log\LoggerInterface;

/**
 * @codeCoverageIgnore
 */
final class CommentProvider extends Provider
{
    public function provide(): void
    {
        $eventManager = $this->container->get(EventManager::class);

        $listener = function (ConfigResolvedEvent $event) use ($eventManager) {
            $commenterFactory = new Factory(
                new CachedSystemFactory(fn () => $this->container->get(CiSystemFactory::class)->createCurrently()),
                $this->container->get(LoggerInterface::class),
            );

            $msgCreator = new \ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator(
                new MessageSelector($this->container->get(OperatorResolver::class)),
                new TextMessageRenderer($this->container->get(TextRenderer::class)),
            );

            $lintFinishedListener = new LintFinishedListener(
                new CommentProducer(
                    $msgCreator,
                    $this->container->get(LoggerInterface::class),
                    $commenterFactory,
                ),
                $event->config->config->getCommentsConfig(),
            );

            $eventManager->listen(LintFinishedEvent::class, $lintFinishedListener);
        };

        $eventManager->listen(ConfigResolvedEvent::class, new CallbackListener(
            'register comments listener',
            $listener,
        ));
    }
}
