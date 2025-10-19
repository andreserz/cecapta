<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\DTO;

use Cecapta\IntegraApi\Domain\Entity\Sucursal;

/**
 * Data Transfer Object para transferir datos de Sucursal entre capas
 */
final readonly class SucursalDTO
{
    public function __construct(
        public int $idBd,
        public string $abreviaturaSerie,
        public string $estatus,
        public bool $isActiva
    ) {
    }

    /**
     * Crea un DTO desde una entidad del dominio
     */
    public static function fromEntity(Sucursal $sucursal): self
    {
        return new self(
            idBd: $sucursal->getIdBd(),
            abreviaturaSerie: $sucursal->getAbreviaturaSerie(),
            estatus: $sucursal->getEstatus()->value,
            isActiva: $sucursal->isActiva()
        );
    }

    /**
     * Convierte el DTO a array para serialización
     */
    public function toArray(): array
    {
        return [
            'idBd' => $this->idBd,
            'abreviaturaSerie' => $this->abreviaturaSerie,
            'estatus' => $this->estatus,
            'isActiva' => $this->isActiva
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
