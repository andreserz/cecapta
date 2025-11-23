<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Value Object: CURP
 * 
 * Representa una Clave Única de Registro de Población (CURP) de México
 * Formato: 18 caracteres alfanuméricos
 */
final readonly class CURP
{
    private string $value;

    public function __construct(string $value)
    {
        $value = strtoupper(trim($value));

        if (!$this->isValid($value)) {
            throw new InvalidArgumentException(
                "CURP inválido: '{$value}'. Debe tener 18 caracteres alfanuméricos"
            );
        }

        $this->value = $value;
    }

    private function isValid(string $curp): bool
    {
        // Validación básica: 18 caracteres alfanuméricos
        // Formato: AAAA######AAAAAA##
        return preg_match('/^[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9A-Z][0-9]$/', $curp) === 1;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(CURP $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
