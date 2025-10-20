# Diseño Técnico: Sistema de Diseño Unificado

## Context

El proyecto CECAPTA CallBlaster AI tiene tres módulos frontend con estilos inconsistentes:
1. **`./requerimientos/`**: Wizard de configuración con diseño moderno, tema oscuro, DaisyUI + Tailwind
2. **`./api_tests/`**: Interfaz de pruebas API con estilos básicos
3. **`./main/`**: Landing page con diseño custom, animaciones, tema claro

El módulo `./requerimientos/` ya implementa un sistema de diseño robusto que puede servir como base para unificar toda la aplicación.

## Goals

- Extraer y documentar el sistema de diseño de `./requerimientos/`
- Crear biblioteca de componentes y patrones reutilizables
- Aplicar sistema unificado a `./api_tests/` y `./main/`
- Mantener funcionalidad existente mientras se mejora la UI
- Establecer guías para desarrollo futuro

## Non-Goals

- Reescribir lógica JavaScript existente (solo actualizar selectores si necesario)
- Cambiar arquitectura backend o APIs
- Implementar nuevas features (solo mejorar UI/UX)
- Crear sistema de design tokens complejo (mantener simplicidad)

## Decisions

### 1. Framework de Componentes: DaisyUI 4.4.19

**Decision**: Usar DaisyUI como framework de componentes en todos los módulos.

**Rationale**:
- Ya implementado exitosamente en `./requerimientos/`
- Built on top de Tailwind CSS (consistencia)
- Componentes accesibles por defecto
- Temas personalizables
- CDN disponible (sin build step)
- Documentación extensa

**Alternatives Considered**:
- **Plain Tailwind**: Más flexible pero requiere más código boilerplate
- **Material UI / Bootstrap**: Cambio mayor, curva de aprendizaje
- **Custom components**: Más mantenimiento, reinventar la rueda

### 2. Paleta de Colores: Naranja Corporativa

