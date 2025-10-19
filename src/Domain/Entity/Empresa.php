<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\EstatusEmpresa;

/**
 * Entidad que representa una Empresa en el dominio
 */
final readonly class Empresa
{
    public function __construct(
        private int $idBd,
        private string $nombre,
        private string $alias,
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

    public function getAlias(): string
    {
        return $this->alias;
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
            nombre: (string) ($data['Nombre'] ?? $data['nombre'] ?? ''),
            alias: (string) ($data['Alias'] ?? $data['alias'] ?? ''),
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
            'alias' => $this->alias,
            'estatus' => $this->estatus->value
        ];
    }
}
