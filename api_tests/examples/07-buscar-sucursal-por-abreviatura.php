<?php

declare(strict_types=1);

/**
 * Ejemplo 7: Buscar sucursal por abreviatura de serie
 * 
 * Este ejemplo muestra cómo buscar una sucursal específica
 * utilizando su abreviatura de serie
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarSucursales;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\SucursalApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24; // CECAPTA
$abreviaturaBuscada = 'CORP'; // Cambiar por la abreviatura que desees buscar

try {
    // Configurar dependencias
    $apiClient = new IntegraApiClient();
    $sucursalRepository = new SucursalApiRepository($apiClient);
    $consultarSucursales = new ConsultarSucursales($sucursalRepository);

    // Buscar sucursal
    echo "🔍 Buscando sucursal con abreviatura: {$abreviaturaBuscada}...\n\n";
    $sucursal = $consultarSucursales->findByAbreviatura($token, $empresaId, $abreviaturaBuscada);

    if ($sucursal === null) {
        echo "⚠️  No se encontró ninguna sucursal con la abreviatura '{$abreviaturaBuscada}'\n";
        exit(0);
    }

    // Mostrar resultado
    echo "✅ Sucursal encontrada:\n\n";
    echo "  ID BD:              {$sucursal->idBd}\n";
    echo "  Abreviatura Serie:  {$sucursal->abreviaturaSerie}\n";
    echo "  Estatus:            {$sucursal->estatus}\n";
    echo "  Activa:             " . ($sucursal->isActiva ? 'Sí ✓' : 'No ✗') . "\n";

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
