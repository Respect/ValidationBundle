<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\StringFormatter\Modifier;
use Respect\StringFormatter\Modifiers\FormatterModifier;
use Respect\StringFormatter\Modifiers\ListModifier;
use Respect\StringFormatter\Modifiers\QuoteModifier;
use Respect\StringFormatter\Modifiers\RawModifier;
use Respect\StringFormatter\Modifiers\StringifyModifier;
use Respect\StringFormatter\Modifiers\TransModifier;
use Respect\Stringifier\Stringifier;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ModifierFactory
{
    public static function create(Stringifier $stringifier, TranslatorInterface $translator): Modifier
    {
        return new TransModifier(
            new ListModifier(
                new QuoteModifier(
                    new RawModifier(
                        new FormatterModifier(new StringifyModifier($stringifier)),
                    ),
                ),
                $translator,
            ),
            $translator,
        );
    }
}
