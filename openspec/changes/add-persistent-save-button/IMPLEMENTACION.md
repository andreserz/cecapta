# ✅ Implementación Completada: Botón "Guardar para después" Persistente

**Fecha**: 2025-10-22  
**Estado**: ✅ COMPLETADO  
**Tiempo**: ~25 minutos

---

## 🎯 Objetivo Cumplido

Hacer visible el botón "Guardar para después" en **TODAS** las preguntas del wizard de configuración, no solo en la última pregunta.

**Opción implementada**: **Opción C** - Ambas ubicaciones
- Botón compacto en barra de progreso (siempre visible)
- Botón completo en área de navegación (contexto de acción)

---

## 📝 Cambios Realizados

### 1. HTML - `requerimientos/index.php`

#### Botón en Barra de Progreso (línea 215)
```html
<button id="btnGuardarProgress" 
        class="btn btn-sm btn-ghost gap-1 text-orange-500 hover:bg-orange-500 hover:bg-opacity-20" 
        title="Guardar progreso actual">
    💾 <span class="hidden sm:inline">Guardar</span>
</button>
```

**Características:**
- Ubicado entre "Paso X de Y" y el porcentaje
- Compacto: solo emoji en móvil, emoji + texto en desktop
- Colores: naranja (tema del proyecto)
- Tooltip descriptivo

#### Botón en Navegación (línea 255)
```html
<button id="btnGuardarDespues" 
        class="btn btn-outline flex-1 sm:flex-initial gap-2" 
        title="Guardar progreso sin finalizar">
    <span class="hidden sm:inline">💾</span>
    <span class="sm:hidden">💾</span>
    <span class="hidden sm:inline">Guardar para después</span>
    <span class="sm:hidden">Guardar</span>
</button>
```

**Características:**
- Ubicado entre "Anterior" y "Siguiente"
- Responsive: texto completo en desktop, compacto en móvil
- Layout flexible: ancho completo en móvil, auto en desktop

### 2. JavaScript - `requerimientos/script.js`

#### Variables Globales (línea 10)
```javascript
let btnGuardarDespues, btnGuardarProgress;
```

#### Inicialización (líneas 23-24)
```javascript
btnGuardarDespues = document.getElementById('btnGuardarDespues');
btnGuardarProgress = document.getElementById('btnGuardarProgress');
```

#### Event Listeners (líneas 48-49)
```javascript
btnGuardarDespues.addEventListener('click', guardarParaDespues);
btnGuardarProgress.addEventListener('click', guardarParaDespues);
```

#### Nueva Función (línea 328)
```javascript
async function guardarParaDespues() {
    // 1. Guarda respuesta actual
    guardarRespuestaActual();
    
    // 2. Prepara datos con tipo: 'backup'
    const configuracion = {
        tipo: 'backup',
        pregunta_actual: estado.preguntaActual,
        timestamp: new Date().toISOString(),
        respuestas: {...}
    };
    
    // 3. Deshabilita todos los botones
    btnGuardarDespues.disabled = true;
    btnGuardarProgress.disabled = true;
    btnSiguiente.disabled = true;
    btnAnterior.disabled = true;
    
    // 4. Muestra spinner de carga
    btnGuardarDespues.innerHTML = 'Guardando...';
    btnGuardarProgress.innerHTML = '<spinner>';
    
    // 5. Envía petición a guardar.php
    const response = await fetch('guardar.php', {
        method: 'POST',
        body: JSON.stringify(configuracion)
    });
    
    // 6. Muestra modal de éxito/error
    if (response.ok) {
        mensajeExito.textContent = 'Progreso guardado';
        modalExito.showModal();
    }
    
    // 7. Re-habilita botones
    btnGuardarDespues.disabled = false;
    // ... (resto de botones)
}
```

### 3. Backend PHP - `requerimientos/guardar.php`

