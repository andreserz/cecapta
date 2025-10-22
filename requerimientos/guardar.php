<?php
declare(strict_types=1);

// Configurar timezone de México
date_default_timezone_set('America/Mexico_City');

// Configurar headers
header('Content-Type: application/json; charset=utf-8');

// Solo aceptar peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'exito' => false,
        'error' => 'Método no permitido. Solo se aceptan peticiones POST.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Leer el cuerpo de la petición
    $inputRaw = file_get_contents('php://input');
    
    if (empty($inputRaw)) {
        throw new Exception('No se recibieron datos');
    }
    
    // Decodificar JSON
    $datos = json_decode($inputRaw, true);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
    }
    
    if (!is_array($datos)) {
        throw new Exception('Los datos recibidos no tienen el formato correcto');
    }
    
    // Verificar si es un guardado de backup (guardar para después)
    $esBackup = isset($datos['tipo']) && $datos['tipo'] === 'backup';
    
    // Si es backup, extraer las respuestas del objeto anidado
    if ($esBackup) {
        $preguntaActual = $datos['pregunta_actual'] ?? 0;
        $timestamp = $datos['timestamp'] ?? date('c');
        $datos = $datos['respuestas'] ?? [];
    }
    
    // Cargar preguntas desde archivo JSON para obtener las claves esperadas
    $archivoPreguntas = __DIR__ . '/preguntas/requirements.json';
    $preguntas = json_decode(file_get_contents($archivoPreguntas), true);
    $clavesEsperadas = array_column($preguntas, 'nombre');
    
    // Para backup, solo validar las claves que tienen datos
    if (!$esBackup) {
        foreach ($clavesEsperadas as $clave) {
            if (!isset($datos[$clave])) {
                throw new Exception("Falta el campo requerido: {$clave}");
            }
        }
    }
    
    // Sanitizar datos
    $datosSanitizados = [];
    
    // Crear mapa de longitudes máximas desde las preguntas
    $longitudesMaximas = [];
    foreach ($preguntas as $pregunta) {
        $longitudesMaximas[$pregunta['nombre']] = $pregunta['maxlength'] ?? 1000;
    }
    
    foreach ($datos as $clave => $valor) {
        // Convertir a string y sanitizar
        $valorSanitizado = filter_var(
            trim((string)$valor),
            FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );
        
        // Validación especial para URL
        if ($clave === 'url_website' && !empty($valorSanitizado)) {
            if (!filter_var($valorSanitizado, FILTER_VALIDATE_URL)) {
                throw new Exception('La URL del sitio web no es válida');
            }
        }
        
        // Validar longitud máxima usando el valor del JSON
        $longitudMaxima = $longitudesMaximas[$clave] ?? 1000;
        
        if (mb_strlen($valorSanitizado) > $longitudMaxima) {
            throw new Exception("El campo {$clave} excede la longitud máxima permitida");
        }
        
        // Validar que no esté vacío (solo si NO es backup, ya que puede tener campos vacíos)
        if (!$esBackup && empty($valorSanitizado)) {
            throw new Exception("El campo {$clave} no puede estar vacío");
        }
        
        $datosSanitizados[$clave] = $valorSanitizado;
    }
    
    // Preparar datos finales con timestamp
    $configuracionCompleta = [
        'fecha_guardado' => date('Y-m-d H:i:s'),
        'tipo' => $esBackup ? 'backup' : 'final',
        'respuestas' => $datosSanitizados
    ];
    
    // Si es backup, agregar información adicional
    if ($esBackup) {
        $configuracionCompleta['pregunta_actual'] = $preguntaActual ?? 0;
        $configuracionCompleta['timestamp_cliente'] = $timestamp ?? null;
    }
    
    // Generar nombre de archivo único con timestamp formato: backup_YYmmDD_HHMMSS.json
    $timestamp = date('ymd_His');
    $prefijo = $esBackup ? 'backup' : 'respuestas';
    $nombreArchivo = "{$prefijo}_{$timestamp}.json";
    
    // Usar directorio diferente para backups
    $subdirectorio = $esBackup ? '/backups' : '/respuestas';
    $directorioDestino = __DIR__ . $subdirectorio;
    $rutaCompleta = $directorioDestino . "/{$nombreArchivo}";
    
    // Verificar que el directorio existe
    if (!is_dir($directorioDestino)) {
        if (!mkdir($directorioDestino, 0755, true)) {
            throw new Exception('No se pudo crear el directorio de guardado');
        }
    }
    
    // Verificar permisos de escritura
    if (!is_writable($directorioDestino)) {
        throw new Exception('El directorio de guardado no tiene permisos de escritura');
    }
    
    // Convertir a JSON con formato legible
    $jsonFormateado = json_encode(
        $configuracionCompleta,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    
    if ($jsonFormateado === false) {
        throw new Exception('Error al convertir los datos a JSON');
    }
    
    // Guardar archivo
    $bytesEscritos = file_put_contents($rutaCompleta, $jsonFormateado);
    
    if ($bytesEscritos === false) {
        throw new Exception('Error al escribir el archivo de configuración');
    }
    
    // Establecer permisos del archivo (solo lectura para grupo/otros)
    chmod($rutaCompleta, 0644);
    
    // Respuesta de éxito
    http_response_code(200);
    echo json_encode([
        'exito' => true,
        'mensaje' => $esBackup ? 'Progreso guardado exitosamente' : 'Configuración guardada exitosamente',
        'archivo' => $nombreArchivo,
        'tipo' => $esBackup ? 'backup' : 'final',
        'timestamp' => $configuracionCompleta['fecha_guardado'],
        'bytes' => $bytesEscritos
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // Log del error (en producción, usar un sistema de logs apropiado)
    error_log("Error en guardar.php: " . $e->getMessage());
    
    // Respuesta de error
    http_response_code(500);
    echo json_encode([
        'exito' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
