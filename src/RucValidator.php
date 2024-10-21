<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Exceptions\LengthException;
use Insoutt\EcValidator\Exceptions\RucCodeException;
use Insoutt\EcValidator\Exceptions\RucLast3DigitsException;

class RucValidator extends Validator
{
    protected $ruc;

    public function __construct($ruc)
    {
        $this->ruc = $ruc;
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function validate()
    {
        try {
            $this->checkLength();
            $this->checkProvinceCode();
            $this->checkLas3Digits();
            $this->checkMod10();

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function isString()
    {
        if (is_string($this->ruc)) {
            return true;
        }

        throw new \Exception("El RUC debe ser un string");
    }

    protected function checkLas3Digits()
    {
        $last3Digits = (int) substr($this->ruc, 10, 3);

        if ($last3Digits > 0) {
            return true;
        }

        throw new RucLast3DigitsException("RUC con código de establecimiento no válido.");
    }

    protected function checkLength()
    {
        if (strlen($this->ruc) === 13) {
            return true;
        }

        throw new LengthException("El RUC debe tener 13 caracteres");
    }

    protected function checkProvinceCode()
    {
        $code = (int) substr($this->ruc, 0, 2);

        if ($code > 0 && $code < 24) {
            return true;
        }

        if ($code === 30) { // Extranjeros
            return true;
        }

        throw new RucCodeException('El código inicial del RUC no es válido.');
    }

    protected function checkMod10()
    {
        // TODO: Implement logic
    }
}
