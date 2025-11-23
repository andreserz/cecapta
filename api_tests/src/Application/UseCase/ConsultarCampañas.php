<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Application\DTO\CampañaDTO;
use Cecapta\IntegraApi\Domain\Repository\CampañaRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Consultar campañas desde la API
 * 
 * Este caso de uso encapsula la lógica de negocio para consultar
 * las campañas de una empresa desde la API de IntegraApp
 */
final readonly class ConsultarCampañas
{
    public function __construct(
        private CampañaRepositoryInterface $campañaRepository
    ) {
    }

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<CampañaDTO> Array de DTOs de campañas
     * @throws \Exception Si hay error en la consulta
     */
    public function execute(string $tokenValue, int $empresaId): array
    {
        // Crear el Value Object Token
        $token = new Token($tokenValue);

        // Obtener las entidades del repositorio
        $campañas = $this->campañaRepository->consultarTabla($token, $empresaId);

        // Convertir las entidades a DTOs
        return array_map(
            fn($campaña) => CampañaDTO::fromEntity($campaña),
            $campañas
        );
    }

    /**
     * Ejecuta el caso de uso y retorna solo las campañas activas
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<CampañaDTO> Array de DTOs de campañas activas
     * @throws \Exception Si hay error en la consulta
     */
    public function executeOnlyActivas(string $tokenValue, int $empresaId): array
    {
        $campañas = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $campañas,
            fn(CampañaDTO $campaña) => $campaña->isActiva
        );
    }

    /**
     * Ejecuta el caso de uso y retorna solo las campañas vigentes
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<CampañaDTO> Array de DTOs de campañas vigentes
     * @throws \Exception Si hay error en la consulta
     */
    public function executeOnlyVigentes(string $tokenValue, int $empresaId): array
    {
        $campañas = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $campañas,
            fn(CampañaDTO $campaña) => $campaña->isVigente
        );
    }

    /**
     * Busca campañas por nombre (búsqueda parcial)
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @param string $nombre Nombre o parte del nombre a buscar
     * @return array<CampañaDTO> Array de DTOs de campañas que coinciden
     * @throws \Exception Si hay error en la consulta
     */
    public function findByNombre(string $tokenValue, int $empresaId, string $nombre): array
    {
        $campañas = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $campañas,
            fn(CampañaDTO $campaña) => stripos($campaña->nombre, $nombre) !== false
        );
    }

    /**
     * Agrupa campañas por plataforma
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<string, array<CampañaDTO>> Array asociativo [plataforma => campañas]
     * @throws \Exception Si hay error en la consulta
     */
    public function groupByPlataforma(string $tokenValue, int $empresaId): array
    {
        $campañas = $this->execute($tokenValue, $empresaId);
        $grouped = [];

        foreach ($campañas as $campaña) {
            $plataforma = $campaña->plataforma;
            if (!isset($grouped[$plataforma])) {
                $grouped[$plataforma] = [];
            }
            $grouped[$plataforma][] = $campaña;
        }

        return $grouped;
    }
}
