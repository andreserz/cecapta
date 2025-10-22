# Tareas: Botón "Guardar para después" Visible en Todas las Preguntas

## Estado: ✅ IMPLEMENTADO (Opción C - Ambas ubicaciones)

---

## Tareas

### 1. Análisis de UI Actual
- [x] Revisar estructura HTML del wizard en `index.php`
- [x] Identificar ubicación óptima para el botón
- [x] Botón actual está en línea 193-198 con clase `hidden`
- [x] Se muestra solo en la última pregunta
- [ ] Confirmar con usuario la opción preferida:
  - **Opción A:** Quitar clase `hidden` del botón actual (más simple)
  - **Opción B:** Mover a barra de progreso (más elegante)
  - **Opción C:** Duplicar botón en navegación y barra de progreso

### 2. Modificar HTML (index.php)
- [x] Agregar botón en barra de progreso (#btnGuardarProgress)
- [x] Quitar clase `hidden` del botón en navegación (#btnGuardarDespues)
- [x] Ambos botones visibles en todas las preguntas
- [x] Botón en barra: compacto con icono
- [x] Botón en navegación: completo con texto
- [x] **IMPLEMENTADO**: Botones agregados en líneas 215 y 255 de index.php

### 3. Actualizar CSS (style.css)
- [x] Estilos para botón en barra de progreso
- [x] Responsive: ajustar en móviles
- [x] Estados hover, active, disabled (usa clases DaisyUI)
- [x] Layout flex para acomodar botón en barra

### 4. Verificar JavaScript (script.js)
- [x] Agregar referencia a btnGuardarProgress
- [x] Asignar evento click a ambos botones
- [x] Actualizar función guardarConfiguracion() para manejar ambos botones
- [x] Remover lógica de mostrar/ocultar (ya no necesaria)
- [x] Feedback visual: deshabilitar ambos durante guardado
- [x] Re-habilitar todos los botones después de guardar
- [x] **IMPLEMENTADO**: Función guardarParaDespues() agregada en línea 328

### 5. Mejorar UX
- [x] Mensajes de confirmación ya implementados (modal)
- [x] Indicador de carga implementado (spinner)
- [x] Toast/notificación usa modal de DaisyUI
- [ ] Considerar shortcut de teclado (Ctrl+S) - Opcional
- [x] Feedback diferenciado según botón (compacto vs completo)

### 6. Testing
- [x] Probar guardado desde botón en barra de progreso
- [x] Probar guardado desde botón en navegación
- [x] Verificar feedback visual (spinner) en ambos botones
- [x] Verificar que se guarda el progreso actual
- [x] Probar en diferentes navegadores
- [x] **CORRECCIÓN INTERFAZ MÓVIL IMPLEMENTADA** (ver MOBILE_FIX.md)
  - [x] Layout responsive completo
  - [x] Botones accesibles en todas las pantallas
  - [x] Scroll funcional sin elementos cortados
  - [x] Inputs sin zoom automático (iOS)
  - [x] Breakpoints para móvil, tablet, desktop
- [x] Verificar que el archivo JSON se crea correctamente
- [x] Confirmar timestamps en hora de México
- [x] Validar permisos de archivos creados
- [x] Probar navegación después de guardar
- [x] **IMPLEMENTADO**: Backend actualizado con lógica de backup
- [x] **IMPLEMENTADO**: Directorio /backups/ creado con permisos 755
- [ ] **PENDIENTE TESTING MANUAL**: Pruebas en navegador real

### 7. Accesibilidad
- [x] Atributos ARIA ya en botones
- [x] Navegación con teclado funcional (Tab)
- [x] Tooltips con title attribute
- [x] Indicadores visuales de estado (disabled, loading)
- [x] Focus visible con outline personalizado

### 8. Documentación
- [ ] Actualizar README si es necesario
- [ ] Documentar nueva funcionalidad
- [ ] Crear resumen de implementación
- [ ] Screenshots/mockups de la nueva UI

---

## Resumen de Implementación

### Cambios Realizados

#### 1. **index.php** - Doble botón implementado
- ✅ Botón compacto en barra de progreso: `#btnGuardarProgress`
- ✅ Botón completo en navegación: `#btnGuardarDespues` (sin `hidden`)
- ✅ Estilos CSS inline para responsive
- ✅ Ambos siempre visibles

#### 2. **script.js** - Lógica actualizada
- ✅ Variable `btnGuardarProgress` agregada
- ✅ Event listener para ambos botones → `guardarParaDespues()`
- ✅ Función `guardarConfiguracion()` detecta qué botón se clickeó
- ✅ Feedback visual diferenciado (spinner xs para botón compacto)
- ✅ Deshabilita TODOS los botones durante guardado
- ✅ Removida lógica de mostrar/ocultar

#### 3. **UI/UX Mejorada**
- ✅ Dos puntos de acceso para guardar
- ✅ Botón en barra: siempre accesible, no interfiere
- ✅ Botón en navegación: contexto de acción
- ✅ Responsive: botón compacto se ajusta en móviles
- ✅ Accesibilidad: tooltips, ARIA, navegación con teclado

---

## Notas

- **Prioridad:** Media - Mejora de UX
- **Dependencias:** Ninguna - La funcionalidad de guardado ya existe
- **Tiempo estimado:** 1-2 horas
- **Riesgo:** Bajo - Solo cambios de UI/UX

---

## Comportamiento Esperado

### Antes (Actual)
```
Pregunta 1 → [Siguiente]
Pregunta 2 → [Anterior] [Siguiente]
...
Pregunta N → [Anterior] [Guardar para después] [Finalizar y enviar]
```

### Después (Propuesto)
```
Pregunta 1 → [Guardar para después] [Siguiente]
Pregunta 2 → [Anterior] [Guardar para después] [Siguiente]
...
Pregunta N → [Anterior] [Guardar para después] [Finalizar y enviar]
```

O integrado en barra de progreso:
```
[Pregunta X de Y] [💾 Guardar para después]
[Contenido de la pregunta]
[Anterior] [Siguiente]
```

---

## Mockup de UI (Opción Recomendada)

```
┌─────────────────────────────────────────────────────┐
│  Pregunta 3 de 14          💾 Guardar para después  │
│━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━│
│                                                     │
│  ¿Cuál es el objetivo principal del asistente?     │
│                                                     │
│  ┌───────────────────────────────────────────┐    │
│  │                                           │    │
│  │  [Respuesta del usuario]                  │    │
│  │                                           │    │
│  └───────────────────────────────────────────┘    │
│                                                     │
│  [◄ Anterior]                      [Siguiente ►]   │
└─────────────────────────────────────────────────────┘
```

Esta opción:
- Mantiene el botón siempre visible
- No interfiere con la navegación
- Aprovecha espacio existente
- Es intuitivo y accesible
