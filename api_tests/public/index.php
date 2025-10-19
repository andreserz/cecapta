<?php

declare(strict_types=1);

session_start();

// Verificar autenticación
$config = require __DIR__ . '/../config/pruebas.php';
$isAuthenticated = isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;

// Procesar intento de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['access_key'])) {
    if ($_POST['access_key'] === $config['access_key']) {
        $_SESSION['authenticated'] = true;
        $isAuthenticated = true;
    } else {
        $error = 'Palabra clave incorrecta';
    }
}

// Procesar logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: /');
    exit;
}

// Si no está autenticado, mostrar formulario de acceso
if (!$isAuthenticated) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso - Validación de Servicios</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                🔒 Acceso Restringido
            </h1>
            <p class="text-gray-600 mb-4 text-center">
                Ingresa la palabra clave para acceder a las pruebas
            </p>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Palabra Clave
                    </label>
                    <input 
                        type="password" 
                        name="access_key" 
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Ingresa la palabra clave"
                        autofocus
                    >
                </div>
                <button 
                    type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors"
                >
                    Acceder
                </button>
            </form>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Usuario autenticado - Mostrar interfaz de pruebas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Servicios - Call Blaster AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .accordion-content.active {
            max-height: 2000px;
            transition: max-height 0.5s ease-in;
        }
        .json-viewer {
            background: #1e293b;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #3b82f6;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">
                        🔷 Validación de servicios para Call Blaster AI
                    </h1>
                    <p class="text-gray-600">
                        Prueba de endpoints de IntegraApp API
                    </p>
                </div>
                <a href="?logout" class="text-sm text-gray-600 hover:text-gray-800">
                    🚪 Salir
                </a>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex flex-wrap gap-4">
                <button 
                    id="btnRunAll" 
                    onclick="runAllTests()"
                    class="flex-1 min-w-[200px] bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors font-semibold flex items-center justify-center gap-2"
                >
                    <span>🚀</span>
                    <span>Ejecutar Todas las Pruebas</span>
                </button>
                <button 
                    id="btnClear" 
                    onclick="clearAllResults()"
                    class="flex-1 min-w-[200px] bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition-colors font-semibold flex items-center justify-center gap-2"
                >
                    <span>🔄</span>
                    <span>Limpiar Resultados</span>
                </button>
            </div>
            
            <!-- Progress Bar -->
            <div id="progressContainer" class="mt-4 hidden">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progreso</span>
                    <span id="progressText" class="text-sm text-gray-600">0 / 8</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div id="progressBar" class="bg-blue-600 h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Tests Container -->
        <div id="testsContainer" class="space-y-4">
            <!-- Los acordeones de pruebas se generarán con JavaScript -->
        </div>
    </div>

    <script>
        // Configuración de pruebas
        const tests = [
            {
                id: 'consultar-empresas',
                name: '1. Consultar Empresas',
                endpoint: 'consultar-empresas',
                group: 'consulta'
            },
            {
                id: 'consultar-sucursales',
                name: '2. Consultar Sucursales',
                endpoint: 'consultar-sucursales',
                group: 'consulta'
            },
            {
                id: 'consultar-campañas',
                name: '3. Consultar Campañas',
                endpoint: 'consultar-campañas',
                group: 'consulta'
            },
            {
                id: 'consultar-empleados',
                name: '4. Consultar Empleados',
                endpoint: 'consultar-empleados',
                group: 'consulta'
            },
            {
                id: 'consultar-productos',
                name: '5. Consultar Productos',
                endpoint: 'consultar-productos',
                group: 'consulta'
            },
            {
                id: 'registrar-prospecto',
                name: '6. Registrar Prospecto',
                endpoint: 'registrar-prospecto',
                group: 'ventas'
            },
            {
                id: 'crear-oportunidad',
                name: '7. Crear Oportunidad',
                endpoint: 'crear-oportunidad',
                group: 'ventas',
                requires: 'registrar-prospecto'
            },
            {
                id: 'agregar-producto',
                name: '8. Agregar Producto a Oportunidad',
                endpoint: 'agregar-producto',
                group: 'ventas',
                requires: 'crear-oportunidad'
            }
        ];

        // Estado de las pruebas
        let testResults = {};
        let isRunningAll = false;

        // Inicializar interfaz
        document.addEventListener('DOMContentLoaded', () => {
            renderTests();
        });
    </script>
    
    <script src="assets/js/pruebas.js"></script>
</body>
</html>
