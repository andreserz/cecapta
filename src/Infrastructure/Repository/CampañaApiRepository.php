<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Entity\Campaña;
use Cecapta\IntegraApi\Domain\Repository\CampañaRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Campañas usando la API de IntegraApp
 * 
 * Esta es la implementación concreta del puerto definido en el dominio.
 * Adapta las respuestas de la API a entidades del dominio.
 */
final class CampañaApiRepository implements CampañaRepositoryInterface
{
    private const ENDPOINT_CONSULTAR_TABLA = 'Campañas/ConsultarTabla';

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
                "Error al consultar la tabla de campañas: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Mapea los datos raw de la API a entidades del dominio
     *
     * @param array $rawData Datos crudos de la API
     * @return array<Campaña> Array de entidades Campaña
     */
    private function mapToEntities(array $rawData): array
    {
        $campañas = [];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $campañas[] = Campaña::fromArray($item);
            } catch (\Exception $e) {
                // Log del error pero continuar con los demás registros
                error_log("Error al mapear campaña: {$e->getMessage()}");
            }
        }

        return $campañas;
    }
}
