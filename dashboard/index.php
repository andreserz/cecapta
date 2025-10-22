<?php
declare(strict_types=1);

// Array de preguntas del wizard
$preguntas = [
    [
        "titulo" => "¿Cuál es el nombre de tu empresa?",
        "tipo" => "text",
        "placeholder" => "Ej: CallBlaster AI",
        "nombre" => "nombre_empresa",
        "maxlength" => 200,
        "valor_defecto" => "CECAPTA"
    ],
    [
        "titulo" => "Describe brevemente el objetivo principal de tu chatbot",
        "tipo" => "textarea",
        "placeholder" => "Ej: Atender dudas frecuentes de clientes sobre nuestros productos y servicios, proporcionar información sobre horarios y ubicaciones...",
        "nombre" => "objetivo_chatbot",
        "maxlength" => 1000
    ],
    [
        "titulo" => "¿Cuál es el tono de comunicación deseado?",
        "tipo" => "select",
        "placeholder" => "Selecciona una opción",
        "nombre" => "tono_comunicacion",
        "opciones" => ["Formal", "Amigable", "Divertido", "Profesional"]
    ],
    [
        "titulo" => "Menciona 3 preguntas frecuentes que debe saber responder",
        "tipo" => "textarea",
        "placeholder" => "1. ¿Cuáles son los horarios de atención?\n2. ¿Dónde están ubicados?\n3. ¿Qué servicios ofrecen?",
        "nombre" => "preguntas_frecuentes",
        "maxlength" => 2000
    ],
    [
        "titulo" => "¿Cuál es el horario de atención?",
        "tipo" => "text",
        "placeholder" => "Ej: Lunes a Viernes de 9am a 6pm",
        "nombre" => "horario_atencion",
        "maxlength" => 200
    ],
    [
        "titulo" => "¿Cómo debe despedirse el chatbot?",
        "tipo" => "text",
        "placeholder" => "Ej: ¡Estoy para servirte! ¡Que tengas un excelente día!",
        "nombre" => "mensaje_despedida",
        "maxlength" => 300
    ],
    [
        "titulo" => "Proporciona la URL de tu página web",
        "tipo" => "url",
        "placeholder" => "https://ejemplo.com",
        "nombre" => "url_website",
        "maxlength" => 500
    ]
];

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
            <h1 class="text-xl md:text-4xl lg:text-2xl font-bold text-gray-100">
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
                <div class="flex justify-between items-center mb-2">
                    <span id="progressText" class="text-sm font-medium text-gray-400">Paso 1 de 7</span>
                    <span id="progressPercent" class="text-sm font-medium text-orange-500">14%</span>
                </div>
                <progress id="progressBar" class="progress progress-custom w-full" value="14" max="100"></progress>
            </div>
            
            <!-- Card de Pregunta -->
            <div class="flex-1 bg-gray-800 rounded-lg p-8 flex flex-col justify-between">
                
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
                <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-700">
                    <button id="btnAnterior" class="btn btn-outline btn-disabled" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Anterior
                    </button>
                    
                    <button id="btnSiguiente" class="btn btn-primary-custom">
                        Siguiente
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
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
                ¡Configuración Guardada!
            </h3>
            <p class="py-4" id="mensajeExito">Tu configuración ha sido guardada exitosamente.</p>
            <div class="modal-action">
                <button class="btn btn-primary-custom" onclick="window.location.reload()">Crear Nueva Configuración</button>
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
