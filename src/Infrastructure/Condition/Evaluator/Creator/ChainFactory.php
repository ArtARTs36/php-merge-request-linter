<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Condition\Evaluator\Creator;

use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AllEvaluator;
use ArtARTs36\MergeRequestLinter\Application\Condition\Evaluators\Composite\AnyEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\ConditionEvaluator;
use ArtARTs36\MergeRequestLinter\Domain\Condition\EvaluatingSubjectFactory;
use ArtARTs36\MergeRequestLinter\Shared\Contracts\DataStructure\Map;

class ChainFactory
{
    /**
     * @param Map<string, class-string<ConditionEvaluator>> $evaluatorByType
     */
    public function __construct(
        private readonly Map $evaluatorByType,
        private readonly EvaluatingSubjectFactory $subjectFactory,
    ) {
        //
    }

    public function create(): EvaluatorCreator
    {
        $chain = new Chain();

        $chain
            ->add(new CompositeEvaluatorCreator($this->subjectFactory, $chain, AnyEvaluator::class))
            ->add(new CompositeEvaluatorCreator($this->subjectFactory, $chain, AllEvaluator::class))
            ->add(new ContainsHeadingEvaluatorCreator())
            ->add(new SimpleCreator($this->evaluatorByType));

        return $chain;
    }
}
