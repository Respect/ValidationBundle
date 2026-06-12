# Respect/ValidationBundle

Symfony bundle for [Respect/Validation](https://github.com/Respect/Validation).

## Installation

```bash
composer require respect/validation-bundle
```

Register the bundle in `config/bundles.php`:

```php
return [
    // ...
    Respect\ValidationBundle\RespectValidationBundle::class => ['all' => true],
];
```

## Usage

Inject `Respect\Validation\ValidatorBuilder` into any service via constructor injection:

```php
use Respect\Validation\ValidatorBuilder;

final class MyService
{
    public function __construct(private readonly ValidatorBuilder $validator)
    {
    }

    public function process(mixed $value): void
    {
        if (!$this->validator->stringType()->length(1, 100)->isValid($value)) {
            throw new \InvalidArgumentException('Invalid value.');
        }

        // proceed...
    }
}
```

`ValidatorFactory` is also available for autowiring if you need to build validators programmatically.

## Custom rule namespaces

Add your own rule namespaces in `config/packages/respect_validation.yaml`:

```yaml
respect_validation:
    rule_namespaces:
        - App\Validation\Rules
```

Rule classes under those namespaces (extending `Respect\Validation\Validators\Core\Simple`)
become available via the builder — e.g. a class `App\Validation\Rules\AcmeId` can be used
as `$builder->acmeId()->isValid($value)`. User namespaces are checked before the built-in
`Respect\Validation\Validators`, so custom rules can shadow defaults.

## Container ownership

The bundle replaces `Respect\Validation\ContainerRegistry`'s default container
with Symfony's container, so `v::email()`, `ValidatorBuilder::init()`, and every
other entry point in Respect/Validation resolves through the same container that
serves your Symfony services. This happens at two points:

1. **Compile time** — a compiler pass calls `ContainerRegistry::setContainer()`
   with the `ContainerBuilder` while the container is being built. Any compiler
   pass running after this one can call the static API safely.
2. **Runtime** — the bundle overrides `setContainer()` so that the moment the
   kernel attaches the compiled container to bundles (before any `boot()` runs
   and before any service is resolved), the registry switches to the runtime
   container.

The practical guarantee: in any Symfony application code (controllers, console
commands, listeners, service constructors), `Respect\Validation\ContainerRegistry`
points at Symfony's container. There is no window in normal Symfony usage where
the static API would resolve against Respect/Validation's default PHP-DI
container.

The only situation this does not cover is code that runs Respect/Validation
without a Symfony kernel at all — for example, a standalone script that uses
`v::email()` directly. In that scenario there is no bundle to register, and
Respect/Validation falls back to its built-in PHP-DI container, which is the
expected behaviour outside of Symfony.

## License

MIT. See [LICENSE](LICENSE).
