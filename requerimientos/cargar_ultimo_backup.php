<?php
declare(strict_types=1);

// Configurar timezone de México
date_default_timezone_set('America/Mexico_City');

header('Content-Type: application/json; charset=utf-8');

try {
    $dirBackups = __DIR__ . '/backups';
    
    // Verificar que el directorio existe
    if (!is_dir($dirBackups)) {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'No hay backups disponibles'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Obtener todos los archivos de backup
    $archivos = glob($dirBackups . '/backup_*.json');
    
    if (empty($archivos)) {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'No se encontraron backups'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Ordenar por fecha de modificación (más reciente primero)
    usort($archivos, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    // Obtener el más reciente
    $archivoMasReciente = $archivos[0];
    
    // Leer contenido
    $contenido = file_get_contents($archivoMasReciente);
    
    if ($contenido === false) {
        throw new Exception('Error al leer el archivo de backup');
    }
    
    $backup = json_decode($contenido, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar el backup: ' . json_last_error_msg());
    }
    
    // Respuesta exitosa
    echo json_encode([
        'exito' => true,
        'backup' => $backup,
        'archivo' => basename($archivoMasReciente),
        'fecha_modificacion' => date('Y-m-d H:i:s', filemtime($archivoMasReciente))
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    error_log("Error en cargar_ultimo_backup.php: " . $e->getMessage());
    
    http_response_code(500);
    echo json_encode([
        'exito' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
