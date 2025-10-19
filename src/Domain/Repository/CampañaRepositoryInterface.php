<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Campaña;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Interfaz del repositorio de Campañas (Puerto en arquitectura hexagonal)
 * Define el contrato que debe implementar la infraestructura
 */
interface CampañaRepositoryInterface
{
    /**
     * Consulta todas las campañas de una empresa usando el token proporcionado
     *
     * @param Token $token Token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<Campaña> Array de entidades Campaña
     * @throws \Exception Si hay error en la consulta
     */
    public function consultarTabla(Token $token, int $empresaId): array;
}
