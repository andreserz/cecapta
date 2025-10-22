# Sistema de Diseño CECAPTA CallBlaster AI

## 📚 Visión General

Este documento describe el sistema de diseño unificado implementado en el proyecto CECAPTA CallBlaster AI, basado en DaisyUI 4.4.19, Tailwind CSS y la fuente Inter.

## 🎨 Componentes del Sistema

### 1. Paleta de Colores Corporativa

**Colores Primarios:**
- Naranja Primario: `#F97316`
- Naranja Hover: `#EA580C`
- Naranja Claro: `#FDBA74`

**Fondos:**
- Oscuro Principal: `#111827`
- Oscuro Secundario: `#1F2937`
- Oscuro Terciario: `#374151`

**Estados:**
- Éxito: `#10B981`
- Error: `#EF4444`
- Advertencia: `#F59E0B`

**Documentación:** `/shared/design-system/colors.md`

### 2. Componentes DaisyUI

Componentes estandarizados:
- Botones (.btn-primary-custom)
- Cards (.card con tema oscuro)
- Modales (<dialog class="modal">)
- Formularios (.input-bordered, .select-bordered, .textarea-bordered)
- Progress bars (.progress-custom)
- Badges (badge-success, badge-error, badge-warning)
- Alerts (.alert-success, .alert-error, .alert-info)

**Documentación:** `/shared/design-system/components.md`

### 3. Tipografía Inter

**Fuente:** Inter (cargada localmente)
**Ubicación:** `/shared/fonts/inter/`
**Pesos disponibles:** 400 (Regular), 500 (Medium), 600 (SemiBold), 700 (Bold)

**Documentación:** `/shared/design-system/typography.md`

### 4. Patrones de UI

Patrones reutilizables:
- Layouts (sin scroll, con sidebar, centrado)
- Animaciones (fade-enter, float-animation, pulse-slow)
- Wizard/Stepper
- Hero sections
- Loading states
- Empty states

**Documentación:** `/shared/design-system/patterns.md`

## 📁 Estructura de Archivos

```
shared/
├── design-system/
│   ├── colors.md           # Paleta de colores
│   ├── components.md       # Catálogo de componentes
│   ├── typography.md       # Guía de tipografía
│   ├── patterns.md         # Patrones UI
│   └── theme-config.css    # Variables CSS y estilos
└── fonts/
    └── inter/
        ├── inter-local.css
        ├── inter-400.ttf
        ├── inter-500.ttf
        ├── inter-600.ttf
        └── inter-700.ttf
```

## 🎯 Módulos Implementados

### ✅ ./requerimientos/ (Fuente del diseño)
**Estado:** Completo - sin cambios
- Tema oscuro (data-theme="night")
- DaisyUI 4.4.19
- Paleta naranja corporativa
- Fuentes Inter locales

### ✅ ./api_tests/ (Recién migrado)
**Estado:** Actualizado con diseño corporativo
**Cambios implementados:**
- ✅ Tema oscuro aplicado (data-theme="night")
- ✅ DaisyUI 4.4.19 integrado
- ✅ Paleta naranja corporativa
- ✅ Fuentes Inter locales
- ✅ Componentes refactorizados:
  - Login card con diseño oscuro
  - Header corporativo
  - Botones con clase btn-primary-custom
  - Cards de pruebas con tema oscuro
  - Progress bar corporativo
  - Alerts y badges con colores corporativos
  - Modales con diseño unificado

**Archivos modificados:**
- `/api_tests/public/index.php` - UI principal
- `/api_tests/public/assets/js/pruebas.js` - JavaScript actualizado

