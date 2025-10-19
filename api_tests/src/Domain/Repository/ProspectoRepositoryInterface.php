<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\Repository;

use Cecapta\IntegraApi\Domain\Entity\Prospecto;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;
use Cecapta\IntegraApi\Domain\ValueObject\CURP;

/**
 * Interfaz de repositorio para Prospectos
 * Define el contrato para operaciones de persistencia de prospectos
 */
interface ProspectoRepositoryInterface
{
    /**
     * Agrega un nuevo prospecto a la API
     *
     * @param Token $token Token de autenticación
     * @param CURP $curp CURP del prospecto
     * @param string $nombreCompleto Nombre completo del prospecto
     * @param string $telefonoLada Lada del teléfono (ej: 999)
     * @param string $telefono10Digitos Teléfono de 10 dígitos
     * @return ProspectoId ID del prospecto creado
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si ocurre un error
     */
    public function agregar(
        Token $token,
        CURP $curp,
        string $nombreCompleto,
        string $telefonoLada,
        string $telefono10Digitos
    ): ProspectoId;
}
