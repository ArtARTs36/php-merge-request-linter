<?php

namespace ArtARTs36\MergeRequestLinter\Tests\E2E;

use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\ChainEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\LocalEnvironment;
use ArtARTs36\MergeRequestLinter\Infrastructure\Environment\Environments\MapEnvironment;
use ArtARTs36\MergeRequestLinter\Presentation\Console\Application\ApplicationFactory;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\ArrayMap;
use ArtARTs36\MergeRequestLinter\Tests\Mocks\StringConsoleOutput;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;
use Symfony\Component\Console\Input\ArrayInput;

final class LintE2ETest extends TestCase
{
    public function providerForLintTest(): array
    {
        $cases = [];

        foreach (glob(__DIR__ . '/cases/*/lint/*') as $path) {
            $meta = [];

            preg_match_all('/cases\/(.*)\/lint\/(\d+)/m', $path, $meta, PREG_SET_ORDER);

            [,$ciSystem, $testNumber] = $meta[0];

            $caseName = $ciSystem . '_' . $testNumber;
            $caseDir = sprintf(
                '%s/cases/%s/lint/%d',
                __DIR__,
                $ciSystem,
                $testNumber,
            );

            $cases[$caseName] = [
                'environment' => json_decode(file_get_contents($caseDir . '/environment.json'), true),
                'configPath' => sprintf(
                    '%s/cases/%s/lint/%d/config.yaml',
                    __DIR__,
                    $ciSystem,
                    $testNumber,
                ),
                'expectResult' => $this->loadExpectResult($caseDir . '/expect_result.txt'),
            ];
        }

        return $cases;
    }

    /**
     * @dataProvider providerForLintTest
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Command\LintCommand::execute
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Application\ApplicationFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Presentation\Console\Application\ApplicationFactory::__construct
     */
    public function testLint(array $env, string $configPath, array $expectResult): void
    {
        $appFactory = new ApplicationFactory(
            new ChainEnvironment([
                new MapEnvironment(new ArrayMap($env)),
                new LocalEnvironment(),
            ]),
        );

        $output = new StringConsoleOutput();

        $app = $appFactory->create($output);
        $app->setAutoExit(false);

        $app->run(
            new ArrayInput([
                'lint',
                '--config' => $configPath,
            ]),
            $output,
        );

        $output->assertContainsMessages($expectResult);
    }

    /**
     * @return array<string>
     */
    private function loadExpectResult(string $path): array
    {
        return Str::make(file_get_contents($path))
            ->trim()
            ->lines()
            ->toStrings();
    }
}
