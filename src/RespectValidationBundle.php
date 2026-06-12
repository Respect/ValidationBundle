<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle;

use Respect\Validation\ContainerRegistry;
use Respect\ValidationBundle\DependencyInjection\Compiler\RegisterContainerRegistryPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

final class RespectValidationBundle extends AbstractBundle
{
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->arrayNode('rule_namespaces')
            ->scalarPrototype()->end()
            ->defaultValue([])
            ->end()
            ->end();
    }

    /** @param array<mixed> $config */
    public function loadExtension(
        array $config,
        ContainerConfigurator $container,
        ContainerBuilder $builder,
    ): void {
        $container->import('../config/services.php');

        /** @var array<int, string> $userNamespaces */
        $userNamespaces = $config['rule_namespaces'];
        $namespaces = [...$userNamespaces, 'Respect\\Validation\\Validators'];
        $builder->setParameter('respect.validation.rule_factory.namespaces', $namespaces);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterContainerRegistryPass());
    }

    public function setContainer(ContainerInterface|null $container): void
    {
        parent::setContainer($container);

        if ($container === null) {
            return;
        }

        ContainerRegistry::setContainer($container);
    }
}
