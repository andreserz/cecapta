<?php

declare(strict_types=1);

/**
 * Ejemplo 10: Agrupar campañas por plataforma
 * 
 * Este ejemplo muestra cómo agrupar las campañas según
 * la plataforma publicitaria utilizada
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

    // Agrupar por plataforma
    echo "🔍 Agrupando campañas por plataforma...\n\n";
    $campañasPorPlataforma = $consultarCampañas->groupByPlataforma($token, $empresaId);

    echo "✅ Campañas agrupadas por plataforma:\n\n";

    foreach ($campañasPorPlataforma as $plataforma => $campañas) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📱 {$plataforma} ({" . count($campañas) . "} campañas)\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        
        foreach ($campañas as $campaña) {
            $vigente = $campaña->isVigente ? '🟢' : '🔴';
            echo "  {$vigente} {$campaña->nombre}\n";
            echo "     Duración: {$campaña->duracionDias} días | Estatus: {$campaña->estatus}\n";
        }
        echo "\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
