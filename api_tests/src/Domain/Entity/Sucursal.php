<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\EstatusEmpresa;

/**
 * Entidad que representa una Sucursal en el dominio
 */
final readonly class Sucursal
{
    public function __construct(
        private int $idBd,
        private string $abreviaturaSerie,
        private EstatusEmpresa $estatus
    ) {
    }

    public function getIdBd(): int
    {
        return $this->idBd;
    }

    public function getAbreviaturaSerie(): string
    {
        return $this->abreviaturaSerie;
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
     * Crea una instancia desde un array de datos
     */
    public static function fromArray(array $data): self
    {
        return new self(
            idBd: (int) ($data['IdBD'] ?? $data['idBd'] ?? 0),
            abreviaturaSerie: (string) ($data['AbreviaturaSerie'] ?? $data['abreviaturaSerie'] ?? ''),
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
            'abreviaturaSerie' => $this->abreviaturaSerie,
            'estatus' => $this->estatus->value
        ];
    }
}
