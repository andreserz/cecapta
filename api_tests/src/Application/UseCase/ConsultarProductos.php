<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Application\DTO\ProductoDTO;
use Cecapta\IntegraApi\Domain\Repository\ProductoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Consultar productos desde la API
 */
final readonly class ConsultarProductos
{
    public function __construct(
        private ProductoRepositoryInterface $productoRepository
    ) {
    }

    /**
     * Ejecuta el caso de uso
     */
    public function execute(string $tokenValue, int $empresaId): array
    {
        $token = new Token($tokenValue);
        $productos = $this->productoRepository->consultarTabla($token, $empresaId);

        return array_map(
            fn($producto) => ProductoDTO::fromEntity($producto),
            $productos
        );
    }

    /**
     * Retorna solo productos activos
     */
    public function executeOnlyActivos(string $tokenValue, int $empresaId): array
    {
        $productos = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $productos,
            fn(ProductoDTO $producto) => $producto->isActivo
        );
    }

    /**
     * Filtra productos por rango de precio
     */
    public function filterByPrecioRange(string $tokenValue, int $empresaId, float $min, float $max): array
    {
        $productos = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $productos,
            fn(ProductoDTO $producto) => $producto->precioValor >= $min && $producto->precioValor <= $max
        );
    }

    /**
     * Agrupa productos por lista de precios
     */
    public function groupByListaPrecios(string $tokenValue, int $empresaId): array
    {
        $productos = $this->execute($tokenValue, $empresaId);
        $grouped = [];

        foreach ($productos as $producto) {
            $listaId = $producto->listaPreciosId;
            $listaNombre = $producto->precio;
            
            if (!isset($grouped[$listaNombre])) {
                $grouped[$listaNombre] = [];
            }
            $grouped[$listaNombre][] = $producto;
        }

        return $grouped;
    }

    /**
     * Busca productos por nombre (búsqueda parcial)
     */
    public function findByNombre(string $tokenValue, int $empresaId, string $nombre): array
    {
        $productos = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $productos,
            fn(ProductoDTO $producto) => stripos($producto->nombre, $nombre) !== false
        );
    }
}
