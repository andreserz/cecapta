<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Infrastructure\Repository;

use Cecapta\IntegraApi\Domain\Repository\OportunidadRepositoryInterface;
use Cecapta\IntegraApi\Domain\Entity\OportunidadProducto;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\OportunidadId;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException;
use DateTimeImmutable;

/**
 * Implementación del repositorio de Oportunidades usando la API de IntegraApp
 */
final readonly class OportunidadApiRepository implements OportunidadRepositoryInterface
{
    public function __construct(
        private IntegraApiClient $apiClient
    ) {}

    /**
     * {@inheritDoc}
     */
    public function agregarCabecero(
        Token $token,
        int $empresaId,
        int $sucursalId,
        int $empleadoId,
        int $campañaId,
        ProspectoId $prospectoId,
        bool $eventoProgramar,
        ?string $eventoSigTipo,
        ?DateTimeImmutable $eventoSigFechaHora,
        ?string $notas,
        int $etapaId,
        ?DateTimeImmutable $fechaEstimadaCierre,
        int $probabilidad
    ): OportunidadId {
        try {
            // Formatear parámetros opcionales
            $eventoSigTipoStr = $eventoSigTipo ?? '';
            $eventoSigFechaHoraStr = $eventoSigFechaHora 
                ? $eventoSigFechaHora->format('Y-m-d H:i:s') 
                : '';
            $notasStr = $notas ?? '';
            $fechaEstimadaCierreStr = $fechaEstimadaCierre 
                ? $fechaEstimadaCierre->format('Y-m-d') 
                : '';

            // Construir endpoint
            $endpoint = sprintf(
                '/Oportunidades/AgregarCabecero/%s/%d/%d/%d/%d/%d/%s/%s/%s/%s/%d/%s/%d',
                $token->getValue(),
                $empresaId,
                $sucursalId,
                $empleadoId,
                $campañaId,
                $prospectoId->getValue(),
                $eventoProgramar ? 'true' : 'false',
                urlencode($eventoSigTipoStr),
                urlencode($eventoSigFechaHoraStr),
                urlencode($notasStr),
                $etapaId,
                urlencode($fechaEstimadaCierreStr),
                $probabilidad
            );

            // Realizar petición
            $response = $this->apiClient->getString($endpoint);

            // Validar respuesta
            if (str_starts_with($response, '-1')) {
                throw new RepositoryException(
                    "Error al agregar oportunidad: {$response}"
                );
            }

            // Convertir respuesta a ID
            $oportunidadId = (int) $response;

            if ($oportunidadId <= 0) {
                throw new RepositoryException(
                    "Respuesta inválida de la API: '{$response}'"
                );
            }

            return new OportunidadId($oportunidadId);

        } catch (\Exception $e) {
            if ($e instanceof RepositoryException) {
                throw $e;
            }

            throw new RepositoryException(
                "Error al agregar cabecero de oportunidad: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function agregarProducto(
        Token $token,
        OportunidadProducto $producto
    ): bool {
        try {
            // Formatear notas opcionales
            $notasStr = $producto->getNotas() ?? '';

            // Construir endpoint
            $endpoint = sprintf(
                '/Oportunidades/AgregarProducto/%s/%d/%d/%d/%d/%d/%s/%s',
                $token->getValue(),
                $producto->getOportunidadId()->getValue(),
                $producto->getProductoId(),
                $producto->getCantidad(),
                $producto->getEsquemaImpuestosId(),
                $producto->getPrecioId(),
                number_format($producto->getPrecioValor(), 2, '.', ''),
                urlencode($notasStr)
            );

            // Realizar petición
            $response = $this->apiClient->getString($endpoint);

            // Validar respuesta
            if (str_starts_with($response, '-1')) {
                throw new RepositoryException(
                    "Error al agregar producto: {$response}"
                );
            }

            // La respuesta debe ser "1" para indicar éxito
            return trim($response) === '1';

        } catch (\Exception $e) {
            if ($e instanceof RepositoryException) {
                throw $e;
            }

            throw new RepositoryException(
                "Error al agregar producto a oportunidad: {$e->getMessage()}",
                $e->getCode(),
                $e
            );
        }
    }
}