#### Detección de Tipo (línea 37)
```php
$esBackup = isset($datos['tipo']) && $datos['tipo'] === 'backup';

if ($esBackup) {
    $preguntaActual = $datos['pregunta_actual'] ?? 0;
    $timestamp = $datos['timestamp'] ?? date('c');
    $datos = $datos['respuestas'] ?? [];
}
```

#### Validación Condicional (líneas 58-62)
```php
// Solo validar campos obligatorios si NO es backup
if (!$esBackup) {
    foreach ($clavesEsperadas as $clave) {
        if (!isset($datos[$clave])) {
            throw new Exception("Falta el campo requerido: {$clave}");
        }
    }
}
```

#### Guardado Diferenciado (líneas 122-128)
```php
$prefijo = $esBackup ? 'backup' : 'respuestas';
$subdirectorio = $esBackup ? '/backups' : '/respuestas';
$nombreArchivo = "{$prefijo}_{$timestamp}.json";
$rutaCompleta = __DIR__ . $subdirectorio . "/{$nombreArchivo}";
```

#### Respuesta JSON (líneas 166-170)
```php
echo json_encode([
    'exito' => true,
    'mensaje' => $esBackup ? 'Progreso guardado exitosamente' : 'Configuración guardada',
    'archivo' => $nombreArchivo,
    'tipo' => $esBackup ? 'backup' : 'final',
    'timestamp' => $configuracionCompleta['fecha_guardado'],
    'bytes' => $bytesEscritos
]);
```

### 4. Nuevo Directorio

```bash
/var/www/cecapta.callblasterai.com/requerimientos/backups/
Permisos: 755 (drwxr-xr-x)
Propietario: websop:grpweb
```

**Estructura de archivos guardados:**
```
backups/
├── backup_2025-10-22_01-09-45.json
├── backup_2025-10-22_02-15-30.json
└── backup_2025-10-22_03-20-10.json

respuestas/
├── respuestas_2025-10-22_01-30-00.json
└── respuestas_2025-10-22_02-45-00.json
```

---

## 🎨 Comportamiento Visual

### Desktop (> 1024px)
```
┌─────────────────────────────────────────────────────┐
│ Pregunta 3 de 7     💾 Guardar           14%        │
│━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━│
│                                                     │
│ ¿Cuál es el objetivo principal del asistente?      │
│                                                     │
│ ┌─────────────────────────────────────────────┐   │
│ │ [Campo de entrada]                          │   │
│ └─────────────────────────────────────────────┘   │
│                                                     │
│ [◄ Anterior]  [💾 Guardar para después]  [Siguiente ►] │
└─────────────────────────────────────────────────────┘
```

### Móvil (< 640px)
```
┌─────────────────────────┐
│ Pregunta 3 de 7  💾  14% │
│━━━━━━━━━━━━━━━━━━━━━━━│
│                         │
│ ¿Cuál es el objetivo?   │
│                         │
│ ┌─────────────────────┐ │
│ │ [Campo entrada]     │ │
│ └─────────────────────┘ │
│                         │
│ [💾 Guardar] [Siguiente] │
│ [◄ Anterior]            │
└─────────────────────────┘
```

---

## ✅ Características Implementadas

- [x] **Botón visible en TODAS las preguntas** (no solo la última)
- [x] **Dos ubicaciones**: barra de progreso + navegación
- [x] **Responsive**: móvil, tablet y desktop
- [x] **Feedback visual**: spinner durante guardado
- [x] **Modal de confirmación**: éxito o error
- [x] **Guardado en `/backups/`**: sin enviar correo
- [x] **Validación flexible**: permite campos vacíos en backup
- [x] **Manejo de errores**: robusto con try/catch
- [x] **Accesibilidad**: tooltips y navegación con teclado
- [x] **Sintaxis validada**: PHP y JS sin errores

---

## 📊 Archivos Modificados

| Archivo | Líneas | Cambios |
|---------|--------|---------|
| `index.php` | 210-269 | +2 botones, layout responsive |
| `script.js` | 10, 23-24, 48-49, 328-398 | +variables, +listeners, +función |
| `guardar.php` | 37-170 | +lógica backup, validación condicional |
| `backups/` | - | Directorio creado |

