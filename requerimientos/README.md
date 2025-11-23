# Requerimientos de Configuración de Chatbot IA

Sistema de wizard (asistente paso a paso) para configurar chatbots de IA sin conocimientos técnicos.

## 📋 Características

- ✅ **Wizard de 14 pasos** para capturar configuración completa del chatbot
- ✅ **Preguntas configurables desde JSON** (`preguntas/requirements.json`)
- ✅ **Diseño responsive** mobile-first sin scroll (funciona en cualquier dispositivo)
- ✅ **Tema oscuro** con paleta de colores naranja corporativa
- ✅ **Validación en tiempo real** de todos los campos
- ✅ **Almacenamiento histórico** en archivos JSON con timestamp
- ✅ **Sistema de backup automático** con versionamiento
- ✅ **Dos modos de guardado**: "Guardar para después" y "Finalizar y enviar"
- ✅ **Notificaciones por correo** en entregas finales
- ✅ **Navegación intuitiva** con teclado y mouse
- ✅ **Feedback visual** de progreso y completitud

## 🚀 Acceso

Accede al wizard desde tu navegador:

```
https://cecapta.callblasterai.com/requerimientos/
```

## 📊 Datos Recopilados

El wizard recopila los siguientes datos en 14 pasos:

1. **Nombre de la empresa** (texto, máx. 200 caracteres)
2. **Situación actual** (textarea, máx. 2000 caracteres)
3. **Objetivos del asistente** (textarea, máx. 2000 caracteres)
4. **Métricas esperadas** (textarea, máx. 2000 caracteres)
5. **Nombre del asistente** (texto, máx. 200 caracteres)
6. **Tono de comunicación** (selección: Formal, Amigable, Divertido, Profesional)
7. **Saludo** (texto, máx. 500 caracteres)
8. **Casos de uso** (textarea, máx. 5000 caracteres)
9. **Flujos conversacionales** (textarea, máx. 3000 caracteres)
10. **Reglas de negocio** (textarea, máx. 3000 caracteres)
11. **Preguntas frecuentes** (textarea, máx. 3000 caracteres)
12. **Horario de atención** (textarea, máx. 500 caracteres)
13. **Mensaje de despedida** (texto, máx. 300 caracteres)
14. **URL del sitio web** (URL válida, máx. 500 caracteres)

> **Nota:** Las preguntas se configuran dinámicamente desde `preguntas/requirements.json`, lo que permite modificarlas sin cambiar el código.

## 📁 Estructura de Archivos

```
requerimientos/
├── index.php              # Interfaz principal del wizard
├── guardar.php           # Endpoint backend para guardar configuraciones
├── script.js             # Lógica JavaScript del wizard
├── preguntas/            # Configuración de preguntas
│   ├── requirements.json # Definición de preguntas del wizard
│   └── backups/          # Backups con timestamp
│       └── requirements_YYYYmmDD_HHMMSS.json
├── respuestas/           # Directorio de almacenamiento legacy (permisos 755)
│   └── respuestas_*.json # Archivos de respuestas guardadas
└── README.md             # Esta documentación
```

## 🔧 Configuración del Servidor

### Requisitos

- **PHP**: 8.3+
- **Nginx**: Configurado para procesar PHP
- **Extensiones PHP**: json, mbstring, filter
- **Función PHP mail()**: Habilitada para notificaciones
- **Permisos**: Directorios `respuestas/` y `preguntas/backups/` con permisos de escritura (755)

### Configuración de Nginx

Para proteger los archivos JSON de acceso público directo, agrega a tu configuración de Nginx:

```nginx
# Denegar acceso directo a archivos JSON
location ~ ^/requerimientos/respuestas/.*\.json$ {
    deny all;
    return 403;
}

location ~ ^/requerimientos/preguntas/.*\.json$ {
    deny all;
    return 403;
}

# O denegar acceso completo a los directorios
location /requerimientos/respuestas/ {
    deny all;
}

location /requerimientos/preguntas/ {
    deny all;
}
```

Recarga Nginx después de cambios:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

### Verificar Permisos

```bash
# Verificar permisos de los directorios
ls -la requerimientos/respuestas/
ls -la requerimientos/preguntas/

# Si es necesario, ajustar permisos
chmod 755 requerimientos/respuestas/
chmod 755 requerimientos/preguntas/backups/
chown www-data:www-data requerimientos/respuestas/
chown www-data:www-data requerimientos/preguntas/backups/
```

## 💾 Formato de Datos Guardados

### Archivo de Preguntas (`preguntas/requirements.json`)

Define las preguntas del wizard:

