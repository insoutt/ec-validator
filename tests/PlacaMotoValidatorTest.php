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
            $this->assertSame('La placa AAAAAA no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('123456'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa 123456 no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('A2239A'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa A2239A no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('AA2391'))->validateMoto();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa AA2391 no es válida', $th->getMessage());
        }
    }

    public function test_valid_placa()
    {
        /** Información obtenida de las siguientes fuentes, o mediante búsquedas en internet.
         * Para solicitar eliminar un número de cédula hacerlo mediante
         * la sección de issues en el repositorio de este proyecto.
         *
         *    https://transitopasaje.gob.ec/formulario/RETIRO-PLACAS.pdf
         */
        $validations = [
            (new PlacaValidator('IV652C'))->validateMoto(),
            (new PlacaValidator('IV655C'))->validateMoto(),
            (new PlacaValidator('IV666C'))->validateMoto(),
            (new PlacaValidator('IV678C'))->validateMoto(),
            (new PlacaValidator('IX609C'))->validateMoto(),
            (new PlacaValidator('IX617C'))->validateMoto(),
            (new PlacaValidator('IX619C'))->validateMoto(),
            (new PlacaValidator('IZ006P'))->validateMoto(),
            (new PlacaValidator('IZ007P'))->validateMoto(),
            (new PlacaValidator('IZ011P'))->validateMoto(),
            (new PlacaValidator('IZ019P'))->validateMoto(),
            (new PlacaValidator('IZ025P'))->validateMoto(),
            (new PlacaValidator('IZ030P'))->validateMoto(),
            (new PlacaValidator('IC338B'))->validateMoto(),
            (new PlacaValidator('IG579D'))->validateMoto(),
        ];

        $result = array_filter($validations, function ($value) { return ! $value; });
        $this->assertSame(0, count($result));
    }
}
