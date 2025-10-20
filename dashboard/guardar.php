<?php
declare(strict_types=1);

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
    
    // Validar que se recibieron todas las claves esperadas
    $clavesEsperadas = [
        'nombre_empresa',
        'objetivo_chatbot',
        'tono_comunicacion',
        'preguntas_frecuentes',
        'horario_atencion',
        'mensaje_despedida',
        'url_website'
    ];
    
    foreach ($clavesEsperadas as $clave) {
        if (!isset($datos[$clave])) {
            throw new Exception("Falta el campo requerido: {$clave}");
        }
    }
    
    // Sanitizar datos
    $datosSanitizados = [];
    foreach ($datos as $clave => $valor) {
        // Convertir a string y sanitizar
        $valorSanitizado = filter_var(
            trim((string)$valor),
            FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            FILTER_FLAG_NO_ENCODE_QUOTES
        );
        
        // Validación especial para URL
        if ($clave === 'url_website') {
            if (!filter_var($valorSanitizado, FILTER_VALIDATE_URL)) {
                throw new Exception('La URL del sitio web no es válida');
            }
        }
        
        // Validar longitud máxima
        $longitudMaxima = match($clave) {
            'nombre_empresa' => 200,
            'objetivo_chatbot' => 1000,
            'tono_comunicacion' => 50,
            'preguntas_frecuentes' => 2000,
            'horario_atencion' => 200,
            'mensaje_despedida' => 300,
            'url_website' => 500,
            default => 1000
        };
        
        if (mb_strlen($valorSanitizado) > $longitudMaxima) {
            throw new Exception("El campo {$clave} excede la longitud máxima permitida");
        }
        
        // Validar que no esté vacío
        if (empty($valorSanitizado)) {
            throw new Exception("El campo {$clave} no puede estar vacío");
        }
        
        $datosSanitizados[$clave] = $valorSanitizado;
    }
    
    // Preparar datos finales con timestamp
    $configuracionCompleta = [
        'fecha_guardado' => date('Y-m-d H:i:s'),
        'respuestas' => $datosSanitizados
    ];
    
    // Generar nombre de archivo único con timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $nombreArchivo = "respuestas_{$timestamp}.json";
    $rutaCompleta = __DIR__ . "/respuestas/{$nombreArchivo}";
    
    // Verificar que el directorio existe
    $directorioRespuestas = __DIR__ . '/respuestas';
    if (!is_dir($directorioRespuestas)) {
        if (!mkdir($directorioRespuestas, 0755, true)) {
            throw new Exception('No se pudo crear el directorio de respuestas');
        }
    }
    
    // Verificar permisos de escritura
    if (!is_writable($directorioRespuestas)) {
        throw new Exception('El directorio de respuestas no tiene permisos de escritura');
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
        'mensaje' => 'Configuración guardada exitosamente',
        'archivo' => $nombreArchivo,
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
