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
            $this->assertSame('La placa 1212122 no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('ABCERIO'))->validateCar();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa ABCERIO no es válida', $th->getMessage());
        }

        try {
            (new PlacaValidator('ABCER3O'))->validateCar();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('La placa ABCER3O no es válida', $th->getMessage());
        }
    }

    public function test_valid_placa()
    {
        /** Información obtenida de las siguientes fuentes, o mediante búsquedas en internet. 
         * Para solicitar eliminar un número de cédula hacerlo mediante 
         * la sección de issues en el repositorio de este proyecto.
         * 
         *    https://www.comisiontransito.gob.ec/wp-content/uploads/2021/07/REGISTRO-TRÁMITE-PENDIENTES-DE-PLACA-2019-CARROS.pdf
         */
        $validations = [
            (new PlacaValidator('TBB7233'))->validateCar(),
            (new PlacaValidator('PCM3929'))->validateCar(),
            (new PlacaValidator('POW0063'))->validateCar(),
            (new PlacaValidator('PCD2241'))->validateCar(),
            (new PlacaValidator('KBA0137'))->validateCar(),
            (new PlacaValidator('GSA2403'))->validateCar(),
            (new PlacaValidator('GCA7154'))->validateCar(),
            (new PlacaValidator('GPY0608'))->validateCar(),
            (new PlacaValidator('GRW7648'))->validateCar(),
            (new PlacaValidator('ABL0225'))->validateCar(),
            (new PlacaValidator('PBJ5999'))->validateCar(),
            (new PlacaValidator('IBC2558'))->validateCar(),
            (new PlacaValidator('XBA7929'))->validateCar(),
            (new PlacaValidator('GEA2237'))->validateCar(),
            (new PlacaValidator('GSC2345'))->validateCar(),
            (new PlacaValidator('ABE1551'))->validateCar(),
            (new PlacaValidator('PCI3617'))->validateCar(),
            (new PlacaValidator('GSU3819'))->validateCar(),
            (new PlacaValidator('GCA4623'))->validateCar(),
            (new PlacaValidator('GSK3507'))->validateCar(),
            (new PlacaValidator('GBN3049'))->validateCar(),
            (new PlacaValidator('PDC4501'))->validateCar(),
            (new PlacaValidator('PCX3456'))->validateCar(),
            (new PlacaValidator('GCB5861'))->validateCar(),
            (new PlacaValidator('GSX2174'))->validateCar(),
            (new PlacaValidator('POE0043'))->validateCar(),
            (new PlacaValidator('GCB5791'))->validateCar(),
            (new PlacaValidator('GSN4442'))->validateCar(),
            (new PlacaValidator('PBF9667'))->validateCar(),
            (new PlacaValidator('PBO1248'))->validateCar(),
            (new PlacaValidator('PBF9666'))->validateCar(),
            (new PlacaValidator('GCA9834'))->validateCar(),
            (new PlacaValidator('GST6201'))->validateCar(),
        ];

        $result = array_filter($validations, function($value) { return !$value; });
        $this->assertSame(0, count($result));
    }
}
