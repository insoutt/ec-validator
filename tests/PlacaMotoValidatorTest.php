<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\Exceptions\ProvinceCodeException;
use Insoutt\EcValidator\PlacaValidator;

class PlacaMotoValidatorTest extends TestCase
{
    public function test_placa_is_not_string()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('La placa debe ser un string');
        (new PlacaValidator(1209))->validateMoto();
    }

    public function test_placa_has_invalid_length()
    {
        $this->expectException(\LengthException::class);
        (new PlacaValidator('AS1209U'))->validateMoto();
    }

    public function test_placa_has_invalid_province_code()
    {
        $this->expectException(ProvinceCodeException::class);
        (new PlacaValidator('DA039E'))->validateMoto();
    }

    public function test_placa_is_invalid()
    {
        try {
            (new PlacaValidator('AAAAAA'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('123456'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('A2239A'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('AA2391'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa no es válida', $th->getMessage());
        }
    }
}
