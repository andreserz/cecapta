# Diseño Técnico: Asistente de Configuración de Chatbot

## Contexto

### Problema
Los usuarios necesitan configurar chatbots de IA sin tener conocimientos técnicos. La configuración actual (si existe) requiere editar archivos o usar herramientas técnicas, creando una barrera de entrada significativa.

### Restricciones
- **Servidor**: VPS con Nginx, sin acceso a frameworks backend complejos
- **Stack simple**: Solo HTML, CSS, JS, PHP (sin dependencias composer)
- **Sin base de datos**: Almacenamiento en archivos JSON por simplicidad
- **Rendimiento**: Debe funcionar en conexiones lentas (mobile-first)
- **Accesibilidad**: Debe ser usable desde dispositivos móviles

### Stakeholders
- **Usuarios finales**: Administradores de empresas que configuran chatbots
- **Desarrolladores**: Equipo que consumirá los archivos JSON para configurar chatbots
- **Soporte técnico**: Personal que ayudará a usuarios con problemas

## Objetivos / No-Objetivos

### Objetivos
✅ Crear una experiencia wizard intuitiva paso a paso
✅ Diseño responsive mobile-first sin scroll
✅ Almacenar configuraciones con histórico temporal
✅ Validación básica de inputs del usuario
✅ Feedback visual claro del progreso
✅ Código mantenible y bien documentado

### No-Objetivos
❌ Sistema de autenticación/autorización (fase futura)
❌ Edición de configuraciones existentes (solo creación)
❌ Dashboard de gestión de múltiples chatbots
❌ Integración directa con API de IA (solo configuración)
❌ Exportación a otros formatos (Excel, CSV, etc.)
❌ Validación avanzada (ej: verificar URLs activas)

## Decisiones Técnicas

### 1. Arquitectura: SPA Ligera con JavaScript Vanilla

**Decisión**: Implementar como Single Page Application sin frameworks

**Alternativas consideradas**:
- **React/Vue**: Rechazado por complejidad de setup y build process
- **jQuery**: Rechazado por ser innecesario con JS moderno
- **Framework PHP (Laravel/Symfony)**: Rechazado por overhead y requisitos de servidor

**Justificación**:
- JavaScript vanilla es suficiente para esta complejidad
- Sin dependencias = sin problemas de versiones o builds
- Carga rápida (solo 1 archivo JS)
- Fácil de mantener por cualquier desarrollador

### 2. Storage: Archivos JSON con Timestamp

**Decisión**: Guardar cada configuración en un archivo JSON separado con timestamp

**Alternativas consideradas**:
- **Base de datos SQLite**: Rechazado por agregar dependencia y complejidad
- **Archivo JSON único**: Rechazado por problemas de concurrencia
- **MySQL**: Rechazado por ser overkill para este caso de uso

**Estructura del archivo**:
```json
{
  "fecha_guardado": "2025-10-20 06:30:15",
  "respuestas": {
    "nombre_empresa": "CallBlaster AI",
    "objetivo_chatbot": "Atender dudas frecuentes...",
    "tono_comunicacion": "Amigable",
    "preguntas_frecuentes": "1. ...\n2. ...\n3. ...",
    "horario_atencion": "Lunes a Viernes 9am-6pm",
    "mensaje_despedida": "¡Estoy para servirte!",
    "url_website": "https://cecapta.callblasterai.com"
  }
}
```

**Beneficios**:
- Histórico automático (no se sobrescribe)
- Fácil de inspeccionar manualmente
- Formato estándar consumible por cualquier lenguaje
- Sin problemas de concurrencia (archivos separados)

### 3. UI Framework: Tailwind CSS + daisyUI

**Decisión**: Usar Tailwind CSS con daisyUI via CDN

**Alternativas consideradas**:
- **Bootstrap**: Más pesado, estilos más opinionados
- **CSS puro**: Demasiado tiempo de desarrollo
- **Tailwind standalone**: daisyUI agrega componentes útiles

**Justificación**:
- Tailwind permite desarrollo rápido con utility classes
- daisyUI provee componentes pre-diseñados (botones, cards, progress)
- CDN = sin build process
- Tema oscuro built-in con `data-theme="night"`
- Responsive utilities integradas

