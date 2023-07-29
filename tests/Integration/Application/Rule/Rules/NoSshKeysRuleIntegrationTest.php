<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Integration\Application\Rule\Rules;

use ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule;
use ArtARTs36\MergeRequestLinter\Domain\Request\Change;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\CompositeKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\PrivateKeyFinder;
use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\RsaKeyFinder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class NoSshKeysRuleIntegrationTest extends TestCase
{
    public function providerForTestLint(): array
    {
        return [
            'found ssh-rsa' => require __DIR__ . '/data/no_ssh_keys_rule_test/1.php',
            'found encrypted private' => require __DIR__ . '/data/no_ssh_keys_rule_test/2.php',
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Application\Rule\Rules\NoSshKeysRule::lint
     *
     * @dataProvider providerForTestLint
     *
     * @param array<string, Change> $changes
     * @param array<string> $expectedNotes
     */
    public function testLint(array $changes, bool $stopOnFirstFailure, array $expectedNotes): void
    {
        $rule = new NoSshKeysRule(
            new CompositeKeyFinder([
                new RsaKeyFinder(),
                new PrivateKeyFinder(),
            ]),
            $stopOnFirstFailure,
        );

        $request = $this->makeMergeRequest([
            'changes' => $changes,
        ]);

        self::assertEquals(
            $expectedNotes,
            array_map('strval', $rule->lint($request)),
        );
    }
}
