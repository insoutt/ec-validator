<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Exceptions\CICodeException;
use Insoutt\EcValidator\Exceptions\LengthException;

class CIValidator extends Validator
{
    protected $ci;

    public function __construct($ci)
    {
        $this->ci = $ci;
    }

    public function getCi()
    {
        return $this->ci;
    }

    public function validate()
    {
        try {
            $this->isString();
            $this->checkLength();
            $this->checkDigits();
            $this->checkProvinceCode();
            $this->checkCi();

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function isString()
    {
        if (is_string($this->ci)) {
            return true;
        }

        throw new \Exception("La cédula debe ser un string");
    }

    protected function checkDigits()
    {
        if (ctype_digit($this->ci)) {
            return true;
        }

        throw new LengthException("La cédula debe tener solo dígitos numéricos");
    }

    protected function checkLength()
    {
        if (strlen($this->ci) === 10) {
            return true;
        }

        throw new LengthException("La cédula debe tener 10 caracteres");
    }

    protected function checkProvinceCode()
    {
        $code = (int) substr($this->ci, 0, 2);

        if ($code > 0 && $code <= 24) {
            return true;
        }

        if ($code === 30) { // Extranjeros
            return true;
        }

        throw new CICodeException('El código de provincia de la cédula no es válido.');
    }

    protected function checkCi()
    {
        // Convert string into an array of digits
        $digits = array_map('intval', str_split($this->ci));

        // Remove the last digit (verifier)
        $verifier = array_pop($digits);

        // Calculate the check digit
        $calculated = array_reduce(
            array_keys($digits),
            function ($previous, $index) use ($digits) {
                $current = $digits[$index];

                return $previous - ($current * (2 - $index % 2)) % 9 - ($current === 9 ? 9 : 0);
            },
            1000
        ) % 10;

        if ($calculated !== $verifier) {
            throw new \Exception("La cédula no es válida.");
        }

        return true;
    }
}
