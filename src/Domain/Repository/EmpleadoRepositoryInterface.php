<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Empleado;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Interfaz del repositorio de Empleados (Puerto en arquitectura hexagonal)
 */
interface EmpleadoRepositoryInterface
{
    /**
     * Consulta todos los empleados de una empresa
     *
     * @param Token $token Token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<Empleado> Array de entidades Empleado
     * @throws \Exception Si hay error en la consulta
     */
    public function consultarTabla(Token $token, int $empresaId): array;
}
