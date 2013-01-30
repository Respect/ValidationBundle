<?php

namespace Respect\ValidationBundle\Validator\Constraints;

use Respect\ValidationBundle\Validator\Constraint;

/**
 * @Annotation
 */
class Assert extends Constraint
{
    public $options;
    
    public function getDefaultOption()
    {
        return 'options';
    }
}