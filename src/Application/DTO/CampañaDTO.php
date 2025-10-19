<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\DTO;

use Cecapta\IntegraApi\Domain\Entity\Campaña;

/**
 * Data Transfer Object para transferir datos de Campaña entre capas
 */
final readonly class CampañaDTO
{
    public function __construct(
        public int $idBd,
        public string $nombre,
        public string $plataforma,
        public string $fechaInicio,
        public string $fechaFin,
        public ?string $notas,
        public string $estatus,
        public bool $isActiva,
        public bool $isVigente,
        public int $duracionDias
    ) {
    }

    /**
     * Crea un DTO desde una entidad del dominio
     */
    public static function fromEntity(Campaña $campaña): self
    {
        return new self(
            idBd: $campaña->getIdBd(),
            nombre: $campaña->getNombre(),
            plataforma: $campaña->getPlataforma()->value,
            fechaInicio: $campaña->getFechaInicio()->format('Y-m-d H:i:s'),
            fechaFin: $campaña->getFechaFin()->format('Y-m-d H:i:s'),
            notas: $campaña->getNotas(),
            estatus: $campaña->getEstatus()->value,
            isActiva: $campaña->isActiva(),
            isVigente: $campaña->isVigente(),
            duracionDias: $campaña->getDuracionDias()
        );
    }

    /**
     * Convierte el DTO a array para serialización
     */
    public function toArray(): array
    {
        return [
            'idBd' => $this->idBd,
            'nombre' => $this->nombre,
            'plataforma' => $this->plataforma,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'notas' => $this->notas,
            'estatus' => $this->estatus,
            'isActiva' => $this->isActiva,
            'isVigente' => $this->isVigente,
            'duracionDias' => $this->duracionDias
        ];
    }

    /**
     * Convierte a JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