### 4. Validación: Frontend-First, Backend Básico

**Decisión**: Validación principal en frontend, sanitización en backend

**Frontend validaciones**:
- Campos no vacíos
- Formato URL básico para el campo website
- Longitud máxima en textareas (5000 caracteres)

**Backend validaciones**:
- `json_decode()` exitoso
- Sanitización con `htmlspecialchars()` o `filter_var()`
- Verificación de estructura de datos

**Justificación**:
- UX mejor con validación inmediata en frontend
- Backend como capa de seguridad (nunca confiar en cliente)
- Balance entre seguridad y simplicidad

### 5. Estado de la Aplicación: JavaScript Object

**Decisión**: Mantener estado en objeto JavaScript simple

```javascript
const estado = {
  preguntaActual: 0,
  respuestas: [],
  preguntasCompletadas: new Set()
};
```

**Justificación**:
- Suficiente para escala pequeña (7 preguntas)
- Sin necesidad de state management library
- Fácil de debuggear en DevTools

## Flujo de Datos

```
[Usuario] 
   ↓ (responde pregunta)
[Frontend JS] 
   ↓ (guarda en estado local)
[Validación Frontend]
   ↓ (click "Finalizar")
[fetch() POST]
   ↓ (JSON en body)
[guardar.php]
   ↓ (valida y sanitiza)
[file_put_contents()]
   ↓
[respuestas/respuestas_YYYY-MM-DD_HH-MM-SS.json]
   ↓ (retorna éxito)
[Mensaje confirmación al usuario]
```

## Estructura de Archivos

```
dashboard/
├── index.php           # Página principal (HTML + array PHP de preguntas)
├── guardar.php         # Endpoint POST para guardar configuraciones
├── script.js           # Lógica del wizard (estado, navegación, fetch)
├── respuestas/         # Directorio de almacenamiento (permisos 755)
│   ├── .htaccess       # Denegar acceso web directo (seguridad)
│   └── respuestas_*.json  # Archivos guardados
└── README.md           # Documentación de uso
```

## Diseño Visual

### Paleta de Colores

```css
/* Tema Principal */
--fondo-oscuro: #111827;
--texto-primario: #F9FAFB;
--texto-secundario: #9CA3AF;

/* Acentos */
--naranja-primario: #F97316;
--naranja-hover: #EA580C;
--naranja-claro: #FDBA74;

/* Estados */
--completado: #10B981;  /* Verde */
--actual: #F97316;       /* Naranja */
--pendiente: #6B7280;    /* Gris */
```

### Layout Responsive

**Mobile (< 768px)**:
```
┌─────────────────────┐
│   [Progreso 3/7]    │
├─────────────────────┤
│                     │
│   ¿Pregunta?        │
│   [Input]           │
│                     │
├─────────────────────┤
│ [Anterior] [Siguiente]│
└─────────────────────┘
```

**Desktop (≥ 1024px)**:
```
┌──────────┬────────────────────┐
│ 1.✓ Empresa│   [Progreso 3/7]   │
│ 2.✓ Objetivo│                    │
│ 3.▶ Tono    │   ¿Pregunta?       │
│ 4.  FAQs   │   [Input]          │
│ 5.  Horario│                    │
│ 6.  Despedida│  [Ant] [Sig]      │
│ 7.  Website│                    │
└──────────┴────────────────────┘
```

## Seguridad

### Mitigaciones Implementadas

1. **XSS Prevention**:
   - Sanitizar outputs con `htmlspecialchars()` en PHP
   - Usar `textContent` en vez de `innerHTML` en JS cuando sea posible

2. **Path Traversal**:
   - No aceptar nombres de archivo del cliente
   - Generar nombres de archivo serverside con formato fijo

3. **Directory Listing**:
   - Archivo `.htaccess` en `respuestas/` para denegar acceso directo

```apache
# dashboard/respuestas/.htaccess
Order Deny,Allow
Deny from all
```

4. **Límite de Tamaño**:
   - Validar tamaño del POST en PHP (`post_max_size`)
   - Limitar longitud de textareas en frontend

5. **Validation**:
   - Validar estructura JSON en backend
   - Rechazar datos malformados con error 400

