<?php

declare(strict_types=1);

/**
 * Ejemplo 4: Exportar empresas en formato JSON
 * 
 * Este ejemplo muestra cómo obtener las empresas y
 * exportarlas en formato JSON para APIs o integraciones
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

    // Consultar empresas
    $empresas = $consultarEmpresas->execute($token);

    // Convertir a array
    $empresasArray = array_map(fn($empresa) => $empresa->toArray(), $empresas);

    // Convertir a JSON con formato bonito
    $json = json_encode(
        $empresasArray,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
    );

    echo "📄 Empresas en formato JSON:\n\n";
    echo $json;
    echo "\n\n";

    // También se puede guardar en un archivo
    $filename = __DIR__ . '/empresas_' . date('Y-m-d_His') . '.json';
    file_put_contents($filename, $json);
    echo "✅ JSON guardado en: {$filename}\n";

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
