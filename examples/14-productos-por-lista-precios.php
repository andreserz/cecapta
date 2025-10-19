<?php

declare(strict_types=1);

/**
 * Ejemplo 14: Agrupar productos por lista de precios
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarProductos;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProductoApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24;

try {
    $apiClient = new IntegraApiClient();
    $productoRepository = new ProductoApiRepository($apiClient);
    $consultarProductos = new ConsultarProductos($productoRepository);

    echo "🔍 Agrupando productos por lista de precios...\n\n";
    $productosPorLista = $consultarProductos->groupByListaPrecios($token, $empresaId);

    echo "✅ Productos agrupados por " . count($productosPorLista) . " listas de precios:\n\n";

    foreach ($productosPorLista as $listaNombre => $productos) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📋 {$listaNombre} (" . count($productos) . " productos)\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        foreach ($productos as $producto) {
            echo "  • {$producto->nombre} - {$producto->precioFormateado}\n";
        }
        echo "\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
