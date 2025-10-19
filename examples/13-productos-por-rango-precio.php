<?php

declare(strict_types=1);

/**
 * Ejemplo 13: Filtrar productos por rango de precio
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarProductos;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProductoApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24;
$precioMin = 1000.00;
$precioMax = 2000.00;

try {
    $apiClient = new IntegraApiClient();
    $productoRepository = new ProductoApiRepository($apiClient);
    $consultarProductos = new ConsultarProductos($productoRepository);

    echo "🔍 Buscando productos entre \${$precioMin} y \${$precioMax}...\n\n";
    $productos = $consultarProductos->filterByPrecioRange($token, $empresaId, $precioMin, $precioMax);

    echo "✅ Se encontraron " . count($productos) . " productos en ese rango:\n\n";

    foreach ($productos as $producto) {
        echo "  • {$producto->nombre}\n";
        echo "    Precio: {$producto->precioFormateado}\n\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
