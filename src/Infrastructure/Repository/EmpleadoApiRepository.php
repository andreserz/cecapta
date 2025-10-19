<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Entity\Empleado;
use Cecapta\IntegraApi\Domain\Repository\EmpleadoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Empleados usando la API de IntegraApp
 */
final class EmpleadoApiRepository implements EmpleadoRepositoryInterface
{
    private const ENDPOINT_CONSULTAR_TABLA = 'Empleados/ConsultarTabla';

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
                "Error al consultar la tabla de empleados: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Mapea los datos raw de la API a entidades del dominio
     *
     * @param array $rawData Datos crudos de la API
     * @return array<Empleado> Array de entidades Empleado
     */
    private function mapToEntities(array $rawData): array
    {
        $empleados = [];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $empleados[] = Empleado::fromArray($item);
            } catch (\Exception $e) {
                error_log("Error al mapear empleado: {$e->getMessage()}");
            }
        }

        return $empleados;
    }
}
