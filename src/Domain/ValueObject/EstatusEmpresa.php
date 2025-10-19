<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

/**
 * Enum que representa los posibles estados de una empresa
 */
enum EstatusEmpresa: string
{
    case ACTIVO = 'ACTIVO';
    case INACTIVO = 'INACTIVO';
    case SUSPENDIDO = 'SUSPENDIDO';

    public static function fromString(string $status): self
    {
        return self::tryFrom($status) ?? self::ACTIVO;
    }

    public function isActivo(): bool
    {
        return $this === self::ACTIVO;
    }
}
