<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Application\DTO\EmpresaDTO;
use Cecapta\IntegraApi\Domain\Repository\EmpresaRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Consultar empresas desde la API
 * 
 * Este caso de uso encapsula la lógica de negocio para consultar
 * la tabla de empresas desde la API de IntegraApp
 */
final readonly class ConsultarEmpresas
{
    public function __construct(
        private EmpresaRepositoryInterface $empresaRepository
    ) {
    }

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Valor del token de autenticación
     * @return array<EmpresaDTO> Array de DTOs de empresas
     * @throws \Exception Si hay error en la consulta
     */
    public function execute(string $tokenValue): array
    {
        // Crear el Value Object Token
        $token = new Token($tokenValue);

        // Obtener las entidades del repositorio
        $empresas = $this->empresaRepository->consultarTabla($token);

        // Convertir las entidades a DTOs
        return array_map(
            fn($empresa) => EmpresaDTO::fromEntity($empresa),
            $empresas
        );
    }

    /**
     * Ejecuta el caso de uso y retorna solo las empresas activas
     *
     * @param string $tokenValue Valor del token de autenticación
     * @return array<EmpresaDTO> Array de DTOs de empresas activas
     * @throws \Exception Si hay error en la consulta
     */
    public function executeOnlyActivas(string $tokenValue): array
    {
        $empresas = $this->execute($tokenValue);

        return array_filter(
            $empresas,
            fn(EmpresaDTO $empresa) => $empresa->isActiva
        );
    }

    /**
     * Busca una empresa por su alias
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param string $alias Alias de la empresa a buscar
     * @return EmpresaDTO|null DTO de la empresa o null si no se encuentra
     * @throws \Exception Si hay error en la consulta
     */
    public function findByAlias(string $tokenValue, string $alias): ?EmpresaDTO
    {
        $empresas = $this->execute($tokenValue);

        foreach ($empresas as $empresa) {
            if (strcasecmp($empresa->alias, $alias) === 0) {
                return $empresa;
            }
        }

        return null;
    }
}
