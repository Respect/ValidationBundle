# ValidationBundle

[![Build Status](https://travis-ci.org/Respect/ValidationBundle.png?branch=develop)](https://travis-ci.org/Respect/ValidationBundle?branch=develop)
[![Latest Stable Version](https://poser.pugx.org/respect/validation-bundle/v/stable.png)](https://packagist.org/packages/respect/validation-bundle)
[![Total Downloads](https://poser.pugx.org/respect/validation-bundle/downloads.png)](https://packagist.org/packages/respect/validation-bundle)
[![Latest Unstable Version](https://poser.pugx.org/respect/validation-bundle/v/unstable.png)](https://packagist.org/packages/respect/validation-bundle)
[![License](https://poser.pugx.org/respect/validation-bundle/license.png)](https://packagist.org/packages/respect/validation-bundle)

A Respect\Validation Bundle for Symfony

## Installation

Package is available on [Packagist](http://packagist.org/packages/respect/validation-bundle),
you can install it using [Composer](http://getcomposer.org).

```shell
composer require respect/validation
```

Add the bundle to your AppKernel.php:

```php
public function registerBundles()
{
    return array(
        // ...
        new Respect\ValidationBundle\RespectValidationBundle(),
        // ...
    );
}
```

## Usage

### Use as service `respect.validator`

```php
//...
class AcmeController extends Controller
{
    public function indexAction()
    {
        $number = 123;
        $isValid = $this->get('respect.validator')->numeric()->validate($number);//true
//...
```

### Use as alias

```php
//...

use Respect\Validation\Validator as v;

class AcmeController extends Controller
{
    public function indexAction()
    {
        $validUsername = v::alnum()
            ->noWhitespace()
            ->length(1,15);

        $isValid = $validUsername->validate('alganet'); //true
        //...
```
