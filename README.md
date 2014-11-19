ValidationBundle
================

[![Build Status](https://travis-ci.org/Respect/ValidationBundle.png?branch=develop)](https://travis-ci.org/Respect/ValidationBundle?branch=develop) [![Latest Stable Version](https://poser.pugx.org/respect/validation-bundle/v/stable.png)](https://packagist.org/packages/respect/validation-bundle) [![Total Downloads](https://poser.pugx.org/respect/validation-bundle/downloads.png)](https://packagist.org/packages/respect/validation-bundle) [![Latest Unstable Version](https://poser.pugx.org/respect/validation-bundle/v/unstable.png)](https://packagist.org/packages/respect/validation-bundle) [![License](https://poser.pugx.org/respect/validation-bundle/license.png)](https://packagist.org/packages/respect/validation-bundle)

A Respect\Validation Bundle for Symfony

Installation:
-------------
Require the bundle via composer:

    "require": {
		"respect/validation-bundle": "dev-develop"
	}

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

Usage:
------

### Use as service respect.validator:

```php    
    //...
    class AcmeController extends Controller
    {
        public function indexAction()
        {
            $number = 123;
            $x = $this->get('respect.validator')->numeric()->validate($number);//true
    //...
```

### Use as alias:

```php
<?php
 
namespace Acme\DemoBundle\Controller;
        
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Respect\Validation\Validator as v;

class AcmeController extends Controller
{
    public function indexAction()
    {
        $validUsername = v::alnum()
            ->noWhitespace()
            ->length(1,15);
                
        $x = $validUsername->validate('alganet'); //true
        //...
```