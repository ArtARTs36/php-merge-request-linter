<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Unit\Shared\Text\Ssh;

use ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\PrivateKeyFinder;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;
use ArtARTs36\Str\Str;

final class PrivateKeyFinderTest extends TestCase
{
    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\PrivateKeyFinder::findFirst
     *
     * @dataProvider providerForTestFindFirst
     */
    public function testFindFirst(string $content, ?string $expectedType): void
    {
        $finder = new PrivateKeyFinder();

        self::assertEquals($expectedType, $finder->findFirst(Str::make($content)));
    }

    public function providerForTestFindFirst(): array
    {
        return [
            'found one of one' => [
                '-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END ENCRYPTED PRIVATE KEY-----',
                'encrypted private',
            ],
            'found first' => [
                '
-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END ENCRYPTED PRIVATE KEY-----

-----BEGIN ENCRYPTED PUBLIC KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END ENCRYPTED PUBLIC KEY-----',
                'encrypted private',
            ],
            'empty' => [
                'erfreferferfrefgrefrefre',
                null,
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Text\Ssh\PrivateKeyFinder::findAll
     *
     * @dataProvider providerForTestFindAll
     */
    public function testFindAll(string $text,array $expectedTypes): void
    {
        $finder = new PrivateKeyFinder();

        self::assertEquals(
            $expectedTypes,
            $finder->findAll(Str::make($text)),
        );
    }

    public function providerForTestFindAll(): array
    {
        return [
            [
                '-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END ENCRYPTED PRIVATE KEY-----',
                ['encrypted private'],
            ],
            [
                '-----BEGIN ENCRYPTED PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END ENCRYPTED PRIVATE KEY-----

-----BEGIN TEST PRIVATE KEY-----
MIIBpjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQI5yNCu9T5SnsCAggA
MBQGCCqGSIb3DQMHBAhJISTgOAxtYwSCAWDXK/a1lxHIbRZHud1tfRMR4ROqkmr4
kVGAnfqTyGptZUt3ZtBgrYlFAaZ1z0wxnhmhn3KIbqebI4w0cIL/3tmQ6eBD1Ad1
nSEjUxZCuzTkimXQ88wZLzIS9KHc8GhINiUu5rKWbyvWA13Ykc0w65Ot5MSw3cQc
w1LEDJjTculyDcRQgiRfKH5376qTzukileeTrNebNq+wbhY1kEPAHojercB7d10E
+QcbjJX1Tb1Zangom1qH9t/pepmV0Hn4EMzDs6DS2SWTffTddTY4dQzvksmLkP+J
i8hkFIZwUkWpT9/k7MeklgtTiy0lR/Jj9CxAIQVxP8alLWbIqwCNRApleSmqtitt
Z+NdsuNeTm3iUaPGYSw237tjLyVE6pr0EJqLv7VUClvJvBnH2qhQEtWYB9gvE1dS
BioGu40pXVfjiLqhEKVVVEoHpI32oMkojhCGJs8Oow4bAxkzQFCtuWB1
-----END TEST PRIVATE KEY-----
',
                ['encrypted private', 'test private'],
            ],
            [
                'feferverfverefcverfvcervcercer',
                [],
            ],
        ];
    }
}
