# Plan de Testing - Dependencias de Navegación

**Fecha:** 22 de octubre de 2025  
**Estado:** ✅ IMPLEMENTADO - PENDIENTE DE TESTING

---

## ✅ Implementación Completada

### Cambios Realizados en `script.js`

1. ✅ **Nueva función:** `validarDependenciaPrevia(indicePregunta)`
   - Ubicación: Línea ~317
   - Valida si una pregunta tiene dependencia activa
   - Retorna: `{ valida: boolean, mensaje: string }`

2. ✅ **Modificada:** `navegarSiguiente()`
   - Ubicación: Línea ~397
   - Agregada validación de dependencia antes de avanzar
   - Muestra error y bloquea navegación si no se cumple

3. ✅ **Modificada:** `actualizarBotones()`
   - Ubicación: Línea ~286
   - Agrega feedback visual (botón deshabilitado + tooltip)
   - Evalúa dependencias en tiempo real

---

## 🧪 Casos de Prueba

### Preparación

1. **Acceder al wizard de prueba:**
   ```
   https://cecapta.callblasterai.com/requerimientos/
   ```

2. **Archivo JSON de prueba creado:**
   ```
   requerimientos/preguntas/requirements-test-dependencias.json
   ```

3. **Para usar el JSON de prueba:**
   - Modificar `index.php` temporalmente
   - O crear una copia de prueba de `index.php`

---

### Caso 1: Sin Dependencia (null)

**Configuración:**
```json
{
    "titulo": "¿Cuál es el nombre de tu empresa?",
    "tipo": "text",
    "nombre": "nombre_empresa",
    "dependencia_previa": null
}
```

**Pasos:**
1. Acceder a la primera pregunta
2. Dejar campo vacío
3. Intentar avanzar

**Resultado Esperado:**
- ❌ Debe mostrar error: "Por favor completa este campo antes de continuar"
- ❌ NO debe avanzar (validación de campo vacío normal)

**Pasos (continuación):**
4. Escribir cualquier texto
5. Click en "Siguiente"

**Resultado Esperado:**
- ✅ Debe avanzar normalmente sin bloqueo por dependencia
- ✅ Debe mostrar siguiente pregunta

**Estado:** [ ] Pendiente

---

### Caso 2: Con Dependencia Activa - Bloqueada

**Configuración:**
```json
{
    "titulo": "¿Cuál es la situación actual?",
    "tipo": "textarea",
    "nombre": "situacion_actual",
    "dependencia_previa": "Activo"
}
```

**Pasos:**
1. Iniciar wizard
2. En pregunta 1, dejar campo VACÍO
3. Observar botón "Siguiente"

**Resultado Esperado:**
- ✅ Botón "Siguiente" debe estar deshabilitado visualmente
- ✅ Botón debe tener opacity-50 y cursor-not-allowed
- ✅ Tooltip debe mostrar: "Debes responder [título pregunta anterior] antes de continuar"

**Pasos (continuación):**
4. Intentar hacer click en "Siguiente" (si es posible)

**Resultado Esperado:**
- ❌ NO debe avanzar
- ❌ Debe mostrar mensaje de error específico

**Estado:** [ ] Pendiente

---

### Caso 3: Con Dependencia Activa - Cumplida

**Pasos:**
1. En pregunta 1, escribir: "Mi Empresa S.A."
2. Observar botón "Siguiente"

**Resultado Esperado:**
- ✅ Botón "Siguiente" debe habilitarse
- ✅ Debe quitar clases: opacity-50, cursor-not-allowed
- ✅ Tooltip debe desaparecer

**Pasos (continuación):**
3. Click en "Siguiente"

**Resultado Esperado:**
- ✅ Debe avanzar a pregunta 2
- ✅ Debe mostrar pregunta dependiente

**Estado:** [ ] Pendiente

---

### Caso 4: Navegación Hacia Atrás (Siempre Libre)

**Pasos:**
1. Avanzar hasta pregunta 3 o 4
2. Click en botón "Anterior"

**Resultado Esperado:**
- ✅ Debe retroceder sin validación
- ✅ NO debe bloquearse por dependencias
- ✅ Debe funcionar siempre

**Pasos (continuación):**
3. Retroceder hasta pregunta 1
4. Borrar el contenido de pregunta 1
5. Avanzar con "Siguiente"

**Resultado Esperado:**
- ❌ Debe bloquear por campo vacío (validación normal)

**Estado:** [ ] Pendiente

---

### Caso 5: Dependencia en Primera Pregunta (Edge Case)

**Configuración:**
```json
{
    "titulo": "Primera pregunta",
    "nombre": "primera",
    "dependencia_previa": "Activo"
}
```

**Pasos:**
1. Cargar JSON con primera pregunta con dependencia
2. Observar comportamiento

**Resultado Esperado:**
- ✅ NO debe bloquear (no hay pregunta anterior)
- ✅ Debe funcionar normalmente
- ⚠️ Console debe mostrar warning: "Primera pregunta no puede tener dependencia"

**Estado:** [ ] Pendiente

---

