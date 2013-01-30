<?php

namespace Respect\ValidationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Respect\ValidationBundle\Validator\RespectConstraintValidator;

/**
 * @Annotation
 */
class AssertValidator extends RespectConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {   
        foreach($constraint->options as $rule => $parameters)
        {
            try {
                call_user_func_array(
                    array($this->validator, $rule), $parameters
                )->assert($value);
            } catch(\InvalidArgumentException $e) {
                $messages = $e->findMessages(array($rule));
            
                foreach($messages as $message) {
                    $this->context->addViolation($message, array('{{ value }}' => $value));
                }
            }    
        }        
    }
}