<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Query;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class QueryErrorProcessorTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::processQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::processQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::createException
     */
    public function testProcessQueryOk(): void
    {
        $processor = new QueryErrorProcessor();
        $processor->processQuery([]);

        $this->addToAssertionCount(1);
    }
}
