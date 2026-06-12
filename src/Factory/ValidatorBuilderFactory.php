<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\Validation\Message\ArrayFormatter;
use Respect\Validation\Message\Renderer;
use Respect\Validation\Message\StringFormatter;
use Respect\Validation\ResultFilter;
use Respect\Validation\ValidatorBuilder;
use Respect\Validation\ValidatorFactory;

final class ValidatorBuilderFactory
{
    /** @param array<int, string> $ignoredBacktracePaths */
    public static function create(
        ValidatorFactory $validatorFactory,
        Renderer $renderer,
        StringFormatter $messageFormatter,
        StringFormatter $fullMessageFormatter,
        ArrayFormatter $messagesFormatter,
        ResultFilter $resultFilter,
        array $ignoredBacktracePaths,
    ): ValidatorBuilder {
        return new ValidatorBuilder(
            $validatorFactory,
            $renderer,
            $messageFormatter,
            $fullMessageFormatter,
            $messagesFormatter,
            $resultFilter,
            $ignoredBacktracePaths,
        );
    }
}
