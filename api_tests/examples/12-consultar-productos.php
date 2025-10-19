<?php

declare(strict_types=1);

/**
 * Ejemplo 12: Consultar productos de una empresa
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

    echo "🔍 Consultando productos de la empresa ID {$empresaId}...\n\n";
    $productos = $consultarProductos->execute($token, $empresaId);

    echo "✅ Se encontraron " . count($productos) . " productos:\n\n";

    // Mostrar primeros 10 productos
    $count = 0;
    foreach ($productos as $producto) {
        if ($count >= 10) {
            echo "... y " . (count($productos) - 10) . " productos más.\n";
            break;
        }
        
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "  ID:     {$producto->id}\n";
        echo "  Nombre: {$producto->nombre}\n";
        echo "  Precio: {$producto->precioFormateado} ({$producto->precio})\n";
        echo "  Lista:  {$producto->listaPreciosId}\n";
        echo "  Estatus: {$producto->estatus} " . ($producto->isActivo ? '✓' : '✗') . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $count++;
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