```json
[
  {
    "titulo": "¿Cuál es el nombre de tu empresa?",
    "tipo": "text",
    "placeholder": "Ej: CallBlaster AI",
    "nombre": "nombre_empresa",
    "maxlength": 200,
    "valor_defecto": "CECAPTA"
  }
]
```

#### Campos Soportados

- **titulo**: Texto de la pregunta (requerido)
- **tipo**: `text`, `textarea`, `select`, `url` (requerido)
- **nombre**: Identificador único del campo (requerido)
- **placeholder**: Texto de ayuda (opcional)
- **maxlength**: Longitud máxima (opcional, por defecto 500)
- **opciones**: Array de opciones para tipo `select` (requerido para select)
- **valor_defecto**: Valor inicial (opcional)
- **dependencia_previa**: Objeto de dependencia condicional (opcional)

#### Dependencias entre Preguntas

El campo `dependencia_previa` permite crear flujos condicionales:

```json
{
  "titulo": "Proporciona la URL de tu sitio web",
  "tipo": "url",
  "nombre": "url_website",
  "dependencia_previa": {
    "campo": "tiene_website",
    "condicion": "valor_especifico",
    "valor": "Sí",
    "mensaje_error": "Primero debes indicar que tienes un sitio web"
  }
}
```

**Condiciones disponibles:**

1. **no_vacio**: El campo anterior debe tener contenido
2. **valor_especifico**: El campo debe ser igual a `valor`
3. **contiene**: El campo debe contener el texto en `valor`
4. **mayor_que**: El campo debe tener longitud mayor que `valor`

**Comportamiento:**
- Sin dependencia: navegación normal
- Dependencia cumplida: permite avanzar
- Dependencia NO cumplida: bloquea botón "Siguiente" y muestra error
- La navegación hacia atrás siempre es libre

### Archivo de Respuestas

Cada configuración se guarda en dos ubicaciones:

1. **Legacy** (`respuestas/respuestas_YYYYmmDD_HHMMSS.json`)
2. **Backup** (`preguntas/backups/requirements_YYYYmmDD_HHMMSS.json`)

Formato:

```json
{
  "fecha_guardado": "2025-10-22 03:15:30",
  "modo": "final",
  "respuestas": {
    "nombre_empresa": "CallBlaster AI",
    "objetivo_chatbot": "Atender dudas frecuentes de clientes...",
    "tono_comunicacion": "Amigable",
    "preguntas_frecuentes": "1. ¿Cuáles son los horarios?\n2. ...",
    "horario_atencion": "Lunes a Viernes de 9am a 6pm",
    "mensaje_despedida": "¡Estoy para servirte!",
    "url_website": "https://cecapta.callblasterai.com"
  }
}
```

**Modos de guardado**:
- `backup`: Guardado temporal (botón "Guardar para después")
- `final`: Entrega final (botón "Finalizar y enviar" + notificación por correo)

## 🎨 Diseño y UX

### Paleta de Colores

- **Fondo**: #111827 (gris oscuro)
- **Acento primario**: #F97316 (naranja)
- **Acento hover**: #EA580C (naranja oscuro)
- **Completado**: #10B981 (verde)
- **Texto**: #F9FAFB (gris claro)

### Responsive

- **Móvil** (< 768px): Layout de una columna, sin sidebar
- **Desktop** (≥ 1024px): Layout de dos columnas con sidebar de pasos
- **Sin scroll**: Todo el contenido visible en viewport, sin desplazamiento

### Navegación

- **Mouse**: Botones "Anterior", "Siguiente", "Guardar para después", "Finalizar y enviar"
- **Teclado**:
  - `Enter`: Avanzar al siguiente paso (en campos de texto)
  - `Shift + Enter`: Retroceder al paso anterior
  - `Tab`: Navegar entre elementos

## 🔒 Seguridad

### Medidas Implementadas

1. **Sanitización de entrada**: Todos los datos se sanitizan con `filter_var()`
2. **Validación de tipos**: URLs, longitudes máximas, campos requeridos
3. **Método HTTP**: Solo acepta peticiones POST
4. **Protección de archivos**: Configuración Nginx para denegar acceso directo
5. **Permisos de archivos**: 644 para JSONs guardados (solo lectura)
6. **Prevención XSS**: Uso de `htmlspecialchars()` y `textContent` en JS

### Validaciones

- Todos los campos son requeridos (no pueden estar vacíos)
- URLs validadas con `filter_var(FILTER_VALIDATE_URL)`
- Longitudes máximas aplicadas según tipo de campo
- Prevención de inyección con sanitización

## 📧 Notificaciones por Correo

Al usar "Finalizar y enviar", se envía un correo automático a:
- ozeamartinez@gmail.com
- andres.reyes.zamorategui@gmail.com

