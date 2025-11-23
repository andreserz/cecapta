# Especificación: Configuración de Chatbot

## ADDED Requirements

### Requirement: Interfaz Wizard de Configuración
El sistema SHALL proporcionar una interfaz tipo wizard (asistente paso a paso) que permita a los usuarios configurar un chatbot de IA respondiendo preguntas secuenciales.

#### Scenario: Usuario completa configuración exitosamente
- **WHEN** el usuario accede a `/dashboard/`
- **AND** responde las 7 preguntas del wizard secuencialmente
- **AND** hace clic en el botón "Finalizar" en la última pregunta
- **THEN** el sistema guarda la configuración en un archivo JSON
- **AND** muestra un mensaje de confirmación de éxito
- **AND** el archivo se guarda en `./dashboard/respuestas/` con formato `respuestas_YYYY-MM-DD_HH-MM-SS.json`

#### Scenario: Usuario navega entre preguntas
- **WHEN** el usuario está en cualquier pregunta del wizard
- **AND** hace clic en el botón "Siguiente"
- **THEN** el sistema guarda la respuesta actual
- **AND** muestra la siguiente pregunta con animación de transición
- **AND** actualiza el indicador de progreso
- **AND** actualiza el sidebar de pasos (en vista desktop)

#### Scenario: Usuario retrocede a pregunta anterior
- **WHEN** el usuario está en cualquier pregunta excepto la primera
- **AND** hace clic en el botón "Anterior"
- **THEN** el sistema muestra la pregunta anterior
- **AND** recupera la respuesta previamente guardada
- **AND** actualiza el indicador de progreso

### Requirement: Colección de Datos de Configuración
El sistema SHALL recopilar exactamente 7 datos de configuración del chatbot mediante preguntas específicas.

#### Scenario: Recopilar nombre de empresa
- **WHEN** el usuario está en el paso 1
- **THEN** el sistema muestra la pregunta "¿Cuál es el nombre de tu empresa?"
- **AND** proporciona un campo de texto con placeholder "Ej: CallBlaster AI"
- **AND** el campo acepta hasta 200 caracteres

#### Scenario: Recopilar objetivo del chatbot
- **WHEN** el usuario está en el paso 2
- **THEN** el sistema muestra la pregunta "Describe brevemente el objetivo principal de tu chatbot"
- **AND** proporciona un campo textarea con placeholder descriptivo
- **AND** el campo acepta hasta 1000 caracteres

#### Scenario: Recopilar tono de comunicación
- **WHEN** el usuario está en el paso 3
- **THEN** el sistema muestra la pregunta "¿Cuál es el tono de comunicación deseado?"
- **AND** proporciona un campo de selección (dropdown/select)
- **AND** las opciones son: "Formal", "Amigable", "Divertido", "Profesional"

#### Scenario: Recopilar preguntas frecuentes
- **WHEN** el usuario está en el paso 4
- **THEN** el sistema muestra la pregunta "Menciona 3 preguntas frecuentes que debe saber responder"
- **AND** proporciona un campo textarea con placeholder numerado
- **AND** el campo acepta hasta 2000 caracteres

#### Scenario: Recopilar horario de atención
- **WHEN** el usuario está en el paso 5
- **THEN** el sistema muestra la pregunta "¿Cuál es el horario de atención?"
- **AND** proporciona un campo de texto con placeholder "Ej: Lunes a Viernes de 9am a 6pm"
- **AND** el campo acepta hasta 200 caracteres

#### Scenario: Recopilar mensaje de despedida
- **WHEN** el usuario está en el paso 6
- **THEN** el sistema muestra la pregunta "¿Cómo debe despedirse el chatbot?"
- **AND** proporciona un campo de texto con placeholder "Ej: ¡Estoy para servirte!"
- **AND** el campo acepta hasta 300 caracteres