**Decision**: Estandarizar en paleta de naranja (#F97316) extraída de `./requerimientos/`.

**Colors**:
```css
:root {
  --naranja-primario: #F97316;   /* Botones, acentos principales */
  --naranja-hover: #EA580C;       /* Estados hover */
  --naranja-claro: #FDBA74;       /* Acentos secundarios */
  --fondo-oscuro: #111827;        /* Fondos en tema oscuro */
  --completado: #10B981;          /* Estados de éxito */
  --error: #EF4444;               /* Estados de error */
  --warning: #F59E0B;             /* Estados de advertencia */
}
```

**Rationale**:
- Naranja es distintivo y profesional
- Alto contraste con fondo oscuro
- Ya validado en producción (módulo requerimientos)
- Consistencia con branding corporativo

**Impact on `./main/`**:
- Actualizar `cb-primary` de #3d4f6d (azul) a #F97316 (naranja)
- Mantener estructura de colores, solo cambiar valores
- Actualizar gradientes hero section

### 3. Tipografía: Inter (Local)

**Decision**: Usar fuente Inter cargada localmente en todos los módulos.

**Rationale**:
- Ya implementado en `./requerimientos/` con carga local
- Excelente legibilidad en pantallas
- Variedad de pesos (300-800)
- Performance: carga local más rápida que Google Fonts
- GDPR compliant (sin terceros)

**Implementation**:
```html
<link href="../shared/fonts/inter/inter-local.css" rel="stylesheet">
```

**Migration Path**:
- `./requerimientos/`: Ya usa Inter local ✓
- `./api_tests/`: Agregar Inter local (actualmente sin fuentes específicas)
- `./main/`: Reemplazar Google Fonts por Inter local

### 4. Temas: Oscuro para Apps, Flexible para Landing

**Decision**:
- `./requerimientos/`: Mantener tema oscuro (`data-theme="night"`)
- `./api_tests/`: Implementar tema oscuro (`data-theme="night"`)
- `./main/`: Mantener tema claro PERO con paleta naranja corporativa

**Rationale**:
- Tema oscuro apropiado para aplicaciones de trabajo (menos fatiga visual)
- Landing page pública puede beneficiarse de tema claro (más acogedor)
- DaisyUI permite cambio fácil de tema si se requiere en futuro

### 5. Estructura de Archivos Compartidos

**Decision**: Crear directorio `shared/` en raíz con recursos compartidos.

**Structure**:
```
shared/
├── design-system/
│   ├── colors.md           # Documentación de paleta
│   ├── components.md       # Catálogo de componentes
│   ├── typography.md       # Guía de tipografía
│   ├── patterns.md         # Patrones UI comunes
│   ├── theme-config.css    # Variables CSS corporativas
│   └── daisyui-config.js   # Config DaisyUI (si se usa build)
└── fonts/
    └── inter/
        ├── inter-local.css
        ├── Inter-Light.woff2
        ├── Inter-Regular.woff2
        ├── Inter-Medium.woff2
        ├── Inter-SemiBold.woff2
        ├── Inter-Bold.woff2
        └── Inter-ExtraBold.woff2
```

**Rationale**:
- Centraliza recursos compartidos
- Fácil referencia desde cualquier módulo
- Facilita mantenimiento
- Clara separación de concerns

**Alternatives Considered**:
- **Copiar archivos a cada módulo**: Duplicación, difícil mantener
- **Usar npm/composer**: Overkill para recursos estáticos simples
- **CDN solo**: Pérdida de control, dependencia externa

### 6. Animaciones: Mantener Existentes, Estandarizar Nuevas

**Decision**:
- `./requerimientos/`: Mantener animaciones CSS custom (fade-enter, float)
- `./main/`: Mantener Animatiss library para animaciones complejas
- Nuevos módulos: Usar animaciones estándar de DaisyUI + custom CSS simple

**Rationale**:
- No romper animaciones que funcionan
- Animatiss ya cargado en main, no hay overhead adicional
- Para nuevos componentes, preferir CSS custom sobre librerías

### 7. Approach de Migración: Incremental

**Decision**: Migración incremental, módulo por módulo, componente por componente.

**Order**:
1. **Fase 1**: Crear biblioteca compartida (shared/)
2. **Fase 2**: Migrar `./api_tests/` (menor complejidad)
3. **Fase 3**: Migrar `./main/` (mayor complejidad)
4. **Fase 4**: Documentación final

**Rationale**:
- Menor riesgo de romper funcionalidad
- Permite testing entre fases
- Facilita rollback si hay problemas
- Aprendizajes de fase 2 informan fase 3

## Risks / Trade-offs

### Risk 1: Cambios visuales rompen funcionalidad JavaScript

**Impact**: Alto  
**Probability**: Media  
**Mitigation**:
- Testing exhaustivo después de cada cambio
- Mantener selectores JavaScript cuando sea posible
- Usar data-attributes para hooks JS si clases cambian
- Testing manual de flujos críticos

### Risk 2: Performance afectada por CDNs adicionales

**Impact**: Bajo  
**Probability**: Baja  
**Mitigation**:
- DaisyUI y Tailwind ya usan CDN en requerimientos
- Fuentes locales reducen llamadas externas
- Medir performance antes/después con Lighthouse

### Risk 3: Accesibilidad degradada

**Impact**: Alto  
**Probability**: Baja  
**Mitigation**:
- DaisyUI tiene buena accesibilidad por defecto
- Validar contraste de colores con herramientas (WCAG)
- Testing con lector de pantalla
- Mantener foco visible

### Risk 4: Inconsistencias entre módulos durante migración

**Impact**: Medio  
**Probability**: Media  
**Mitigation**:
- Documentar claramente estado de cada módulo
- Migración rápida para minimizar tiempo de inconsistencia
- Priorizar módulos más visibles

### Trade-off 1: Flexibilidad vs. Consistencia

**Chosen**: Consistencia  
**Impact**: Menos libertad creativa, pero mejor mantenibilidad

### Trade-off 2: CDN vs. Build Local

**Chosen**: CDN para DaisyUI/Tailwind  
**Impact**: Dependencia externa pero setup más simple

## Migration Plan

### Phase 1: Setup (Tareas 1-3)
**Duration**: 2-3 horas  
**Deliverables**:
- Directorio `shared/` con recursos
- Documentación de sistema de diseño
- Artefactos reutilizables (templates, snippets)

### Phase 2: api_tests Migration (Tarea 4)
**Duration**: 4-6 horas  
**Deliverables**:
- `./api_tests/` con tema oscuro corporativo
- Componentes migrados a DaisyUI
- Testing completo de funcionalidad

**Steps**:
1. Análisis estado actual
2. Implementar cambios HTML/CSS
3. Testing navegadores
4. Testing funcional
5. Ajustes finales

### Phase 3: main Migration (Tarea 5)
**Duration**: 6-8 horas  
**Deliverables**:
- `./main/` con paleta corporativa
- Componentes consistentes con sistema
- Animaciones preservadas

**Steps**:
1. Análisis estado actual
2. Actualizar colores y fuentes
3. Refactorizar componentes
4. Testing navegadores
5. Testing responsive
6. Ajustes finales

### Phase 4: Documentation & Validation (Tareas 6-7)
**Duration**: 2-3 horas  
**Deliverables**:
- `DESIGN_SYSTEM.md` completo
- Screenshots antes/después
- Validación final de consistencia

### Rollback Plan

Si algo sale mal en cualquier fase:

1. **Git**: Cada fase en commit separado para rollback fácil
2. **Backup**: Screenshot/video antes de cambios
3. **Testing**: Validación funcional antes de commit
4. **Incremental**: Si fase falla, no bloquea otras

### Success Metrics

- ✅ Todos los módulos usan DaisyUI 4.4.19
- ✅ Todos los módulos usan paleta naranja corporativa
- ✅ Todos los módulos usan fuentes Inter locales
- ✅ Consistencia visual > 90% entre módulos
- ✅ Funcionalidad preservada 100%
- ✅ Performance mantenida o mejorada (Lighthouse)
- ✅ Accesibilidad WCAG AA cumplida

## Open Questions

1. **¿Mantener data-theme="light" en ./main/ o cambiar a "night"?**
   - Propuesta: Mantener light pero discutir con stakeholders
   - Impacto en conversión de landing page

2. **¿Migrar Animatiss a animaciones CSS custom en ./main/?**
   - Propuesta: Mantener Animatiss (ya funciona, no hay beneficio claro)
   - Reevaluar si hay problemas de performance

3. **¿Implementar theme switcher para usuarios?**
   - Propuesta: No en esta fase (fuera de scope)
   - Considerar para propuesta futura si hay demanda

4. **¿Ubicación final de logo corporativo?**
   - Actualmente en `./requerimientos/Logo_Claro_Trans.png`
   - Considerar mover a `shared/assets/logo/`
