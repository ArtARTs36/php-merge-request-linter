<?php

namespace ArtARTs36\MergeRequestLinter\Tests\Integration\Shared\Reflection\TypeResolver;

use ArtARTs36\MergeRequestLinter\Infrastructure\Ci\System\Github\Env\Repo;
use ArtARTs36\MergeRequestLinter\Infrastructure\Container\MapContainer;
use ArtARTs36\MergeRequestLinter\Shared\Attributes\Generic;
use ArtARTs36\MergeRequestLinter\Shared\DataStructure\Arrayee;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\Type;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\Reflector\TypeName;
use ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ResolverFactory;
use ArtARTs36\MergeRequestLinter\Tests\TestCase;

final class CompositeResolverIntegrationTest extends TestCase
{
    public function providerForTestConvert(): array
    {
        return [
            [
                [],
                new Type(TypeName::Object, TestProject::class),
                [
                    'name' => 'merge-request-linter',
                    'type' => 'pet',
                    'contributors' => [
                        [
                            'name' => 'Artem',
                            'birthAt' => '06-07-1999',
                            'likesGithub' => 'yes',
                            'repos' => [
                                new TestRepo('merge-request-linter'),
                                new TestRepo('str'),
                            ],
                        ],
                    ],
                ],
                new TestProject(
                    'merge-request-linter',
                    TestProjectType::Pet,
                    new Arrayee([
                        new TestContributor(
                            'Artem',
                            new \DateTime('06-07-1999'),
                            LikesGithub::Yes,
                            new Arrayee([
                                new TestRepo('merge-request-linter'),
                                new TestRepo('str'),
                            ]),
                        ),
                    ]),
                ),
            ],
        ];
    }

    /**
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\MapCompositeResolver::resolve
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ResolverFactory::create
     * @covers \ArtARTs36\MergeRequestLinter\Shared\Reflection\TypeResolver\ResolverFactory::__construct
     * @dataProvider providerForTestConvert
     */
    public function testResolve(array $container, Type $type, array $data, mixed $expected): void
    {
        $resolver = (new ResolverFactory(new MapContainer($container)))->create();

        self::assertEquals($expected, $resolver->resolve($type, $data));
    }
}

class TestProject
{
    public function __construct(
        public readonly string $name,
        public readonly TestProjectType $type,
        #[Generic(TestContributor::class)]
        public readonly Arrayee $contributors,
    ) {
        //
    }
}

enum TestProjectType: string
{
    case Commerce = 'commerce';
    case Pet = 'pet';
}

class TestContributor
{
    public function __construct(
        public readonly string $name,
        public readonly \DateTimeInterface $birthAt,
        public readonly LikesGithub $likesGithub,
        #[Generic(Repo::class)]
        public readonly Arrayee $repos,
    ) {
        //
    }
}

enum LikesGithub: string
{
    case Yes = 'yes';
    case No = 'no';
}

class TestRepo
{
    public function __construct(
        public readonly string $name,
    ) {
        //
    }
}
