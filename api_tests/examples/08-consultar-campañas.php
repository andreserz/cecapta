<?php

declare(strict_types=1);

/**
 * Ejemplo 8: Consultar todas las campañas de una empresa
 * 
 * Este ejemplo muestra cómo usar el cliente para consultar
 * todas las campañas de una empresa específica
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarCampañas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\CampañaApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

// ID de la empresa CECAPTA
$empresaId = 24;

try {
    // 1. Crear el cliente HTTP
    $apiClient = new IntegraApiClient();

    // 2. Crear el repositorio
    $campañaRepository = new CampañaApiRepository($apiClient);

    // 3. Crear el caso de uso
    $consultarCampañas = new ConsultarCampañas($campañaRepository);

    // 4. Ejecutar el caso de uso
    echo "🔍 Consultando campañas de la empresa ID {$empresaId}...\n\n";
    $campañas = $consultarCampañas->execute($token, $empresaId);

    // 5. Mostrar resultados
    echo "✅ Se encontraron " . count($campañas) . " campañas:\n\n";

    foreach ($campañas as $campaña) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "  ID:          {$campaña->idBd}\n";
        echo "  Nombre:      {$campaña->nombre}\n";
        echo "  Plataforma:  {$campaña->plataforma}\n";
        echo "  Inicio:      {$campaña->fechaInicio}\n";
        echo "  Fin:         {$campaña->fechaFin}\n";
        echo "  Duración:    {$campaña->duracionDias} días\n";
        echo "  Estatus:     {$campaña->estatus} " . ($campaña->isActiva ? '✓' : '✗') . "\n";
        echo "  Vigente:     " . ($campaña->isVigente ? 'Sí ✓' : 'No ✗') . "\n";
        if ($campaña->notas) {
            echo "  Notas:       {$campaña->notas}\n";
        }
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