### ✅ ./main/ (Completado - Dark Theme)
**Estado:** Migrado completamente a dark theme con diseño corporativo
**Cambios implementados:**
- ✅ Paleta actualizada de azul (#3d4f6d) a naranja (#F97316)
- ✅ Google Fonts reemplazado por Inter local
- ✅ Variables CSS corporativas integradas
- ✅ Todos los componentes actualizados automáticamente
- ✅ **Tema actualizado de light a dark (data-theme="night")**
- ✅ **Fondos oscuros aplicados (bg-gray-900, bg-gray-800)**
- ✅ **Textos claros para contraste (text-gray-100, text-gray-300)**
- ✅ **Glass effect adaptado a dark mode**
- ✅ **Hero gradient actualizado a tonos oscuros**
- ✅ Animaciones y funcionalidad preservadas

**Archivos modificados:**
- `/main/index.html` - Actualizado con dark theme
- `/main/css/styles.css` - Actualizado con dark theme

## 🚀 Cómo Usar el Sistema de Diseño

### 1. Incluir en HTML

```html
<!DOCTYPE html>
<html lang="es" data-theme="night">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Página</title>
    
    <!-- DaisyUI + Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Inter Font Local -->
    <link href="/shared/fonts/inter/inter-local.css" rel="stylesheet" />
    
    <!-- Theme Config -->
    <link href="/shared/design-system/theme-config.css" rel="stylesheet" />
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Contenido aquí -->
</body>
</html>
```

### 2. Usar Componentes

**Botón Primario:**
```html
<button class="btn btn-primary-custom">Acción</button>
```

**Card:**
```html
<div class="card bg-gray-800 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-orange-600">Título</h2>
        <p class="text-gray-300">Contenido</p>
    </div>
</div>
```

**Modal:**
```html
<dialog id="miModal" class="modal">
    <div class="modal-box bg-gray-800">
        <h3 class="font-bold text-lg text-orange-500">Título</h3>
        <p class="py-4 text-gray-300">Contenido</p>
        <div class="modal-action">
            <button class="btn btn-primary-custom">Aceptar</button>
        </div>
    </div>
</dialog>
```

### 3. Aplicar Animaciones

```html
<div class="fade-enter">
    Elemento con animación de entrada
</div>
```

## ✅ Checklist de Implementación

### Fase 1: Setup ✅
- [x] Crear directorio shared/
- [x] Copiar fuentes Inter
- [x] Crear colors.md
- [x] Crear components.md
- [x] Crear typography.md
- [x] Crear patterns.md
- [x] Crear theme-config.css

### Fase 2: api_tests ✅
- [x] Agregar DaisyUI + Tailwind CDN
- [x] Incluir fuentes Inter locales
- [x] Aplicar data-theme="night"
- [x] Refactorizar login form
- [x] Refactorizar header
- [x] Actualizar botones
- [x] Actualizar cards de pruebas
- [x] Actualizar progress bar
- [x] Actualizar modales
- [x] Actualizar JavaScript (pruebas.js)

### Fase 3: main ✅
- [x] Actualizar Tailwind config (colores)
- [x] Reemplazar Google Fonts por Inter local
- [x] Refactorizar navbar
- [x] Refactorizar hero section
- [x] Refactorizar cards de servicios
- [x] Refactorizar timeline
- [x] Actualizar CSS custom

### Fase 4: Documentación
- [x] Crear DESIGN_SYSTEM.md
- [ ] Screenshots antes/después
- [ ] Validación final

## 📊 Métricas de Éxito

- ✅ Todos los módulos usan DaisyUI 4.4.19
- ✅ Todos los módulos usan tema dark (data-theme="night")
- ✅ api_tests usa paleta naranja corporativa y dark theme
- ✅ api_tests usa fuentes Inter locales
- ✅ main usa paleta naranja corporativa y dark theme
- ✅ main usa fuentes Inter locales
- ✅ requerimientos usa dark theme (ya estaba)
- ✅ dashboard usa dark theme (ya estaba)
- ✅ Consistencia visual total entre módulos
- ✅ Documentación completa del sistema
- ⏳ Accesibilidad WCAG AA validada (pendiente testing)

## 🔗 Referencias

- **DaisyUI:** https://daisyui.com/
- **Tailwind CSS:** https://tailwindcss.com/
- **Inter Font:** https://rsms.me/inter/
- **Propuesta OpenSpec (Sistema):** `/openspec/changes/add-design-system-unification/`
- **Propuesta OpenSpec (Dark Theme):** `/openspec/changes/update-main-theme-to-dark/`

## 📝 Notas de Versión

**Versión 1.1 - Octubre 2025**
- ✅ Sistema de diseño creado
- ✅ Módulo api_tests migrado completamente
- ✅ Módulo main migrado completamente a dark theme
- ✅ Consistencia visual total (todos en dark)
- ✅ Documentación completa actualizada
- ✅ Todos los módulos usando diseño corporativo

**Versión 1.0 - Octubre 2025**
- ✅ Sistema de diseño inicial creado
- ✅ Módulo api_tests migrado
- ✅ Módulo main con paleta naranja (light theme)

---

**Mantenido por:** Equipo CECAPTA  
**Última actualización:** 2025-10-21  
**Estado:** Implementación Completada (100% - Dark Theme Unificado)
