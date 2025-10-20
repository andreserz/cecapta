# Tareas de Implementación: Sistema de Diseño Unificado

## 1. Análisis y Documentación del Sistema de Diseño Actual

- [ ] 1.1 Documentar paleta de colores de `./requerimientos/` (naranja primario, hover, claro, fondos)
- [ ] 1.2 Inventariar componentes DaisyUI utilizados (botones, inputs, modals, progress, etc.)
- [ ] 1.3 Documentar patrones de construcción (layouts, animaciones, transiciones)
- [ ] 1.4 Extraer configuración de fuentes Inter locales
- [ ] 1.5 Documentar tema oscuro (data-theme="night" + customizaciones)

## 2. Crear Biblioteca de Diseño Compartida

- [ ] 2.1 Crear directorio `shared/design-system/` en raíz del proyecto
- [ ] 2.2 Crear `shared/design-system/colors.md` con paleta corporativa documentada
- [ ] 2.3 Crear `shared/design-system/components.md` con catálogo de componentes DaisyUI
- [ ] 2.4 Crear `shared/design-system/typography.md` con guía de fuentes Inter
- [ ] 2.5 Crear `shared/design-system/patterns.md` con patrones de UI comunes
- [ ] 2.6 Copiar fuentes Inter a `shared/fonts/inter/`
- [ ] 2.7 Crear `shared/design-system/theme-config.css` con variables CSS corporativas
- [ ] 2.8 Crear `shared/design-system/daisyui-config.js` con configuración DaisyUI

## 3. Definir Artefactos Reutilizables

- [ ] 3.1 Crear plantilla HTML base con CDN DaisyUI 4.4.19 + Tailwind
- [ ] 3.2 Definir clases CSS custom para colores corporativos (--naranja-primario, etc.)
- [ ] 3.3 Crear snippets de componentes comunes:
  - [ ] 3.3.1 Botones primarios (.btn-primary-custom)
  - [ ] 3.3.2 Cards de contenido (.card-custom)
  - [ ] 3.3.3 Modals de éxito/error
  - [ ] 3.3.4 Progress bars con colores corporativos
  - [ ] 3.3.5 Forms inputs estándar
- [ ] 3.4 Crear librería de animaciones (fade-enter, float-animation, etc.)
- [ ] 3.5 Definir layout patterns (sidebar + main, hero section, wizard-style)

## 4. Planificación para ./api_tests

### 4.1 Análisis de Estado Actual
- [ ] 4.1.1 Revisar `./api_tests/public/index.php` (HTML estructura actual)
- [ ] 4.1.2 Identificar estilos inline y clases custom actuales
- [ ] 4.1.3 Mapear componentes actuales a equivalentes DaisyUI
- [ ] 4.1.4 Identificar JavaScript que requiere actualización

### 4.2 Diseño de Migración
- [ ] 4.2.1 Crear mockup de nueva UI con tema oscuro
- [ ] 4.2.2 Planificar estructura de componentes:
  - [ ] Login card con tema oscuro
  - [ ] Header con logo y navegación
  - [ ] Cards de pruebas API con estados (success/error)
  - [ ] Modals de resultados
  - [ ] Loading states
