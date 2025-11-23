# Dashboard de Configuración de Chatbot IA

Sistema de wizard (asistente paso a paso) para configurar chatbots de IA sin conocimientos técnicos.

## 📋 Características

- ✅ **Wizard de 7 pasos** para capturar configuración completa del chatbot
- ✅ **Diseño responsive** mobile-first sin scroll (funciona en cualquier dispositivo)
- ✅ **Tema oscuro** con paleta de colores naranja corporativa
- ✅ **Validación en tiempo real** de todos los campos
- ✅ **Almacenamiento histórico** en archivos JSON con timestamp
- ✅ **Navegación intuitiva** con teclado y mouse
- ✅ **Feedback visual** de progreso y completitud

## 🚀 Acceso

Accede al wizard desde tu navegador:

```
https://cecapta.callblasterai.com/dashboard/
```

## 📊 Datos Recopilados

El wizard recopila los siguientes datos en 7 pasos:

1. **Nombre de la empresa** (texto, máx. 200 caracteres)
2. **Objetivo del chatbot** (textarea, máx. 1000 caracteres)
3. **Tono de comunicación** (selección: Formal, Amigable, Divertido, Profesional)
4. **Preguntas frecuentes** (textarea, máx. 2000 caracteres)
5. **Horario de atención** (texto, máx. 200 caracteres)
6. **Mensaje de despedida** (texto, máx. 300 caracteres)
7. **URL del sitio web** (URL válida, máx. 500 caracteres)

## 📁 Estructura de Archivos

```
dashboard/
├── index.php              # Interfaz principal del wizard
├── guardar.php           # Endpoint backend para guardar configuraciones
├── script.js             # Lógica JavaScript del wizard
├── respuestas/           # Directorio de almacenamiento (permisos 755)
│   ├── NGINX_CONFIG.md   # Instrucciones de configuración Nginx
│   └── respuestas_*.json # Archivos de configuración guardados
└── README.md             # Esta documentación
```

## 🔧 Configuración del Servidor

### Requisitos

- **PHP**: 8.3+
- **Nginx**: Configurado para procesar PHP
- **Extensiones PHP**: json, mbstring, filter
- **Permisos**: El directorio `respuestas/` debe tener permisos de escritura (755)

### Configuración de Nginx

Para proteger los archivos JSON de acceso público directo, agrega a tu configuración de Nginx:

```nginx
# Denegar acceso directo a archivos JSON
location ~ ^/dashboard/respuestas/.*\.json$ {
    deny all;
    return 403;
}

# O denegar acceso completo al directorio
location /dashboard/respuestas/ {
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
# Verificar permisos del directorio
ls -la dashboard/respuestas/

# Si es necesario, ajustar permisos
chmod 755 dashboard/respuestas/
chown www-data:www-data dashboard/respuestas/  # Ajusta según tu usuario web
```

## 💾 Formato de Datos Guardados

Cada configuración se guarda en un archivo JSON con el siguiente formato:

```json
{
  "fecha_guardado": "2025-10-20 06:30:15",
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

**Nombre del archivo**: `respuestas_YYYY-MM-DD_HH-MM-SS.json`

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

- **Mouse**: Botones "Anterior" y "Siguiente"/"Finalizar"
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

## 🧪 Testing

### Pruebas Básicas

1. **Navegación**: Verificar que se pueda avanzar y retroceder entre pasos
2. **Validación**: Intentar avanzar con campos vacíos (debe mostrar error)
3. **URL**: Probar con URLs inválidas en el último paso
4. **Guardado**: Completar wizard y verificar archivo JSON creado
5. **Responsive**: Probar en diferentes tamaños de pantalla

### Navegadores Soportados

- Chrome (últimas 2 versiones)
- Firefox (últimas 2 versiones)
- Safari (últimas 2 versiones)
- Edge (últimas 2 versiones)

## 📝 Uso

### Flujo Normal

1. Accede a `/dashboard/`
2. Responde cada pregunta del wizard
3. Navega con "Siguiente" o Enter
4. Retrocede con "Anterior" si necesitas cambiar respuestas
5. En el último paso, haz clic en "Finalizar"
6. Espera el mensaje de confirmación
7. Opcionalmente, crea una nueva configuración

### Gestión de Archivos

Los archivos JSON guardados se acumulan en `respuestas/`. Para gestión:

```bash
# Listar configuraciones guardadas
ls -lh dashboard/respuestas/*.json

# Ver contenido de una configuración
cat dashboard/respuestas/respuestas_2025-10-20_06-30-15.json

# Eliminar configuraciones antiguas (manual)
find dashboard/respuestas/ -name "*.json" -mtime +30 -delete  # >30 días
```

## 🐛 Solución de Problemas

### Error: "No se pudo crear el directorio de respuestas"

**Solución**: Verificar permisos del directorio padre
```bash
chmod 755 dashboard/
```

### Error: "El directorio de respuestas no tiene permisos de escritura"

**Solución**: Ajustar permisos del directorio
```bash
chmod 755 dashboard/respuestas/
chown www-data:www-data dashboard/respuestas/
```

### Error: Los archivos JSON no se guardan

**Diagnóstico**:
1. Verificar que PHP puede escribir: `php -i | grep "file_uploads"`
2. Verificar `post_max_size` en php.ini (debe ser >= 2MB)
3. Revisar logs de PHP: `tail -f /var/log/php8.3-fpm.log`

### La interfaz no se ve correctamente

**Solución**: Verificar que los CDNs están cargando
1. Abrir DevTools (F12)
2. Revisar pestaña Network
3. Verificar que Tailwind CSS y daisyUI cargan correctamente
4. Si CDN falla, considerar copias locales

### Error: "Método no permitido"

**Causa**: Intento de acceder a `guardar.php` con GET
**Solución**: Solo usar desde el wizard (POST automático)

## 📊 Monitoreo

### Verificar Espacio en Disco

```bash
# Ver espacio usado por configuraciones
du -sh dashboard/respuestas/

# Ver número de configuraciones
ls dashboard/respuestas/*.json | wc -l
```

### Logs

Los errores se registran en el log de PHP. Para ver:

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
cp -r dashboard/ dashboard_backup_$(date +%Y%m%d)/

# Después de actualizar, verificar
ls -la dashboard/
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

**Versión**: 1.0.0  
**Última actualización**: Octubre 2025  
**Stack**: PHP 8.3, HTML5, Tailwind CSS, daisyUI, JavaScript ES6+
