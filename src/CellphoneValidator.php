<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Exceptions\CellphoneInternationalException;
use Insoutt\EcValidator\Exceptions\CellphoneLocalException;
use InvalidArgumentException;

class CellphoneValidator
{
    private $phoneNumber;

    public function __construct($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function validate()
    {

        try {
            if (substr($this->phoneNumber, 0, 3) === '593') {
                return $this->validateInternational();
            } else {
                return $this->validateNational();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validateInternational()
    {
        $this->checkDigits();
        $this->checkLength(12);
        $localNumber = substr($this->phoneNumber, 3);

        if (strlen($localNumber) !== 9 || substr($localNumber, 0, 1) !== '9') {
            throw new CellphoneInternationalException('Número de celular no válido');
        }

        return true;
    }

    public function validateNational()
    {
        $this->checkDigits();
        $this->checkLength(10);

        // El número local debe tener 10 dígitos y empezar con 09
        if (strlen($this->phoneNumber) !== 10 || substr($this->phoneNumber, 0, 2) !== '09') {
            throw new CellphoneLocalException('Número de celular no válido');
        }

        return true;
    }

    protected function checkDigits()
    {
        if (ctype_digit($this->phoneNumber)) {
            return true;
        }

        throw new InvalidArgumentException("El número de celular debe tener solo dígitos numéricos");
    }

    protected function checkLength($length)
    {
        if (strlen($this->phoneNumber) === $length) {
            return true;
        }

        throw new \LengthException("El número de celular debe ser de {$length} caracteres");
    }
}
