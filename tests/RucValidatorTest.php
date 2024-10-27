<?php

namespace Insoutt\EcValidator\Tests;

use Exception;
use Insoutt\EcValidator\Exceptions\LengthException;
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
        try {
            (new RucValidator('0010000000001'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\RucCodeException::class, $th);
        }

        try {
            (new RucValidator('2510000000001'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\RucCodeException::class, $th);
        }
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

    public function test_valid_ruc()
    {
        /** Información obtenida de las siguientes fuentes, o mediante búsquedas en internet.
         * Para solicitar eliminar un número de cédula hacerlo mediante
         * la sección de issues en el repositorio de este proyecto.
         *
         *    https://www.aduana.gob.ec/archivos/Boletines/2016/Nuevos_Tipos_de_Embalajes_CyD.pdf
         */
        $validations = [
            (new RucValidator('0990828237001'))->validate(),
            (new RucValidator('0962893970001'))->validate(),
            (new RucValidator('0990271712001'))->validate(),
            (new RucValidator('1791248678001'))->validate(),
            (new RucValidator('0992142618001'))->validate(),
            (new RucValidator('0990372055001'))->validate(),
            (new RucValidator('1790360741001'))->validate(),
            (new RucValidator('0991352937001'))->validate(),
            (new RucValidator('0992233761001'))->validate(),
            (new RucValidator('0990179085001'))->validate(),
            (new RucValidator('0992362316001'))->validate(),
            (new RucValidator('0992497025001'))->validate(),
            (new RucValidator('0992256230001'))->validate(),
            (new RucValidator('1790408515001'))->validate(),
            (new RucValidator('0992415290001'))->validate(),
            (new RucValidator('1790450635001'))->validate(),
            (new RucValidator('0991331433001'))->validate(),
            (new RucValidator('0791722675001'))->validate(),
            (new RucValidator('1790241483001'))->validate(),
            (new RucValidator('1790506886001'))->validate(),
            (new RucValidator('0992209682001'))->validate(),
            (new RucValidator('1790093840001'))->validate(),
            (new RucValidator('0991372784001'))->validate(),
            (new RucValidator('0990856583001'))->validate(),
            (new RucValidator('0991152601001'))->validate(),
            (new RucValidator('0992703342001'))->validate(),
            (new RucValidator('0990112150001'))->validate(),
            (new RucValidator('1790142981001'))->validate(),
            (new RucValidator('1790417581001'))->validate(),
            (new RucValidator('1790175952001'))->validate(),
            (new RucValidator('0990005419001'))->validate(),
            (new RucValidator('1390000991001'))->validate(),
            (new RucValidator('0591705466001'))->validate(),
            (new RucValidator('0990914559001'))->validate(),
            (new RucValidator('1792444403001'))->validate(),
            (new RucValidator('0992588942001'))->validate(),
            (new RucValidator('1790199568001'))->validate(),
            (new RucValidator('1790233979001'))->validate(),
            (new RucValidator('1792014980001'))->validate(),
            (new RucValidator('1790542750001'))->validate(),
            (new RucValidator('1791148800001'))->validate(),
            (new RucValidator('1790252361001'))->validate(),
            (new RucValidator('1792015065001'))->validate(),
            (new RucValidator('1791897498001'))->validate(),
            (new RucValidator('1792109485001'))->validate(),
            (new RucValidator('1792128218001'))->validate(),
            (new RucValidator('1791961684001'))->validate(),
            (new RucValidator('0991210245001'))->validate(),
            (new RucValidator('0190353575001'))->validate(),
            (new RucValidator('0990000530001'))->validate(),
            (new RucValidator('0990000689001'))->validate(),
            (new RucValidator('0990071969001'))->validate(),
            (new RucValidator('1790885186001'))->validate(),
            (new RucValidator('0991134352001'))->validate(),
            (new RucValidator('1792123801001'))->validate(),
            (new RucValidator('0913743464001'))->validate(),
            (new RucValidator('0990575053001'))->validate(),
            (new RucValidator('0400579231001'))->validate(),
            (new RucValidator('0190007510001'))->validate(),
            (new RucValidator('0990004277001'))->validate(),
            (new RucValidator('0190311198001'))->validate(),
            (new RucValidator('0992399074001'))->validate(),
            (new RucValidator('0992111232001'))->validate(),
            (new RucValidator('0990331944001'))->validate(),
            (new RucValidator('0991284214001'))->validate(),
            (new RucValidator('1792405130001'))->validate(),
            (new RucValidator('1792453712001'))->validate(),
            (new RucValidator('0991400427001'))->validate(),
            (new RucValidator('0992141913001'))->validate(),
            (new RucValidator('1391722486001'))->validate(),
            (new RucValidator('0992444762001'))->validate(),
            (new RucValidator('1792174643001'))->validate(),
            (new RucValidator('1791888189001'))->validate(),
            (new RucValidator('1791290313001'))->validate(),
            (new RucValidator('1791731824001'))->validate(),
            (new RucValidator('1790004724001'))->validate(),
            (new RucValidator('1790007499001'))->validate(),
            (new RucValidator('1791261151001'))->validate(),
            (new RucValidator('1790775941001'))->validate(),
            (new RucValidator('1790980197001'))->validate(),
            (new RucValidator('1790994708001'))->validate(),
            (new RucValidator('1792144566001'))->validate(),
            (new RucValidator('1791355792001'))->validate(),
            (new RucValidator('1791361342001'))->validate(),
            (new RucValidator('1791808398001'))->validate(),
            (new RucValidator('0990011214001'))->validate(),
            (new RucValidator('1792459044001'))->validate(),
            (new RucValidator('1792115213001'))->validate(),
            (new RucValidator('1791310233001'))->validate(),
            (new RucValidator('1791316584001'))->validate(),
            (new RucValidator('1791412540001'))->validate(),
            (new RucValidator('1791283635001'))->validate(),
            (new RucValidator('1792060346001'))->validate(),
            (new RucValidator('1791290151001'))->validate(),
            (new RucValidator('0992185228001'))->validate(),
            (new RucValidator('0992638125001'))->validate(),
            (new RucValidator('0992330066001'))->validate(),
            (new RucValidator('0190058670001'))->validate(),
            (new RucValidator('0190003299001'))->validate(),
            (new RucValidator('0190151549001'))->validate(),
            (new RucValidator('1792250285001'))->validate(),
        ];

        $result = array_filter($validations, function ($value) { return ! $value; });
        $this->assertSame(0, count($result));
    }
}