#### Scenario: Recopilar URL del sitio web
- **WHEN** el usuario está en el paso 7 (última pregunta)
- **THEN** el sistema muestra la pregunta "Proporciona la URL de tu página web"
- **AND** proporciona un campo de tipo URL con placeholder "https://ejemplo.com"
- **AND** el campo acepta formato de URL válido
- **AND** el botón cambia de "Siguiente" a "Finalizar"

### Requirement: Validación de Campos
El sistema SHALL validar que todos los campos requeridos contengan información antes de permitir avanzar o finalizar.

#### Scenario: Usuario intenta avanzar con campo vacío
- **WHEN** el usuario deja un campo de respuesta vacío
- **AND** intenta hacer clic en "Siguiente" o "Finalizar"
- **THEN** el sistema muestra un mensaje de error
- **AND** resalta el campo vacío visualmente
- **AND** no avanza al siguiente paso
- **AND** mantiene el foco en el campo actual

#### Scenario: Usuario proporciona URL inválida
- **WHEN** el usuario está en la pregunta de URL (paso 7)
- **AND** ingresa un texto que no es una URL válida
- **AND** intenta hacer clic en "Finalizar"
- **THEN** el sistema muestra un mensaje indicando formato inválido
- **AND** no procede a guardar la configuración

### Requirement: Indicadores de Progreso
El sistema SHALL mostrar claramente el progreso del usuario a través del wizard mediante múltiples indicadores visuales.

