# Validador de Cedula, RUC y más datos de Ecuador

[![Latest Version on Packagist](https://img.shields.io/packagist/v/insoutt/ec-validator.svg?style=flat-square)](https://packagist.org/packages/insoutt/ec-validator)
[![Tests](https://img.shields.io/github/actions/workflow/status/insoutt/ec-validator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/insoutt/ec-validator/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/insoutt/ec-validator.svg?style=flat-square)](https://packagist.org/packages/insoutt/ec-validator)

Con `insoutt/ec-validator` podrás realizar comprobaciones de distinta información que frecuentemente se suele validar como: 
- Validar RUC
- Validar cédula
- Validar número de teléfono fijo
- Validar número de celular
- Validar placa de vehículo
- Validar placa de moto

## Support us



## Installación

Para instalar el paquete debes ejecutar el siguiente comando en la terminal de tu proyecto:

```bash
composer require insoutt/ec-validator
```

## Uso

```php
require 'vendor/autoload.php';

use Insoutt\EcValidator\EcValidator;

// Crear Validador
$validator = new EcValidator() // or EcValidator::make();

// Validar cédula
if ($validator->validateCedula('0102030405')) {
    echo "Cédula válida";
} else {
    echo "Error: " . $validator->getError();
}

// Validar RUC
if ($validator->validateRuc('1790012356001')) {
    echo "RUC válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar número de celular con prefijo 09 o con prefijo internacional 593
if ($validator->validateCellphone('0991234567') || $validator->validateCellphone('593991234567')) {
    echo "Número de celular válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar número de celular (nacional)
if ($validator->validateCellphone('0991234567', EcValidator::VALIDATE_NATIONAL)) {
    echo "Número de celular válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar número de celular (internacional)
if ($validator->validateCellphone('593991234567', EcValidator::VALIDATE_INTERNATIONAL)) {
    echo "Número de celular válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar placa de auto o moto
if ($validator->validatePlaca('ABC1234') || $validator->validatePlaca('IX000A')) {
    echo "Placa de auto válida";
} else {
    echo "Error: " . $validator->getError();
}

// Validar placa de auto
if ($validator->validatePlaca('ABC1234', EcValidator::VALIDATE_PLACA_CAR)) {
    echo "Placa de auto válida";
} else {
    echo "Error: " . $validator->getError();
}

// Validar placa de moto
if ($validator->validatePlaca('MOTO123', EcValidator::VALIDATE_PLACA_MOTO)) {
    echo "Placa de moto válida";
} else {
    echo "Error: " . $validator->getError();
}

// Validar teléfono local (sin código de provincia)
if ($validator->validateTelephone('2334590', EcValidator::VALIDATE_LOCAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar teléfono (con código de provincia)
if ($validator->validateTelephone('072334590', EcValidator::VALIDATE_NATIONAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar teléfono (con código de internacional)
if ($validator->validateTelephone('59322345678', EcValidator::VALIDATE_INTERNATIONAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Error: " . $validator->getError();
}

// Validar teléfono local, con código de provincia o en formato interacional
if ($validator->validateTelephone('022345678') || $validator->validateTelephone('022345678') || $validator->validateTelephone('59322345678')) {
    echo "Número de teléfono válido";
} else {
    echo "Error: " . $validator->getError();
}

```

## Testing

```bash
composer test
```

Si deseas conocer mejor el funcionamiento de cada método es recomendable revisar los distintos ejemplos en `tests/EcValidatorTest.php`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Creditos

- [insoutt](https://github.com/insoutt)
- [All Contributors](../../contributors)

## Contacto
- 𝕏 (Twitter): [@insoutt](http://x.com/insoutt)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
