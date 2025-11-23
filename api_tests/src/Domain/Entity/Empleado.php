<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\EstatusEmpresa;

/**
 * Entidad que representa un Empleado en el dominio
 * 
 * Nota: Esta estructura está preparada para cuando la API devuelva datos.
 * Actualmente el endpoint retorna array vacío para la empresa de prueba.
 */
final readonly class Empleado
{
    public function __construct(
        private int $idBd,
        private string $nombre,
        private string $apellido,
        private string $email,
        private string $puesto,
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

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getNombreCompleto(): string
    {
        return trim($this->nombre . ' ' . $this->apellido);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPuesto(): string
    {
        return $this->puesto;
    }

    public function getEstatus(): EstatusEmpresa
    {
        return $this->estatus;
    }

    public function isActivo(): bool
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
            apellido: (string) ($data['Apellido'] ?? $data['apellido'] ?? ''),
            email: (string) ($data['Email'] ?? $data['email'] ?? ''),
            puesto: (string) ($data['Puesto'] ?? $data['puesto'] ?? ''),
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
            'apellido' => $this->apellido,
            'nombreCompleto' => $this->getNombreCompleto(),
            'email' => $this->email,
            'puesto' => $this->puesto,
            'estatus' => $this->estatus->value
        ];
    }
}
