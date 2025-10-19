<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Domain\Repository\ProspectoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;
use Cecapta\IntegraApi\Domain\ValueObject\CURP;
use Cecapta\IntegraApi\Domain\ValueObject\ProspectoId;

/**
 * Caso de uso: Registrar nuevo Prospecto
 * 
 * Registra un nuevo prospecto (cliente potencial) en el sistema IntegraApp
 */
final readonly class RegistrarProspecto
{
    public function __construct(
        private ProspectoRepositoryInterface $prospectoRepository
    ) {}

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Token de autenticación
     * @param string $curp CURP del prospecto
     * @param string $nombreCompleto Nombre completo del prospecto
     * @param string $telefonoLada Lada del teléfono (ej: 999)
     * @param string $telefono10Digitos Teléfono de 10 dígitos
     * @return int ID del prospecto creado
     * @throws \InvalidArgumentException Si los datos son inválidos
     * @throws \Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException Si hay error en la API
     */
    public function execute(
        string $tokenValue,
        string $curp,
        string $nombreCompleto,
        string $telefonoLada,
        string $telefono10Digitos
    ): int {
        // Validar datos de entrada
        $this->validarDatos($nombreCompleto, $telefonoLada, $telefono10Digitos);

        // Crear value objects
        $token = new Token($tokenValue);
        $curpVO = new CURP($curp);

        // Agregar prospecto
        $prospectoId = $this->prospectoRepository->agregar(
            $token,
            $curpVO,
            $nombreCompleto,
            $telefonoLada,
            $telefono10Digitos
        );

        return $prospectoId->getValue();
    }

    private function validarDatos(
        string $nombreCompleto,
        string $telefonoLada,
        string $telefono10Digitos
    ): void {
        if (empty(trim($nombreCompleto))) {
            throw new \InvalidArgumentException(
                'El nombre completo no puede estar vacío'
            );
        }

        if (!preg_match('/^\d{2,4}$/', $telefonoLada)) {
            throw new \InvalidArgumentException(
                "Lada telefónica inválida: '{$telefonoLada}'. Debe ser de 2 a 4 dígitos"
            );
        }

        if (!preg_match('/^\d{10}$/', $telefono10Digitos)) {
            throw new \InvalidArgumentException(
                "Teléfono inválido: '{$telefono10Digitos}'. Debe ser de 10 dígitos"
            );
        }
    }
}
