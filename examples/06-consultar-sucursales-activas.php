<?php

declare(strict_types=1);

/**
 * Ejemplo 6: Consultar solo sucursales activas
 * 
 * Este ejemplo muestra cómo filtrar y obtener solo las sucursales
 * que tienen estatus ACTIVO
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarSucursales;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\SucursalApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24; // CECAPTA

try {
    // Configurar dependencias
    $apiClient = new IntegraApiClient();
    $sucursalRepository = new SucursalApiRepository($apiClient);
    $consultarSucursales = new ConsultarSucursales($sucursalRepository);

    // Obtener solo sucursales activas
    echo "🔍 Consultando sucursales activas de la empresa ID {$empresaId}...\n\n";
    $sucursalesActivas = $consultarSucursales->executeOnlyActivas($token, $empresaId);

    echo "✅ Sucursales activas encontradas: " . count($sucursalesActivas) . "\n\n";

    foreach ($sucursalesActivas as $sucursal) {
        echo "  • [{$sucursal->abreviaturaSerie}] - ID: {$sucursal->idBd}\n";
    }

    echo "\n";

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
