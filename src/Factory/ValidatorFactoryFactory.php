<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\Validation\NamespacedValidatorFactory;
use Respect\Validation\Transformers\Transformer;
use Respect\Validation\ValidatorFactory;

final class ValidatorFactoryFactory
{
    /** @param array<int, string> $namespaces */
    public static function create(Transformer $transformer, array $namespaces): ValidatorFactory
    {
        return new NamespacedValidatorFactory($transformer, $namespaces);
    }
}
