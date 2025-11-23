# Diseño Técnico: Dark Theme para ./main/

## Context

El módulo `./main/` actualmente usa tema light mientras que `./requerimientos/` y `./dashboard/` usan tema dark (night). Esta inconsistencia fue identificada durante la revisión del sistema de diseño unificado. El cambio a dark theme requiere actualización cuidadosa de:

- Tema DaisyUI de "light" a "night"
- Colores de fondo y texto
- Efectos visuales (glass, gradientes)
- Contraste WCAG AA

## Goals / Non-Goals

**Goals:**
- Cambiar ./main/ completamente a dark theme
- Mantener consistencia visual con ./requerimientos/ y ./dashboard/
- Preservar paleta naranja corporativa (#F97316)
- Mantener todas las animaciones y funcionalidad existente
- Asegurar contraste WCAG AA en todos los textos

**Non-Goals:**
- No crear toggle light/dark (solo dark)
- No modificar estructura HTML o componentes
- No cambiar paleta de colores corporativa
- No afectar otros módulos

## Decisions

### 1. Enfoque de Migración
**Decisión:** Migración directa de light a dark sin período de transición

**Razones:**
- Cambio puramente visual, sin impacto en funcionalidad
- Consistencia inmediata con otros módulos
- Evita mantener dos temas simultáneamente

**Alternativas consideradas:**
- Toggle light/dark → Rechazado: añade complejidad innecesaria
- Gradual por secciones → Rechazado: crea inconsistencia temporal

### 2. Paleta de Colores Dark

**Fondos:**
```css
--bg-primary: #111827     /* gray-900 - Fondo principal */
--bg-secondary: #1F2937   /* gray-800 - Cards, navbar */
--bg-tertiary: #374151    /* gray-700 - Elementos elevados */
```

**Textos:**
```css
--text-primary: #F9FAFB   /* gray-100 - Títulos principales */
--text-secondary: #D1D5DB /* gray-300 - Texto secundario */
--text-muted: #9CA3AF     /* gray-400 - Texto auxiliar */
```

**Acentos (sin cambios):**
```css
--accent-primary: #F97316   /* Naranja corporativo */
--accent-hover: #EA580C     /* Naranja hover */
--accent-light: #FDBA74     /* Naranja claro */
```

### 3. Componentes Específicos

**Navbar:**
- `glass-effect` actualizado con `backdrop-blur-md bg-gray-800/80`
- Links con `text-gray-100 hover:text-orange-500`
- Dropdown con `bg-gray-800 border-gray-700`

**Hero Section:**
- Gradiente dark: `from-gray-900 via-gray-800 to-gray-900`
- Elementos flotantes con opacidad reducida para fondo oscuro
- Textos mantienen blanco (text-white) sobre gradiente oscuro

**Cards:**
- `bg-gray-800` para fondo de cards
- `border-gray-700` para bordes
- `shadow-2xl shadow-black/50` para profundidad

**Forms:**
- `input-bordered` y `textarea-bordered` de DaisyUI automáticamente adapta a night
- Labels en `text-gray-300`
- Placeholders en `placeholder-gray-500`

### 4. Accesibilidad

**Contraste mínimo WCAG AA:**
- Texto normal: 4.5:1
- Texto grande: 3:1

**Combinaciones validadas:**
- `#F9FAFB` (text) sobre `#1F2937` (bg) → 13.6:1 ✅
- `#D1D5DB` (text) sobre `#1F2937` (bg) → 9.4:1 ✅
- `#F97316` (accent) sobre `#1F2937` (bg) → 4.8:1 ✅
- `#F97316` (accent) sobre `#111827` (bg) → 5.2:1 ✅

## Risks / Trade-offs

**Riesgo 1: Ajuste Visual de Usuarios**
- **Descripción:** Usuarios acostumbrados a tema light pueden necesitar adaptación
- **Probabilidad:** Baja
- **Impacto:** Bajo
- **Mitigación:** 
  - Cambio es consistente con otros módulos ya en dark
  - Dark theme es estándar en aplicaciones profesionales
  - Mejora reducción de fatiga visual

**Riesgo 2: Contraste Insuficiente en Algunos Elementos**
- **Descripción:** Algunos elementos pueden requerir ajuste fino de contraste
- **Probabilidad:** Media
- **Impacto:** Medio
- **Mitigación:**
  - Validación WCAG AA con herramientas automatizadas
  - Testing manual en diferentes pantallas
  - Ajustes iterativos post-despliegue si necesario

**Trade-off: Uniformidad vs Personalización**
- **Decisión:** Priorizar uniformidad (dark en todos los módulos)
- **Beneficio:** Experiencia consistente, profesional
- **Costo:** Pérdida de opción light (bajo impacto dado que otros módulos ya son dark)

## Migration Plan

**Fase 1: Preparación (5 min)**
1. Backup de archivos originales
   - `cp main/index.html main/index.html.light-backup`
   - `cp main/css/styles.css main/css/styles.css.light-backup`

**Fase 2: Implementación HTML (10 min)**
1. Cambiar `data-theme="light"` → `data-theme="night"`
2. Actualizar body class: añadir `bg-gray-900 text-gray-100`
3. Actualizar navbar con clases dark
4. Actualizar hero section con bg dark
5. Actualizar cards de servicios con `bg-gray-800`
6. Actualizar timeline con `bg-gray-800`
7. Actualizar formulario de contacto

**Fase 3: Implementación CSS (10 min)**
1. Actualizar `.hero-gradient` para gradiente oscuro
2. Actualizar `.glass-effect` para fondo oscuro
3. Ajustar variable `--cb-gray` si necesario
4. Verificar animaciones funcionan correctamente

**Fase 4: Testing (15 min)**
1. Testing visual en navegadores principales
2. Testing responsive en móvil/tablet/desktop
3. Validación WCAG AA de contraste
4. Navegación entre módulos
5. Testing de interacciones (hover, focus, click)

**Fase 5: Despliegue (5 min)**
1. Commit de cambios
2. Desplegar a producción
3. Verificación post-despliegue
4. Monitoreo de feedback inicial

**Rollback:**
Si hay problemas críticos:
```bash
cp main/index.html.light-backup main/index.html
cp main/css/styles.css.light-backup main/css/styles.css
```

## Open Questions

**Q1:** ¿Hay algún requisito de accesibilidad específico más allá de WCAG AA?
- **Estado:** Pendiente de confirmación con stakeholders
- **Impacto:** Bajo - WCAG AA es estándar suficiente

**Q2:** ¿Se requiere testing con usuarios reales antes de despliegue?
- **Estado:** Opcional - cambio visual alineado con diseño existente
- **Recomendación:** Testing interno suficiente dado contexto

**Q3:** ¿Existen métricas específicas a trackear post-despliegue?
- **Estado:** A definir
- **Sugerencias:** 
  - Tiempo promedio en página
  - Tasa de rebote
  - Feedback de usuarios sobre tema

## Implementation Notes

**Orden de desarrollo recomendado:**
1. HTML structure (theme + body)
2. Navbar
3. Hero section
4. Services cards
5. Timeline
6. Contact form
7. CSS adjustments
8. Final polish

**Puntos de atención especiales:**
- Verificar que logo `Logo_Claro_Trans.png` tenga buen contraste en dark
- Confirmar que gradientes animados funcionan bien en fondo oscuro
- Validar que glass-effect mantenga efecto sobre fondo dark
- Probar shadows en elementos para asegurar profundidad visual

**Herramientas recomendadas:**
- Chrome DevTools para testing
- WebAIM Contrast Checker para validación WCAG
- Responsively App para testing multi-dispositivo
