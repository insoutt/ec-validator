<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\TelephoneValidator;

class TelephoneValidatorTest extends TestCase
{
    public function test_telephone_has_only_digits()
    {
        try {
            (new TelephoneValidator('12s12122'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('El número de teléfono debe tener solo dígitos numéricos', $th->getMessage());
        }
    }

    public function test_telephone_has_valid_length()
    {
        try {
            (new TelephoneValidator('0909'))->validateLocal();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 7 caracteres', $th->getMessage());
        }

        try {
            (new TelephoneValidator('0909'))->validateWithProvinceCode();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 9 caracteres', $th->getMessage());
        }

        try {
            (new TelephoneValidator('0909'))->validateInternational();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 11 caracteres', $th->getMessage());
        }

        try {
            (new TelephoneValidator('4909'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 7 caracteres', $th->getMessage());
        }

        try {
            (new TelephoneValidator('0909'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 9 caracteres', $th->getMessage());
        }

        try {
            (new TelephoneValidator('5930909'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de teléfono debe ser de 11 caracteres', $th->getMessage());
        }
    }

    public function test_telephone_has_invalid_codes()
    {
        try {
            (new TelephoneValidator('033459045'))->validateWithProvinceCode();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\TelephoneWithProvinceCodeException::class, $th);
            $this->assertSame('Número de teléfono 033459045 no válido', $th->getMessage());
        }

        try {
            (new TelephoneValidator('092398900'))->validateWithProvinceCode();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\TelephoneWithProvinceCodeException::class, $th);
            $this->assertSame('Número de teléfono 092398900 no válido', $th->getMessage());
        }

        try {
            (new TelephoneValidator('59392398900'))->validateInternational();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\TelephoneInternationalException::class, $th);
            $this->assertSame('Número de teléfono 59392398900 no válido', $th->getMessage());
        }

        try {
            (new TelephoneValidator('092398900'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\TelephoneWithProvinceCodeException::class, $th);
            $this->assertSame('Número de teléfono 092398900 no válido', $th->getMessage());
        }

        try {
            (new TelephoneValidator('59392398900'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\Insoutt\EcValidator\Exceptions\TelephoneInternationalException::class, $th);
            $this->assertSame('Número de teléfono 59392398900 no válido', $th->getMessage());
        }
    }

    public function test_telephone_is_valid()
    {
        /**
         * Números de teléfono generados de forma aleatoria
         */
        $validations = [
            (new TelephoneValidator('022334590'))->validateWithProvinceCode(),
            (new TelephoneValidator('032334590'))->validateWithProvinceCode(),
            (new TelephoneValidator('042334590'))->validateWithProvinceCode(),
            (new TelephoneValidator('052334590'))->validateWithProvinceCode(),
            (new TelephoneValidator('062334590'))->validateWithProvinceCode(),
            (new TelephoneValidator('072334590'))->validateWithProvinceCode(),

            (new TelephoneValidator('59322334590'))->validateInternational(),
            (new TelephoneValidator('59332334590'))->validateInternational(),
            (new TelephoneValidator('59342334590'))->validateInternational(),
            (new TelephoneValidator('59352334590'))->validateInternational(),
            (new TelephoneValidator('59362334590'))->validateInternational(),
            (new TelephoneValidator('59372334590'))->validateInternational(),

            (new TelephoneValidator('2334590'))->validateLocal(),
            (new TelephoneValidator('2334590'))->validateLocal(),
            (new TelephoneValidator('4334590'))->validateLocal(),
            (new TelephoneValidator('5334590'))->validateLocal(),
            (new TelephoneValidator('3334590'))->validateLocal(),
            (new TelephoneValidator('2334590'))->validateLocal(),

            
            (new TelephoneValidator('022334590'))->validate(),
            (new TelephoneValidator('032334590'))->validate(),
            (new TelephoneValidator('042334590'))->validate(),
            (new TelephoneValidator('052334590'))->validate(),
            (new TelephoneValidator('062334590'))->validate(),
            (new TelephoneValidator('072334590'))->validate(),

            (new TelephoneValidator('59322334590'))->validate(),
            (new TelephoneValidator('59332334590'))->validate(),
            (new TelephoneValidator('59342334590'))->validate(),
            (new TelephoneValidator('59352334590'))->validate(),
            (new TelephoneValidator('59362334590'))->validate(),
            (new TelephoneValidator('59372334590'))->validate(),

            (new TelephoneValidator('2334590'))->validate(),
            (new TelephoneValidator('2334590'))->validate(),
            (new TelephoneValidator('4334590'))->validate(),
            (new TelephoneValidator('5334590'))->validate(),
            (new TelephoneValidator('3334590'))->validate(),
            (new TelephoneValidator('2334590'))->validate(),
        ];

        $result = array_filter($validations, function ($value) { return ! $value; });
        $this->assertSame(0, count($result));
    }
}
