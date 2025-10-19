<?php

declare(strict_types=1);

/**
 * Ejemplo 1: Consultar todas las empresas
 * 
 * Este ejemplo muestra cómo usar el cliente para consultar
 * la tabla completa de empresas desde la API de IntegraApp
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpresas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpresaApiRepository;

// Token de autenticación (en producción, debería estar en .env o config)
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    // 1. Crear el cliente HTTP
    $apiClient = new IntegraApiClient();

    // 2. Crear el repositorio
    $empresaRepository = new EmpresaApiRepository($apiClient);

    // 3. Crear el caso de uso
    $consultarEmpresas = new ConsultarEmpresas($empresaRepository);

    // 4. Ejecutar el caso de uso
    echo "🔍 Consultando empresas...\n\n";
    $empresas = $consultarEmpresas->execute($token);

    // 5. Mostrar resultados
    echo "✅ Se encontraron " . count($empresas) . " empresas:\n\n";

    foreach ($empresas as $empresa) {
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "  ID BD:   {$empresa->idBd}\n";
        echo "  Nombre:  {$empresa->nombre}\n";
        echo "  Alias:   {$empresa->alias}\n";
        echo "  Estatus: {$empresa->estatus} " . ($empresa->isActiva ? '✓' : '✗') . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
