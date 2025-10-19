<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Domain\Repository\OportunidadRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use DateTimeImmutable;

/**
 * Caso de uso: Crear nueva Oportunidad de Venta
 * 
 * Crea una nueva oportunidad de venta asociada a un prospecto
 */
final readonly class CrearOportunidad
{
    public function __construct(
        private OportunidadRepositoryInterface $oportunidadRepository
    ) {}

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Token de autenticación
     * @param int $empresaId ID de la empresa
     * @param int $sucursalId ID de la sucursal
     * @param int $empleadoId ID del empleado responsable
     * @param int $campañaId ID de la campaña
     * @param int $prospectoId ID del prospecto
     * @param bool $eventoProgramar Si se debe programar un evento de seguimiento
     * @param string|null $eventoSigTipo Tipo de evento siguiente
     * @param string|null $eventoSigFechaHora Fecha y hora del siguiente evento (formato: Y-m-d H:i:s)
     * @param string|null $notas Notas adicionales
     * @param int $etapaId ID de la etapa en el embudo de ventas
     * @param string|null $fechaEstimadaCierre Fecha estimada de cierre (formato: Y-m-d)
     * @param int $probabilidad Probabilidad de cierre (0-100)
     * @return int ID de la oportunidad creada
     * @throws \InvalidArgumentException Si los datos son inválidos
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si hay error en la API
     */
    public function execute(
        string $tokenValue,
        int $empresaId,
        int $sucursalId,
        int $empleadoId,
        int $campañaId,
        int $prospectoId,
        bool $eventoProgramar = false,
        ?string $eventoSigTipo = null,
        ?string $eventoSigFechaHora = null,
        ?string $notas = null,
        int $etapaId = 1,
        ?string $fechaEstimadaCierre = null,
        int $probabilidad = 50
    ): int {
        // Validar datos
        $this->validarDatos($empresaId, $sucursalId, $empleadoId, $campañaId, $prospectoId, $etapaId, $probabilidad);

        // Crear value objects
        $token = new Token($tokenValue);
        $prospectoIdVO = new ProspectoId($prospectoId);

        // Parsear fechas opcionales
        $eventoSigFechaHoraVO = $eventoSigFechaHora 
            ? new DateTimeImmutable($eventoSigFechaHora)
            : null;

        $fechaEstimadaCierreVO = $fechaEstimadaCierre 
            ? new DateTimeImmutable($fechaEstimadaCierre)
            : null;

        // Agregar oportunidad
        $oportunidadId = $this->oportunidadRepository->agregarCabecero(
            $token,
            $empresaId,
            $sucursalId,
            $empleadoId,
            $campañaId,
            $prospectoIdVO,
            $eventoProgramar,
            $eventoSigTipo,
            $eventoSigFechaHoraVO,
            $notas,
            $etapaId,
            $fechaEstimadaCierreVO,
            $probabilidad
        );

        return $oportunidadId->getValue();
    }

    private function validarDatos(
        int $empresaId,
        int $sucursalId,
        int $empleadoId,
        int $campañaId,
        int $prospectoId,
        int $etapaId,
        int $probabilidad
    ): void {
        if ($empresaId <= 0) {
            throw new \InvalidArgumentException('El ID de la empresa debe ser positivo');
        }

        if ($sucursalId <= 0) {
            throw new \InvalidArgumentException('El ID de la sucursal debe ser positivo');
        }

        if ($empleadoId <= 0) {
            throw new \InvalidArgumentException('El ID del empleado debe ser positivo');
        }

        if ($campañaId <= 0) {
            throw new \InvalidArgumentException('El ID de la campaña debe ser positivo');
        }

        if ($prospectoId <= 0) {
            throw new \InvalidArgumentException('El ID del prospecto debe ser positivo');
        }

        if ($etapaId <= 0) {
            throw new \InvalidArgumentException('El ID de la etapa debe ser positivo');
        }

        if ($probabilidad < 0 || $probabilidad > 100) {
            throw new \InvalidArgumentException('La probabilidad debe estar entre 0 y 100');
        }
    }
}