**Total**: ~120 líneas modificadas/agregadas

---

## 🧪 Testing Realizado

### ✅ Validaciones de Sintaxis
- [x] PHP: `php -l guardar.php` → Sin errores
- [x] PHP: `php -l index.php` → Sin errores
- [x] JavaScript: Sintaxis validada

### ✅ Verificaciones de Código
- [x] Botones presentes en HTML (líneas 215, 255)
- [x] Variables declaradas en JS (línea 10)
- [x] Event listeners configurados (líneas 48-49)
- [x] Función `guardarParaDespues()` implementada (línea 328)
- [x] Lógica de backup en PHP (línea 37+)
- [x] Directorio `/backups/` creado con permisos correctos

### ⏳ Pendiente - Testing Manual
- [ ] Guardar desde pregunta 1, 3, 5, 7
- [ ] Verificar archivo JSON en `/backups/`
- [ ] Probar en Chrome, Firefox, Safari
- [ ] Probar en iPhone, Android
- [ ] Probar con campos vacíos
- [ ] Probar con error de red
- [ ] Verificar que NO se envía correo en backup

---

## 🚀 Próximos Pasos

1. **Testing Manual** (30 min)
   - Abrir https://cecapta.callblasterai.com/requerimientos/
   - Navegar a pregunta 2 o 3
   - Click en "💾 Guardar"
   - Verificar modal de éxito
   - Revisar `/backups/backup_YYYY-MM-DD_HH-mm-ss.json`
   - Probar en móvil

2. **Ajustes (si necesario)**
   - Modificar colores del botón
   - Ajustar textos de confirmación
   - Optimizar para pantallas específicas

3. **Documentación**
   - Screenshot de la UI
   - Actualizar README del proyecto
   - Documentar estructura de archivos backup

---

## 📖 Uso

### Para el Usuario
1. Completa una o más preguntas del wizard
2. Click en "💾 Guardar para después" (en cualquier pregunta)
3. Espera confirmación "✅ Progreso guardado exitosamente"
4. Puedes cerrar el navegador y continuar después

### Para el Desarrollador
```javascript
// El guardado se realiza con:
{
    "tipo": "backup",
    "pregunta_actual": 2,
    "timestamp": "2025-10-22T01:09:45.123Z",
    "respuestas": {
        "nombre_empresa": "CECAPTA",
        "objetivo_chatbot": "Atender clientes",
        "tono_comunicacion": "",  // ← Puede estar vacío
        ...
    }
}

// Se guarda en:
/requerimientos/backups/backup_2025-10-22_01-09-45.json

// Con estructura:
{
    "fecha_guardado": "2025-10-22 01:09:45",
    "tipo": "backup",
    "pregunta_actual": 2,
    "timestamp_cliente": "2025-10-22T01:09:45.123Z",
    "respuestas": {...}
}
```

---

## 🔧 Troubleshooting

### Problema: Botón no aparece
**Solución**: Verificar que el archivo `index.php` tiene las líneas 215 y 255 con los botones.

### Problema: Click no hace nada
**Solución**: Abrir consola del navegador, verificar errores JavaScript.

### Problema: Error al guardar
**Solución**: Verificar permisos del directorio `/backups/` (debe ser 755).

### Problema: Archivo no se crea
**Solución**: Verificar que Apache/PHP tiene permisos de escritura en `/requerimientos/backups/`.

---

## 📞 Soporte

Para reportar problemas o sugerencias:
1. Revisar logs de Apache: `/var/log/apache2/error.log`
2. Revisar logs de PHP: `error_log("mensaje")`
3. Verificar consola del navegador (F12)

---

**Implementado por**: AI Assistant  
**Fecha**: 2025-10-22  
**Versión**: 1.0.0  
**Estado**: ✅ COMPLETADO
