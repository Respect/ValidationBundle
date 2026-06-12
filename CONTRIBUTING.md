<!--
SPDX-FileCopyrightText: (c) Respect Project Contributors
SPDX-License-Identifier: MIT
-->

# Contributing

Contributions to Respect\ValidationBundle are always welcome. You make our lives
easier by sending us your contributions through [pull requests][].

Due to time constraints, we are not always able to respond as quickly as we
would like. Please do not take delays personally.

Before writing anything, feature or bug fix:

- Check if there is already an issue related to it (opened or closed) and if
  someone is already working on that;
  - If there is not, [open an issue][] and notify everybody that you're going
    to work on that;
  - If there is, create a comment to notify everybody that you're going to
    work on that.
- Make sure that what you need is not done yet.

This bundle is intentionally small: it wires
[Respect\Validation](https://github.com/Respect/Validation) into a Symfony
application's service container. New validation rules belong in the
[Respect\Validation](https://github.com/Respect/Validation) library, not here.
If you want to make a new rule available to your Symfony app without contributing
it upstream, add your namespace via the `rule_namespaces` configuration option
documented in the README.

## Scope of contributions

Changes that belong in this repository:

- Bundle wiring (`src/`, `config/`) for new services Respect\Validation exposes.
- Configuration options that influence how Validation services are constructed.
- Tests covering the bundle's integration with Symfony.
- Tooling, CI, and documentation for the bundle itself.

Changes that should go to [Respect\Validation](https://github.com/Respect/Validation):

- New validation rules.
- Changes to existing validation rules' behaviour.
- Changes to `ValidatorBuilder`, `ValidatorFactory`, or any class under
  `Respect\Validation\*`.

## Running Checks

After running `composer install` in the bundle's root directory you must run
`composer qa`.

This alias runs PHP_CodeSniffer, PHPStan, and PHPUnit. All three must pass.

Check the `scripts` section of `composer.json` for the individual commands.

[open an issue]: https://github.com/Respect/ValidationBundle/issues
[pull requests]: https://help.github.com/pull-requests "GitHub pull requests"
