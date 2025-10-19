<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Entity;

use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use Cecapta\IntegraApi\Domain\ValueObject\CURP;

/**
 * Entidad de dominio: Prospecto
 * 
 * Representa un prospecto (cliente potencial) en el sistema IntegraApp
 */
final readonly class Prospecto
{
    public function __construct(
        private ProspectoId $id,
        private CURP $curp,
        private string $nombreCompleto,
        private string $telefonoLada,
        private string $telefono10Digitos
    ) {}

    public function getId(): ProspectoId
    {
        return $this->id;
    }

    public function getCurp(): CURP
    {
        return $this->curp;
    }

    public function getNombreCompleto(): string
    {
        return $this->nombreCompleto;
    }

    public function getTelefonoLada(): string
    {
        return $this->telefonoLada;
    }

    public function getTelefono10Digitos(): string
    {
        return $this->telefono10Digitos;
    }

    public function getTelefonoCompleto(): string
    {
        return "+{$this->telefonoLada} {$this->telefono10Digitos}";
    }

    /**
     * Crea una instancia desde datos primitivos
     */
    public static function create(
        int $id,
        string $curp,
        string $nombreCompleto,
        string $telefonoLada,
        string $telefono10Digitos
    ): self {
        return new self(
            new ProspectoId($id),
            new CURP($curp),
            $nombreCompleto,
            $telefonoLada,
            $telefono10Digitos
        );
    }
}
