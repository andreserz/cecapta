# Tareas de Implementación: Dark Theme en ./main/

## 1. Actualización de HTML Base
- [x] 1.1 Cambiar `data-theme="light"` a `data-theme="night"` en `<html>` tag
- [x] 1.2 Actualizar clase body de `min-h-screen` a `min-h-screen bg-gray-900 text-gray-100`
- [x] 1.3 Verificar que DaisyUI tema "night" esté cargando correctamente

## 2. Actualización del Navbar
- [x] 2.1 Actualizar clases del navbar para tema oscuro
- [x] 2.2 Ajustar glass-effect para funcionar con fondo oscuro
- [x] 2.3 Verificar contraste de enlaces y texto en navbar
- [x] 2.4 Ajustar dropdown menu para tema oscuro (bg-base-100 en night)

## 3. Actualización del Hero Section
- [x] 3.1 Cambiar hero-gradient de claro a oscuro en styles.css
- [x] 3.2 Actualizar divs de fondo animados con colores dark
- [x] 3.3 Ajustar contraste de textos en hero (ya están en blanco, validar visibilidad)
- [x] 3.4 Verificar logo y elementos flotantes sobre fondo oscuro
- [x] 3.5 Ajustar botones CTA para tema oscuro

## 4. Actualización de Sección de Servicios
- [x] 4.1 Actualizar cards de servicios con `bg-gray-800` y bordes oscuros
- [x] 4.2 Ajustar iconos para contraste con fondo oscuro
- [x] 4.3 Actualizar texto de cards a `text-gray-100` / `text-gray-300`
- [x] 4.4 Verificar hover effects en tema oscuro
- [x] 4.5 Ajustar sombras (shadow-xl) para tema oscuro

## 5. Actualización de Timeline
- [x] 5.1 Actualizar cards de timeline con `bg-gray-800`
- [x] 5.2 Ajustar línea conectora de timeline para tema oscuro
- [x] 5.3 Actualizar badges y etiquetas con colores oscuros
- [x] 5.4 Verificar contraste de texto en cada paso del timeline
- [x] 5.5 Ajustar iconos y elementos visuales

## 6. Actualización de Sección de Contacto
- [x] 6.1 Actualizar formulario de contacto con tema oscuro
- [x] 6.2 Aplicar `input-bordered` y `textarea-bordered` con dark theme
- [x] 6.3 Actualizar botón de envío con btn-primary-custom
- [x] 6.4 Ajustar colores de placeholder y labels
- [x] 6.5 Verificar estados de validación (error, success) en dark

## 7. Actualización de CSS Custom (styles.css)
- [x] 7.1 Actualizar variable --cb-gray de #e6e6e6 a tono oscuro apropiado
- [x] 7.2 Modificar .hero-gradient para gradiente oscuro
- [x] 7.3 Actualizar .glass-effect para funcionar con fondo oscuro
- [x] 7.4 Ajustar .gradient-text si es necesario para contraste
- [x] 7.5 Verificar y ajustar animaciones (float-animation, pulse-slow)
- [x] 7.6 Actualizar cualquier color hardcodeado a versión dark

## 8. Validación y Testing
- [ ] 8.1 Probar en navegadores principales (Chrome, Firefox, Safari, Edge)
- [ ] 8.2 Validar responsive design en móvil, tablet y desktop
- [ ] 8.3 Verificar contraste WCAG AA con herramienta de accesibilidad
- [ ] 8.4 Probar navegación entre módulos (main → requerimientos → dashboard)
- [ ] 8.5 Validar que todas las animaciones funcionan correctamente
- [ ] 8.6 Verificar legibilidad de todos los textos
- [ ] 8.7 Probar interacciones de usuario (hover, click, focus)

## 9. Documentación
- [ ] 9.1 Actualizar DESIGN_SYSTEM.md reflejando cambio a dark en main
- [ ] 9.2 Actualizar IMPLEMENTACION_COMPLETADA.md con el cambio
- [ ] 9.3 Tomar screenshots del antes/después
- [ ] 9.4 Documentar cualquier ajuste adicional realizado

## 10. Despliegue
- [x] 10.1 Backup de archivos originales
- [ ] 10.2 Aplicar cambios en desarrollo
- [ ] 10.3 Testing final en ambiente de desarrollo
- [ ] 10.4 Desplegar a producción
- [ ] 10.5 Verificar funcionamiento en producción
