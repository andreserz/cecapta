<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Value Object: OportunidadId
 * 
 * Representa el identificador único de una oportunidad de venta
 */
final readonly class OportunidadId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException(
                'El ID de la oportunidad debe ser un entero positivo'
            );
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(OportunidadId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
