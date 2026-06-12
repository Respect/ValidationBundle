<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Tests;

use Respect\Validation\ContainerRegistry;
use Respect\Validation\ValidatorBuilder;
use Respect\Validation\ValidatorFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use function restore_exception_handler;

final class RespectValidationBundleTest extends KernelTestCase
{
    public function testContainerHasValidatorBuilder(): void
    {
        $container = self::bootKernel()->getContainer();

        self::assertTrue($container->has(ValidatorBuilder::class));
    }

    public function testValidatorBuilderIsCorrectType(): void
    {
        $container = self::bootKernel()->getContainer();
        $builder = $container->get(ValidatorBuilder::class);

        self::assertInstanceOf(ValidatorBuilder::class, $builder);
    }

    public function testValidatorBuilderCanValidateStrings(): void
    {
        $container = self::bootKernel()->getContainer();
        $builder = $container->get(ValidatorBuilder::class);
        self::assertInstanceOf(ValidatorBuilder::class, $builder);

        self::assertTrue($builder->stringType()->isValid('foo'));
        self::assertFalse($builder->intType()->isValid('foo'));
    }

    public function testContainerHasValidatorFactory(): void
    {
        $container = self::bootKernel()->getContainer();
        $factory = $container->get(ValidatorFactory::class);

        self::assertInstanceOf(ValidatorFactory::class, $factory);
    }

    public function testAutowiringOfValidatorBuilder(): void
    {
        $container = self::bootKernel()->getContainer();
        $consumer = $container->get(ValidatorConsumer::class);
        self::assertInstanceOf(ValidatorConsumer::class, $consumer);

        self::assertTrue($consumer->validatorBuilder->stringType()->isValid('hello'));
    }

    public function testContainerRegistryUsesSymfonyContainer(): void
    {
        $kernel = self::bootKernel();

        self::assertSame($kernel->getContainer(), ContainerRegistry::getContainer());
    }

    public function testStaticApiWorksAfterBoot(): void
    {
        self::bootKernel();

        self::assertTrue(ValidatorBuilder::stringType()->isValid('foo'));
        self::assertFalse(ValidatorBuilder::stringType()->isValid(42));
    }

    public function testCustomRuleNamespaceIsUsed(): void
    {
        $kernel = new TestKernel('test_custom', false, ['Respect\\ValidationBundle\\Tests\\Fixtures\\Rules']);
        $kernel->boot();

        $container = $kernel->getContainer();
        $factory = $container->get(ValidatorFactory::class);
        self::assertInstanceOf(ValidatorFactory::class, $factory);

        $builder = $container->get(ValidatorBuilder::class);
        self::assertInstanceOf(ValidatorBuilder::class, $builder);

        $alwaysFoo = $factory->create('alwaysFoo');
        self::assertTrue($builder->with($alwaysFoo)->isValid('foo'));
        self::assertFalse($builder->with($alwaysFoo)->isValid('bar'));

        $kernel->shutdown();
    }

    /** @param array<string, mixed> $options */
    protected static function createKernel(array $options = []): TestKernel
    {
        return new TestKernel($options['environment'] ?? 'test', $options['debug'] ?? false);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // FrameworkBundle registers a Symfony ErrorHandler via set_exception_handler()
        // during kernel boot but never removes it on shutdown. Restore the handler
        // manually so PHPUnit 12 does not mark the test as risky.
        restore_exception_handler();
    }
}
