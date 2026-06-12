<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

namespace Respect\ValidationBundle\Factory;

use Respect\Stringifier\Handler;
use Respect\Stringifier\Handlers\CompositeHandler;
use Respect\Stringifier\Quoter;
use Respect\Validation\Message\Parameters\NameHandler;
use Respect\Validation\Message\Parameters\PathHandler;
use Respect\Validation\Message\Parameters\ResultHandler;

final class HandlerFactory
{
    public static function create(Quoter $quoter): Handler
    {
        $handler = CompositeHandler::create();
        $handler->prependHandler(new PathHandler($quoter));
        $handler->prependHandler(new NameHandler());
        $handler->prependHandler(new ResultHandler($handler));

        return $handler;
    }
}
