# Tareas de Implementación: Asistente de Configuración de Chatbot

## 1. Preparación del Entorno
- [ ] 1.1 Crear directorio `./dashboard/`
- [ ] 1.2 Crear subdirectorio `./dashboard/respuestas/`
- [ ] 1.3 Configurar permisos de escritura en `./dashboard/respuestas/` (chmod 755 o según servidor)
- [ ] 1.4 Verificar que PHP esté habilitado en Nginx para el directorio

## 2. Implementación del Frontend

### 2.1 Estructura HTML (index.php)
- [ ] 2.1.1 Crear estructura base HTML5 con DOCTYPE y meta tags
- [ ] 2.1.2 Enlazar Tailwind CSS vía CDN (última versión)
- [ ] 2.1.3 Enlazar daisyUI vía CDN (última versión)
- [ ] 2.1.4 Importar Google Fonts (Inter o Manrope)
- [ ] 2.1.5 Configurar tema oscuro en elemento HTML (`data-theme="night"`)
- [ ] 2.1.6 Crear contenedor principal con diseño centrado y sin scroll

### 2.2 Componentes UI
- [ ] 2.2.1 Implementar barra de progreso superior
- [ ] 2.2.2 Crear indicador de "Paso X de N"
- [ ] 2.2.3 Diseñar área de pregunta central con título y campo de entrada
- [ ] 2.2.4 Implementar botones de navegación (Anterior/Siguiente/Finalizar)
- [ ] 2.2.5 Crear sidebar de pasos para vista desktop (lista vertical de pasos)
- [ ] 2.2.6 Implementar diseño responsive (mobile-first, luego 2 columnas desktop)
- [ ] 2.2.7 Agregar estados visuales: paso actual, completado, pendiente

### 2.3 Array de Preguntas PHP
- [ ] 2.3.1 Definir array `$preguntas` con las 7 preguntas especificadas
- [ ] 2.3.2 Incluir propiedades: titulo, tipo, placeholder, opciones (para select)
- [ ] 2.3.3 Convertir array a JSON con `json_encode()` para JavaScript
- [ ] 2.3.4 Inyectar JSON en script inline o variable global

## 3. Implementación de JavaScript (script.js)

### 3.1 Estado y Variables
- [ ] 3.1.1 Declarar variable `preguntas` desde PHP
- [ ] 3.1.2 Inicializar `preguntaActualIndex = 0`
- [ ] 3.1.3 Crear array `respuestasUsuario` para almacenar respuestas
- [ ] 3.1.4 Declarar referencias a elementos DOM principales

### 3.2 Funciones de Renderizado
- [ ] 3.2.1 Implementar `mostrarPregunta(index)` para renderizar pregunta actual
- [ ] 3.2.2 Crear función para actualizar barra de progreso
- [ ] 3.2.3 Implementar función para actualizar indicador "Paso X de N"
- [ ] 3.2.4 Crear función para renderizar sidebar de pasos (desktop)
- [ ] 3.2.5 Implementar lógica para cambiar campos según tipo (text, textarea, select, url)

### 3.3 Navegación
- [ ] 3.3.1 Implementar handler de botón "Siguiente"
- [ ] 3.3.2 Implementar handler de botón "Anterior"
- [ ] 3.3.3 Agregar validación básica antes de avanzar (campo no vacío)
- [ ] 3.3.4 Guardar respuesta en `respuestasUsuario[index]` al navegar
- [ ] 3.3.5 Deshabilitar botón "Anterior" en primera pregunta
- [ ] 3.3.6 Cambiar botón "Siguiente" a "Finalizar" en última pregunta

### 3.4 Guardado de Datos
- [ ] 3.4.1 Implementar función `finalizarConfiguracion()`
- [ ] 3.4.2 Preparar objeto con todas las respuestas
- [ ] 3.4.3 Usar `fetch()` para enviar POST a `guardar.php`
- [ ] 3.4.4 Configurar headers: `Content-Type: application/json`
- [ ] 3.4.5 Convertir datos a JSON con `JSON.stringify()`
- [ ] 3.4.6 Manejar respuesta del servidor (then/catch)
- [ ] 3.4.7 Mostrar mensaje de éxito al usuario
- [ ] 3.4.8 Mostrar mensaje de error si falla guardado
- [ ] 3.4.9 Opcional: Limpiar formulario o redirigir tras éxito

### 3.5 Mejoras UX
- [ ] 3.5.1 Agregar transiciones suaves entre preguntas (CSS transitions)
- [ ] 3.5.2 Implementar enfoque automático en campo de entrada al cambiar pregunta
- [ ] 3.5.3 Permitir navegación con Enter (siguiente) y Shift+Enter (anterior)
- [ ] 3.5.4 Agregar indicadores de carga durante guardado

## 4. Implementación del Backend (guardar.php)

### 4.1 Recepción de Datos
- [ ] 4.1.1 Leer cuerpo de la petición con `file_get_contents('php://input')`
- [ ] 4.1.2 Decodificar JSON a array PHP con `json_decode()`
- [ ] 4.1.3 Validar que los datos sean válidos (no null, estructura correcta)
- [ ] 4.1.4 Sanitizar inputs para seguridad

