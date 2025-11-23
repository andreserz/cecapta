# Propuesta: Asistente de Configuración de Chatbot IA

## Por Qué

Se necesita una interfaz administrativa intuitiva que permita a los usuarios configurar chatbots de IA sin conocimientos técnicos. Actualmente no existe una herramienta visual para capturar los parámetros necesarios del chatbot (nombre empresa, tono, FAQs, horarios, etc.), lo que dificulta la adopción del servicio.

## Qué Cambia

- **Nuevo módulo**: Dashboard de configuración tipo wizard en `./dashboard/`
- **Interfaz guiada**: Sistema de preguntas paso a paso con navegación bidireccional
- **Almacenamiento histórico**: Guardar configuraciones en archivos JSON timestamped en `./dashboard/respuestas/`
- **Diseño responsive**: Layout adaptativo mobile-first con versión desktop de dos columnas
- **Stack tecnológico**: HTML5, CSS (Tailwind + daisyUI), JavaScript vanilla, PHP backend

### Características Clave

1. **Wizard de 7 pasos** que captura:
   - Nombre de la empresa
   - Objetivo del chatbot
   - Tono de comunicación (selección)
   - Preguntas frecuentes
   - Horario de atención
   - Mensaje de despedida
   - URL del sitio web

2. **Interfaz sin scroll** (Single Page, contenido dinámico)

3. **Paleta de colores**:
   - Tema oscuro (`#111827` fondo)
   - Acento primario: Naranja vibrante (`#F97316`)
   - Acentos secundarios: Extraídos de `https://cecapta.callblasterai.com`

4. **Experiencia de usuario**:
   - Barra de progreso visual
   - Indicador "Paso X de N"
   - Navegación Anterior/Siguiente/Finalizar
   - Validación de respuestas antes de avanzar
   - Feedback visual de pasos completados

5. **Backend PHP**:
   - `index.php`: Página principal con array de preguntas
   - `guardar.php`: Endpoint POST que guarda respuestas con timestamp

## Impacto

### Capacidades Afectadas
- **NUEVA**: `chatbot-configuration` - Sistema completo de configuración de chatbots

### Archivos Afectados
- **Nuevos**:
  - `./dashboard/index.php`
  - `./dashboard/guardar.php`
  - `./dashboard/script.js`
  - `./dashboard/respuestas/` (directorio con permisos de escritura)

### Infraestructura
- **Servidor**: Nginx en VPS existente
- **Permisos**: La carpeta `./dashboard/respuestas/` necesita permisos de escritura para el usuario del servidor web
- **CDN**: Tailwind CSS y daisyUI via CDN (sin instalación local)

### Dependencias Externas
- Tailwind CSS (CDN)
- daisyUI (CDN)
- Google Fonts (Inter o Manrope)

## Consideraciones de Seguridad

- **Validación de entrada**: Sanitizar todos los inputs antes de guardar
- **Límite de tamaño**: Implementar límite en textarea para prevenir abuse
- **Protección de archivos**: Los JSON guardados no deben ser accesibles públicamente vía web
- **Rate limiting**: Considerar límite de peticiones para prevenir spam del endpoint de guardado

## Próximos Pasos

1. Revisar y aprobar esta propuesta
2. Implementar según `tasks.md`
3. Configurar permisos del directorio `respuestas/`
4. Probar en entorno de desarrollo
5. Desplegar a producción
6. Archivar cambio tras despliegue exitoso
