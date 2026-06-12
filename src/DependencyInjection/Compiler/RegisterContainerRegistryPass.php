<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\DependencyInjection\Compiler;

use Respect\Validation\ContainerRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterContainerRegistryPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        ContainerRegistry::setContainer($container);
    }
}
