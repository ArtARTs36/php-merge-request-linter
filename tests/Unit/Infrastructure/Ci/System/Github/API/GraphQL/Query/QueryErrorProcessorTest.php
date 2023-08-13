<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Infrastructure\Ci\System\Github\API\GraphQL\Query;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Exceptions\NotFoundException;
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

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::processQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::processQuery
     * @covers \ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\API\GraphQL\Query\QueryErrorProcessor::createException
     */
    public function testProcessOnNotFoundException(): void
    {
        $processor = new QueryErrorProcessor();

        self::expectException(NotFoundException::class);

        $processor->processQuery([
            'errors' => [
                [
                    'type' => QueryErrorProcessor::ERROR_TYPE_NOT_FOUND,
                    'message' => 'not found',
                ],
            ],
        ]);
    }
}
