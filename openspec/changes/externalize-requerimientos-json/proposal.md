# Propuesta: Externalizar JSON de Preguntas en Módulo Requerimientos

## Por Qué

El módulo `./requerimientos` (anteriormente `dashboard`) tiene las preguntas del wizard hardcodeadas dentro de `index.php`, lo cual dificulta la edición y mantenimiento. Se requiere externalizar estas preguntas a un archivo JSON para facilitar su gestión y permitir versionamiento con respaldo automático.

## Qué Cambia

- Extraer array PHP de preguntas a archivo JSON externo `requirements.json`
- Implementar sistema de respaldo automático con timestamp
- Agregar botón "Guardar para después" que crea backup sin enviar correo
- Modificar botón "Finalizar y enviar" para crear backup y enviar notificación por correo
- Cargar siempre la última versión del JSON al abrir la página
- Mantener histórico de versiones en carpeta `backups/`

## Impacto

- **Archivos afectados:**
  - `requerimientos/index.php` - Lectura de JSON en lugar de array PHP
  - `requerimientos/guardar.php` - Agregar lógica de backup y envío de correo
  - `requerimientos/script.js` - Agregar nuevo botón y funcionalidad
  - Nuevo: `requerimientos/preguntas/requirements.json`
  - Nuevo directorio: `requerimientos/preguntas/backups/`

- **Comportamiento nuevo:**
  - Sistema de versionamiento automático
  - Notificaciones por correo en entregas finales
  - Dos opciones de guardado (temporal vs final)

- **Sin breaking changes** - La funcionalidad existente se mantiene
