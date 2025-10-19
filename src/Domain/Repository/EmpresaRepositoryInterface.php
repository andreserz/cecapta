<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Empresa;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Interfaz del repositorio de Empresas (Puerto en arquitectura hexagonal)
 * Define el contrato que debe implementar la infraestructura
 */
interface EmpresaRepositoryInterface
{
    /**
     * Consulta todas las empresas usando el token proporcionado
     *
     * @param Token $token Token de autenticación
     * @return array<Empresa> Array de entidades Empresa
     * @throws \Exception Si hay error en la consulta
     */
    public function consultarTabla(Token $token): array;
}
