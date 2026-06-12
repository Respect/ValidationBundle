<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\StringFormatter\Modifier;
use Respect\StringFormatter\PlaceholderFormatter;

final class PlaceholderFormatterFactory
{
    public static function create(Modifier $modifier): PlaceholderFormatter
    {
        return new PlaceholderFormatter([], $modifier);
    }
}
