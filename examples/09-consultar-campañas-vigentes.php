<?php

declare(strict_types=1);

/**
 * Ejemplo 9: Consultar solo campañas vigentes
 * 
 * Este ejemplo muestra cómo filtrar y obtener solo las campañas
 * que están vigentes (dentro del rango de fechas actual)
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarCampañas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\CampañaApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresaId = 24; // CECAPTA

try {
    // Configurar dependencias
    $apiClient = new IntegraApiClient();
    $campañaRepository = new CampañaApiRepository($apiClient);
    $consultarCampañas = new ConsultarCampañas($campañaRepository);

    // Obtener solo campañas vigentes
    echo "🔍 Consultando campañas vigentes de la empresa ID {$empresaId}...\n\n";
    $campañasVigentes = $consultarCampañas->executeOnlyVigentes($token, $empresaId);

    echo "✅ Campañas vigentes encontradas: " . count($campañasVigentes) . "\n\n";

    foreach ($campañasVigentes as $campaña) {
        echo "  • {$campaña->nombre}\n";
        echo "    Plataforma: {$campaña->plataforma} | ";
        echo "Duración: {$campaña->duracionDias} días | ";
        echo "Estatus: {$campaña->estatus}\n\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
