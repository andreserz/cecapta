<?php

declare(strict_types=1);

/**
 * Ejemplo 5: Consultar todas las sucursales de una empresa
 * 
 * Este ejemplo muestra cómo usar el cliente para consultar
 * todas las sucursales de una empresa específica
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarSucursales;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\SucursalApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

// ID de la empresa CECAPTA (obtenido del endpoint de Empresas)
$empresaId = 24;

try {
    // 1. Crear el cliente HTTP
    $apiClient = new IntegraApiClient();

    // 2. Crear el repositorio
    $sucursalRepository = new SucursalApiRepository($apiClient);

    // 3. Crear el caso de uso
    $consultarSucursales = new ConsultarSucursales($sucursalRepository);

    // 4. Ejecutar el caso de uso
    echo "🔍 Consultando sucursales de la empresa ID {$empresaId}...\n\n";
    $sucursales = $consultarSucursales->execute($token, $empresaId);

    // 5. Mostrar resultados
    echo "✅ Se encontraron " . count($sucursales) . " sucursales:\n\n";

    foreach ($sucursales as $sucursal) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "  ID BD:              {$sucursal->idBd}\n";
        echo "  Abreviatura Serie:  {$sucursal->abreviaturaSerie}\n";
        echo "  Estatus:            {$sucursal->estatus} " . ($sucursal->isActiva ? '✓' : '✗') . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
