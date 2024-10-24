<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Exceptions\ProvinceCodeException;
use InvalidArgumentException;
use LengthException;

class PlacaValidator extends Validator
{
    protected $codes = ['A','B','C','E','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y'];

    protected $licensePlate;
    protected $type;

    public function __construct($licensePlate)
    {

        $this->licensePlate = $licensePlate;
    }

    public function validate()
    {
        try {
            return $this->validateCar();
        } catch (\Throwable $carException) {
            try {
                return $this->validateMoto();
            } catch (\Throwable $motoException) {
                if ($carException instanceof ProvinceCodeException) {
                    throw $carException;
                }

                if ($carException->getMessage() === $motoException->getMessage()) {
                    throw new \InvalidArgumentException($carException->getMessage());
                }

                throw new \InvalidArgumentException($carException->getMessage() . ' o ' . $motoException->getMessage());
            }
        }
    }

    public function validateCar()
    {
        try {
            $this->checkGeneral();
            $this->checkLength(7);
            $this->checkLetters(0, 3);
            $this->checkDigits(3, 4);
            $this->checkProvinceCode();

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validateMoto()
    {
        try {
            $this->checkGeneral();
            $this->checkLength(6);
            $this->checkLetters(0, 2);
            $this->checkDigits(2, 3);
            $this->checkLetters(5, 1);
            $this->checkProvinceCode();

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function checkGeneral()
    {
        try {
            $this->isString();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function checkProvinceCode()
    {
        $code = $this->licensePlate[0];

        if (in_array($code, $this->codes)) {
            return true;
        }

        throw new ProvinceCodeException('Código de provincia no válido');
    }

    protected function checkLetters($start, $end)
    {
        $letters = substr($this->licensePlate, $start, $end);

        if (preg_match('/^[A-Za-z]+$/', $letters)) {
            return true;
        }

        throw new InvalidArgumentException("La placa {$this->licensePlate} no es válida");
    }

    protected function checkDigits($start, $end)
    {
        $digits = substr($this->licensePlate, $start, $end);

        if (ctype_digit($digits)) {
            return true;
        }

        throw new InvalidArgumentException("La placa {$this->licensePlate} no es válida");
    }

    protected function isString()
    {
        if (is_string($this->licensePlate)) {
            return true;
        }

        throw new InvalidArgumentException("La placa debe ser un string");
    }

    protected function checkLength($length)
    {
        if (strlen($this->licensePlate) === $length) {
            return true;
        }

        throw new LengthException("La placa debe ser de {$length} caracteres");
    }
}
