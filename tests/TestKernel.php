<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Tests;

use Respect\ValidationBundle\RespectValidationBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Kernel\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

use function sys_get_temp_dir;

final class TestKernel extends Kernel
{
    /** @param array<int, string> $ruleNamespaces */
    public function __construct(
        string $environment,
        bool $debug,
        private readonly array $ruleNamespaces = [],
    ) {
        parent::__construct($environment, $debug);
    }

    /** @return iterable<BundleInterface> */
    public function registerBundles(): iterable
    {
        return [new FrameworkBundle(), new RespectValidationBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $ruleNamespaces = $this->ruleNamespaces;

        $loader->load(static function (ContainerBuilder $container) use ($ruleNamespaces): void {
            $container->loadFromExtension('framework', [
                'secret' => 'test',
                'test' => true,
                'http_method_override' => false,
                'handle_all_throwables' => true,
                'php_errors' => ['log' => true],
                'router' => ['utf8' => true, 'resource' => 'kernel::loadRoutes', 'type' => 'service'],
                'validation' => false,
            ]);

            $container->loadFromExtension('respect_validation', ['rule_namespaces' => $ruleNamespaces]);

            $container->register(ValidatorConsumer::class, ValidatorConsumer::class)
                ->setAutowired(true)
                ->setPublic(true);
        });
    }

    public function getCacheDir(): string
    {
        $suffix = $this->ruleNamespaces !== [] ? '_custom' : '';

        return sys_get_temp_dir() . '/respect-validation-bundle/cache/' . $this->environment . $suffix;
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/respect-validation-bundle/log';
    }
}