### 4.2 Preparación de Datos
- [ ] 4.2.1 Crear array final con clave `fecha_guardado`
- [ ] 4.2.2 Agregar timestamp con formato legible: `date('Y-m-d H:i:s')`
- [ ] 4.2.3 Incluir las respuestas del usuario en el array
- [ ] 4.2.4 Convertir array a JSON con `JSON_PRETTY_PRINT`

### 4.3 Guardado de Archivo
- [ ] 4.3.1 Generar nombre único: `respuestas_YYYY-MM-DD_HH-MM-SS.json`
- [ ] 4.3.2 Construir ruta completa: `./respuestas/` + nombre
- [ ] 4.3.3 Escribir archivo con `file_put_contents()`
- [ ] 4.3.4 Verificar que el guardado fue exitoso
- [ ] 4.3.5 Manejar errores de escritura (permisos, disco lleno, etc.)

### 4.4 Respuesta al Cliente
- [ ] 4.4.1 Configurar header `Content-Type: application/json`
- [ ] 4.4.2 Retornar JSON de éxito con nombre de archivo guardado
- [ ] 4.4.3 Retornar JSON de error con mensaje descriptivo si falla
- [ ] 4.4.4 Usar código HTTP apropiado (200, 400, 500)

## 5. Estilos CSS Personalizados

- [ ] 5.1 Aplicar paleta de colores personalizada (naranja #F97316)
- [ ] 5.2 Estilizar tema oscuro con fondo #111827
- [ ] 5.3 Crear estilos para barra de progreso con color de acento
- [ ] 5.4 Estilizar botones con colores corporativos
- [ ] 5.5 Agregar estados hover y focus consistentes
- [ ] 5.6 Implementar transiciones suaves (0.3s ease)
- [ ] 5.7 Asegurar que no haya scroll (overflow-hidden en body)

## 6. Testing y Validación

### 6.1 Testing Frontend
- [ ] 6.1.1 Probar navegación hacia adelante y atrás
- [ ] 6.1.2 Verificar validación de campos vacíos
- [ ] 6.1.3 Probar select con todas las opciones
- [ ] 6.1.4 Verificar que textarea permita múltiples líneas
- [ ] 6.1.5 Probar campo URL con formato válido
- [ ] 6.1.6 Verificar responsive en móvil (320px+)
- [ ] 6.1.7 Verificar responsive en tablet (768px+)
- [ ] 6.1.8 Verificar responsive en desktop (1024px+)
- [ ] 6.1.9 Probar en diferentes navegadores (Chrome, Firefox, Safari)

### 6.2 Testing Backend
- [ ] 6.2.1 Verificar que guardar.php recibe datos correctamente
- [ ] 6.2.2 Probar generación de nombres de archivo únicos
- [ ] 6.2.3 Verificar formato JSON guardado (válido y legible)
- [ ] 6.2.4 Probar con datos especiales (caracteres UTF-8, comillas, etc.)
- [ ] 6.2.5 Verificar manejo de errores (permisos, directorio no existe)
- [ ] 6.2.6 Probar límite de tamaño de datos

### 6.3 Testing de Seguridad
- [ ] 6.3.1 Verificar sanitización de inputs
- [ ] 6.3.2 Probar inyección de HTML/JavaScript en campos
- [ ] 6.3.3 Verificar que archivos JSON no sean accesibles vía URL directa
- [ ] 6.3.4 Probar límites de tamaño de petición
- [ ] 6.3.5 Verificar que solo se acepten peticiones POST

## 7. Documentación

- [ ] 7.1 Agregar comentarios clave en index.php
- [ ] 7.2 Documentar funciones principales en script.js
- [ ] 7.3 Comentar lógica de guardado en guardar.php
- [ ] 7.4 Crear README.md en ./dashboard/ con instrucciones de uso
- [ ] 7.5 Documentar requisitos de permisos del servidor
- [ ] 7.6 Documentar estructura del JSON guardado

## 8. Despliegue

- [ ] 8.1 Subir archivos al servidor VPS
- [ ] 8.2 Verificar permisos de ./dashboard/respuestas/ (755 o 775)
- [ ] 8.3 Verificar que PHP tenga permisos de escritura
- [ ] 8.4 Probar acceso vía navegador
- [ ] 8.5 Verificar que CDNs carguen correctamente (Tailwind, daisyUI, Google Fonts)
- [ ] 8.6 Realizar prueba end-to-end en producción
- [ ] 8.7 Configurar backup automático de ./dashboard/respuestas/

## 9. Post-Implementación

- [ ] 9.1 Monitorear logs de error del servidor
- [ ] 9.2 Verificar espacio en disco para archivos JSON
- [ ] 9.3 Considerar implementar limpieza automática de archivos antiguos
- [ ] 9.4 Recopilar feedback de usuarios
- [ ] 9.5 Actualizar esta propuesta con cambios necesarios
