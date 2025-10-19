<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\DTO;

use Cecapta\IntegraApi\Domain\Entity\Empleado;

/**
 * Data Transfer Object para transferir datos de Empleado entre capas
 */
final readonly class EmpleadoDTO
{
    public function __construct(
        public int $idBd,
        public string $nombre,
        public string $apellido,
        public string $nombreCompleto,
        public string $email,
        public string $puesto,
        public string $estatus,
        public bool $isActivo
    ) {
    }

    /**
     * Crea un DTO desde una entidad del dominio
     */
    public static function fromEntity(Empleado $empleado): self
    {
        return new self(
            idBd: $empleado->getIdBd(),
            nombre: $empleado->getNombre(),
            apellido: $empleado->getApellido(),
            nombreCompleto: $empleado->getNombreCompleto(),
            email: $empleado->getEmail(),
            puesto: $empleado->getPuesto(),
            estatus: $empleado->getEstatus()->value,
            isActivo: $empleado->isActivo()
        );
    }

    public function toArray(): array
    {
        return [
            'idBd' => $this->idBd,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'nombreCompleto' => $this->nombreCompleto,
            'email' => $this->email,
            'puesto' => $this->puesto,
            'estatus' => $this->estatus,
            'isActivo' => $this->isActivo
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
