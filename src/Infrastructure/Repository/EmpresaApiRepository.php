<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Entity\Empresa;
use Cecapta\IntegraApi\Domain\Repository\EmpresaRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Empresas usando la API de IntegraApp
 * 
 * Esta es la implementación concreta del puerto definido en el dominio.
 * Adapta las respuestas de la API a entidades del dominio.
 */
final class EmpresaApiRepository implements EmpresaRepositoryInterface
{
    private const ENDPOINT_CONSULTAR_TABLA = 'Empresas/ConsultarTabla';

    public function __construct(
        private readonly IntegraApiClient $apiClient
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function consultarTabla(Token $token): array
    {
        try {
            $endpoint = self::ENDPOINT_CONSULTAR_TABLA . '/' . $token->getValue();
            
            $rawData = $this->apiClient->get($endpoint);

            // Convertir los datos raw a entidades del dominio
            return $this->mapToEntities($rawData);

        } catch (\Exception $e) {
            throw new RepositoryException(
                "Error al consultar la tabla de empresas: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * Mapea los datos raw de la API a entidades del dominio
     *
     * @param array $rawData Datos crudos de la API
     * @return array<Empresa> Array de entidades Empresa
     */
    private function mapToEntities(array $rawData): array
    {
        $empresas = [];

        foreach ($rawData as $item) {
            if (!is_array($item)) {
                continue;
            }

            try {
                $empresas[] = Empresa::fromArray($item);
            } catch (\Exception $e) {
                // Log del error pero continuar con los demás registros
                // En un entorno productivo, aquí se registraría en un logger
                error_log("Error al mapear empresa: {$e->getMessage()}");
            }
        }

        return $empresas;
    }
}
