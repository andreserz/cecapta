<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Entity\Sucursal;
use Cecapta\IntegraApi\Domain\Repository\SucursalRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Sucursales usando la API de IntegraApp
 * 
 * Esta es la implementación concreta del puerto definido en el dominio.
 * Adapta las respuestas de la API a entidades del dominio.
 */
final class SucursalApiRepository implements SucursalRepositoryInterface
{
    private const ENDPOINT_CONSULTAR_TABLA = 'Sucursales/ConsultarTabla';

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

            // Convertir los datos raw a entidades del dominio
            return $this->mapToEntities($rawData);

        } catch (\Exception $e) {
            throw new RepositoryException(
                "Error al consultar la tabla de sucursales: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Mapea los datos raw de la API a entidades del dominio
     *
     * @param array $rawData Datos crudos de la API
     * @return array<Sucursal> Array de entidades Sucursal
     */
    private function mapToEntities(array $rawData): array
    {
        $sucursales = [];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $sucursales[] = Sucursal::fromArray($item);
            } catch (\Exception $e) {
                // Log del error pero continuar con los demás registros
                error_log("Error al mapear sucursal: {$e->getMessage()}");
            }
        }

        return $sucursales;
    }
}
