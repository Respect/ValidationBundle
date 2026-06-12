<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\Stringifier\DumpStringifier;
use Respect\Stringifier\Handler;
use Respect\Stringifier\HandlerStringifier;
use Respect\Stringifier\Stringifier;

final class StringifierFactory
{
    public static function create(Handler $handler): Stringifier
    {
        return new HandlerStringifier($handler, new DumpStringifier());
    }
}
