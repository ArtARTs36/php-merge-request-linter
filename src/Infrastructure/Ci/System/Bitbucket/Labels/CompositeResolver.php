<?php

namespace ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Labels;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\API\PullRequest;
use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Bitbucket\Settings\LabelsSettings;

final class CompositeResolver implements LabelsResolver
{
    /**
     * @param iterable<LabelsResolver> $resolvers
     */
    public function __construct(
        private readonly iterable $resolvers,
    ) {
        //
    }

    public function resolve(PullRequest $pr, LabelsSettings $settings): array
    {
        $result = [];

        foreach ($this->resolvers as $resolver) {
            $labels = $resolver->resolve($pr, $settings);

            array_push($result, ...$labels);
        }

        return $result;
    }
}
