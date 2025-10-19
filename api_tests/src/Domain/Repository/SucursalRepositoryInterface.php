<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Sucursal;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Interfaz del repositorio de Sucursales (Puerto en arquitectura hexagonal)
 * Define el contrato que debe implementar la infraestructura
 */
interface SucursalRepositoryInterface
{
    /**
     * Consulta todas las sucursales de una empresa usando el token proporcionado
     *
     * @param Token $token Token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<Sucursal> Array de entidades Sucursal
     * @throws \Exception Si hay error en la consulta
     */
    public function consultarTabla(Token $token, int $empresaId): array;
}
