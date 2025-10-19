<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\EstatusEmpresa;
use Cecapta\IntegraApi\Domain\ValueObject\Plataforma;
use DateTime;
use DateTimeInterface;

/**
 * Entidad que representa una Campaña en el dominio
 */
final readonly class Campaña
{
    public function __construct(
        private int $idBd,
        private string $nombre,
        private Plataforma $plataforma,
        private DateTimeInterface $fechaInicio,
        private DateTimeInterface $fechaFin,
        private ?string $notas,
        private EstatusEmpresa $estatus
    ) {
    }

    public function getIdBd(): int
    {
        return $this->idBd;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPlataforma(): Plataforma
    {
        return $this->plataforma;
    }

    public function getFechaInicio(): DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function getFechaFin(): DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function getNotas(): ?string
    {
        return $this->notas;
    }

    public function getEstatus(): EstatusEmpresa
    {
        return $this->estatus;
    }

    public function isActiva(): bool
    {
        return $this->estatus->isActivo();
    }

    /**
     * Verifica si la campaña está vigente (dentro del rango de fechas)
     */
    public function isVigente(?DateTimeInterface $fecha = null): bool
    {
        $fecha = $fecha ?? new DateTime();
        return $fecha >= $this->fechaInicio && $fecha <= $this->fechaFin;
    }

    /**
     * Obtiene la duración de la campaña en días
     */
    public function getDuracionDias(): int
    {
        $diff = $this->fechaInicio->diff($this->fechaFin);
        return (int) $diff->days;
    }

    /**
     * Crea una instancia desde un array de datos
     */
    public static function fromArray(array $data): self
    {
        // Parsear fechas en formato ISO 8601
        $fechaInicio = new DateTime($data['FechaInicio'] ?? $data['fechaInicio'] ?? 'now');
        $fechaFin = new DateTime($data['FechaFin'] ?? $data['fechaFin'] ?? 'now');

        return new self(
            idBd: (int) ($data['IdBD'] ?? $data['idBd'] ?? 0),
            nombre: (string) ($data['Nombre'] ?? $data['nombre'] ?? ''),
            plataforma: Plataforma::fromString((string) ($data['Plataforma'] ?? $data['plataforma'] ?? 'OTRO')),
            fechaInicio: $fechaInicio,
            fechaFin: $fechaFin,
            notas: $data['Notas'] ?? $data['notas'] ?? null,
            estatus: EstatusEmpresa::fromString((string) ($data['Estatus'] ?? $data['estatus'] ?? 'ACTIVO'))
        );
    }

    /**
     * Convierte la entidad a array
     */
    public function toArray(): array
    {
        return [
            'idBd' => $this->idBd,
            'nombre' => $this->nombre,
            'plataforma' => $this->plataforma->value,
            'fechaInicio' => $this->fechaInicio->format('Y-m-d H:i:s'),
            'fechaFin' => $this->fechaFin->format('Y-m-d H:i:s'),
            'notas' => $this->notas,
            'estatus' => $this->estatus->value
        ];
    }
}
