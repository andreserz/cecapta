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
    <html lang="es" data-theme="night">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Acceso - Validación de Servicios</title>
        
        <!-- DaisyUI + Tailwind CSS -->
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Inter Font Local -->
        <link href="/shared/fonts/inter/inter-local.css" rel="stylesheet" type="text/css" />
        
        <!-- Theme Config -->
        <link href="/shared/design-system/theme-config.css" rel="stylesheet" type="text/css" />
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-900 min-h-screen flex items-center justify-center p-4">
        <div class="card bg-gray-800 shadow-2xl max-w-md w-full">
            <div class="card-body">
                <h1 class="text-2xl font-bold text-gray-100 mb-2 text-center">
                    🔒 Acceso Restringido
                </h1>
                <p class="text-gray-400 mb-6 text-center">
                    Ingresa la palabra clave para acceder a las pruebas
                </p>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-error mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?= htmlspecialchars($error) ?></span>
                    </div>
                <?php endif; ?>
                
                <form method="POST" class="space-y-4">
                    <div class="form-control w-full">
                        <label class="label">
                            <span class="label-text text-gray-200 font-medium">Palabra Clave</span>
                        </label>
                        <input 
                            type="password" 
                            name="access_key" 
                            required
                            class="input input-bordered w-full bg-gray-700 text-white"
                            placeholder="Ingresa la palabra clave"
                            autofocus
                        >
                    </div>
                    <button 
                        type="submit"
                        class="btn btn-primary-custom w-full"
                    >
                        Acceder
                    </button>
                </form>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Usuario autenticado - Mostrar interfaz de pruebas
?>
<!DOCTYPE html>
<html lang="es" data-theme="night">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validación de Servicios - Call Blaster AI</title>
    
    <!-- DaisyUI + Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Inter Font Local -->
    <link href="/shared/fonts/inter/inter-local.css" rel="stylesheet" type="text/css" />
    
    <!-- Theme Config -->
    <link href="/shared/design-system/theme-config.css" rel="stylesheet" type="text/css" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
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
    </style>
</head>
<body class="bg-gray-900 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header -->
        <header class="card bg-gray-800 shadow-2xl mb-6 fade-enter">
            <div class="card-body">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-100 mb-2">
                            🔷 Validación de Servicios Call Blaster AI
                        </h1>
                        <p class="text-gray-400">
                            Prueba de endpoints de IntegraApp API
                        </p>
                    </div>
                    <a href="?logout" class="btn btn-outline btn-error btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Salir
                    </a>
                </div>
            </div>
        </header>

        <!-- Control Buttons -->
        <div class="card bg-gray-800 shadow-xl mb-6 fade-enter" style="animation-delay: 0.1s;">
            <div class="card-body">
                <div class="flex flex-wrap gap-4">
                    <button 
                        id="btnRunAll" 
                        onclick="runAllTests()"
                        class="flex-1 min-w-[200px] btn btn-primary-custom btn-lg"
                >
                    <span>🚀</span>
                    <span>Ejecutar Todas las Pruebas</span>
                </button>
                <button 
                    id="btnClear" 
                    onclick="clearAllResults()"
                    class="flex-1 min-w-[200px] btn btn-outline btn-lg"
                >
                    <span>🔄</span>
                    <span>Limpiar Resultados</span>
                </button>
            </div>
            
            <!-- Progress Bar -->
            <div id="progressContainer" class="mt-4 hidden">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-200">Progreso</span>
                    <span id="progressText" class="text-sm text-gray-400">0 / 8</span>
                </div>
                <progress id="progressBar" class="progress progress-custom w-full" value="0" max="100"></progress>
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
