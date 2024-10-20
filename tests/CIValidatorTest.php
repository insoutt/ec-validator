<?php

namespace Insoutt\EcValidator\Tests;

use Exception;
use Insoutt\EcValidator\CIValidator;
use Insoutt\EcValidator\Exceptions\CICodeException;
use Insoutt\EcValidator\Exceptions\LengthException;

class CIValidatorTest extends TestCase
{
    public function test_ci_must_be_string()
    {
        $this->expectException(Exception::class);
        
        (new CIValidator(1012897898))->validate();
    }
    public function test_ci_length_exception()
    {
        $this->expectException(LengthException::class);

        $validator = new CIValidator('1209');
        $validator->validate();
    }

    public function test_ci_code_exception()
    {
        $this->expectException(CICodeException::class);
        
        $validator = new CIValidator('0012897898');
        $validator->validate();
    }
}
