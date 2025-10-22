# Propuesta: Actualizar Tema de ./main/ a Dark Mode

## Why

Actualmente el módulo `./main/` utiliza tema light (data-theme="light") mientras que los otros dos módulos del sistema (`./requerimientos/` y `./dashboard/`) utilizan tema dark (data-theme="night"). Esta inconsistencia genera una experiencia de usuario fragmentada al navegar entre diferentes secciones de la aplicación CECAPTA CallBlaster AI.

La unificación del tema dark en todos los módulos es esencial para:
- Mantener consistencia visual en toda la aplicación
- Mejorar la experiencia de usuario
- Seguir el diseño corporativo establecido en DESIGN_SYSTEM.md
- Reducir fatiga visual en usuarios que usan la aplicación por períodos prolongados

## What Changes

- **MODIFIED**: Cambiar tema de `./main/index.html` de "light" a "night" (dark mode)
- **MODIFIED**: Actualizar colores de fondo en `./main/css/styles.css` para tema oscuro
- **MODIFIED**: Ajustar colores de texto para contraste apropiado en tema oscuro
- **MODIFIED**: Actualizar elementos visuales (hero section, cards, navbar) para tema dark
- **MODIFIED**: Mantener paleta naranja corporativa (#F97316) ya implementada

**Elementos clave a modificar:**
- `data-theme="light"` → `data-theme="night"` en HTML
- Fondos claros → fondos oscuros (bg-gray-900, bg-gray-800)
- Textos oscuros → textos claros (text-gray-100, text-gray-300)
- Glass effects y gradientes adaptados a tema oscuro
- Hero gradient actualizado para fondo oscuro

**Elementos a preservar:**
- Paleta naranja corporativa (#F97316, #EA580C, #FDBA74)
- Fuente Inter local
- Componentes DaisyUI 4.4.19
- Animaciones y efectos existentes
- Funcionalidad JavaScript

## Impact

**Módulos afectados:**
- `./main/` - Página principal landing (cambio visual completo a dark)

**Archivos a modificar:**
- `/main/index.html` - Actualizar data-theme y clases de colores
- `/main/css/styles.css` - Ajustar variables CSS y estilos para dark mode

**Beneficios:**
- ✅ Consistencia visual total en la aplicación
- ✅ Mejor experiencia de usuario
- ✅ Reducción de fatiga visual
- ✅ Cumplimiento completo del sistema de diseño corporativo

**Riesgos:**
- ⚠️ Bajo: Algunos elementos pueden requerir ajustes finos de contraste
- ⚠️ Bajo: Testing requerido para validar legibilidad en diferentes pantallas

**Testing requerido:**
- Validar contraste de texto (WCAG AA)
- Verificar legibilidad en diferentes dispositivos
- Confirmar que animaciones funcionan correctamente
- Probar navegación entre módulos para validar consistencia
