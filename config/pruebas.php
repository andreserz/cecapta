<?php

declare(strict_types=1);

/**
 * Configuración de Pruebas de Endpoints
 * 
 * Contiene la configuración necesaria para ejecutar pruebas
 * de los endpoints de IntegraApp API
 */

return [
    // Token de autenticación para la API
    'api_token' => 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv',
    
    // Palabra clave para acceder a la interfaz de pruebas
    'access_key' => 'CECAPTA',
    
    // IDs de recursos para pruebas
    'test_data' => [
        'empresa_id' => 24,
        'sucursal_id' => 5,
        'empleado_id' => 10,
        'campaña_id' => 3,
        'producto_id' => 101,
        'precio_id' => 5,
        'esquema_impuestos_id' => 1,
        'etapa_id' => 1,
    ],
    
    // Datos de prueba para prospecto
    'test_prospecto' => [
        'curp' => 'PEJJ920615HDFRRN05',
        'nombre' => 'Juan Test Pérez Jiménez',
        'lada' => '999',
        'telefono' => '9999999999',
    ],
    
    // Datos de prueba para oportunidad
    'test_oportunidad' => [
        'evento_programar' => true,
        'evento_tipo' => 'LLAMADA',
        'notas' => 'Prueba automatizada desde interfaz web',
        'probabilidad' => 50,
    ],
    
    // Datos de prueba para producto
    'test_producto' => [
        'cantidad' => 1,
        'precio_valor' => 100.00,
        'notas' => 'Producto de prueba',
    ],
    
    // Timeout para las pruebas (segundos)
    'timeout' => 30,
    
    // Tiempo de espera entre pruebas en ejecución masiva (milisegundos)
    'delay_between_tests' => 500,
];
