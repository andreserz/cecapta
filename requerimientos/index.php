<?php
declare(strict_types=1);

// Cargar preguntas desde archivo JSON externo
$archivoPreguntas = __DIR__ . '/preguntas/requirements.json';

if (!file_exists($archivoPreguntas)) {
    die('Error: No se encontró el archivo de preguntas. Contacte al administrador.');
}

$contenidoJson = file_get_contents($archivoPreguntas);
$preguntas = json_decode($contenidoJson, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('Error: El archivo de preguntas tiene un formato inválido. Contacte al administrador.');
}

if (!is_array($preguntas) || empty($preguntas)) {
    die('Error: El archivo de preguntas está vacío o es inválido. Contacte al administrador.');
}

// Convertir a JSON para JavaScript
$preguntasJson = json_encode($preguntas, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="es" data-theme="night">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Chatbot IA - CECAPTA</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DaisyUI CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Inter Local Fonts -->
    <link href="./fonts/inter-local.css" rel="stylesheet" type="text/css" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
        }
        
        /* Paleta de colores personalizada */
        :root {
            --naranja-primario: #F97316;
            --naranja-hover: #EA580C;
            --naranja-claro: #FDBA74;
            --fondo-oscuro: #111827;
            --completado: #10B981;
        }
        
        /* Ajuste de altura dinámica para móviles */
        @media (max-width: 1024px) {
            .question-card {
                max-height: calc(100vh - 260px);
                overflow-y: auto;
                padding: 1.5rem !important;
            }
            
            #questionArea {
                max-height: calc(100vh - 350px);
                overflow-y: auto;
            }
            
            /* Reducir espaciado en móviles */
            .question-card h1 {
                margin-bottom: 1.5rem !important;
                font-size: 1.5rem !important;
            }
        }
        
        /* Transiciones suaves */
        .fade-enter {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Estilo del botón principal */
        .btn-primary-custom {
            background-color: var(--naranja-primario);
            border-color: var(--naranja-primario);
        }
        
        .btn-primary-custom:hover {
            background-color: var(--naranja-hover);
            border-color: var(--naranja-hover);
        }
        
        /* Barra de progreso personalizada */
        .progress-custom {
            background-color: #374151;
        }
        
        .progress-custom::-webkit-progress-value {
            background-color: var(--naranja-primario);
        }
        
        .progress-custom::-moz-progress-bar {
            background-color: var(--naranja-primario);
        }
        
        /* Sidebar de pasos */
        .step-item {
            transition: all 0.2s ease;
        }
        
        .step-item.active {
            color: var(--naranja-primario);
            font-weight: 600;
        }
        
        .step-item.completed {
            color: var(--completado);
        }
        
        .step-item.pending {
            color: #6B7280;
        }
        
        /* Navegación clickeable en sidebar */
        .step-item.clickable {
            cursor: pointer;
        }
        
        .step-item.clickable:hover {
            background-color: rgba(249, 115, 22, 0.1);
            transform: translateX(4px);
        }
        
        .step-item.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Focus visible para accesibilidad */
        *:focus-visible {
            outline: 2px solid var(--naranja-primario);
            outline-offset: 2px;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 h-screen flex flex-col">
    
    <!-- Header con Logo y Título -->
    <header class="bg-gray-800 border-b border-gray-700 py-1 px-6">
        <div class="max-w-7xl mx-auto flex items-center gap-4">
            <img 
                src="Logo_Claro_Trans.png" 
                alt="Call Blaster Logo"
                class="h-10 md:h-12 w-auto"
                loading="eager"
            >
            <h1 class="text-base md:text-xl lg:text-xl font-bold text-gray-100">
                Requerimientos
            </h1>
        </div>
    </header>
    
    <!-- Contenedor Principal -->
    <div class="flex-1 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full h-full max-w-7xl flex flex-col lg:flex-row gap-6">
        
        <!-- Sidebar de Pasos (Solo Desktop) -->
        <aside id="sidebar" class="hidden lg:block lg:w-1/3 bg-gray-800 rounded-lg p-6 overflow-y-auto">
            <h2 class="text-xl font-bold mb-6 text-orange-500">Pasos de Configuración</h2>
            <ul id="stepsList" class="space-y-4">
                <!-- Los pasos se generarán dinámicamente con JavaScript -->
            </ul>
        </aside>
        
        <!-- Área Principal -->
        <main class="flex-1 flex flex-col">
            
            <!-- Barra de Progreso -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2 gap-2 flex-wrap">
                    <span id="progressText" class="text-sm font-medium text-gray-400">Paso 1 de 7</span>
                    
                    <!-- Botón Guardar para Después en Barra de Progreso -->
                    <button id="btnGuardarProgress" class="btn btn-sm btn-ghost gap-1 text-orange-500 hover:bg-orange-500 hover:bg-opacity-20" title="Guardar progreso actual">
                        Guardar para después
                    </button>
                    
                    <span id="progressPercent" class="text-sm font-medium text-orange-500">14%</span>
                </div>
                <progress id="progressBar" class="progress progress-custom w-full" value="14" max="100"></progress>
            </div>
            
            <!-- Card de Pregunta -->
            <div class="flex-1 bg-gray-800 rounded-lg p-8 flex flex-col justify-between question-card">
                
                <!-- Pregunta y Campo de Entrada -->
                <div class="flex-1 flex flex-col justify-center" id="questionArea">
                    <h1 id="questionTitle" class="text-2xl md:text-3xl font-bold mb-8 text-center fade-enter">
                        <!-- Título de la pregunta -->
                    </h1>
                    
                    <div id="inputContainer" class="max-w-2xl mx-auto w-full fade-enter">
                        <!-- Campo de entrada dinámico -->
                    </div>
                    
                    <!-- Mensaje de error -->
                    <div id="errorMessage" class="hidden mt-4 alert alert-error">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span id="errorText">Error message</span>
                    </div>
                </div>
                
                <!-- Botones de Navegación -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-8 pt-6 border-t border-gray-700">
                    <button id="btnAnterior" class="btn btn-outline btn-disabled w-full sm:w-auto order-2 sm:order-1" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Anterior
                    </button>
                    
                    <div class="flex gap-3 w-full sm:w-auto order-1 sm:order-2">
                        <button id="btnSiguiente" class="btn btn-primary-custom flex-1 sm:flex-initial">
                            Siguiente
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
                
            </div>
            
        </main>
        
        </div> <!-- Cierre de max-w-7xl -->
        
    </div> <!-- Cierre de flex-1 contenedor principal -->
    
    <!-- Modal de Éxito -->
    <dialog id="modalExito" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                ¡Progreso Guardado!
            </h3>
            <p class="py-4" id="mensajeExito">Tu progreso ha sido guardado exitosamente.</p>
            <div class="modal-action">
                <button class="btn btn-primary-custom" onclick="modalExito.close()">Continuar</button>
            </div>
        </div>
    </dialog>
    
    <!-- Modal de Error -->
    <dialog id="modalError" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Error al Guardar
            </h3>
            <p class="py-4" id="mensajeError">Ocurrió un error al guardar la configuración. Por favor intenta nuevamente.</p>
            <div class="modal-action">
                <button class="btn" onclick="modalError.close()">Cerrar</button>
            </div>
        </div>
    </dialog>
    
    <!-- Pasar datos PHP a JavaScript -->
    <script>
        window.preguntasData = <?php echo $preguntasJson; ?>;
    </script>
    
    <!-- Cargar script principal -->
    <script src="script.js"></script>
    
</body>
</html>
