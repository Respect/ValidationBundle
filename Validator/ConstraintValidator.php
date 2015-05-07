<?php

namespace Respect\ValidationBundle\Validator;

use Respect\Validation\Validator;
use Symfony\Component\Validator\ConstraintValidator as SymfonyConstraintValidator;

abstract class ConstraintValidator extends SymfonyConstraintValidator
{
    /**
     * @var \Respect\Validation\Validator
     */
    protected $validator;

    /**
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }
}
