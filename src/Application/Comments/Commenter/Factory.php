<?php

namespace ArtARTs36\MergeRequestLinter\Application\Comments\Commenter;

use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\Commenter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Contracts\CommenterFactory;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\AppendUpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageCreator;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageFormatter;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\MessageSelector;
use ArtARTs36\MergeRequestLinter\Application\Comments\Message\NewUpdatingMessageFormatter;
use ArtARTs36\MergeRequestLinter\Domain\Configuration\CommentsPostStrategy;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\CI\CiSystemFactory;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Condition\OperatorResolver;
use ArtARTs36\MergeRequestLinter\Infrastructure\Contracts\Text\TextRenderer;
use Psr\Log\LoggerInterface;

final class Factory implements CommenterFactory
{
    public function __construct(
        private readonly CiSystemFactory $ciSystem,
        private readonly OperatorResolver $operatorResolver,
        private readonly TextRenderer $textRenderer,
        private readonly LoggerInterface $logger,
    ) {
        //
    }

    public function create(CommentsPostStrategy $strategy): Commenter
    {
        if ($strategy === CommentsPostStrategy::Null) {
            return new NullCommenter();
        }

        $messageCreator = new MessageCreator(
            new MessageSelector($this->operatorResolver),
            new MessageFormatter($this->textRenderer),
        );

        if ($strategy === CommentsPostStrategy::New) {
            return new NewCommenter(
                $this->ciSystem->createCurrently(),
                $messageCreator,
                $this->logger,
            );
        }

        if ($strategy === CommentsPostStrategy::Single) {
            return new SingleCommenter(
                $this->ciSystem->createCurrently(),
                $messageCreator,
                $this->logger,
                new NewUpdatingMessageFormatter(),
            );
        }

        return new SingleCommenter(
            $this->ciSystem->createCurrently(),
            $messageCreator,
            $this->logger,
            new AppendUpdatingMessageFormatter(),
        );
    }
}
