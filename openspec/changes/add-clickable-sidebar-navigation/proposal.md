# Propuesta: Navegación Clickeable en Sidebar de Pasos

## Why
Actualmente, el sidebar "Pasos de Configuración" en el módulo de requerimientos es **solo visual** - muestra el progreso pero los usuarios no pueden hacer clic en los pasos para navegar directamente a una pregunta específica. Esto obliga a los usuarios a usar solo los botones "Anterior/Siguiente" para moverse entre preguntas, lo cual es ineficiente si quieren revisar o editar una respuesta anterior específica.

Los usuarios necesitan poder:
- Hacer clic en cualquier paso del sidebar para saltar directamente a esa pregunta
- Revisar y editar respuestas anteriores sin tener que navegar secuencialmente
- Tener una experiencia más ágil al completar el formulario de requerimientos

## What Changes
- **Agregar interactividad al sidebar**: Convertir los items del sidebar en elementos clickeables
- **Navegación directa**: Permitir saltar a cualquier pregunta haciendo clic en su paso
- **Feedback visual**: Agregar estilos hover y cursor pointer para indicar que son clickeables
- **Validación antes de navegar**: Guardar la respuesta actual antes de cambiar de pregunta
- **Restricción de navegación hacia adelante**: Solo permitir navegar a preguntas que:
  - Ya han sido visitadas/respondidas, O
  - Son la siguiente pregunta inmediata (respetando dependencias)
- **Mantener validaciones existentes**: Respetar las dependencias entre preguntas

## Impact
- **Archivos afectados**:
  - `requerimientos/script.js` - Agregar event listeners y lógica de navegación clickeable
  - `requerimientos/index.php` - Posible ajuste de estilos CSS para hover states
- **Comportamiento modificado**:
  - La función `renderizarSidebar()` necesitará agregar event listeners a cada item
  - Nueva función para manejar navegación por clic
  - Los pasos no visitados hacia adelante deberán estar deshabilitados visualmente
- **No breaking changes**: Solo agrega funcionalidad, no rompe comportamiento existente
- **Mejora de UX**: Significativa mejora en experiencia de usuario

## Questions to Clarify

Antes de implementar, necesito confirmar:

1. **¿Cómo manejar navegación hacia adelante?**
   - Opción A: Permitir saltar a cualquier pregunta sin restricciones
   - Opción B: Solo permitir navegar a preguntas ya visitadas + siguiente pregunta inmediata
   - Opción C: Solo permitir navegar a preguntas ya respondidas
   
   **Recomendación**: Opción B (balance entre flexibilidad y validación)

2. **¿Validar respuesta actual antes de saltar?**
   - Opción A: Validar y bloquear si la pregunta actual está incompleta (estricto)
   - Opción B: Guardar sin validar y permitir saltar (flexible)
   
   **Recomendación**: Opción B (permitir exploración libre, validar solo al avanzar con botón "Siguiente")

3. **¿Feedback visual para pasos no disponibles?**
   - Opción A: Deshabilitar visualmente pasos futuros (opacity reducida, cursor not-allowed)
   - Opción B: Mostrar tooltip explicando por qué no se puede acceder
   - Opción C: Permitir click pero mostrar mensaje de error
   
   **Recomendación**: Opción A (feedback visual claro e inmediato)

4. **¿Comportamiento en móvil?**
   - El sidebar está oculto en móvil (`hidden lg:block`)
   - ¿Mantener comportamiento actual o agregar menú de navegación móvil?
   
   **Recomendación**: Mantener actual (solo agregar funcionalidad en desktop donde sidebar es visible)

## Proposed Design Decisions

### Lógica de Navegación
```javascript
function navegarAPregunta(index) {
    // 1. Verificar si se puede navegar a ese índice
    if (!puedeNavegarAIndice(index)) {
        mostrarToastInfo('⚠️ Completa las preguntas anteriores primero');
        return;
    }
    
    // 2. Guardar respuesta actual (sin validar estrictamente)
    guardarRespuestaActual();
    
    // 3. Actualizar índice y mostrar pregunta
    estado.preguntaActual = index;
    mostrarPregunta(index);
}

function puedeNavegarAIndice(targetIndex) {
    // Permitir navegación hacia atrás sin restricciones
    if (targetIndex < estado.preguntaActual) {
        return true;
    }
    
    // Permitir siguiente pregunta inmediata
    if (targetIndex === estado.preguntaActual + 1) {
        return true;
    }
    
    // Permitir si ya fue visitada/completada
    if (estado.preguntasCompletadas.has(targetIndex)) {
        return true;
    }
    
    // Bloquear saltos hacia adelante a preguntas no visitadas
    return false;
}
```

### Estilos CSS
```css
.step-item.clickable {
    cursor: pointer;
    transition: all 0.2s ease;
}

.step-item.clickable:hover {
    background-color: rgba(249, 115, 22, 0.1);
    transform: translateX(4px);
}

.step-item.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
```

## ¿Apruebas esta especificación?

Por favor revisa:
1. Las opciones propuestas para cada pregunta
2. Las recomendaciones de diseño
3. El comportamiento sugerido
4. El alcance del cambio

Una vez que apruebes o hagas ajustes, procederé a crear la especificación completa con requirements y scenarios.
