<?php

declare(strict_types=1);

/**
 * Ejemplo 18: Flujo Completo de Venta
 * 
 * Este ejemplo demuestra el flujo completo desde el registro
 * de un prospecto hasta la creación de una oportunidad con productos
 * 
 * Combina los ejemplos 15, 16 y 17 en un solo flujo
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    echo "🚀 FLUJO COMPLETO DE VENTA\n";
    echo "═══════════════════════════════════════\n\n";

    // ========================================
    // PASO 1: Registrar Prospecto
    // ========================================
    echo "📝 PASO 1: Registrando prospecto...\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

    $apiClient = new IntegraApiClient();
    $prospectoRepository = new ProspectoApiRepository($apiClient);
    $registrarProspecto = new RegistrarProspecto($prospectoRepository);

    $curp = 'GAMJ850312HDFNRN03';
    $nombreCompleto = 'José María García Núñez';
    $telefonoLada = '999';
    $telefono10Digitos = '1234567890';

    echo "Nombre: {$nombreCompleto}\n";
    echo "CURP:   {$curp}\n";
    echo "Tel:    +{$telefonoLada} {$telefono10Digitos}\n\n";

    $prospectoId = $registrarProspecto->execute(
        $token,
        $curp,
        $nombreCompleto,
        $telefonoLada,
        $telefono10Digitos
    );

    echo "✅ Prospecto ID: {$prospectoId}\n\n";

    // ========================================
    // PASO 2: Crear Oportunidad
    // ========================================
    echo "🎯 PASO 2: Creando oportunidad...\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

    $oportunidadRepository = new OportunidadApiRepository($apiClient);
    $crearOportunidad = new CrearOportunidad($oportunidadRepository);

    $empresaId = 24;
    $sucursalId = 5;
    $empleadoId = 10;
    $campañaId = 3;
    $etapaId = 1;
    $probabilidad = 70;

    echo "Empresa:      {$empresaId}\n";
    echo "Sucursal:     {$sucursalId}\n";
    echo "Probabilidad: {$probabilidad}%\n\n";

    $oportunidadId = $crearOportunidad->execute(
        $token,
        $empresaId,
        $sucursalId,
        $empleadoId,
        $campañaId,
        $prospectoId,
        eventoProgramar: true,
        eventoSigTipo: 'VISITA',
        eventoSigFechaHora: (new DateTime('+5 days'))->format('Y-m-d H:i:s'),
        notas: 'Cliente interesado en capacitación corporativa',
        etapaId: $etapaId,
        fechaEstimadaCierre: (new DateTime('+45 days'))->format('Y-m-d'),
        probabilidad: $probabilidad
    );

    echo "✅ Oportunidad ID: {$oportunidadId}\n\n";

    // ========================================
    // PASO 3: Agregar Productos
    // ========================================
    echo "🛒 PASO 3: Agregando productos...\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

    $agregarProducto = new AgregarProductoAOportunidad($oportunidadRepository);

    // Producto 1
    $productos = [
        [
            'nombre' => 'Curso PHP Avanzado',
            'productoId' => 101,
            'cantidad' => 2,
            'esquemaImpuestosId' => 1,
            'precioId' => 5,
            'precioValor' => 3500.00,
            'notas' => 'Para 2 empleados'
        ],
        [
            'nombre' => 'Curso Laravel',
            'productoId' => 102,
            'cantidad' => 2,
            'esquemaImpuestosId' => 1,
            'precioId' => 6,
            'precioValor' => 4000.00,
            'notas' => 'Para 2 empleados'
        ],
        [
            'nombre' => 'Certificación',
            'productoId' => 205,
            'cantidad' => 2,
            'esquemaImpuestosId' => 1,
            'precioId' => 8,
            'precioValor' => 1500.00,
            'notas' => null
        ]
    ];

    $totalVenta = 0;
    foreach ($productos as $prod) {
        echo "- {$prod['nombre']} (x{$prod['cantidad']}) - \$" . 
             number_format($prod['precioValor'] * $prod['cantidad'], 2) . "\n";
        
        $agregarProducto->execute(
            $token,
            $oportunidadId,
            $prod['productoId'],
            $prod['cantidad'],
            $prod['esquemaImpuestosId'],
            $prod['precioId'],
            $prod['precioValor'],
            $prod['notas']
        );

        $totalVenta += $prod['precioValor'] * $prod['cantidad'];
    }

    echo "\n";

    // ========================================
    // RESUMEN FINAL
    // ========================================
    echo "═══════════════════════════════════════\n";
    echo "✅ PROCESO COMPLETADO EXITOSAMENTE\n";
    echo "═══════════════════════════════════════\n";
    echo "Prospecto ID:    {$prospectoId}\n";
    echo "Oportunidad ID:  {$oportunidadId}\n";
    echo "Productos:       " . count($productos) . "\n";
    echo "Total Venta:     \$" . number_format($totalVenta, 2) . " MXN\n";
    echo "═══════════════════════════════════════\n\n";
    echo "🎉 La oportunidad está lista para seguimiento!\n";

} catch (\InvalidArgumentException $e) {
    echo "\n❌ Error de validación: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "\n❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
