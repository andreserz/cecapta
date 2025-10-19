<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\OportunidadId;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use DateTimeImmutable;

/**
 * Entidad de dominio: Oportunidad
 * 
 * Representa una oportunidad de venta en el sistema IntegraApp
 */
final readonly class Oportunidad
{
    public function __construct(
        private OportunidadId $id,
        private int $empresaId,
        private int $sucursalId,
        private int $empleadoId,
        private int $campañaId,
        private ProspectoId $prospectoId,
        private bool $eventoProgramar,
        private ?string $eventoSigTipo,
        private ?DateTimeImmutable $eventoSigFechaHora,
        private ?string $notas,
        private int $etapaId,
        private ?DateTimeImmutable $fechaEstimadaCierre,
        private int $probabilidad
    ) {}

    public function getId(): OportunidadId
    {
        return $this->id;
    }

    public function getEmpresaId(): int
    {
        return $this->empresaId;
    }

    public function getSucursalId(): int
    {
        return $this->sucursalId;
    }

    public function getEmpleadoId(): int
    {
        return $this->empleadoId;
    }

    public function getCampañaId(): int
    {
        return $this->campañaId;
    }

    public function getProspectoId(): ProspectoId
    {
        return $this->prospectoId;
    }

    public function isEventoProgramado(): bool
    {
        return $this->eventoProgramar;
    }

    public function getEventoSigTipo(): ?string
    {
        return $this->eventoSigTipo;
    }

    public function getEventoSigFechaHora(): ?DateTimeImmutable
    {
        return $this->eventoSigFechaHora;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function getEtapaId(): int
    {
        return $this->etapaId;
    }

    public function getFechaEstimadaCierre(): ?DateTimeImmutable
    {
        return $this->fechaEstimadaCierre;
    }

    public function getProbabilidad(): int
    {
        return $this->probabilidad;
    }

    /**
     * Crea una instancia desde datos primitivos
     */
    public static function create(
        int $id,
        int $empresaId,
        int $sucursalId,
        int $empleadoId,
        int $campañaId,
        int $prospectoId,
        bool $eventoProgramar,
        ?string $eventoSigTipo,
        ?DateTimeImmutable $eventoSigFechaHora,
        ?string $notas,
        int $etapaId,
        ?DateTimeImmutable $fechaEstimadaCierre,
        int $probabilidad
    ): self {
        return new self(
            new OportunidadId($id),
            $empresaId,
            $sucursalId,
            $empleadoId,
            $campañaId,
            new ProspectoId($prospectoId),
            $eventoProgramar,
            $eventoSigTipo,
            $eventoSigFechaHora,
            $notas,
            $etapaId,
            $fechaEstimadaCierre,
            $probabilidad
        );
    }
}
