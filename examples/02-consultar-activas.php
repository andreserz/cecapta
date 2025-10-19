<?php

declare(strict_types=1);

/**
 * Ejemplo 2: Consultar solo empresas activas
 * 
 * Este ejemplo muestra cómo filtrar y obtener solo las empresas
 * que tienen estatus ACTIVO
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpresas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpresaApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    // Configurar dependencias
    $apiClient = new IntegraApiClient();
    $empresaRepository = new EmpresaApiRepository($apiClient);
    $consultarEmpresas = new ConsultarEmpresas($empresaRepository);

    // Obtener solo empresas activas
    echo "🔍 Consultando empresas activas...\n\n";
    $empresasActivas = $consultarEmpresas->executeOnlyActivas($token);

    echo "✅ Empresas activas encontradas: " . count($empresasActivas) . "\n\n";

    foreach ($empresasActivas as $empresa) {
        echo "  • {$empresa->alias} - {$empresa->nombre}\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
