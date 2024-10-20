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
            $this->checkLength();
            $this->checkProvinceCode();
            $this->checkMod10();
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
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
        $code = (int) "{$this->ci[0]}{$this->ci[1]}";

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
        
    }

 
}
