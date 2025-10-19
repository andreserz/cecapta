<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

use InvalidArgumentException;

/**
 * Value Object que representa un token de autenticación
 */
final readonly class Token
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('El token no puede estar vacío');
        }

        $this->value = trim($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Token $other): bool
    {
        return $this->value === $other->value;
    }
}
