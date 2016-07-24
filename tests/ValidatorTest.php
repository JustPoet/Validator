<?php
namespace Andy\Validator\Tests;

use Andy\Validator\Validator;
use PHPUnit_Framework_TestCase;

class ValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testValidate()
    {
        $rules = [
            'name' => 'required|length:2,5',
            'date' => function($value){
                return strtotime($value) > time();
            }
        ];

        $data = [
            'name' => '',
            'age' => 10,
            'date'=>'2016-07-26'
        ];

        $result = Validator::validate($data, $rules);
        $this->assertEquals(false, $result['name']);
        $this->assertEquals(true, $result['date']);
    }
}