## Riesgos y Mitigaciones

### Riesgo 1: Pérdida de Datos por Límite de Espacio en Disco
**Probabilidad**: Baja | **Impacto**: Medio

**Mitigación**:
- Monitorear espacio en disco del servidor
- Implementar rotación/limpieza de archivos antiguos (>30 días)
- Alert cuando espacio < 10%

### Riesgo 2: Concurrencia (múltiples usuarios guardando simultáneamente)
**Probabilidad**: Baja | **Impacto**: Bajo

**Mitigación**:
- Timestamps incluyen segundos (colisión improbable)
- Si colisión, PHP sobrescribirá (último gana)
- En fase futura: agregar microsegundos al filename

### Riesgo 3: CDN no disponible (Tailwind/daisyUI)
**Probabilidad**: Muy Baja | **Impacto**: Alto

**Mitigación**:
- Usar CDN confiable (jsDelivr o unpkg)
- Considerar fallback a versión local en producción
- Implementar Service Worker para cache (fase futura)

### Riesgo 4: Usuarios abandonan el wizard a mitad
**Probabilidad**: Media | **Impacto**: Bajo

**Mitigación actual**: Ninguna (no se guarda progreso parcial)

**Mejora futura**:
- LocalStorage para guardar progreso
- Botón "Guardar borrador"
- Recuperar sesión al volver

## Plan de Migración

### Fase 1: MVP (Esta Propuesta)
- Wizard básico con 7 preguntas
- Guardado en JSON
- Sin autenticación

### Fase 2: Mejoras UX (Futuro)
- Guardar progreso en LocalStorage
- Modo de edición de configuraciones existentes
- Preview del chatbot antes de guardar

### Fase 3: Multi-tenant (Futuro)
- Sistema de autenticación
- Dashboard con lista de configuraciones
- Gestión de múltiples chatbots por usuario

### Fase 4: Integración (Futuro)
- Conexión directa con API de IA
- Prueba del chatbot en vivo
- Exportación a otros formatos

## Preguntas Abiertas

### ¿Necesitamos autenticación en MVP?
**Decisión**: NO
- Agregar después si múltiples usuarios/empresas lo requieren
- Por ahora, acceso directo a /dashboard/

### ¿Qué hacer con configuraciones antiguas?
**Decisión**: Manual por ahora
- Administrador puede borrar archivos vía SSH/FTP
- Script de limpieza automática en fase futura

### ¿Validar URLs activas?
**Decisión**: NO en MVP
- Solo validación de formato básico
- Validación de conectividad agregada en fase futura si necesario

## Testing Plan

### Pruebas Manuales Requeridas

1. **Happy Path**:
   - Responder todas las preguntas
   - Verificar guardado exitoso
   - Inspeccionar JSON generado

2. **Edge Cases**:
   - Campos vacíos
   - Caracteres especiales (émojis, acentos, comillas)
   - Textos muy largos
   - URLs inválidas

3. **Responsive**:
   - iPhone SE (320px)
   - iPad (768px)
   - Desktop (1920px)

4. **Navegadores**:
   - Chrome (latest)
   - Firefox (latest)
   - Safari (latest)
   - Mobile Safari

### Criterios de Aceptación

✅ Usuario puede completar wizard en < 3 minutos
✅ Interfaz funciona sin scroll en cualquier paso
✅ JSON se guarda correctamente con todos los datos
✅ Responsive funciona en mobile, tablet, desktop
✅ Validación previene envío con campos vacíos
✅ Mensajes de error/éxito son claros
✅ No hay errores en consola del navegador

## Métricas de Éxito

### Post-Lanzamiento (1 mes)

- **Tasa de Completación**: > 80% de usuarios que empiezan terminan el wizard
- **Tiempo Promedio**: < 5 minutos para completar
- **Tasa de Error**: < 5% de peticiones POST fallan
- **Configuraciones Creadas**: > 10 en primer mes

## Referencias

- [Tailwind CSS Docs](https://tailwindcss.com/docs)
- [daisyUI Components](https://daisyui.com/components/)
- [MDN Fetch API](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)
- [PHP file_put_contents](https://www.php.net/manual/en/function.file-put-contents.php)
