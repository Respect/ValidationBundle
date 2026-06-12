<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Tests\Fixtures\Rules;

use Respect\Validation\Validators\Core\Simple;

final class AlwaysFoo extends Simple
{
    public function isValid(mixed $input): bool
    {
        return $input === 'foo';
    }
}
