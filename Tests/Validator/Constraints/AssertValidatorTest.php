<?php

namespace Respect\ValidationBundle\Tests\Validator\Constraints;

use Respect\Validation\Validator;
use Respect\ValidationBundle\Validator\Constraints\Assert;
use Respect\ValidationBundle\Validator\Constraints\AssertValidator;

class AssertValidatorTest extends \PHPUnit_Framework_TestCase
{
    protected $context;
    protected $validator;
    protected $assertValidator;
    
    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = Validator::create();
        $this->assertValidator = new AssertValidator($this->validator);
        $this->assertValidator->initialize($this->context);
    }
    
    protected function tearDown()
    {
        $this->context = null;
        $this->respectValidator = null;
        $this->assertValidator = null;
    }
    
    public function providerInvalidString()
    {
        return array(
            array(false),
            array(true),
            //array(new \stdClass()), what about this one?
            //array(array()), and this one?
            array(12345),            
        );
    }
    
    /**
     * @dataProvider providerInvalidString
     */
    public function testStringValidator($invalidString)
    {   
        $constraint = new Assert(array(
            'options' => array(
                'string' => array('')
            )
        ));

        $this->context->expects($this->once())
                      ->method('addViolation')
                      ->with("\"$invalidString\" must be a string", array('{{ value }}' => $invalidString));
        
        $this->assertValidator->validate($invalidString, $constraint);
    }
}