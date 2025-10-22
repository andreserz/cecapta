# Reporte de Implementación: Navegación Condicional Simple

**Fecha:** 22 de octubre de 2025  
**Estado:** ⚠️ **PENDIENTE DE IMPLEMENTACIÓN**

---

## 📋 Resumen Ejecutivo

El sistema debe validar que cada pregunta esté respondida antes de avanzar a la siguiente, usando el campo `dependencia_previa` con valores simples:
- **`null`**: Navegación libre, no requiere validación
- **`"Activo"`**: Requiere que la pregunta anterior esté respondida para avanzar

---

## 🎯 Modelo Simplificado

### Esquema JSON

```json
{
    "titulo": "Pregunta que no requiere validación previa",
    "tipo": "text",
    "nombre": "campo_libre",
    "dependencia_previa": null
}
```

```json
{
    "titulo": "Pregunta que REQUIERE respuesta anterior",
    "tipo": "textarea", 
    "nombre": "campo_obligatorio",
    "dependencia_previa": "Activo"
}
```

### Lógica de Validación

**Regla Simple:**
- Si `dependencia_previa === null` → Navegar libremente
- Si `dependencia_previa === "Activo"` → Validar que pregunta anterior tenga respuesta válida

---

## ❌ Estado Actual del Código

### Archivo: `requerimientos/script.js`

**Función `navegarSiguiente()` - Línea 365**

**CÓDIGO ACTUAL:**
```javascript
function navegarSiguiente() {
    if (!validarRespuestaActual()) {
        return;
    }
    
    guardarRespuestaActual();
    
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    
    if (esUltimaPregunta) {
        finalizarConfiguracion();
    } else {
        estado.preguntaActual++;
        mostrarPregunta(estado.preguntaActual);
    }
}
```

**PROBLEMA:** No valida `dependencia_previa` antes de avanzar.

---

## ✅ Solución Propuesta

### Implementación Mínima

#### 1. Agregar función de validación simple

```javascript
/**
 * Verifica si la pregunta actual requiere dependencia de la anterior
 * @param {Number} indicePregunta - Índice de la pregunta a validar
 * @returns {Object} { valida: boolean, mensaje: string }
 */
function validarDependenciaPrevia(indicePregunta) {
    const pregunta = window.preguntasData[indicePregunta];
    
    // Si no tiene dependencia_previa o es null, siempre es válida
    if (!pregunta.dependencia_previa || pregunta.dependencia_previa === null) {
        return { valida: true, mensaje: '' };
    }
    
    // Si tiene dependencia "Activo", validar pregunta anterior
    if (pregunta.dependencia_previa === "Activo") {
        // Validar que existe pregunta anterior
        if (indicePregunta === 0) {
            console.warn('Primera pregunta no puede tener dependencia');
            return { valida: true, mensaje: '' };
        }
        
        // Obtener respuesta de la pregunta anterior
        const respuestaAnterior = estado.respuestas[indicePregunta - 1];
        const preguntaAnterior = window.preguntasData[indicePregunta - 1];
        
        // Validar que la pregunta anterior tenga respuesta
        if (!respuestaAnterior || respuestaAnterior.trim() === '') {
            return { 
                valida: false, 
                mensaje: `Debes responder "${preguntaAnterior.titulo}" antes de continuar`
            };
        }
    }
    
    return { valida: true, mensaje: '' };
}
```

#### 2. Modificar `navegarSiguiente()`

```javascript
function navegarSiguiente() {
    // Validación actual (campo actual)
    if (!validarRespuestaActual()) {
        return;
    }
    
    guardarRespuestaActual();
    
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    
    if (esUltimaPregunta) {
        finalizarConfiguracion();
        return;
    }
    
    // 🆕 NUEVO: Validar dependencia de la SIGUIENTE pregunta
    const siguienteIndice = estado.preguntaActual + 1;
    const validacion = validarDependenciaPrevia(siguienteIndice);
    
    if (!validacion.valida) {
        mostrarError(validacion.mensaje);
        return; // Bloquear navegación
    }
    
    // Avanzar si todo está OK
    estado.preguntaActual++;
    mostrarPregunta(estado.preguntaActual);
}
```

#### 3. (Opcional) Actualizar `actualizarBotones()` para feedback visual

```javascript
function actualizarBotones() {
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    const esPrimeraPregunta = estado.preguntaActual === 0;
    
    // Botón anterior (sin cambios)
    if (esPrimeraPregunta) {
        btnAnterior.disabled = true;
        btnAnterior.classList.add('btn-disabled');
    } else {
        btnAnterior.disabled = false;
        btnAnterior.classList.remove('btn-disabled');
    }
    
    // 🆕 NUEVO: Verificar si siguiente pregunta tiene dependencia no cumplida
    let bloqueado = false;
    let mensajeBloqueo = '';
    
    if (!esUltimaPregunta) {
        const validacion = validarDependenciaPrevia(estado.preguntaActual + 1);
        bloqueado = !validacion.valida;
        mensajeBloqueo = validacion.mensaje;
    }
    
    // Aplicar estado visual al botón siguiente
    if (bloqueado) {
        btnSiguiente.disabled = true;
        btnSiguiente.classList.add('btn-disabled', 'opacity-50', 'cursor-not-allowed');
        btnSiguiente.title = mensajeBloqueo;
    } else {
        btnSiguiente.disabled = false;
        btnSiguiente.classList.remove('btn-disabled', 'opacity-50', 'cursor-not-allowed');
        btnSiguiente.title = '';
    }
    
    // Texto del botón (sin cambios)
    if (esUltimaPregunta) {
        btnSiguiente.innerHTML = `
            Finalizar y enviar
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        `;
    } else {
        btnSiguiente.innerHTML = `
            Siguiente
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        `;
    }
}
```

