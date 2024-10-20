<?php

namespace Insoutt\EcValidator\Tests;

use Exception;
use Insoutt\EcValidator\CIValidator;
use Insoutt\EcValidator\Exceptions\CICodeException;
use Insoutt\EcValidator\Exceptions\LengthException;
use Insoutt\EcValidator\Exceptions\RucCodeException;
use Insoutt\EcValidator\Exceptions\RucLast3DigitsException;
use Insoutt\EcValidator\RucValidator;

class RucValidatorTest extends TestCase
{
    public function test_ruc_length_exception()
    {
        $this->expectException(LengthException::class);

        $validator = new RucValidator('1209');
        $validator->validate();
    }

    public function test_ruc_code_exception()
    {
        $this->expectException(RucCodeException::class);
        
        $validator = new RucValidator('0010000000001');
        $validator->validate();
    }

    public function test_last_3_digits_exception()
    {
        $this->expectException(RucLast3DigitsException::class);
        (new RucValidator('1800000000000'))->validate();
    }

    public function test_last_3_digits_with_letters_exception()
    {
        $this->expectException(RucLast3DigitsException::class);
        (new RucValidator('18000000000A1'))->validate();
    }

    public function test_last_3_digits_with_numbers_exception()
    {
        $this->expectException(Exception::class);
        (new RucValidator(1800000000000))->validate();
    }
}
