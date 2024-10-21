<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\Exceptions\ProvinceCodeException;
use Insoutt\EcValidator\PlacaValidator;

class PlacaCarValidatorTest extends TestCase
{
    public function test_placa_is_not_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La placa debe ser un string');
        (new PlacaValidator(1209))->validateCar();
    }

    public function test_placa_has_invalid_length()
    {
        $this->expectException(\LengthException::class);
        (new PlacaValidator('AS1209'))->validateCar();
    }

    public function test_placa_has_invalid_province_code()
    {
        $this->expectException(ProvinceCodeException::class);
        (new PlacaValidator('DBC1234'))->validateCar();
    }

    public function test_placa_is_invalid()
    {
        try {
            (new PlacaValidator('1212122'))->validateCar();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('ABCERIO'))->validateCar();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('ABCER3O'))->validateCar();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }
    }
}
