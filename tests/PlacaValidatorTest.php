<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\Exceptions\ProvinceCodeException;
use Insoutt\EcValidator\PlacaValidator;

class PlacaValidatorTest extends TestCase
{
    public function test_placa_is_not_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La placa debe ser un string');
        (new PlacaValidator(120909))->validate();
    }

    public function test_placa_moto_or_car_is_valid()
    {
        // Validate moto
        $validation = (new PlacaValidator('AB122O'))->validate();
        $this->assertTrue($validation);

        // Validate car
        $validation = (new PlacaValidator('ABC2839'))->validate();
        $this->assertTrue($validation);
    }


}