- [ ] 4.2.3 Definir nueva paleta de colores para estados (éxito verde #10B981, error, warning)

### 4.3 Tareas de Implementación
- [ ] 4.3.1 Agregar DaisyUI 4.4.19 CDN al `<head>`
- [ ] 4.3.2 Agregar Tailwind CSS CDN
- [ ] 4.3.3 Incluir fuentes Inter locales desde `shared/fonts/`
- [ ] 4.3.4 Establecer `data-theme="night"` en `<html>`
- [ ] 4.3.5 Agregar `<style>` con variables corporativas
- [ ] 4.3.6 Refactorizar login form:
  - [ ] Usar `.card` de DaisyUI
  - [ ] Aplicar `.input-bordered` a input password
  - [ ] Usar `.btn-primary-custom` para botón submit
- [ ] 4.3.7 Refactorizar lista de pruebas:
  - [ ] Usar `.card` para cada prueba
  - [ ] Aplicar badges de estado con colores corporativos
  - [ ] Añadir loading spinner de DaisyUI
- [ ] 4.3.8 Refactorizar modals de resultados usando `<dialog>` de DaisyUI
- [ ] 4.3.9 Actualizar header con logo consistente
- [ ] 4.3.10 Aplicar animaciones fade-enter

### 4.4 Testing y Ajustes
- [ ] 4.4.1 Probar en navegadores (Chrome, Firefox, Safari)
- [ ] 4.4.2 Verificar responsive en móvil, tablet, desktop
- [ ] 4.4.3 Validar contraste de colores (accesibilidad WCAG)
- [ ] 4.4.4 Ajustar animaciones si necesario
- [ ] 4.4.5 Verificar funcionalidad de pruebas API (no romper JS)

## 5. Planificación para ./main

### 5.1 Análisis de Estado Actual
- [ ] 5.1.1 Revisar `./main/index.html` (estructura actual)
- [ ] 5.1.2 Revisar `./main/css/styles.css` (estilos custom)
- [ ] 5.1.3 Identificar animaciones actuales (Animatiss)
- [ ] 5.1.4 Evaluar colores actuales vs. paleta corporativa

### 5.2 Diseño de Actualización
- [ ] 5.2.1 Crear mockup de landing page con paleta corporativa
- [ ] 5.2.2 Planificar componentes:
  - [ ] Navbar con tema corporativo
  - [ ] Hero section con gradiente naranja
  - [ ] Cards de servicios con estilo corporativo
  - [ ] Timeline con colores actualizados
  - [ ] Footer consistente
- [ ] 5.2.3 Definir si mantener data-theme="light" o cambiar a "night"
- [ ] 5.2.4 Decidir sobre Animatiss (mantener o usar animaciones CSS custom)

### 5.3 Tareas de Implementación
- [ ] 5.3.1 Actualizar DaisyUI a versión 4.4.19 (actualmente usa 4.4.19 ✓)
- [ ] 5.3.2 Reemplazar fuentes Google Fonts por Inter local desde `shared/fonts/`
- [ ] 5.3.3 Actualizar variables de colores en Tailwind config:
  - [ ] cb-primary: actualizar a #F97316 (naranja)
  - [ ] cb-secondary: actualizar derivado
  - [ ] cb-accent: ya es naranja, mantener o ajustar
- [ ] 5.3.4 Refactorizar navbar:
  - [ ] Aplicar colores corporativos
  - [ ] Usar componentes DaisyUI estándar
- [ ] 5.3.5 Refactorizar hero section:
  - [ ] Aplicar gradiente con naranja corporativo
  - [ ] Usar botones `.btn-primary-custom`
  - [ ] Mantener animaciones pero con paleta actualizada
- [ ] 5.3.6 Refactorizar cards de servicios:
  - [ ] Aplicar `.card` de DaisyUI con tema corporativo
  - [ ] Actualizar iconos con colores naranja
- [ ] 5.3.7 Refactorizar timeline:
  - [ ] Aplicar colores corporativos a steps
  - [ ] Mantener estructura, actualizar estilos
- [ ] 5.3.8 Refactorizar footer:
  - [ ] Aplicar tema corporativo
  - [ ] Usar componentes DaisyUI
- [ ] 5.3.9 Actualizar `css/styles.css`:
  - [ ] Migrar variables a corporativas
  - [ ] Eliminar estilos redundantes con DaisyUI
  - [ ] Mantener animaciones custom necesarias

### 5.4 Testing y Ajustes
- [ ] 5.4.1 Probar en navegadores (Chrome, Firefox, Safari)
- [ ] 5.4.2 Verificar responsive en móvil, tablet, desktop
- [ ] 5.4.3 Validar animaciones (Animatiss + custom)
- [ ] 5.4.4 Verificar contraste y accesibilidad
- [ ] 5.4.5 Ajustar gradientes y efectos visuales
- [ ] 5.4.6 Validar navegación smooth scroll

## 6. Documentación y Mantenimiento

- [ ] 6.1 Crear `DESIGN_SYSTEM.md` en raíz del proyecto
- [ ] 6.2 Documentar guías de uso para desarrolladores:
  - [ ] 6.2.1 Cómo usar componentes estándar
  - [ ] 6.2.2 Cómo aplicar colores corporativos
  - [ ] 6.2.3 Cómo añadir nuevas páginas con sistema de diseño
- [ ] 6.3 Crear ejemplos de código para componentes comunes
- [ ] 6.4 Documentar proceso de actualización de DaisyUI
- [ ] 6.5 Crear checklist de QA para nuevos componentes

## 7. Validación Final

- [ ] 7.1 Revisar consistencia visual entre `./requerimientos/`, `./api_tests/`, `./main/`
- [ ] 7.2 Validar que todos los módulos usan DaisyUI 4.4.19
- [ ] 7.3 Validar que todos los módulos usan fuentes Inter locales
- [ ] 7.4 Validar paleta de colores corporativa en todos los módulos
- [ ] 7.5 Probar flujo completo de usuario entre módulos
- [ ] 7.6 Generar screenshots de antes/después
- [ ] 7.7 Obtener aprobación de diseño
