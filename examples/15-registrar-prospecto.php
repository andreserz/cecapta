<?php

declare(strict_types=1);

/**
 * Ejemplo 15: Registrar un nuevo Prospecto
 * 
 * Este ejemplo muestra cómo registrar un nuevo prospecto (cliente potencial)
 * en el sistema IntegraApp utilizando el caso de uso RegistrarProspecto
 */

require_once __DIR__ . '/../bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;

// Token de autenticación
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';

try {
    // 1. Configurar dependencias
    $apiClient = new IntegraApiClient();
    $prospectoRepository = new ProspectoApiRepository($apiClient);
    $registrarProspecto = new RegistrarProspecto($prospectoRepository);

    // 2. Datos del prospecto
    $curp = 'PEJJ920615HDFRRN05'; // CURP válido (ejemplo)
    $nombreCompleto = 'Juan Pérez Jiménez';
    $telefonoLada = '999'; // Lada de Mérida, Yucatán
    $telefono10Digitos = '5551234567';

    echo "📝 Registrando prospecto...\n\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  CURP:     {$curp}\n";
    echo "  Nombre:   {$nombreCompleto}\n";
    echo "  Teléfono: +{$telefonoLada} {$telefono10Digitos}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

    // 3. Ejecutar caso de uso
    $prospectoId = $registrarProspecto->execute(
        $token,
        $curp,
        $nombreCompleto,
        $telefonoLada,
        $telefono10Digitos
    );

    // 4. Mostrar resultado
    echo "✅ Prospecto registrado exitosamente\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "  ID del Prospecto: {$prospectoId}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    echo "💡 Este ID será necesario para crear oportunidades\n";

} catch (\InvalidArgumentException $e) {
    echo "❌ Error de validación: {$e->getMessage()}\n";
    exit(1);
} catch (\Exception $e) {
    echo "❌ Error: {$e->getMessage()}\n";
    echo "   Archivo: {$e->getFile()}:{$e->getLine()}\n";
    exit(1);
}
