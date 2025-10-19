<?php

declare(strict_types=1);

/**
 * Ejemplo 17: Agregar Productos a una Oportunidad
 * 
 * Este ejemplo muestra cómo agregar uno o varios productos
 * a una oportunidad de venta existente
 * 
 * NOTA: Debes tener un ID de oportunidad válido (obtenido del ejemplo 16)
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    // 1. Configurar dependencias
    $apiClient = new IntegraApiClient();
    $oportunidadRepository = new OportunidadApiRepository($apiClient);
    $agregarProducto = new AgregarProductoAOportunidad($oportunidadRepository);

    // 2. ID de la oportunidad (del ejemplo 16)
    $oportunidadId = 456; // Reemplazar con un ID real

    echo "🛒 Agregando productos a la oportunidad #{$oportunidadId}...\n\n";

    // 3. Agregar primer producto
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Producto 1: Curso de PHP Avanzado\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    $resultado1 = $agregarProducto->execute(
        $token,
        $oportunidadId,
        productoId: 101,              // ID del producto
        cantidad: 1,                  // Cantidad
        esquemaImpuestosId: 1,        // ID esquema de impuestos (IVA 16%)
        precioId: 5,                  // ID del precio aplicable
        precioValor: 3500.00,         // Precio unitario
        notas: 'Incluye material digital'
    );

    echo $resultado1 ? "✅ Agregado\n\n" : "❌ Error al agregar\n\n";

    // 4. Agregar segundo producto
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Producto 2: Certificación Profesional\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    $resultado2 = $agregarProducto->execute(
        $token,
        $oportunidadId,
        productoId: 205,
        cantidad: 1,
        esquemaImpuestosId: 1,
        precioId: 8,
        precioValor: 1500.00,
        notas: null
    );

    echo $resultado2 ? "✅ Agregado\n\n" : "❌ Error al agregar\n\n";

    // 5. Resumen
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "✅ Productos agregados a la oportunidad\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  Subtotal: $5,000.00 MXN\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

} catch (\InvalidArgumentException $e) {
    echo "❌ Error de validación: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
