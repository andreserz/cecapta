# Propuesta: Sistema de Diseño Unificado Basado en Requerimientos

## Why

Actualmente el proyecto tiene tres módulos frontend (`./requerimientos/`, `./api_tests/`, `./main/`) con estilos y patrones de diseño inconsistentes. El módulo de requerimientos ya implementa un sistema de diseño cohesivo y moderno que utiliza:

- **DaisyUI 4.4.19** como framework de componentes
- **Tailwind CSS** como base de utilidades
- **Fuentes Inter** (cargadas localmente)
- **Paleta de colores naranja corporativa** (#F97316 primario, #EA580C hover, #FDBA74 claro)
- **Tema oscuro** (data-theme="night") con fondo #111827
- **Componentes reutilizables**: botones, inputs, modals, progress bars, selects, textareas
- **Patrones de construcción**: layout sin scroll, animaciones fade, navegación wizard-style

Esta propuesta busca extraer estos elementos de diseño en un sistema reutilizable y aplicarlo consistentemente a los módulos `api_tests` y `main` para lograr una experiencia de usuario coherente en todo el proyecto.

## What Changes

- **Crear biblioteca de diseño compartida** extrayendo patrones, colores y componentes de `./requerimientos/`
- **Definir artefactos reutilizables de DaisyUI**:
  - Temas personalizados (night theme customizado)
  - Clases de utilidad para colores corporativos
  - Componentes estándar (botones, cards, modals, forms)
  - Animaciones y transiciones comunes
- **Estandarizar fuentes**: Usar Inter localmente en todos los módulos
- **Crear guía de implementación** para `./api_tests/`:
  - Reemplazar estilos actuales con sistema unificado
  - Migrar componentes a DaisyUI
  - Aplicar paleta de colores corporativa
  - Implementar tema oscuro consistente
- **Crear guía de implementación** para `./main/`:
  - Actualizar desde estilos custom a sistema unificado
  - Mantener animaciones pero con paleta corporativa
  - Unificar navegación y componentes hero
  - Consistencia en tipografía

## Impact

### Affected Specs
- `specs/frontend-ui` (nuevo): Sistema de diseño y componentes UI
- `specs/api-tests-interface` (modificado): Interfaz de pruebas API
- `specs/landing-page` (modificado): Página principal

### Affected Code
- `./requerimientos/`: Fuente de patrones (sin cambios significativos)
- `./api_tests/public/index.php`: Refactorización de UI
- `./api_tests/public/assets/`: Recursos de diseño
- `./main/index.html`: Actualización de estilos y componentes
- `./main/css/styles.css`: Migración a sistema unificado
- Nuevos archivos compartidos en directorio común (a definir ubicación)

### Benefits
- **Consistencia visual** en toda la aplicación
- **Mantenibilidad mejorada** con componentes reutilizables
- **Tiempo de desarrollo reducido** para nuevas features
- **Experiencia de usuario coherente** entre módulos
- **Documentación clara** de patrones de diseño

### Risks
- Cambios visuales pueden requerir ajustes en testing existente
- Migración puede introducir bugs visuales temporales
- Requiere revisión cuidadosa de accesibilidad en cada módulo
