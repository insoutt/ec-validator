# Validar Cedula, RUC y más datos de Ecuador

[![Latest Version on Packagist](https://img.shields.io/packagist/v/insoutt/ec-validator.svg?style=flat-square)](https://packagist.org/packages/insoutt/ec-validator)
[![Tests](https://img.shields.io/github/actions/workflow/status/insoutt/ec-validator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/insoutt/ec-validator/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/insoutt/ec-validator.svg?style=flat-square)](https://packagist.org/packages/insoutt/ec-validator)

Con `insoutt/ec-validator` podrás realizar validaciones de distintos datos que se suele usar frecuentemente en Ecuador, como por ejemplo:

- Validar RUC
- Validar cédula
- Validar número de teléfono fijo
- Validar número de celular
- Validar placa de carro
- Validar placa de moto

Si crees que falta validar alguna información adicional puedes crear una sugerencia en el [Foro de Discuciones](https://github.com/insoutt/ec-validator/discussions/new?category=ideas) para desarrollarla o también puedes crear un [Pull Request](https://github.com/insoutt/ec-validator/pulls) para ser implementado.

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
```

### Validar Cédula
```php
if ($validator->validateCedula('0102030405')) {
    echo "Cédula válida";
} else {
    echo "Cédula no válida: " . $validator->getError();
}

```

### Validar RUC
El número de RUC no tiene un algoritmo específico definido por lo que no existe un método exacto para validarlo. Ante esto la validación que se realiza es de estructura validando el código de provincia y el número de establecimiento.

Si conoces algún mejor método puedes publicarlo en el [Foro de Discuciones](https://github.com/insoutt/ec-validator/discussions/new?category=q-a) o [crear un Pull Request](https://github.com/insoutt/ec-validator/pulls) para implementarlo.

En el caso de validaciones de un RUC personal si se podría realizar ya que la comprobación sería la misma que la cédula más el código de establecimiento que por lo general es `001`.

```php
if ($validator->validateRuc('1790012356001')) {
    echo "RUC válido";
} else {
    echo "Ruc no válido: " . $validator->getError();
}
```

### Validar placa de un vehículo
Se puede realizar validaciones especificas por placa de moto, placa de carro o también se puede realizar una validación más general para validar ambos casos.

```php
// Validar placa de auto o moto
if ($validator->validatePlaca('ABC1234') || $validator->validatePlaca('IX000A')) {
    echo "Placa de auto válida";
} else {
    echo "Placa de auto no válida: " . $validator->getError();
}

// Validar placa de auto
if ($validator->validatePlaca('ABC1234', EcValidator::VALIDATE_PLACA_CAR)) {
    echo "Placa de auto válida";
} else {
    echo "Placa de auto no válida: " . $validator->getError();
}

// Validar placa de moto
if ($validator->validatePlaca('MOTO123', EcValidator::VALIDATE_PLACA_MOTO)) {
    echo "Placa de moto válida";
} else {
    echo "Placa de moto no válida: " . $validator->getError();
}
```

### Validar número de celular
Para validar un número de celular existen 3 escenarios:
- `EcValidator::VALIDATE_NATIONAL`: Número de celular nacional que empieza con `09`, para llamadas/mensajes dentro de Ecuador
- `EcValidator::VALIDATE_INTERNATIONAL`: Número de celular con el código de país `593`, para llamadas internacionales.
- `EcValidator::VALIDATE_GENERAL`: Validar ambos casos
```php
// Validar número de celular con prefijo 09 o con prefijo internacional 593
if ($validator->validateCellphone('0991234567') || $validator->validateCellphone('593991234567')) {
    echo "Número de celular válido";
} else {
    echo "Número de celular no válido: " . $validator->getError();
}

// Validar número de celular (nacional)
if ($validator->validateCellphone('0991234567', EcValidator::VALIDATE_NATIONAL)) {
    echo "Número de celular válido";
} else {
    echo "Número de celular no válido: " . $validator->getError();
}

// Validar número de celular (internacional)
if ($validator->validateCellphone('593991234567', EcValidator::VALIDATE_INTERNATIONAL)) {
    echo "Número de celular válido";
} else {
    echo "Número de celular no válido: " . $validator->getError();
}
```

### Validar teléfono convencional
Para los números de teléfono convencionales existen 4 tipos de validaciones:
- `EcValidator::VALIDATE_LOCAL`: Número de teléfono local para llamadas que son en la misma ciudad/provincia.
- `EcValidator::VALIDATE_NATIONAL`: Número de teléfono con el código de la provincia para llamadas entre distintas ciudades/provincias.
- `EcValidator::VALIDATE_INTERNATIONAL`: Número de teléfono con el código de país y provincia para llamadas internacionales.
- `EcValidator::VALIDATE_GENERAL`: Validar cualquiera de los 3 casos.

```php
// Validar teléfono local (sin código de provincia)
if ($validator->validateTelephone('2334590', EcValidator::VALIDATE_LOCAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Número de teléfono no válido: " . $validator->getError();
}

// Validar teléfono (con código de provincia)
if ($validator->validateTelephone('072334590', EcValidator::VALIDATE_NATIONAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Número de teléfono no válido: " . $validator->getError();
}

// Validar teléfono (con código de internacional)
if ($validator->validateTelephone('59322345678', EcValidator::VALIDATE_INTERNATIONAL)) {
    echo "Número de teléfono válido";
} else {
    echo "Número de teléfono no válido: " . $validator->getError();
}

// Validar teléfono local, con código de provincia o en formato interacional
if ($validator->validateTelephone('022345678') || $validator->validateTelephone('022345678') || $validator->validateTelephone('59322345678')) {
    echo "Número de teléfono válido";
} else {
    echo "Número de teléfono no válido: " . $validator->getError();
}
```

## API
A continuación se detalla los parámetros disponibles de cada método:

### `validateCedula($value)`

| Método                | Argumentos          | Descripción                                | Retorno                                   |
|-----------------------|---------------------|--------------------------------------------|-------------------------------------------|
| `validateCedula`       | `$value` (string)   | Valida un número de cédula ecuatoriana.    | `true` si es válido, `false` si no es válido. |

---

### `validateRuc($value)`

| Método                | Argumentos          | Descripción                                | Retorno                                   |
|-----------------------|---------------------|--------------------------------------------|-------------------------------------------|
| `validateRuc`          | `$value` (string)   | Valida un número de RUC ecuatoriano.       | `true` si es válido, `false` si no es válido. |

---

### `validatePlaca($value, $type = self::VALIDATE_GENERAL)`

| Método                | Argumentos                                              | Descripción                                                                                  | Retorno                                   |
|-----------------------|---------------------------------------------------------|----------------------------------------------------------------------------------------------|-------------------------------------------|
| `validatePlaca`        | `$value` (string), `$type` (string)                    | Valida una placa de vehículo. Tipos: `VALIDATE_PLACA_CAR`, `VALIDATE_PLACA_MOTO`, `VALIDATE_GENERAL`. | `true` si es válido, `false` si no es válido. |
---

### `validateCellphone($value, $type = self::VALIDATE_GENERAL)`

| Método                | Argumentos                                              | Descripción                                                                                     | Retorno                                   |
|-----------------------|---------------------------------------------------------|-------------------------------------------------------------------------------------------------|-------------------------------------------|
| `validateCellphone`    | `$value` (string), `$type` (string)                    | Valida un número de celular. Tipos: `VALIDATE_GENERAL`, `VALIDATE_NATIONAL`, `VALIDATE_INTERNATIONAL`. | `true` si es válido, `false` si no es válido. |

---

### `validateTelephone($value, $type = self::VALIDATE_GENERAL)`

| Método                | Argumentos                                              | Descripción                                                                                          | Retorno                                   |
|-----------------------|---------------------------------------------------------|------------------------------------------------------------------------------------------------------|-------------------------------------------|
| `validateTelephone`    | `$value` (string), `$type` (string)                    | Valida un número de teléfono fijo. Tipos: `VALIDATE_LOCAL`, `VALIDATE_NATIONAL`, `VALIDATE_INTERNATIONAL`, `VALIDATE_GENERAL`. | `true` si es válido, `false` si no es válido. |

---

### `getError()`

| Método                | Argumentos  | Descripción                                | Retorno                                   |
|-----------------------|-------------|--------------------------------------------|-------------------------------------------|
| `getError`            | Ninguno     | Devuelve el último mensaje de error registrado después de una validación fallida. | Mensaje de error o cadena vacía si no hay errores. |


## Testing

Al clonar el repositorio en tu máquina local puedes ejecutar el siguiente comando para ejecutar las pruebas.

```bash
composer test
```

**TIP:** Si deseas conocer mejor el funcionamiento de cada método es recomendable revisar los distintos ejemplos disponibles en `tests/EcValidatorTest.php`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Créditos

- [insoutt](https://github.com/insoutt)
- [All Contributors](../../contributors)

## Contacto
- 𝕏 (Twitter): [@insoutt](http://x.com/insoutt)

## Support us


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
