# Propuesta: Botón "Guardar para después" Visible en Todas las Preguntas

## Por Qué

Actualmente, el botón "Guardar para después" solo aparece al final del formulario junto con "Finalizar y enviar". Los usuarios pueden necesitar guardar sus avances en cualquier momento mientras completan el cuestionario, especialmente si:

- El proceso toma mucho tiempo y necesitan pausar
- Quieren asegurar sus respuestas antes de continuar
- Tienen interrupciones durante el llenado del formulario
- Desean tener checkpoints de progreso

Mantener el botón visible en todas las preguntas permite mayor flexibilidad y reduce el riesgo de pérdida de datos.

## Qué Cambia

- Hacer el botón "Guardar para después" visible en todas las preguntas del formulario
- Mantener el comportamiento actual: crear backup sin enviar correo
- El botón debe estar siempre accesible, independientemente de la pregunta actual
- Posición fija o visible en la barra de navegación del wizard

## Impacto

- **Archivos afectados:**
  - `requerimientos/index.php` - Agregar botón en la estructura HTML
  - `requerimientos/style.css` - Estilos para el botón persistente
  - `requerimientos/script.js` - Sin cambios necesarios (funcionalidad ya existe)

- **Comportamiento nuevo:**
  - Botón "Guardar para después" visible en todas las preguntas
  - Usuario puede guardar en cualquier momento
  - Mejora la experiencia de usuario (UX)

- **Sin breaking changes** - La funcionalidad existente se mantiene

## Opciones de Diseño

### Opción 1: Botón Fijo en Footer
Mantener el botón siempre visible en la parte inferior de cada pregunta, junto a los botones de navegación.

**Ventajas:**
- Siempre visible
- Posición consistente
- Fácil acceso

**Desventajas:**
- Puede ocupar espacio visual

### Opción 2: Botón Flotante
Botón flotante en esquina inferior derecha, siempre visible sobre el contenido.

**Ventajas:**
- No interfiere con el diseño
- Siempre accesible
- Moderno y discreto

**Desventajas:**
- Puede tapar contenido en pantallas pequeñas

### Opción 3: En Barra de Progreso (Recomendado)
Integrar el botón en la barra de progreso superior, junto al indicador de pregunta actual.

**Ventajas:**
- Aprovecha espacio existente
- No duplica elementos de navegación
- Mantiene UI limpia
- Contexto visual claro

**Desventajas:**
- Requiere ajuste de layout en la barra

## Consideraciones UX

- **Feedback Visual:** Mostrar mensaje de confirmación temporal al guardar
- **Estado de Carga:** Indicador mientras se guarda (spinner o texto)
- **Acceso Rápido:** Shortcut de teclado opcional (ej: Ctrl+S)
- **Mobile-Friendly:** Botón accesible en dispositivos móviles

## Seguridad

- Mantener las validaciones existentes
- Sanitización de datos igual que en el flujo actual
- Permisos de archivos consistentes