El correo incluye:
- Nombre de la empresa
- Fecha y hora de entrega
- Resumen de los datos principales
- Nombre del archivo de backup generado

## 📝 Uso

### Flujo Normal

1. Accede a `/requerimientos/`
2. Responde cada pregunta del wizard
3. Navega con "Siguiente" o Enter
4. Retrocede con "Anterior" si necesitas cambiar respuestas
5. En el último paso:
   - **Guardar para después**: Crea backup sin notificación
   - **Finalizar y enviar**: Crea backup + envía notificación por correo
6. Espera el mensaje de confirmación
7. Opcionalmente, crea una nueva configuración

### Gestión de Archivos

Los archivos JSON guardados se acumulan en dos ubicaciones. Para gestión:

```bash
# Listar configuraciones guardadas
ls -lh requerimientos/respuestas/*.json
ls -lh requerimientos/preguntas/backups/*.json

# Ver contenido de una configuración
cat requerimientos/preguntas/backups/requirements_20251022_031530.json

# Eliminar backups antiguos (manual)
find requerimientos/preguntas/backups/ -name "*.json" -mtime +30 -delete  # >30 días
```

### Editar Preguntas del Wizard

Para modificar las preguntas del wizard, edita el archivo:

```bash
nano requerimientos/preguntas/requirements.json
```

Formato de cada pregunta:
```json
{
  "titulo": "Texto de la pregunta",
  "tipo": "text|textarea|select|url",
  "placeholder": "Texto de ejemplo",
  "nombre": "nombre_campo",
  "maxlength": 500,
  "valor_defecto": "Valor inicial (opcional)",
  "opciones": ["Opción 1", "Opción 2"],  // Solo para tipo select
  "dependencia_previa": null  // null=libre, "Activo"=requiere respuesta anterior
}
```

### Dependencias Condicionales (Nuevo ✨)

El sistema ahora soporta navegación condicional mediante el campo `dependencia_previa`:

**Valores posibles:**
- `null` - Navegación libre (comportamiento por defecto)
- `"Activo"` - Requiere que la pregunta anterior esté respondida para avanzar

**Ejemplo de uso:**
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
    "dependencia_previa": "Activo"  // Requiere responder pregunta anterior
  }
]
```

**Comportamiento:**
- Si una pregunta tiene `dependencia_previa: "Activo"`, el usuario **debe** responder la pregunta anterior antes de poder avanzar
- El botón "Siguiente" se deshabilita visualmente si la dependencia no se cumple
- Muestra mensaje específico indicando qué falta
- La navegación hacia atrás (botón "Anterior") siempre es libre
- Compatible con JSON existente (todas las preguntas actuales tienen `null`)

## 🐛 Solución de Problemas

### Error: "No se encontró el archivo de preguntas"

**Solución**: Verificar que existe `preguntas/requirements.json`
```bash
ls -la requerimientos/preguntas/requirements.json
```

### Error: "No se pudo crear el directorio de backups"

**Solución**: Verificar permisos del directorio
```bash
chmod 755 requerimientos/preguntas/
mkdir -p requerimientos/preguntas/backups
chmod 755 requerimientos/preguntas/backups/
```

### El correo no se envía

**Diagnóstico**:
1. Verificar que la función `mail()` está habilitada en PHP
2. Revisar logs de mail: `tail -f /var/log/mail.log`
3. Configurar SMTP si es necesario

## 📊 Monitoreo

### Verificar Espacio en Disco

```bash
# Ver espacio usado por backups
du -sh requerimientos/preguntas/backups/
du -sh requerimientos/respuestas/

# Ver número de configuraciones
ls requerimientos/preguntas/backups/*.json | wc -l
```

### Logs

Los errores se registran en el log de PHP:

```bash
# Log de PHP-FPM
tail -f /var/log/php8.3-fpm.log

# Log de Nginx (errores)
tail -f /var/log/nginx/error.log
```

## 🔄 Actualización

Para actualizar el wizard:

1. Hacer backup de archivos existentes
2. Subir nuevos archivos
3. Verificar permisos
4. Probar en navegador

```bash
# Backup
cp -r requerimientos/ requerimientos_backup_$(date +%Y%m%d)/

# Después de actualizar, verificar
ls -la requerimientos/
```

## 📞 Soporte

Para problemas o preguntas:

1. Revisar esta documentación
2. Verificar logs de PHP y Nginx
3. Revisar configuración de Nginx
4. Verificar permisos de archivos y directorios

## 📜 Licencia

Este proyecto es propiedad de CECAPTA.

---

**Versión**: 2.0.0  
**Última actualización**: Octubre 2025  
**Stack**: PHP 8.3, HTML5, Tailwind CSS, daisyUI, JavaScript ES6+
