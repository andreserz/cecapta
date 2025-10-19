<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Repository\ProspectoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use Cecapta\IntegraApi\Domain\ValueObject\CURP;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;

/**
 * Implementación del repositorio de Prospectos usando la API de IntegraApp
 */
final readonly class ProspectoApiRepository implements ProspectoRepositoryInterface
{
    public function __construct(
        private IntegraApiClient $apiClient
    ) {}

    /**
     * {@inheritDoc}
     */
    public function agregar(
        Token $token,
        CURP $curp,
        string $nombreCompleto,
        string $telefonoLada,
        string $telefono10Digitos
    ): ProspectoId {
        try {
            // Construir endpoint
            $endpoint = sprintf(
                '/Prospectos/Agregar/%s/%s/%s/%s/%s',
                $token->getValue(),
                $curp->getValue(),
                urlencode($nombreCompleto),
                $telefonoLada,
                $telefono10Digitos
            );

            // Realizar petición
            $response = $this->apiClient->getString($endpoint);

            // Validar respuesta
            if (str_starts_with($response, '-1')) {
                throw new RepositoryException(
                    "Error al agregar prospecto: {$response}"
                );
            }

            // Convertir respuesta a ID
            $prospectoId = (int) $response;

            if ($prospectoId <= 0) {
                throw new RepositoryException(
                    "Respuesta inválida de la API: '{$response}'"
                );
            }

            return new ProspectoId($prospectoId);

        } catch (\Exception $e) {
            if ($e instanceof RepositoryException) {
                throw $e;
            }

            throw new RepositoryException(
                "Error al agregar prospecto: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}
