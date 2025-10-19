<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\DTO;

use Cecapta\IntegraApi\Domain\Entity\Empresa;

/**
 * Data Transfer Object para transferir datos de Empresa entre capas
 */
final readonly class EmpresaDTO
{
    public function __construct(
        public int $idBd,
        public string $nombre,
        public string $alias,
        public string $estatus,
        public bool $isActiva
    ) {
    }

    /**
     * Crea un DTO desde una entidad del dominio
     */
    public static function fromEntity(Empresa $empresa): self
    {
        return new self(
            idBd: $empresa->getIdBd(),
            nombre: $empresa->getNombre(),
            alias: $empresa->getAlias(),
            estatus: $empresa->getEstatus()->value,
            isActiva: $empresa->isActiva()
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
            'alias' => $this->alias,
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
