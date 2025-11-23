# Tasks: Navegación Clickeable en Sidebar

## 1. Preparación
- [x] 1.1 Crear propuesta OpenSpec
- [x] 1.2 Crear especificación con requirements y scenarios
- [x] 1.3 Validar especificación con `openspec validate`

## 2. Implementación JavaScript
- [x] 2.1 Crear función `navegarAPregunta(index)` para manejar clicks
- [x] 2.2 Crear función `puedeNavegarAIndice(targetIndex)` para validar navegación
- [x] 2.3 Modificar `renderizarSidebar()` para agregar event listeners a items clickeables
- [x] 2.4 Agregar clases CSS dinámicas (clickable/disabled) según estado
- [x] 2.5 Integrar auto-guardado antes de navegar

## 3. Estilos CSS
- [x] 3.1 Agregar estilos para `.step-item.clickable` con hover effects
- [x] 3.2 Agregar estilos para `.step-item.disabled` con feedback visual
- [x] 3.3 Agregar transiciones suaves para mejorar UX

## 4. Pruebas y Validación
- [ ] 4.1 Probar navegación hacia atrás (debe permitir)
- [ ] 4.2 Probar navegación a siguiente inmediata (debe permitir)
- [ ] 4.3 Probar navegación a pasos futuros no visitados (debe bloquear)
- [ ] 4.4 Probar navegación a pasos ya completados (debe permitir)
- [ ] 4.5 Verificar auto-guardado de respuestas al cambiar de pregunta
- [ ] 4.6 Verificar feedback visual en hover
- [ ] 4.7 Probar en navegadores (Chrome, Firefox, Safari)
- [ ] 4.8 Verificar que funcionalidad existente no se rompa

## 5. Documentación
- [ ] 5.1 Actualizar comentarios en código si es necesario
- [ ] 5.2 Archivar change en OpenSpec tras deployment