---

## 📝 Tareas de Implementación

### ✅ Checklist

- [ ] **Tarea 1:** Agregar función `validarDependenciaPrevia()` (~30 min)
  - [ ] Verificar valor de `dependencia_previa`
  - [ ] Si es `null`, retornar válido
  - [ ] Si es `"Activo"`, validar pregunta anterior
  - [ ] Retornar mensaje de error descriptivo

- [ ] **Tarea 2:** Modificar `navegarSiguiente()` (~15 min)
  - [ ] Llamar `validarDependenciaPrevia()` antes de avanzar
  - [ ] Mostrar error si no es válida
  - [ ] Bloquear navegación si falla

- [ ] **Tarea 3:** (Opcional) Modificar `actualizarBotones()` (~20 min)
  - [ ] Evaluar dependencia en tiempo real
  - [ ] Deshabilitar botón visualmente
  - [ ] Agregar tooltip con mensaje

- [ ] **Tarea 4:** Testing (~1 hora)
  - [ ] Probar pregunta con `dependencia_previa: null`
  - [ ] Probar pregunta con `dependencia_previa: "Activo"`
  - [ ] Verificar mensaje de error correcto
  - [ ] Validar que navegación hacia atrás funciona
  - [ ] Testing en mobile y desktop

---

## 🧪 Casos de Prueba

### Caso 1: Sin dependencia (null)
```json
{
    "titulo": "¿Nombre de tu empresa?",
    "tipo": "text",
    "nombre": "nombre_empresa",
    "dependencia_previa": null
}
```
**Esperado:** Navegar libremente sin validación adicional

### Caso 2: Con dependencia activa
```json
{
    "titulo": "Primera pregunta",
    "nombre": "pregunta1",
    "dependencia_previa": null
},
{
    "titulo": "Segunda pregunta (requiere anterior)",
    "nombre": "pregunta2",
    "dependencia_previa": "Activo"
}
```

**Escenarios:**
- ✅ Usuario responde pregunta1 → Puede avanzar a pregunta2
- ❌ Usuario NO responde pregunta1 → Bloqueado, mensaje de error
- ✅ Usuario retrocede desde pregunta2 → Siempre permitido

### Caso 3: Primera pregunta del wizard
```json
{
    "titulo": "Primera pregunta del wizard",
    "nombre": "primera",
    "dependencia_previa": "Activo"
}
```
**Esperado:** Ignorar dependencia (no hay pregunta anterior)

---

## ⏱️ Estimación

| Tarea | Tiempo |
|-------|--------|
| Implementación core (Tareas 1-2) | 45 min |
| Mejora visual (Tarea 3) | 20 min |
| Testing completo (Tarea 4) | 1 hora |
| **TOTAL** | **2 horas** |

---

## 🎯 Ejemplo de Uso en Producción

### JSON Actual (requirements.json)

Todas las preguntas tienen `dependencia_previa: null`, que significa navegación libre:

```json
[
    {
        "titulo": "¿Cuál es el nombre de tu empresa?",
        "tipo": "text",
        "nombre": "nombre_empresa",
        "dependencia_previa": null
    },
    {
        "titulo": "¿Cuál es la situación actual?",
        "tipo": "textarea",
        "nombre": "situacion_actual",
        "dependencia_previa": null
    }
]
```

### Modificación Sugerida (opcional)

Si quieres forzar que ciertas preguntas requieran la anterior:

```json
[
    {
        "titulo": "¿Cuál es el nombre de tu empresa?",
        "tipo": "text",
        "nombre": "nombre_empresa",
        "dependencia_previa": null
    },
    {
        "titulo": "¿Cuál es la situación actual?",
        "tipo": "textarea",
        "nombre": "situacion_actual",
        "dependencia_previa": "Activo"  // ← Cambiar a "Activo"
    }
]
```

**Comportamiento:** Usuario debe responder nombre de empresa antes de poder avanzar a situación actual.

---

## ✅ Ventajas de Este Enfoque

1. **Simple:** Solo 2 valores posibles (`null` o `"Activo"`)
2. **Retrocompatible:** JSON actual con `null` funciona sin cambios
3. **Mínima implementación:** ~1 hora de código
4. **Fácil de entender:** Lógica clara y directa
5. **Flexible:** Se puede activar/desactivar por pregunta

---

## 🚨 Consideraciones

### ✅ Retrocompatibilidad
- JSON actual tiene todo en `null`
- Implementación trata `null` como "sin dependencia"
- **Sin riesgo de romper funcionalidad actual**

### ⚠️ Limitaciones
- Solo valida que pregunta anterior tenga respuesta (no valida contenido específico)
- No soporta dependencias complejas (ej: "solo si respuesta es X")
- No soporta saltos de preguntas

### 💡 Futuras Mejoras (si se necesitan)
- Agregar valor `"ContenidoEspecifico"` para validar respuesta exacta
- Agregar `dependencia_campo` para referenciar campo específico
- Agregar `dependencia_valor` para validar contenido

---

## ✅ Aprobación

**Para aprobar e implementar:**

- [ ] Revisar lógica de validación propuesta
- [ ] Confirmar que enfoque simple es suficiente
- [ ] Aprobar estimación de 2 horas
- [ ] Decidir si implementar feedback visual (Tarea 3)
- [ ] Confirmar casos de prueba

**Una vez aprobado, se implementará en ~2 horas.**

---

**Elaborado por:** GitHub Copilot CLI  
**Versión:** 2.0 (Simplificada)
