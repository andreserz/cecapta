<?php

declare(strict_types=1);

/**
 * Ejemplo 3: Buscar empresa por alias
 * 
 * Este ejemplo muestra cómo buscar una empresa específica
 * utilizando su alias
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpresas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpresaApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$aliasBuscado = 'CECAPTA'; // Cambiar por el alias que desees buscar

try {
    // Configurar dependencias
    $apiClient = new IntegraApiClient();
    $empresaRepository = new EmpresaApiRepository($apiClient);
    $consultarEmpresas = new ConsultarEmpresas($empresaRepository);

    // Buscar empresa
    echo "🔍 Buscando empresa con alias: {$aliasBuscado}...\n\n";
    $empresa = $consultarEmpresas->findByAlias($token, $aliasBuscado);

    if ($empresa === null) {
        echo "⚠️  No se encontró ninguna empresa con el alias '{$aliasBuscado}'\n";
        exit(0);
    }

    // Mostrar resultado
    echo "✅ Empresa encontrada:\n\n";
    echo "  ID BD:   {$empresa->idBd}\n";
    echo "  Nombre:  {$empresa->nombre}\n";
    echo "  Alias:   {$empresa->alias}\n";
    echo "  Estatus: {$empresa->estatus}\n";
    echo "  Activa:  " . ($empresa->isActiva ? 'Sí ✓' : 'No ✗') . "\n";

} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    exit(1);
}
