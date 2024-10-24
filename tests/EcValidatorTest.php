<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\EcValidator;

class EcValidatorTest extends TestCase
{
    public function test_validate_ci()
    {
        $validator = EcValidator::make();

        $this->assertFalse($validator->validateCedula('1212'));
        $this->assertSame('La cédula debe tener 10 caracteres', $validator->getError());

        $this->assertTrue($validator->validateCedula('1500744576'));
        $this->assertSame('', $validator->getError());
    }

    public function test_validate_ruc()
    {
        $validator = EcValidator::make();

        $this->assertFalse($validator->validateRuc('1212'));
        $this->assertSame('El RUC debe tener 13 caracteres', $validator->getError());

        $this->assertTrue($validator->validateRuc('1791248678001'));
        $this->assertSame('', $validator->getError());
    }

    public function test_validate_placa()
    {
        $validator = EcValidator::make();
        $this->assertFalse($validator->validatePlaca('DBA0289'));
        $this->assertSame('Código de provincia no válido', $validator->getError());

        $this->assertFalse($validator->validatePlaca('TBB7233', EcValidator::VALIDATE_PLACA_MOTO));
        $this->assertSame('La placa debe ser de 6 caracteres', $validator->getError());

        $this->assertFalse($validator->validatePlaca('IX617C', EcValidator::VALIDATE_PLACA_CAR));
        $this->assertSame('La placa debe ser de 7 caracteres', $validator->getError());

        try {
            $validator->validatePlaca('1212', EcValidator::VALIDATE_INTERNATIONAL);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('Tipo de validación no válida, valores pueden ser: CAR, MOTO, GENERAL', $th->getMessage());
        }

        $this->assertTrue($validator->validatePlaca('TBB7233', EcValidator::VALIDATE_PLACA_CAR));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validatePlaca('IX617C', EcValidator::VALIDATE_PLACA_MOTO));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validatePlaca('TBB7233'));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validatePlaca('IX617C'));
        $this->assertSame('', $validator->getError());
    }

    public function test_validate_telephone()
    {
        $validator = EcValidator::make();
        $this->assertFalse($validator->validateTelephone('1212'));
        $this->assertSame('El número de teléfono debe ser de 7 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('022334590', EcValidator::VALIDATE_LOCAL));
        $this->assertSame('El número de teléfono debe ser de 7 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('59352334590', EcValidator::VALIDATE_LOCAL));
        $this->assertSame('El número de teléfono debe ser de 7 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('59352334590', EcValidator::VALIDATE_NATIONAL));
        $this->assertSame('El número de teléfono debe ser de 9 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('2334590', EcValidator::VALIDATE_NATIONAL));
        $this->assertSame('El número de teléfono debe ser de 9 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('022334590', EcValidator::VALIDATE_INTERNATIONAL));
        $this->assertSame('El número de teléfono debe ser de 11 caracteres', $validator->getError());

        $this->assertFalse($validator->validateTelephone('2334590', EcValidator::VALIDATE_INTERNATIONAL));
        $this->assertSame('El número de teléfono debe ser de 11 caracteres', $validator->getError());


        try {
            $validator->validateTelephone('1212', EcValidator::VALIDATE_PLACA_CAR);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('Tipo de validación no válida, valores pueden ser: LOCAL, NATIONAL, INTERNATIONAL, GENERAL', $th->getMessage());
        }

        $this->assertTrue($validator->validateTelephone('2334590', EcValidator::VALIDATE_LOCAL));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validateTelephone('022334590', EcValidator::VALIDATE_NATIONAL));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validateTelephone('59352334590', EcValidator::VALIDATE_INTERNATIONAL));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validateTelephone('2334590'));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validateTelephone('022334590'));
        $this->assertSame('', $validator->getError());

        $this->assertTrue($validator->validateTelephone('59352334590'));
        $this->assertSame('', $validator->getError());
    }
}
