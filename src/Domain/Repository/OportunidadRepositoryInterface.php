<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\OportunidadProducto;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\OportunidadId;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use DateTimeImmutable;

/**
 * Interfaz de repositorio para Oportunidades
 * Define el contrato para operaciones de persistencia de oportunidades
 */
interface OportunidadRepositoryInterface
{
    /**
     * Agrega un nuevo cabecero de oportunidad a la API
     *
     * @param Token $token Token de autenticación
     * @param int $empresaId ID de la empresa
     * @param int $sucursalId ID de la sucursal
     * @param int $empleadoId ID del empleado responsable
     * @param int $campañaId ID de la campaña
     * @param ProspectoId $prospectoId ID del prospecto
     * @param bool $eventoProgramar Si se debe programar un evento de seguimiento
     * @param string|null $eventoSigTipo Tipo de evento siguiente (ej: "LLAMADA", "VISITA")
     * @param DateTimeImmutable|null $eventoSigFechaHora Fecha y hora del siguiente evento
     * @param string|null $notas Notas adicionales
     * @param int $etapaId ID de la etapa en el embudo de ventas
     * @param DateTimeImmutable|null $fechaEstimadaCierre Fecha estimada de cierre
     * @param int $probabilidad Probabilidad de cierre (0-100)
     * @return OportunidadId ID de la oportunidad creada
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si ocurre un error
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
    ): OportunidadId;

    /**
     * Agrega un producto a una oportunidad existente
     *
     * @param Token $token Token de autenticación
     * @param OportunidadProducto $producto Datos del producto a agregar
     * @return bool True si se agregó correctamente
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si ocurre un error
     */
    public function agregarProducto(
        Token $token,
        OportunidadProducto $producto
    ): bool;
}
