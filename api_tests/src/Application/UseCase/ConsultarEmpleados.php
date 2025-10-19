<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Application\UseCase;

use Cecapta\IntegraApi\Application\DTO\EmpleadoDTO;
use Cecapta\IntegraApi\Domain\Repository\EmpleadoRepositoryInterface;
use Cecapta\IntegraApi\Domain\ValueObject\Token;

/**
 * Caso de uso: Consultar empleados desde la API
 */
final readonly class ConsultarEmpleados
{
    public function __construct(
        private EmpleadoRepositoryInterface $empleadoRepository
    ) {
    }

    /**
     * Ejecuta el caso de uso
     *
     * @param string $tokenValue Valor del token de autenticación
     * @param int $empresaId ID de la empresa
     * @return array<EmpleadoDTO> Array de DTOs de empleados
     * @throws \Exception Si hay error en la consulta
     */
    public function execute(string $tokenValue, int $empresaId): array
    {
        $token = new Token($tokenValue);
        $empleados = $this->empleadoRepository->consultarTabla($token, $empresaId);

        return array_map(
            fn($empleado) => EmpleadoDTO::fromEntity($empleado),
            $empleados
        );
    }

    /**
     * Retorna solo empleados activos
     */
    public function executeOnlyActivos(string $tokenValue, int $empresaId): array
    {
        $empleados = $this->execute($tokenValue, $empresaId);

        return array_filter(
            $empleados,
            fn(EmpleadoDTO $empleado) => $empleado->isActivo
        );
    }
}