### Caso 6: Alternar entre Preguntas

**Pasos:**
1. Responder pregunta 1: "Empresa Test"
2. Avanzar a pregunta 2
3. Responder pregunta 2 (tiene dependencia activa)
4. Retroceder a pregunta 1
5. BORRAR contenido de pregunta 1
6. Avanzar con "Siguiente"

**Resultado Esperado:**
- ❌ Debe bloquear por campo vacío de pregunta 1
- ❌ NO debe avanzar

**Pasos (continuación):**
7. Escribir nuevo texto en pregunta 1
8. Avanzar

**Resultado Esperado:**
- ✅ Debe avanzar normalmente
- ✅ Pregunta 2 debe mostrar texto previamente guardado

**Estado:** [ ] Pendiente

---

### Caso 7: Múltiples Dependencias Consecutivas

**Configuración:** Usar `requirements-test-dependencias.json`
- Pregunta 1: sin dependencia
- Pregunta 2: con dependencia
- Pregunta 3: con dependencia
- Pregunta 4: sin dependencia
- Pregunta 5: con dependencia

**Pasos:**
1. Responder pregunta 1
2. Avanzar a pregunta 2 (debe permitir)
3. Responder pregunta 2
4. Avanzar a pregunta 3 (debe permitir)
5. Responder pregunta 3
6. Avanzar a pregunta 4 (debe permitir, sin dependencia)
7. NO responder pregunta 4
8. Observar botón "Siguiente"

**Resultado Esperado:**
- ✅ Botón debe estar deshabilitado (pregunta 5 tiene dependencia de 4)

**Estado:** [ ] Pendiente

---

### Caso 8: Retrocompatibilidad con JSON Actual

**Pasos:**
1. Usar el JSON actual de producción: `requirements.json`
2. Verificar que todas las preguntas tienen `dependencia_previa: null`
3. Navegar por todo el wizard

**Resultado Esperado:**
- ✅ Debe funcionar EXACTAMENTE igual que antes
- ✅ NO debe haber cambios en comportamiento
- ✅ NO debe haber errores en console

**Estado:** [ ] Pendiente

---

## 🖥️ Testing en Navegadores

### Desktop
- [ ] Chrome (versión reciente)
- [ ] Firefox (versión reciente)
- [ ] Safari (Mac)
- [ ] Edge (versión reciente)

### Mobile
- [ ] Chrome Mobile (Android)
- [ ] Safari Mobile (iOS)
- [ ] Firefox Mobile

---

## 📱 Testing Responsive

### Breakpoints a probar
- [ ] Mobile: < 768px
- [ ] Tablet: 768px - 1024px
- [ ] Desktop: > 1024px

### Elementos a verificar
- [ ] Botones deshabilitados se ven correctamente
- [ ] Tooltips son legibles
- [ ] Mensajes de error se muestran apropiadamente
- [ ] No hay overflow o scroll no deseado

---

## 🔍 Console Logs Esperados

### Comportamiento Normal
```javascript
// Sin errores en console
// Solo warning esperado:
"Primera pregunta no puede tener dependencia" // Si aplica
```

### No debe aparecer
- ❌ Errores de sintaxis
- ❌ Errores de referencia a funciones
- ❌ Errores de acceso a propiedades undefined

---

## ✅ Checklist de Validación Final

### Funcionalidad
- [ ] Dependencia null funciona (sin bloqueo)
- [ ] Dependencia "Activo" bloquea correctamente
- [ ] Mensajes de error son claros
- [ ] Navegación hacia atrás siempre libre
- [ ] Botones se deshabilitan visualmente
- [ ] Tooltips informativos funcionan

### UX
- [ ] Feedback visual claro
- [ ] Mensajes de error específicos y útiles
- [ ] No hay confusión en navegación
- [ ] Performance sin lag

### Retrocompatibilidad
- [ ] JSON actual (producción) funciona sin cambios
- [ ] No hay regresiones en funcionalidad existente
- [ ] Validaciones normales siguen funcionando

---

## 🐛 Registro de Bugs (Si se encuentran)

### Bug #1
**Descripción:**  
**Pasos para reproducir:**  
**Resultado esperado:**  
**Resultado actual:**  
**Severidad:** [ ] Crítico [ ] Alto [ ] Medio [ ] Bajo  
**Estado:** [ ] Pendiente [ ] En progreso [ ] Resuelto

---

## 📊 Resultado Final

**Fecha de testing:**  
**Tester:**  
**Navegador principal usado:**  
**Casos exitosos:** ___ / 8  
**Bugs encontrados:** ___  
**Estado general:** [ ] ✅ APROBADO [ ] ⚠️ APROBADO CON OBSERVACIONES [ ] ❌ RECHAZADO

**Comentarios:**

---

## 🚀 Listo para Producción

- [ ] Todos los tests pasaron
- [ ] No hay bugs críticos
- [ ] Retrocompatibilidad validada
- [ ] Documentación actualizada
- [ ] README actualizado con ejemplos

**Aprobado por:**  
**Fecha:**  

---

**Notas adicionales:**

