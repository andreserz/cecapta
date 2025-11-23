# Plan de Implementación: Dependencias Condicionales

## Fase 1: Preparación y Schema

### Archivo: `requerimientos/preguntas/requirements.json`

Agregar campo opcional `dependencia_previa` a cualquier pregunta que requiera validación:

```json
{
  "titulo": "Pregunta dependiente",
  "tipo": "text",
  "nombre": "campo_dependiente",
  "dependencia_previa": {
    "campo": "nombre_campo_anterior",
    "condicion": "no_vacio",
    "mensaje_error": "Debes completar [campo anterior] primero"
  }
}
```

## Fase 2: Lógica JavaScript

### Archivo: `requerimientos/script.js`

#### 2.1 Función de Evaluación de Dependencias

```javascript
/**
 * Evalúa si una dependencia se cumple
 * @param {Object} dependencia - Objeto con campo, condicion, valor, mensaje_error
 * @param {Array} respuestas - Array de respuestas del usuario
 * @param {Number} preguntaActual - Índice de la pregunta actual
 * @returns {Object} { cumplida: boolean, mensaje: string }
 */
function evaluarDependencia(dependencia, respuestas, preguntaActual) {
    if (!dependencia) {
        return { cumplida: true, mensaje: '' };
    }
    
    // Buscar índice del campo dependiente
    const indiceCampo = window.preguntasData.findIndex(
        p => p.nombre === dependencia.campo
    );
    
    if (indiceCampo === -1 || indiceCampo >= preguntaActual) {
        console.warn('Campo de dependencia no encontrado o inválido');
        return { cumplida: true, mensaje: '' };
    }
    
    const valorCampo = respuestas[indiceCampo] || '';
    let cumplida = false;
    
    switch(dependencia.condicion) {
        case 'no_vacio':
            cumplida = valorCampo.trim().length > 0;
            break;
            
        case 'valor_especifico':
            cumplida = valorCampo === dependencia.valor;
            break;
            
        case 'contiene':
            cumplida = valorCampo.toLowerCase()
                .includes((dependencia.valor || '').toLowerCase());
            break;
            
        case 'mayor_que':
            cumplida = valorCampo.length > parseInt(dependencia.valor || 0);
            break;
            
        default:
            console.warn('Condición no reconocida:', dependencia.condicion);
            cumplida = true;
    }
    
    const mensaje = cumplida ? '' : (
        dependencia.mensaje_error || 
        `Debes completar "${window.preguntasData[indiceCampo].titulo}" primero`
    );
    
    return { cumplida, mensaje };
}
```

#### 2.2 Modificar `navegarSiguiente()`

```javascript
function navegarSiguiente() {
    if (!validarRespuestaActual()) {
        return;
    }
    
    guardarRespuestaActual();
    
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    
    if (esUltimaPregunta) {
        finalizarConfiguracion();
        return;
    }
    
    // NUEVO: Validar dependencia de la siguiente pregunta
    const siguientePregunta = window.preguntasData[estado.preguntaActual + 1];
    
    if (siguientePregunta.dependencia_previa) {
        const resultado = evaluarDependencia(
            siguientePregunta.dependencia_previa,
            estado.respuestas,
            estado.preguntaActual + 1
        );
        
        if (!resultado.cumplida) {
            mostrarError(resultado.mensaje);
            return;
        }
    }
    
    estado.preguntaActual++;
    mostrarPregunta(estado.preguntaActual);
}
```

#### 2.3 Actualizar Estado de Botones

```javascript
function actualizarBotones() {
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    const esPrimeraPregunta = estado.preguntaActual === 0;
    
    // Botón anterior - siempre permite retroceder
    if (esPrimeraPregunta) {
        btnAnterior.disabled = true;
        btnAnterior.classList.add('btn-disabled');
    } else {
        btnAnterior.disabled = false;
        btnAnterior.classList.remove('btn-disabled');
    }
    
    // NUEVO: Verificar si la siguiente pregunta tiene dependencia
    let siguienteBloqueado = false;
    let mensajeBloqueo = '';
    
    if (!esUltimaPregunta) {
        const siguientePregunta = window.preguntasData[estado.preguntaActual + 1];
        
        if (siguientePregunta.dependencia_previa) {
            const resultado = evaluarDependencia(
                siguientePregunta.dependencia_previa,
                estado.respuestas,
                estado.preguntaActual + 1
            );
            
            siguienteBloqueado = !resultado.cumplida;
            mensajeBloqueo = resultado.mensaje;
        }
    }
    
    // Aplicar estado visual al botón siguiente
    if (siguienteBloqueado) {
        btnSiguiente.disabled = true;
        btnSiguiente.classList.add('btn-disabled', 'tooltip');
        btnSiguiente.setAttribute('data-tip', mensajeBloqueo);
    } else {
        btnSiguiente.disabled = false;
        btnSiguiente.classList.remove('btn-disabled', 'tooltip');
        btnSiguiente.removeAttribute('data-tip');
    }
    
    // Resto del código existente...
}
```

## Fase 3: Mejorar Feedback Visual

### CSS Adicional (si necesario)

```css
.btn-disabled.tooltip::before {
    content: attr(data-tip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 0.5rem;
    background: #374151;
    color: white;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s;
}

.btn-disabled.tooltip:hover::before {
    opacity: 1;
}
```

## Fase 4: Documentación

### README.md - Nueva Sección

```markdown
## Dependencias entre Preguntas

El sistema soporta dependencias condicionales entre preguntas. Esto permite controlar el flujo del wizard basándose en respuestas anteriores.

### Configuración

Agrega el campo `dependencia_previa` a cualquier pregunta en `requirements.json`:

```json
{
  "dependencia_previa": {
    "campo": "nombre_del_campo_anterior",
    "condicion": "tipo_de_validacion",
    "valor": "valor_esperado (opcional)",
    "mensaje_error": "Mensaje personalizado (opcional)"
  }
}
```

### Condiciones Soportadas

- **no_vacio**: El campo anterior debe tener contenido
- **valor_especifico**: El campo debe ser exactamente igual a `valor`
- **contiene**: El campo debe contener el texto especificado en `valor`
- **mayor_que**: El campo debe tener longitud mayor que el número en `valor`

### Ejemplos

Ver ejemplos completos en la sección de casos de uso.
```

## Retrocompatibilidad

✅ **100% Retrocompatible**
- Preguntas sin `dependencia_previa` funcionan normalmente
- JSON existente no requiere cambios
- Funcionalidad es opt-in (opcional)
