<?php

namespace Respect\ValidationBundle\Validator;

use Symfony\Component\Validator\Constraint as SymfonyConstraint;

abstract class Constraint extends SymfonyConstraint
{
    public function validatedBy()
    {
        return 'respect_validation';
    }
}