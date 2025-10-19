<?php

declare(strict_types=1);

/**
 * Ejemplo 16: Crear una Oportunidad de Venta
 * 
 * Este ejemplo muestra cómo crear una oportunidad de venta asociada
 * a un prospecto existente
 * 
 * NOTA: Debes tener un ID de prospecto válido (obtenido del ejemplo 15)
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    // 1. Configurar dependencias
    $apiClient = new IntegraApiClient();
    $oportunidadRepository = new OportunidadApiRepository($apiClient);
    $crearOportunidad = new CrearOportunidad($oportunidadRepository);

    // 2. Parámetros de la oportunidad
    // IMPORTANTE: Estos IDs deben existir en tu sistema IntegraApp
    $empresaId = 24;           // ID de la empresa (CECAPTA)
    $sucursalId = 5;           // ID de la sucursal
    $empleadoId = 10;          // ID del empleado responsable
    $campañaId = 3;            // ID de la campaña
    $prospectoId = 123;        // ID del prospecto (del ejemplo 15)
    
    // Parámetros opcionales
    $eventoProgramar = true;
    $eventoSigTipo = 'LLAMADA';
    $eventoSigFechaHora = (new DateTime('+3 days'))->format('Y-m-d H:i:s');
    $notas = 'Prospecto interesado en curso de programación PHP';
    $etapaId = 1;              // Etapa inicial del embudo
    $fechaEstimadaCierre = (new DateTime('+30 days'))->format('Y-m-d');
    $probabilidad = 60;        // 60% de probabilidad

    echo "🎯 Creando oportunidad de venta...\n\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  Empresa:      {$empresaId}\n";
    echo "  Sucursal:     {$sucursalId}\n";
    echo "  Empleado:     {$empleadoId}\n";
    echo "  Campaña:      {$campañaId}\n";
    echo "  Prospecto:    {$prospectoId}\n";
    echo "  Probabilidad: {$probabilidad}%\n";
    echo "  Cierre est.:  {$fechaEstimadaCierre}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // 3. Ejecutar caso de uso
    $oportunidadId = $crearOportunidad->execute(
        $token,
        $empresaId,
        $sucursalId,
        $empleadoId,
        $campañaId,
        $prospectoId,
        $eventoProgramar,
        $eventoSigTipo,
        $eventoSigFechaHora,
        $notas,
        $etapaId,
        $fechaEstimadaCierre,
        $probabilidad
    );

    // 4. Mostrar resultado
    echo "✅ Oportunidad creada exitosamente\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  ID de la Oportunidad: {$oportunidadId}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    echo "💡 Siguiente paso: Agregar productos con el ejemplo 17\n";

} catch (\InvalidArgumentException $e) {
    echo "❌ Error de validación: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