#### Scenario: Mostrar barra de progreso
- **WHEN** el usuario está en cualquier paso del wizard
- **THEN** el sistema muestra una barra de progreso visual en la parte superior
- **AND** la barra indica el porcentaje completado (ej: 3/7 = 42.8%)
- **AND** la barra usa el color de acento naranja (#F97316)
- **AND** la barra se actualiza con animación al cambiar de paso

#### Scenario: Mostrar indicador textual de paso
- **WHEN** el usuario está en cualquier paso del wizard
- **THEN** el sistema muestra texto "Paso X de 7" donde X es el número actual
- **AND** el indicador se actualiza al navegar entre pasos

#### Scenario: Mostrar sidebar de pasos (desktop)
- **WHEN** el usuario accede desde un dispositivo desktop (≥1024px)
- **THEN** el sistema muestra un sidebar lateral (30% ancho) con lista de todos los pasos
- **AND** el paso actual está resaltado con color naranja
- **AND** los pasos completados muestran un icono de check verde
- **AND** los pasos pendientes están en color gris

### Requirement: Diseño Responsive Sin Scroll
El sistema SHALL proporcionar una interfaz adaptativa que funcione en diferentes tamaños de pantalla sin requerir desplazamiento vertical u horizontal.

#### Scenario: Vista móvil (< 768px)
- **WHEN** el usuario accede desde un dispositivo móvil
- **THEN** el sistema muestra un layout de una sola columna
- **AND** el contenido se centra verticalmente
- **AND** todos los elementos son visibles sin scroll
- **AND** no se muestra el sidebar de pasos
- **AND** los botones de navegación están en la parte inferior

#### Scenario: Vista desktop (≥ 1024px)
- **WHEN** el usuario accede desde un dispositivo desktop
- **THEN** el sistema muestra un layout de dos columnas
- **AND** la columna izquierda (30%) contiene el sidebar de pasos
- **AND** la columna derecha (70%) contiene la pregunta y controles
- **AND** todo el contenido es visible sin scroll

#### Scenario: Vista tablet (768px - 1023px)
- **WHEN** el usuario accede desde una tablet
- **THEN** el sistema adapta el diseño móvil
- **AND** aumenta el tamaño de fuentes y botones proporcionalmente
- **AND** mantiene el principio de sin scroll

### Requirement: Tema Visual Oscuro
El sistema SHALL implementar un tema visual oscuro con paleta de colores corporativa.

#### Scenario: Aplicar tema oscuro
- **WHEN** el usuario accede a la interfaz
- **THEN** el sistema usa fondo oscuro (#111827)
- **AND** el texto primario es claro (#F9FAFB)
- **AND** los botones de acción principal usan naranja (#F97316)
- **AND** los estados hover usan naranja más oscuro (#EA580C)
- **AND** la fuente es sans-serif moderna (Inter o Manrope)

### Requirement: Guardado de Configuración
El sistema SHALL guardar la configuración completada en un archivo JSON estructurado en el servidor.

#### Scenario: Guardar configuración con timestamp
- **WHEN** el usuario completa todas las preguntas
- **AND** hace clic en "Finalizar"
- **THEN** el sistema envía una petición POST a `guardar.php`
- **AND** el servidor crea un archivo JSON con formato `respuestas_YYYY-MM-DD_HH-MM-SS.json`
- **AND** el archivo incluye la clave `fecha_guardado` con timestamp ISO
- **AND** el archivo incluye todas las respuestas del usuario
- **AND** el archivo se guarda en `./dashboard/respuestas/`
- **AND** el servidor retorna respuesta JSON de éxito

#### Scenario: Estructura del archivo JSON guardado
- **WHEN** el sistema guarda una configuración
- **THEN** el archivo JSON contiene un objeto raíz
- **AND** el objeto tiene la propiedad `fecha_guardado` con formato "YYYY-MM-DD HH:MM:SS"
- **AND** el objeto tiene la propiedad `respuestas` con un objeto anidado
- **AND** el objeto `respuestas` contiene las 7 claves correspondientes a las preguntas
- **AND** el JSON está formateado con indentación (`JSON_PRETTY_PRINT`)

#### Scenario: Manejo de errores de guardado
- **WHEN** el sistema intenta guardar la configuración
- **AND** ocurre un error (permisos, disco lleno, etc.)
- **THEN** el servidor retorna un código HTTP 500
- **AND** retorna un JSON con la clave `error` describiendo el problema
- **AND** el frontend muestra un mensaje de error claro al usuario
- **AND** los datos del usuario permanecen en el formulario (no se pierden)

### Requirement: Seguridad de Datos
El sistema SHALL implementar medidas de seguridad básicas para proteger los datos de configuración.

#### Scenario: Sanitizar entradas del usuario
- **WHEN** el backend recibe datos del frontend
- **THEN** el sistema sanitiza todos los strings con `htmlspecialchars()` o `filter_var()`
- **AND** valida que el JSON sea decodificable
- **AND** rechaza peticiones con datos malformados con código HTTP 400

#### Scenario: Prevenir acceso directo a archivos JSON
- **WHEN** un usuario intenta acceder directamente a una URL como `/dashboard/respuestas/respuestas_2025-10-20_06-30-15.json`
- **THEN** el servidor retorna un error 403 Forbidden
- **AND** no permite descargar el archivo
- **AND** existe un archivo `.htaccess` en el directorio `respuestas/` que deniega acceso

#### Scenario: Validar tipo de petición HTTP
- **WHEN** alguien intenta acceder a `guardar.php` con método GET
- **THEN** el servidor retorna error 405 Method Not Allowed
- **AND** solo acepta peticiones POST

### Requirement: Experiencia de Usuario Optimizada
El sistema SHALL proporcionar feedback visual y micro-interacciones para mejorar la experiencia del usuario.

#### Scenario: Transiciones suaves entre preguntas
- **WHEN** el usuario navega entre preguntas
- **THEN** el sistema aplica una transición de fade (0.3 segundos)
- **AND** la nueva pregunta aparece con animación sutil

#### Scenario: Enfoque automático en campo de entrada
- **WHEN** una nueva pregunta es mostrada
- **THEN** el sistema automáticamente enfoca (focus) el campo de entrada
- **AND** el cursor está listo para que el usuario empiece a escribir

#### Scenario: Indicador de carga durante guardado
- **WHEN** el usuario hace clic en "Finalizar"
- **AND** la petición se está procesando
- **THEN** el sistema muestra un indicador de carga (spinner o similar)
- **AND** deshabilita el botón "Finalizar" para prevenir clicks múltiples
- **AND** muestra texto "Guardando configuración..."

#### Scenario: Mensaje de confirmación exitosa
- **WHEN** la configuración se guarda exitosamente
- **THEN** el sistema muestra un mensaje de éxito prominente
- **AND** el mensaje incluye el nombre del archivo guardado
- **AND** el mensaje permanece visible por al menos 3 segundos
- **AND** opcionalmente ofrece un botón para "Crear nueva configuración"

### Requirement: Navegación con Teclado
El sistema SHALL permitir navegación básica mediante teclado para mejorar accesibilidad.

#### Scenario: Avanzar con tecla Enter
- **WHEN** el usuario está en un campo de texto (no textarea)
- **AND** presiona la tecla Enter
- **THEN** el sistema ejecuta la acción de "Siguiente" o "Finalizar"
- **AND** guarda la respuesta actual
- **AND** avanza al siguiente paso

#### Scenario: Tab entre elementos
- **WHEN** el usuario presiona Tab
- **THEN** el sistema mueve el foco al siguiente elemento interactivo
- **AND** mantiene un orden lógico de navegación (pregunta → campo → botones)
- **AND** los elementos focuseados tienen un outline visible

### Requirement: Compatibilidad de Navegadores
El sistema SHALL funcionar correctamente en navegadores modernos principales.

#### Scenario: Funcionar en navegadores principales
- **WHEN** el usuario accede desde Chrome (últimas 2 versiones)
- **OR** Firefox (últimas 2 versiones)
- **OR** Safari (últimas 2 versiones)
- **OR** Edge (últimas 2 versiones)
- **THEN** todas las funcionalidades del wizard operan correctamente
- **AND** el diseño se renderiza como esperado
- **AND** no hay errores en la consola del navegador

### Requirement: Carga de Dependencias Externas
El sistema SHALL cargar correctamente las dependencias CSS y fuentes desde CDN.

#### Scenario: Cargar Tailwind CSS desde CDN
- **WHEN** la página se carga
- **THEN** el sistema carga Tailwind CSS desde jsDelivr o unpkg CDN
- **AND** aplica los estilos utility correctamente
- **AND** el tema oscuro se activa correctamente

#### Scenario: Cargar daisyUI desde CDN
- **WHEN** la página se carga
- **THEN** el sistema carga daisyUI desde CDN
- **AND** los componentes (botones, progress, etc.) se estilizan correctamente
- **AND** el tema "night" está configurado

#### Scenario: Cargar fuente desde Google Fonts
- **WHEN** la página se carga
- **THEN** el sistema carga la fuente Inter o Manrope desde Google Fonts
- **AND** aplica la fuente a todos los elementos de texto
- **AND** usa fallback sans-serif si Google Fonts falla

### Requirement: Configuración del Servidor
El sistema SHALL proporcionar instrucciones claras para la configuración del entorno de servidor.

#### Scenario: Permisos de directorio respuestas
- **WHEN** el sistema está desplegado en el servidor
- **THEN** el directorio `./dashboard/respuestas/` tiene permisos 755 o 775
- **AND** el usuario del servidor web (www-data, nginx, etc.) tiene permisos de escritura
- **AND** el directorio existe antes de intentar guardar archivos

#### Scenario: Configuración de Nginx/PHP
- **WHEN** el sistema está desplegado
- **THEN** Nginx está configurado para procesar archivos PHP en la ruta `/dashboard/`
- **AND** PHP tiene habilitado `file_put_contents()`
- **AND** PHP tiene configurado `post_max_size` suficiente (al menos 2MB)
- **AND** PHP tiene habilitado `json_encode()` y `json_decode()`
