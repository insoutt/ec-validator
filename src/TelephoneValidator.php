<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Exceptions\TelephoneInternationalException;
use Insoutt\EcValidator\Exceptions\TelephoneLocalException;
use Insoutt\EcValidator\Exceptions\TelephoneWithProvinceCodeException;
use InvalidArgumentException;

class TelephoneValidator
{
    private $codes = ['2', '3', '4', '5', '6', '7'];
    private $telephone;

    public function __construct($telephone)
    {
        $this->telephone = $telephone;
    }

    public function validate()
    {
        try {
            if (substr($this->telephone, 0, 1) === '0') {
                return $this->validateWithProvinceCode();
            } elseif (substr($this->telephone, 0, 3) === '593') {
                return $this->validateInternational();
            } else {
                return $this->validateLocal();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validateInternational()
    {
        $this->checkDigits();
        $this->checkLength(11);
        $this->startsWith('593', $this->telephone);

        try {
            $provinceCode = substr($this->telephone, 3, 1);
            $this->checkProvinceCode($provinceCode);

            return true;
        } catch (\Throwable $th) {
            throw new TelephoneInternationalException("Número de teléfono {$this->telephone} no válido");
        }
    }

    public function validateWithProvinceCode()
    {
        $this->checkDigits();
        $this->checkLength(9);
        $this->startsWith('0', $this->telephone);

        try {
            $provinceCode = substr($this->telephone, 1, 1);
            $this->checkProvinceCode($provinceCode);

            return true;
        } catch (\Throwable $th) {
            throw new TelephoneWithProvinceCodeException("Número de teléfono {$this->telephone} no válido");
        }
    }

    public function validateLocal()
    {
        $this->checkDigits();
        $this->checkLength(7);

        if (substr($this->telephone, 0, 1) === '0') {
            throw new TelephoneLocalException("Número de teléfono {$this->telephone} no válido");
        }

        return true;
    }

    protected function startsWith($start, $value)
    {
        if (strpos($value, $start) === 0) {
            return true;
        }

        throw new InvalidArgumentException("Número de teléfono {$this->telephone} no válido");
    }

    protected function checkProvinceCode($code)
    {
        if (in_array($code, $this->codes)) {
            return true;
        }

        throw new InvalidArgumentException('Código de provincia no válido');
    }

    protected function checkDigits()
    {
        if (ctype_digit($this->telephone)) {
            return true;
        }

        throw new InvalidArgumentException("El número de teléfono debe tener solo dígitos numéricos");
    }

    protected function checkLength($length)
    {
        if (strlen($this->telephone) === $length) {
            return true;
        }

        throw new \LengthException("El número de teléfono debe ser de {$length} caracteres");
    }
}
