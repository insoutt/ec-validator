<?php

namespace Insoutt\EcValidator\Tests;

use Insoutt\EcValidator\CellphoneValidator;

class CellphoneValidatorTest extends TestCase
{
    public function test_phone_has_only_digits()
    {
        try {
            (new CellphoneValidator('12s12122'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
            $this->assertSame('El número de celular debe tener solo dígitos numéricos', $th->getMessage());
        }
    }

    public function test_phone_has_valid_length()
    {
        try {
            (new CellphoneValidator('0909'))->validateNational();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de celular debe ser de 10 caracteres', $th->getMessage());
        }

        try {
            (new CellphoneValidator('0909'))->validateInternational();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de celular debe ser de 12 caracteres', $th->getMessage());
        }

        try {
            (new CellphoneValidator('0909'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de celular debe ser de 10 caracteres', $th->getMessage());
        }

        try {
            (new CellphoneValidator('5930909'))->validate();
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\LengthException::class, $th);
            $this->assertSame('El número de celular debe ser de 12 caracteres', $th->getMessage());
        }
    }

    public function test_phone_is_valid()
    {
        /**
         * Números de celular generados de forma aleatoria
         */
        $validations = [
            (new CellphoneValidator('0947888421'))->validate(),
            (new CellphoneValidator('0983788601'))->validate(),
            (new CellphoneValidator('0983788602'))->validate(),
            (new CellphoneValidator('0983788603'))->validate(),
            (new CellphoneValidator('0983788604'))->validate(),

            (new CellphoneValidator('593903788600'))->validate(),
            (new CellphoneValidator('593903788601'))->validate(),
            (new CellphoneValidator('593903788602'))->validate(),
            (new CellphoneValidator('593903788603'))->validate(),
            (new CellphoneValidator('593903788604'))->validate(),

            (new CellphoneValidator('0983788600'))->validateNational(),
            (new CellphoneValidator('0983788601'))->validateNational(),
            (new CellphoneValidator('0983788602'))->validateNational(),
            (new CellphoneValidator('0983788603'))->validateNational(),
            (new CellphoneValidator('0983788604'))->validateNational(),

            (new CellphoneValidator('593903788600'))->validateInternational(),
            (new CellphoneValidator('593903788601'))->validateInternational(),
            (new CellphoneValidator('593903788602'))->validateInternational(),
            (new CellphoneValidator('593903788603'))->validateInternational(),
            (new CellphoneValidator('593903788604'))->validateInternational(),
        ];

        $result = array_filter($validations, function ($value) { return ! $value; });
        $this->assertSame(0, count($result));
    }
}
