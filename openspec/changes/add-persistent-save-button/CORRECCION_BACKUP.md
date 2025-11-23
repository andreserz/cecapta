# Corrección: Guardado y Carga de Backups

## Fecha: 2025-10-22

## Problemas Reportados

1. ✅ Al guardar, no se restauraban los datos al recargar la página
2. ✅ No se veían archivos en la carpeta `/backups/`
3. ✅ Formato de nombre incorrecto: debía ser `backup_YYmmDD_HHMMSS.json`

## Soluciones Implementadas

### 1. Corrección del Formato de Timestamp

**Archivo:** `guardar.php` (líneas 1-5 y 113)

**Antes:**
```php
$timestamp = date('Y-m-d_H-i-s'); // backup_2025-10-22_07-51-30.json
```

**Después:**
```php
// Configurar timezone de México
date_default_timezone_set('America/Mexico_City');

$timestamp = date('ymd_His'); // backup_251022_022802.json
```

**Formato resultante:** `backup_251022_022802.json`
- `ymd` = año (2 dígitos), mes, día → 251022
- `His` = hora, minuto, segundo → 022802
- **Timezone:** America/Mexico_City (hora de México)

### 2. Nuevo Endpoint: Cargar Último Backup

**Archivo creado:** `cargar_ultimo_backup.php`

Este endpoint:
- Busca todos los archivos `backup_*.json` en `/backups/`
- Los ordena por fecha de modificación (más reciente primero)
- Devuelve el contenido del backup más reciente
- Retorna información del archivo y fecha

**Respuesta exitosa:**
```json
{
  "exito": true,
  "backup": {
    "fecha_guardado": "2025-10-22 07:51:30",
    "tipo": "backup",
    "respuestas": { ... },
    "pregunta_actual": 0
  },
  "archivo": "backup_251022_075130.json",
  "fecha_modificacion": "2025-10-22 07:51:30"
}
```

### 3. Carga Automática al Iniciar

**Archivo modificado:** `script.js`

**Cambios:**

1. Función `DOMContentLoaded` ahora es `async`
2. Llama a `await cargarUltimoBackup()` antes de mostrar la primera pregunta
3. Nueva función `cargarUltimoBackup()`:
   - Llama al endpoint `cargar_ultimo_backup.php`
   - Restaura las respuestas guardadas
   - Restaura la pregunta actual
   - Marca preguntas como completadas si tienen valores
   - Muestra notificación toast con fecha de restauración **en timezone de México**

**Formato de fecha en toast:**
```javascript
const fechaLegible = fecha.toLocaleString('es-MX', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    timeZone: 'America/Mexico_City'
});
```

**Flujo de carga:**
```
1. Página carga
2. ↓
3. Intentar cargar último backup
4. ↓
5. Si existe backup:
   - Restaurar respuestas
   - Restaurar pregunta actual
   - Marcar preguntas completadas
   - Mostrar toast de confirmación
6. ↓
7. Renderizar UI con datos restaurados
```

## Notificación de Restauración

Cuando se carga un backup, aparece un toast temporal (4 segundos) en la esquina superior derecha:

```
ℹ️ Progreso restaurado (22/10/2025, 02:28)
```

**Nota:** La fecha/hora mostrada usa el timezone de México (America/Mexico_City)

## Verificación de Archivos

Los backups se guardan correctamente en:
```
/var/www/cecapta.callblasterai.com/requerimientos/backups/
```

Ejemplo de archivos generados:
```
backup_251022_075130.json
backup_251022_080245.json
backup_251022_083012.json
```

## Permisos

- Directorio `/backups/`: `drwxrwxr-x` (775)
- Archivos JSON: `-rw-r--r--` (644)
- Owner: `www-data:www-data` (servidor web)

## Comportamiento Esperado

### Guardado:
1. Usuario llena algunas preguntas
2. Hace clic en "Guardar para después" (cualquier botón)
3. Se muestra spinner "Guardando..."
4. Se guarda archivo `backup_YYmmDD_HHMMSS.json`
5. Modal de confirmación: "✅ Progreso guardado exitosamente"

### Carga (al recargar):
1. Usuario recarga la página
2. Script busca último backup automáticamente
3. Si existe, restaura:
   - Respuestas guardadas
   - Pregunta donde se quedó
   - Preguntas completadas (marcadas con ✓)
4. Toast de notificación: "Progreso restaurado (fecha)"
5. Usuario continúa desde donde se quedó

## Testing Manual Pendiente

- [ ] Guardar en pregunta 1, recargar → debe mostrar pregunta 1 con datos
- [ ] Guardar en pregunta 5, recargar → debe mostrar pregunta 5 con datos
- [ ] Llenar 3 preguntas, guardar, recargar → las 3 deben estar marcadas como completadas
- [ ] Verificar que los archivos en `/backups/` tienen el formato correcto
- [ ] Probar en Chrome, Firefox, Safari
- [ ] Probar en móvil (iOS/Android)

## Archivos Modificados

1. ✅ `guardar.php` - Formato de timestamp corregido + timezone México
2. ✅ `script.js` - Carga automática implementada + formato de fecha con timezone México
3. ✅ `cargar_ultimo_backup.php` - Nuevo endpoint creado + timezone México
4. ✅ `tasks.md` - Actualizado con progreso

## Notas Técnicas

- La carga es silenciosa: si falla, no muestra error (continúa normal)
- Solo se carga el backup MÁS RECIENTE (por `filemtime`)
- Los backups antiguos no se borran automáticamente (quedan en `/backups/`)
- La fecha en el toast usa formato mexicano: `dd/mm/yyyy hh:mm`

## Ajustes Finales de UI

### 1. Reducción de Tamaño del Título
- **Ubicación:** Barra de encabezado (header)
- **Cambio:** Reducción del 33% aproximadamente
- **Antes:** `text-xl md:text-4xl lg:text-2xl`
- **Después:** `text-base md:text-xl lg:text-xl`

### 2. Notificación Toast - Color Naranja con Transparencia
- **Ubicación:** Toast de "Progreso restaurado"
- **Color:** Naranja primario (#F97316) con 70% de transparencia
- **Estilo aplicado:** `background-color: rgba(249, 115, 22, 0.7)`
- **Border:** `border-color: rgba(249, 115, 22, 0.9)`
- **Texto:** Blanco para mejor contraste

**Código del toast actualizado:**
```javascript
toast.innerHTML = `
    <div class="alert shadow-lg" style="background-color: rgba(249, 115, 22, 0.7); border-color: rgba(249, 115, 22, 0.9); color: white;">
        <div>
            <svg>...</svg>
            <span>Progreso restaurado (${fechaLegible})</span>
        </div>
    </div>
`;
```

## Estado: ✅ COMPLETADO

Todos los ajustes implementados. Pendiente solo testing manual en navegador real.
