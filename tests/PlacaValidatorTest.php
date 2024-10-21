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

    public function test_valid_placa()
    {
        /** Información obtenida de las siguientes fuentes, o mediante búsquedas en internet. 
         * Para solicitar eliminar un número de cédula hacerlo mediante 
         * la sección de issues en el repositorio de este proyecto.
         * 
         *    https://www.comisiontransito.gob.ec/wp-content/uploads/2021/07/REGISTRO-TRÁMITE-PENDIENTES-DE-PLACA-2019-CARROS.pdf
         *    https://transitopasaje.gob.ec/formulario/RETIRO-PLACAS.pdf
         */
        $validations = [
            (new PlacaValidator('TBB7233'))->validate(),
            (new PlacaValidator('PCM3929'))->validate(),
            (new PlacaValidator('POW0063'))->validate(),
            (new PlacaValidator('PCD2241'))->validate(),
            (new PlacaValidator('KBA0137'))->validate(),
            (new PlacaValidator('GSA2403'))->validate(),
            (new PlacaValidator('GCA7154'))->validate(),
            (new PlacaValidator('IV678C'))->validate(),
            (new PlacaValidator('IX609C'))->validate(),
            (new PlacaValidator('IX617C'))->validate(),
            (new PlacaValidator('IX619C'))->validate(),
            (new PlacaValidator('IZ006P'))->validate(),
            (new PlacaValidator('IZ007P'))->validate(),
        ];

        $result = array_filter($validations, function($value) { return !$value; });
        $this->assertSame(0, count($result));
    }
}
