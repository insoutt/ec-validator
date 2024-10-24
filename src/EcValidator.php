<?php

namespace Insoutt\EcValidator;

use Insoutt\EcValidator\Traits\Makeable;
use InvalidArgumentException;

class EcValidator
{
    use Makeable;

    public const VALIDATE_GENERAL = 'GENERAL';
    public const VALIDATE_LOCAL = 'LOCAL';
    public const VALIDATE_NATIONAL = 'NATIONAL';
    public const VALIDATE_INTERNATIONAL = 'INTERNATIONAL';
    public const VALIDATE_PLACA_MOTO = 'MOTO';
    public const VALIDATE_PLACA_CAR = 'CAR';

    private $error = '';

    public function getError()
    {
        return $this->error;
    }

    public function validateCedula($value)
    {
        try {
            $validator = new CIValidator($value);
            $validator->validate();
            $this->reset();

            return true;
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();

            return false;
        }
    }

    public function validateRuc($value)
    {
        try {
            $validator = new RucValidator($value);
            $validator->validate();
            $this->reset();

            return true;
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();

            return false;
        }
    }

    public function validateCellphone($value, $type = self::VALIDATE_GENERAL)
    {
        $this->checkTypeArg($type, [self::VALIDATE_NATIONAL, self::VALIDATE_INTERNATIONAL, self::VALIDATE_GENERAL]);

        try {
            $validator = new CellphoneValidator($value);
            switch ($type) {
                case self::VALIDATE_NATIONAL:
                    $validator->validateNational();

                    break;
                case self::VALIDATE_INTERNATIONAL:
                    $validator->validateInternational();

                    break;
                default:
                    $validator->validate();

                    break;
            }
            $this->reset();

            return true;
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();

            return false;
        }
    }

    public function validatePlaca($value, $type = self::VALIDATE_GENERAL)
    {
        $this->checkTypeArg($type, [self::VALIDATE_PLACA_CAR, self::VALIDATE_PLACA_MOTO, self::VALIDATE_GENERAL]);

        try {
            $validator = new PlacaValidator($value);
            switch ($type) {
                case self::VALIDATE_PLACA_CAR:
                    $validator->validateCar();

                    break;
                case self::VALIDATE_PLACA_MOTO:
                    $validator->validateMoto();

                    break;
                default:
                    $validator->validate();

                    break;
            }
            $this->reset();

            return true;
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();

            return false;
        }
    }

    public function validateTelephone($value, $type = self::VALIDATE_GENERAL)
    {
        $this->checkTypeArg($type, [self::VALIDATE_LOCAL, self::VALIDATE_NATIONAL, self::VALIDATE_INTERNATIONAL, self::VALIDATE_GENERAL]);

        try {
            $validator = new TelephoneValidator($value);
            switch ($type) {
                case self::VALIDATE_LOCAL:
                    $validator->validateLocal();

                    break;
                case self::VALIDATE_NATIONAL:
                    $validator->validateWithProvinceCode();

                    break;
                case self::VALIDATE_INTERNATIONAL:
                    $validator->validateInternational();

                    break;
                default:
                    $validator->validate();

                    break;
            }
            $this->reset();

            return true;
        } catch (\Throwable $th) {
            $this->error = $th->getMessage();

            return false;
        }
    }

    private function checkTypeArg($type, $availableTypes)
    {
        if (! in_array($type, $availableTypes)) {
            throw new InvalidArgumentException('Tipo de validación no válida, valores pueden ser: ' . implode(', ', $availableTypes));
        }
    }

    private function reset()
    {
        $this->error = '';
    }
}
