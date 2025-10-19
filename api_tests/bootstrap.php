<?php

declare(strict_types=1);

/**
 * Bootstrap file - Inicializa la aplicación y configura el autoloader
 */

// Cargar el autoloader de Composer
$autoloadPath = __DIR__ . '/vendor/autoload.php';

if (!file_exists($autoloadPath)) {
    die(
        "ERROR: Las dependencias de Composer no están instaladas.\n" .
        "Por favor ejecuta: composer install\n"
    );
}

require_once $autoloadPath;

// Configuración de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');

return true;
