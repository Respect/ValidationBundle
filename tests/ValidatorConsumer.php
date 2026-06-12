<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Tests;

use Respect\Validation\ValidatorBuilder;

final class ValidatorConsumer
{
    public function __construct(public readonly ValidatorBuilder $validatorBuilder)
    {
    }
}
