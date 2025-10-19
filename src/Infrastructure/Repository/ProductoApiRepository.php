<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Entity\Producto;
use Cecapta\IntegraApi\Domain\Repository\ProductoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Productos usando la API de IntegraApp
 */
final class ProductoApiRepository implements ProductoRepositoryInterface
{
    private const ENDPOINT_CONSULTAR_TABLA = 'Productos/ConsultarTabla';

    public function __construct(
        private readonly IntegraApiClient $apiClient
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function consultarTabla(Token $token, int $empresaId): array
    {
        try {
            $endpoint = self::ENDPOINT_CONSULTAR_TABLA . '/' . $token->getValue() . '/' . $empresaId;
            
            $rawData = $this->apiClient->get($endpoint);

            return $this->mapToEntities($rawData);

        } catch (\Exception $e) {
            throw new RepositoryException(
                "Error al consultar la tabla de productos: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Mapea los datos raw de la API a entidades del dominio
     *
     * @param array $rawData Datos crudos de la API
     * @return array<Producto> Array de entidades Producto
     */
    private function mapToEntities(array $rawData): array
    {
        $productos = [];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $productos[] = Producto::fromArray($item);
            } catch (\Exception $e) {
                error_log("Error al mapear producto: {$e->getMessage()}");
            }
        }

        return $productos;
    }
}
