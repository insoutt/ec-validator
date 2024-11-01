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

    public function test_invalid_ci()
    {
        $this->expectException(\Exception::class);

        $validator = new CIValidator('1400724650');
        $validator->validate();
    }

    public function test_valid_ci()
    {
        /** Información obtenida de las siguientes fuentes, o mediante búsquedas en internet.
         * Para solicitar eliminar un número de cédula hacerlo mediante
         * la sección de issues en el repositorio de este proyecto.
         *
         *    https://portal.compraspublicas.gob.ec/sercop/wp-content/uploads/2018/04/ASISTENTE_DE_ATENCION_USUARIO_PROVINCIAL_ZONAL2.pdf
         *    https://portal.compraspublicas.gob.ec/sercop/wp-content/uploads/2018/04/ASISTENTE_DE_ATENCION_USUARIO_PROVINCIAL_ZONAL2.pdf
         */
        $validations = [
            (new CIValidator('1400724652'))->validate(),
            (new CIValidator('1003462080'))->validate(),
            (new CIValidator('1500744576'))->validate(),
            (new CIValidator('1723808109'))->validate(),
            (new CIValidator('1900316843'))->validate(),
            (new CIValidator('1900509959'))->validate(),
            (new CIValidator('0603141177'))->validate(),
            (new CIValidator('2100460878'))->validate(),
            (new CIValidator('1600538324'))->validate(),
            (new CIValidator('1310257637'))->validate(),
            (new CIValidator('1400567069'))->validate(),
            (new CIValidator('0401524541'))->validate(),
            (new CIValidator('1104129133'))->validate(),
            (new CIValidator('0604742403'))->validate(),
            (new CIValidator('1600523862'))->validate(),
            (new CIValidator('1500956030'))->validate(),
            (new CIValidator('2200082481'))->validate(),
            (new CIValidator('1900394220'))->validate(),
            (new CIValidator('2100494208'))->validate(),
            (new CIValidator('1600378382'))->validate(),
            (new CIValidator('2200049464'))->validate(),
            (new CIValidator('1803276649'))->validate(),
            (new CIValidator('0102560471'))->validate(),
            (new CIValidator('1721872156'))->validate(),
            (new CIValidator('0301749941'))->validate(),
            (new CIValidator('1101160032'))->validate(),
            (new CIValidator('1719690487'))->validate(),
            (new CIValidator('1717430100'))->validate(),
            (new CIValidator('1723077382'))->validate(),
            (new CIValidator('1724354459'))->validate(),
            (new CIValidator('0400988903'))->validate(),
            (new CIValidator('0202412755'))->validate(),
            (new CIValidator('1717877714'))->validate(),
            (new CIValidator('0400966289'))->validate(),
            (new CIValidator('1000630309'))->validate(),
            (new CIValidator('1709839664'))->validate(),
            (new CIValidator('1723415418'))->validate(),
            (new CIValidator('1708232754'))->validate(),
            (new CIValidator('1721147880'))->validate(),
            (new CIValidator('1721147898'))->validate(),
            (new CIValidator('1707608756'))->validate(),
            (new CIValidator('1710203694'))->validate(),
            (new CIValidator('0503372732'))->validate(),
            (new CIValidator('1712114196'))->validate(),
            (new CIValidator('1708810732'))->validate(),
            (new CIValidator('0501088975'))->validate(),
            (new CIValidator('1706757026'))->validate(),
            (new CIValidator('0601667249'))->validate(),
            (new CIValidator('1715932560'))->validate(),
            (new CIValidator('1722599154'))->validate(),
            (new CIValidator('1712030541'))->validate(),
            (new CIValidator('1710873934'))->validate(),
            (new CIValidator('0201846581'))->validate(),
            (new CIValidator('1717795882'))->validate(),
        ];

        $result = array_filter($validations, function ($value) { return ! $value; });
        $this->assertSame(0, count($result));
    }
}
