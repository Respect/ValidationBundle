<?php

namespace Respect\ValidationBundle\Validator\Constraints;

use Respect\ValidationBundle\Validator\RespectConstraint;

/**
 * @Annotation
 */
class Assert extends RespectConstraint
{
    public $options;
    
    public function getDefaultOption()
    {
        return 'options';
    }
}