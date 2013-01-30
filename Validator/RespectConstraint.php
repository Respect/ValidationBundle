<?php

namespace Respect\ValidationBundle\Validator;

use Symfony\Component\Validator\Constraint;

abstract class RespectConstraint extends Constraint
{
    public function validatedBy()
    {
        return 'respect_validation';
    }
}