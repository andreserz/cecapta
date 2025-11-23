# Sistema de Diseño Unificado - Guía Rápida

## 🎯 Objetivo

Extraer el sistema de diseño exitoso de `./requerimientos/` y aplicarlo consistentemente a `./api_tests/` y `./main/` para crear una experiencia visual coherente en todo el proyecto CECAPTA CallBlaster AI.

## 🎨 Elementos del Sistema de Diseño

### Paleta de Colores Corporativa
```css
--naranja-primario: #F97316   /* Primario, botones, acentos */
--naranja-hover: #EA580C       /* Estados hover */
--naranja-claro: #FDBA74       /* Acentos secundarios */
--fondo-oscuro: #111827        /* Fondos tema oscuro */
--completado: #10B981          /* Estados de éxito */
--error: #EF4444               /* Estados de error */
--warning: #F59E0B             /* Advertencias */
```

### Framework y Herramientas
- **DaisyUI**: 4.4.19 (componentes UI)
- **Tailwind CSS**: Última versión CDN (utilidades)
- **Fuentes**: Inter (cargada localmente desde `/shared/fonts/inter/`)
- **Temas**: 
  - `data-theme="night"` para apps (api_tests, requerimientos)
  - `data-theme="light"` para landing (main) con paleta corporativa

### Componentes Reutilizables
- Botones: `.btn-primary-custom`
- Cards: `.card` con tema corporativo
- Inputs: `.input-bordered`
- Modals: `<dialog class="modal">`
- Progress bars: `.progress-custom`
- Animaciones: `.fade-enter`, `.float-animation`

## 📂 Estructura de Archivos

```
shared/
├── design-system/
│   ├── colors.md           # Documentación de paleta
│   ├── components.md       # Catálogo de componentes
│   ├── typography.md       # Guía de tipografía
│   ├── patterns.md         # Patrones UI comunes
│   ├── theme-config.css    # Variables CSS corporativas
│   └── daisyui-config.js   # Configuración DaisyUI
└── fonts/
    └── inter/
        ├── inter-local.css
        └── *.woff2 files
```

## 🎯 Módulos Afectados

### 1. ./api_tests/ (Interfaz de Pruebas API)
**Cambios**:
- ✅ Implementar tema oscuro (`data-theme="night"`)
- ✅ Migrar a DaisyUI 4.4.19
- ✅ Aplicar paleta naranja corporativa
- ✅ Usar fuentes Inter locales
- ✅ Refactorizar componentes (login, cards, modals)

**Tiempo estimado**: 4-6 horas

