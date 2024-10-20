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
            $this->checkProvinceCode();
            $this->checkMod10();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function isString()
    {
        if(is_string($this->ci)) {
            return true;
        }

        throw new \Exception("La cédula debe ser un string");
    }

    protected function checkLength()
    {
        if(strlen($this->ci) === 10) {
            return true;
        }

        throw new LengthException("La cédula debe tener 10 caracteres");
    }

    protected function checkProvinceCode()
    {
        $code = (int) substr($this->ci, 0, 2);

        if($code > 0 && $code < 24) {
            return true;
        }

        if($code === 30) { // Extranjeros
            return true;
        }

        throw new CICodeException('El código de provincia de la cédula no es válido.');
    }

    protected function checkMod10()
    {
        // TODO: Implement logic
    }

 
}
