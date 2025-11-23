<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Value Object: ProspectoId
 * 
 * Representa el identificador único de un prospecto
 */
final readonly class ProspectoId
{
    private int $value;

    public function __construct(int $value)
    {
        if ($value <= 0) {
            throw new InvalidArgumentException(
                'El ID del prospecto debe ser un entero positivo'
            );
        }

        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(ProspectoId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