### 2. ./main/ (Landing Page)
**Cambios**:
- ✅ Actualizar paleta de azul a naranja (#3d4f6d → #F97316)
- ✅ Reemplazar Google Fonts por Inter local
- ✅ Mantener tema claro pero con colores corporativos
- ✅ Actualizar gradientes y animaciones
- ✅ Refactorizar navbar, hero, cards, timeline

**Tiempo estimado**: 6-8 horas

### 3. ./requerimientos/ (Wizard de Configuración)
**Cambios**:
- ✅ Sin cambios (es la fuente del sistema de diseño)
- ✅ Servir como referencia de implementación

## 📋 Fases de Implementación

### Fase 1: Setup (2-3 horas)
1. Crear directorio `shared/`
2. Copiar fuentes Inter a `shared/fonts/inter/`
3. Crear documentación en `shared/design-system/`
4. Extraer snippets de componentes
5. Crear `theme-config.css` con variables

### Fase 2: Migrar api_tests (4-6 horas)
1. Agregar DaisyUI + Tailwind CDN
2. Agregar fuentes Inter locales
3. Aplicar `data-theme="night"`
4. Refactorizar login card
5. Refactorizar lista de pruebas
6. Actualizar modals de resultados
7. Testing completo

### Fase 3: Migrar main (6-8 horas)
1. Actualizar Tailwind config (colores)
2. Reemplazar Google Fonts por Inter local
3. Refactorizar navbar
4. Refactorizar hero section
5. Refactorizar cards de servicios
6. Refactorizar timeline
7. Actualizar CSS custom
8. Testing completo

### Fase 4: Documentación (2-3 horas)
1. Crear `DESIGN_SYSTEM.md` en raíz
2. Documentar guías de uso
3. Crear ejemplos de código
4. Screenshots antes/después
5. Validación final de consistencia

**Tiempo Total**: 14-20 horas

## 🚀 Cómo Usar Este Sistema

### Para Nuevos Componentes

1. **Incluir DaisyUI y Tailwind**:
```html
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.19/dist/full.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
```

2. **Incluir Fuentes Inter**:
```html
<link href="/shared/fonts/inter/inter-local.css" rel="stylesheet">
```

3. **Establecer Tema**:
```html
<html data-theme="night"> <!-- para apps -->
<html data-theme="light"> <!-- para landing -->
```

4. **Agregar Variables Corporativas**:
```html
<style>
:root {
  --naranja-primario: #F97316;
  --naranja-hover: #EA580C;
  --naranja-claro: #FDBA74;
  --fondo-oscuro: #111827;
  --completado: #10B981;
}
.btn-primary-custom {
  background-color: var(--naranja-primario);
  border-color: var(--naranja-primario);
}
.btn-primary-custom:hover {
  background-color: var(--naranja-hover);
}
</style>
```

5. **Usar Componentes DaisyUI**:
```html
<!-- Botón -->
<button class="btn btn-primary-custom">Acción</button>

<!-- Card -->
<div class="card bg-base-100 shadow-xl">
  <div class="card-body">
    <h2 class="card-title">Título</h2>
    <p>Contenido</p>
  </div>
</div>

<!-- Modal -->
<dialog id="myModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Título</h3>
    <p class="py-4">Contenido</p>
  </div>
</dialog>
```

## 📚 Referencias

### Documentos de Propuesta
- **Propuesta**: `openspec/changes/add-design-system-unification/proposal.md`
- **Diseño Técnico**: `openspec/changes/add-design-system-unification/design.md`
- **Tareas**: `openspec/changes/add-design-system-unification/tasks.md`

### Especificaciones
- **Frontend UI**: `openspec/changes/add-design-system-unification/specs/frontend-ui/spec.md`
- **API Tests**: `openspec/changes/add-design-system-unification/specs/api-tests-interface/spec.md`
- **Landing Page**: `openspec/changes/add-design-system-unification/specs/landing-page/spec.md`

### Referencias Externas
- [DaisyUI Documentation](https://daisyui.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Inter Font Family](https://rsms.me/inter/)

## ✅ Criterios de Éxito

- [ ] Todos los módulos usan DaisyUI 4.4.19
- [ ] Todos los módulos usan paleta naranja corporativa
- [ ] Todos los módulos usan fuentes Inter locales
- [ ] Consistencia visual >90% entre módulos
- [ ] Funcionalidad preservada al 100%
- [ ] Performance mantenida o mejorada
- [ ] Accesibilidad WCAG AA cumplida
- [ ] Documentación completa del sistema

## 🔍 Comandos Útiles

```bash
# Ver propuesta completa
openspec show add-design-system-unification

# Ver diferencias en specs
openspec diff add-design-system-unification

# Validar propuesta
openspec validate add-design-system-unification --strict

# Listar todas las propuestas
openspec list
```

## 💡 Notas Importantes

1. **No Romper Funcionalidad**: Los cambios son solo visuales, no afectan lógica
2. **Testing Exhaustivo**: Probar cada módulo después de cambios
3. **Incremental**: Implementar fase por fase, no todo a la vez
4. **Accesibilidad**: Validar contraste y navegación por teclado
5. **Performance**: Monitorear con Lighthouse antes/después

---

**Creado**: 2025-10-20  
**Estado**: Propuesta - Pendiente Aprobación  
**Contacto**: Revisar con equipo CECAPTA antes de implementar
