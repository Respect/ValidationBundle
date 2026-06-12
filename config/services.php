<?php

/*
 * SPDX-License-Identifier: MIT
 * SPDX-FileCopyrightText: (c) Respect Project Contributors
 * SPDX-FileContributor: Henrique Moody <henriquemoody@gmail.com>
 */

declare(strict_types=1);

use Respect\StringFormatter\BypassTranslator;
use Respect\StringFormatter\Modifier;
use Respect\StringFormatter\PlaceholderFormatter;
use Respect\Stringifier\Handler;
use Respect\Stringifier\Quoter;
use Respect\Stringifier\Quoters\CodeQuoter;
use Respect\Stringifier\Stringifier;
use Respect\Validation\Message\Formatter\FirstResultStringFormatter;
use Respect\Validation\Message\Formatter\NestedArrayFormatter;
use Respect\Validation\Message\Formatter\NestedListStringFormatter;
use Respect\Validation\Message\Formatter\TemplateResolver;
use Respect\Validation\Message\InterpolationRenderer;
use Respect\Validation\Message\Renderer;
use Respect\Validation\Message\TemplateRegistry;
use Respect\Validation\OnlyFailedChildrenResultFilter;
use Respect\Validation\ResultFilter;
use Respect\Validation\Transformers\Prefix;
use Respect\Validation\Transformers\Transformer;
use Respect\Validation\ValidatorBuilder;
use Respect\Validation\ValidatorFactory;
use Respect\ValidationBundle\Factory\HandlerFactory;
use Respect\ValidationBundle\Factory\ModifierFactory;
use Respect\ValidationBundle\Factory\PlaceholderFormatterFactory;
use Respect\ValidationBundle\Factory\StringifierFactory;
use Respect\ValidationBundle\Factory\ValidatorBuilderFactory;
use Respect\ValidationBundle\Factory\ValidatorFactoryFactory;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Contracts\Translation\TranslatorInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $configurator): void {
    $ignoredBacktracePath = (new ReflectionClass(ValidatorBuilder::class))->getFileName();

    $configurator->parameters()
        ->set('respect.validation.ignored_backtrace_paths', [$ignoredBacktracePath])
        ->set('respect.validation.rule_factory.namespaces', ['Respect\\Validation\\Validators']);

    $services = $configurator->services();

    // Validators of optional dependencies fetch these through ContainerRegistry::getContainer()
    // at runtime, so they must be public to survive container compilation
    if (class_exists('libphonenumber\\PhoneNumberUtil')) {
        $services->set('libphonenumber\\PhoneNumberUtil')
            ->class('libphonenumber\\PhoneNumberUtil')
            ->factory(['libphonenumber\\PhoneNumberUtil', 'getInstance'])
            ->public();
    }

    if (class_exists('Ramsey\\Uuid\\UuidFactory')) {
        $services->set('Ramsey\\Uuid\\UuidFactory')
            ->class('Ramsey\\Uuid\\UuidFactory')
            ->public();
    }

    foreach (['Countries', 'Currencies', 'Languages', 'Subdivisions'] as $database) {
        if (!class_exists('Sokil\\IsoCodes\\Database\\' . $database)) {
            continue;
        }

        $services->set('Sokil\\IsoCodes\\Database\\' . $database)
            ->class('Sokil\\IsoCodes\\Database\\' . $database)
            ->public();
    }

    $services->set(Transformer::class, Prefix::class);

    $services->set(TemplateRegistry::class);

    $services->set(TemplateResolver::class)
        ->args([service(TemplateRegistry::class)]);

    $services->set(TranslatorInterface::class, BypassTranslator::class);

    $services->set(Renderer::class, InterpolationRenderer::class)
        ->args([
            service(TranslatorInterface::class),
            service(PlaceholderFormatter::class),
            service(TemplateResolver::class),
        ]);

    $services->set(ResultFilter::class, OnlyFailedChildrenResultFilter::class);

    $services->set('respect.validation.formatter.message', FirstResultStringFormatter::class);

    $services->set('respect.validation.formatter.full_message', NestedListStringFormatter::class);

    $services->set('respect.validation.formatter.messages', NestedArrayFormatter::class);

    $services->set(Quoter::class, CodeQuoter::class)
        ->args([120]);

    $services->set(Handler::class)
        ->factory([HandlerFactory::class, 'create'])
        ->args([service(Quoter::class)]);

    $services->set(Stringifier::class)
        ->factory([StringifierFactory::class, 'create'])
        ->args([service(Handler::class)]);

    $services->set(Modifier::class)
        ->factory([ModifierFactory::class, 'create'])
        ->args([service(Stringifier::class), service(TranslatorInterface::class)]);

    $services->set(PlaceholderFormatter::class)
        ->factory([PlaceholderFormatterFactory::class, 'create'])
        ->args([service(Modifier::class)]);

    $services->set(ValidatorFactory::class)
        ->factory([ValidatorFactoryFactory::class, 'create'])
        ->args([service(Transformer::class), param('respect.validation.rule_factory.namespaces')])
        ->public();

    $services->set(ValidatorBuilder::class)
        ->factory([ValidatorBuilderFactory::class, 'create'])
        ->args([
            service(ValidatorFactory::class),
            service(Renderer::class),
            service('respect.validation.formatter.message'),
            service('respect.validation.formatter.full_message'),
            service('respect.validation.formatter.messages'),
            service(ResultFilter::class),
            param('respect.validation.ignored_backtrace_paths'),
        ])
        ->public();
};
