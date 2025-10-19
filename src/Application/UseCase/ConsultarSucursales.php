<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Application\DTO\SucursalDTO;
use Cecapta\IntegraApi\Domain\Repository\SucursalRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Consultar sucursales desde la API
 * 
 * Este caso de uso encapsula la lógica de negocio para consultar
 * las sucursales de una empresa desde la API de IntegraApp
 */
final readonly class ConsultarSucursales
{
    public function __construct(
        private SucursalRepositoryInterface $sucursalRepository
    ) {
    }

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<SucursalDTO> Array de DTOs de sucursales
     * @throws \Exception Si hay error en la consulta
     */
    public function execute(string $tokenValue, int $empresaId): array
    {
        // Crear el Value Object Token
        $token = new Token($tokenValue);

        // Obtener las entidades del repositorio
        $sucursales = $this->sucursalRepository->consultarTabla($token, $empresaId);

        // Convertir las entidades a DTOs
        return array_map(
            fn($sucursal) => SucursalDTO::fromEntity($sucursal),
            $sucursales
        );
    }

    /**
     * Ejecuta el caso de uso y retorna solo las sucursales activas
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<SucursalDTO> Array de DTOs de sucursales activas
     * @throws \Exception Si hay error en la consulta
     */
    public function executeOnlyActivas(string $tokenValue, int $empresaId): array
    {
        $sucursales = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $sucursales,
            fn(SucursalDTO $sucursal) => $sucursal->isActiva
        );
    }

    /**
     * Busca una sucursal por su abreviatura de serie
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @param string $abreviaturaSerie Abreviatura de serie a buscar
     * @return SucursalDTO|null DTO de la sucursal o null si no se encuentra
     * @throws \Exception Si hay error en la consulta
     */
    public function findByAbreviatura(string $tokenValue, int $empresaId, string $abreviaturaSerie): ?SucursalDTO
    {
        $sucursales = $this->execute($tokenValue, $empresaId);

        foreach ($sucursales as $sucursal) {
            if (strcasecmp($sucursal->abreviaturaSerie, $abreviaturaSerie) === 0) {
                return $sucursal;
            }
        }

        return null;
    }
}
