<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Producto;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Interfaz del repositorio de Productos
 */
interface ProductoRepositoryInterface
{
    /**
     * Consulta todos los productos de una empresa
     *
     * @param Token $token Token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<Producto> Array de entidades Producto
     * @throws \Exception Si hay error en la consulta
     */
    public function consultarTabla(Token $token, int $empresaId): array;
}
