<?php

declare(strict_types=1);

/**
 * Ejemplo 11: Consultar empleados de una empresa
 * 
 * Nota: Este endpoint actualmente devuelve array vacío para la empresa 24.
 * La estructura está preparada para cuando haya datos disponibles.
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpleados;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpleadoApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24;

try {
    $apiClient = new IntegraApiClient();
    $empleadoRepository = new EmpleadoApiRepository($apiClient);
    $consultarEmpleados = new ConsultarEmpleados($empleadoRepository);

    echo "🔍 Consultando empleados de la empresa ID {$empresaId}...\n\n";
    $empleados = $consultarEmpleados->execute($token, $empresaId);

    if (count($empleados) === 0) {
        echo "ℹ️  No se encontraron empleados para esta empresa.\n";
        echo "   La estructura está lista para cuando haya datos disponibles.\n";
    } else {
        echo "✅ Se encontraron " . count($empleados) . " empleados:\n\n";

        foreach ($empleados as $empleado) {
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
            echo "  ID:     {$empleado->idBd}\n";
            echo "  Nombre: {$empleado->nombreCompleto}\n";
            echo "  Email:  {$empleado->email}\n";
            echo "  Puesto: {$empleado->puesto}\n";
            echo "  Estatus: {$empleado->estatus} " . ($empleado->isActivo ? '✓' : '✗') . "\n";
            echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        }
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
