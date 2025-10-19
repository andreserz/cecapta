# Diseño - Interfaz Web de Validación de Servicios

## 📋 Información General

**Título**: Validación de servicios para Call Blaster AI  
**Propósito**: Probar todos los endpoints implementados de forma individual o masiva  
**Tecnologías**: PHP 8.3, HTML5, TailwindCSS, JavaScript (Vanilla)

---

## 🎨 Diseño Visual

### Layout General

```
┌─────────────────────────────────────────────────────────┐
│  🔷 Validación de servicios para Call Blaster AI       │
│  ─────────────────────────────────────────────────────  │
│                                                          │
│  [ 🚀 Ejecutar Todas las Pruebas ]  [ 🔄 Limpiar ]    │
│                                                          │
│  ┌──────────────────────────────────────────────────┐  │
│  │ ▶ 1. Consultar Empresas              [✓ Exitoso]│  │
│  ├──────────────────────────────────────────────────┤  │
│  │ 🔍 Detalles de la prueba                         │  │
│  │ ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━│  │
│  │ Endpoint: GET /Empresas/ConsultarTabla          │  │
│  │ Tiempo: 1.23s                                    │  │
│  │ Estado: 200 OK                                   │  │
│  │                                                   │  │
│  │ Respuesta:                                       │  │
│  │ {                                                │  │
│  │   "empresas": [...]                              │  │
│  │ }                                                │  │
│  │                                [ ▶ Ejecutar ]    │  │
│  └──────────────────────────────────────────────────┘  │
│                                                          │
│  ┌──────────────────────────────────────────────────┐  │
│  │ ▼ 2. Consultar Sucursales         [⏳ Ejecutando]│  │
│  └──────────────────────────────────────────────────┘  │
│                                                          │
│  ... (más acordeones)                                   │
│                                                          │
└─────────────────────────────────────────────────────────┘
```

---

## 🏗️ Estructura de Archivos

### Archivos a Crear

```
public/
├── test-endpoints.php          # Página principal
├── api/
│   └── test-runner.php        # API para ejecutar pruebas
├── assets/
│   ├── css/
│   │   └── test-page.css      # Estilos personalizados (opcional)
│   └── js/
│       └── test-page.js       # JavaScript para interactividad
└── config/
    └── test-config.php        # Configuración de pruebas
```

---

## 📊 Endpoints a Probar

### Grupo 1: Consultas (5 endpoints)

1. **Consultar Empresas**
   - Endpoint: `GET /Empresas/ConsultarTabla/{token}`
   - Use Case: `ConsultarEmpresas`

2. **Consultar Sucursales**
   - Endpoint: `GET /Sucursales/ConsultarXEmpresa/{token}/{empresaId}`
   - Use Case: `ConsultarSucursales`

3. **Consultar Campañas**
   - Endpoint: `GET /Campañas/ConsultarXEmpresa/{token}/{empresaId}`
   - Use Case: `ConsultarCampañas`

4. **Consultar Empleados**
   - Endpoint: `GET /Empleados/ConsultarXEmpresa/{token}/{empresaId}`
   - Use Case: `ConsultarEmpleados`

5. **Consultar Productos**
   - Endpoint: `GET /Productos/ConsultarXEmpresa/{token}/{empresaId}`
   - Use Case: `ConsultarProductos`

### Grupo 2: Registro y Ventas (3 endpoints)

6. **Registrar Prospecto**
   - Endpoint: `GET /Prospectos/Agregar/{token}/{curp}/{nombre}/{lada}/{telefono}`
   - Use Case: `RegistrarProspecto`
   - **NOTA**: Usará datos de prueba ficticios

7. **Crear Oportunidad**
   - Endpoint: `GET /Oportunidades/AgregarCabecero/{token}/...`
   - Use Case: `CrearOportunidad`
   - **NOTA**: Requiere prospecto del test anterior

8. **Agregar Producto a Oportunidad**
   - Endpoint: `GET /Oportunidades/AgregarProducto/{token}/...`
   - Use Case: `AgregarProductoAOportunidad`
   - **NOTA**: Requiere oportunidad del test anterior

---

## 🎯 Estados de Prueba

Cada prueba puede tener uno de estos estados:

| Estado | Emoji | Color | Descripción |
|--------|-------|-------|-------------|
| `pending` | ⚪ | Gris | No ejecutado aún |
| `running` | ⏳ | Azul | Ejecutándose actualmente |
| `success` | ✅ | Verde | Ejecutado exitosamente |
| `error` | ❌ | Rojo | Error en la ejecución |
| `warning` | ⚠️ | Amarillo | Ejecutado con advertencias |

---

## 🔧 Funcionalidad

### Botón Individual

Al hacer clic en **"▶ Ejecutar"** de un endpoint:

1. Cambia estado a `running`
2. Realiza petición AJAX a `api/test-runner.php`
3. Muestra spinner en el acordeón
4. Recibe respuesta y actualiza estado
5. Muestra detalles técnicos:
   - Tiempo de respuesta
   - Código HTTP
   - Headers relevantes
   - Body de respuesta (formateado)
   - Errores (si los hay)

### Botón Masivo

Al hacer clic en **"🚀 Ejecutar Todas las Pruebas"**:

1. Ejecuta pruebas secuencialmente (una por una)
2. Actualiza estado en tiempo real
3. Respeta dependencias (ej: Oportunidad requiere Prospecto)
4. Muestra progreso general
5. Al finalizar, muestra resumen:
   - Total ejecutadas
   - Exitosas
   - Fallidas
   - Tiempo total

### Botón Limpiar

Al hacer clic en **"🔄 Limpiar"**:

1. Cierra todos los acordeones
2. Restablece estados a `pending`
3. Limpia resultados almacenados
4. No elimina datos en la API (solo limpia la UI)

---

## 💻 Detalles Técnicos de Implementación

### Backend (test-runner.php)

**Entrada (JSON)**:
```json
{
  "action": "run-test",
  "endpoint": "consultar-empresas",
  "params": {
    "token": "xxx"
  }
}
```

**Salida (JSON)**:
```json
{
  "status": "success",
  "endpoint": "consultar-empresas",
  "execution_time": 1.234,
  "http_code": 200,
  "response": {
    "data": [...],
    "count": 3
  },
  "details": {
    "url": "https://integraapp.net/API/...",
    "method": "GET",
    "headers": {...}
  },
  "timestamp": "2025-10-15 18:30:45"
}
```

**Salida Error (JSON)**:
```json
{
  "status": "error",
  "endpoint": "consultar-empresas",
  "execution_time": 0.234,
  "http_code": 500,
  "error": {
    "message": "Error de conexión",
    "type": "ApiConnectionException",
    "trace": "..."
  },
  "timestamp": "2025-10-15 18:30:45"
}
```

### Frontend (JavaScript)

**Funciones principales**:

```javascript
// Ejecutar prueba individual
async function runTest(endpointId)

// Ejecutar todas las pruebas
async function runAllTests()

// Actualizar estado de prueba
function updateTestState(endpointId, state, data)

// Mostrar/ocultar acordeón
function toggleAccordion(endpointId)

// Formatear JSON para display
function formatJSON(data)

// Limpiar todos los resultados
function clearAllResults()
```

---

## 🎨 Diseño Visual Detallado

### Colores (TailwindCSS)

- **Fondo página**: `bg-gray-50`
- **Contenedor principal**: `bg-white shadow-lg rounded-lg`
- **Acordeón cerrado**: `bg-gray-100 hover:bg-gray-200`
- **Acordeón abierto**: `bg-white border-l-4 border-blue-500`
- **Botón principal**: `bg-blue-600 hover:bg-blue-700 text-white`
- **Botón secundario**: `bg-gray-200 hover:bg-gray-300 text-gray-700`

### Estados Visuales

**Pendiente**:
```
┌────────────────────────────────────────┐
│ ▶ 1. Consultar Empresas    [⚪ Pendiente]│
└────────────────────────────────────────┘
```

**Ejecutando**:
```
┌────────────────────────────────────────┐
│ ▼ 1. Consultar Empresas  [⏳ Ejecutando]│
├────────────────────────────────────────┤
│ 🔄 Ejecutando prueba...                │
│ ▓▓▓▓▓▓▓░░░░░░░ 45%                     │
└────────────────────────────────────────┘
```

**Exitoso**:
```
┌────────────────────────────────────────┐
│ ▼ 1. Consultar Empresas     [✅ Exitoso]│
├────────────────────────────────────────┤
│ ✓ Prueba completada exitosamente       │
│ ⏱ Tiempo: 1.23s                        │
│ 📊 Resultados: 3 empresas encontradas  │
│                                         │
│ 📋 Respuesta:                           │
│ ┌─────────────────────────────────────┐│
│ │ {                                   ││
│ │   "empresas": [                     ││
│ │     { "id": 24, "nombre": "..." }   ││
│ │   ]                                 ││
│ │ }                                   ││
│ └─────────────────────────────────────┘│
│                                         │
│          [ ▶ Re-ejecutar ]              │
└────────────────────────────────────────┘
```

**Error**:
```
┌────────────────────────────────────────┐
│ ▼ 1. Consultar Empresas        [❌ Error]│
├────────────────────────────────────────┤
│ ✗ Error en la ejecución                │
│ ⏱ Tiempo: 0.23s                        │
│                                         │
│ ⚠️ Error:                               │
│ ApiConnectionException: Error de       │
│ conexión con la API                    │
│                                         │
│ 🔍 Detalles:                            │
│ - URL: https://integraapp.net/...      │
│ - Código HTTP: 500                     │
│                                         │
│          [ ▶ Reintentar ]               │
└────────────────────────────────────────┘
```

---

## 📱 Responsividad

### Desktop (> 1024px)
- Ancho máximo del contenedor: `1200px`
- 2 columnas para botones principales
- Acordeones con padding generoso

### Tablet (768px - 1024px)
- Ancho completo con padding
- 2 columnas para botones
- Acordeones más compactos

### Mobile (< 768px)
- Ancho completo
- 1 columna para botones (stack vertical)
- Acordeones optimizados para móvil
- Font-size ligeramente menor

---

## 🔒 Seguridad

### Consideraciones

1. **Token**: Se cargará desde configuración, no hardcoded en frontend
2. **Rate Limiting**: Implementar en backend para evitar abuso
3. **CSRF Protection**: Token CSRF en formularios
4. **Validación**: Validar todos los inputs en backend
5. **Errores**: No exponer información sensible en mensajes de error

---

## 🧪 Datos de Prueba

### Para Endpoints de Escritura

**Prospecto de Prueba**:
```php
$testProspecto = [
    'curp' => 'TEST920615HDFRRN05',  // CURP ficticio válido
    'nombre' => 'Juan Test Pérez',
    'lada' => '999',
    'telefono' => '0000000000'
];
```

**Oportunidad de Prueba**:
```php
$testOportunidad = [
    'empresaId' => 24,
    'sucursalId' => 5,
    'empleadoId' => 10,
    'campañaId' => 3,
    'prospectoId' => '{desde test anterior}',
    'probabilidad' => 50
];
```

**Producto de Prueba**:
```php
$testProducto = [
    'oportunidadId' => '{desde test anterior}',
    'productoId' => 101,
    'cantidad' => 1,
    'esquemaImpuestosId' => 1,
    'precioId' => 5,
    'precioValor' => 100.00
];
```

---

## 📊 Características Adicionales (Opcionales)

### Historial de Ejecuciones

- Guardar últimas 10 ejecuciones en localStorage
- Mostrar en panel lateral colapsable
- Comparar resultados entre ejecuciones

### Exportar Resultados

- Botón para exportar como JSON
- Botón para exportar como PDF (reporte)
- Botón para copiar al portapapeles

### Modo Desarrollador

- Mostrar request completo (headers, body)
- Mostrar response raw (sin formatear)
- Mostrar stack trace completo en errores

### Notificaciones

- Toast notifications para eventos importantes
- Sonido al completar todas las pruebas
- Notificación desktop (con permiso)

---

## 🎯 Flujo de Usuario

### Escenario 1: Prueba Individual

```
Usuario abre página
    ↓
Ve lista de endpoints (todos en estado pendiente)
    ↓
Click en "▶ Ejecutar" de un endpoint específico
    ↓
Acordeón se expande automáticamente
    ↓
Muestra "Ejecutando..." con spinner
    ↓
Backend ejecuta prueba
    ↓
Recibe respuesta
    ↓
Actualiza UI con resultados
    ↓
Usuario revisa detalles
    ↓
Puede re-ejecutar o probar otro endpoint
```

### Escenario 2: Prueba Masiva

```
Usuario abre página
    ↓
Click en "🚀 Ejecutar Todas las Pruebas"
    ↓
Sistema ejecuta pruebas secuencialmente
    ↓
Actualiza cada acordeón en tiempo real
    ↓
Progreso general se muestra en header
    ↓
Al finalizar, muestra resumen modal
    ↓
Usuario revisa resultados individuales
```

---

## 🚀 Propuesta de Implementación

### Fase 1: Backend
1. Crear `test-runner.php` con lógica de pruebas
2. Implementar cada test usando Use Cases existentes
3. Formatear respuestas en JSON estándar

### Fase 2: Frontend Base
1. Crear `test-endpoints.php` con HTML estructura
2. Integrar TailwindCSS via CDN
3. Crear acordeones con HTML/CSS

### Fase 3: Interactividad
1. Crear `test-page.js` con funciones AJAX
2. Implementar estados y transiciones
3. Conectar botones con funcionalidad

### Fase 4: Refinamiento
1. Agregar animaciones suaves
2. Mejorar UX con loading states
3. Agregar manejo de errores robusto
4. Testing en diferentes navegadores

---

## 📋 Preguntas para Revisión

Antes de proceder con la construcción, confirma:

1. **¿El diseño visual propuesto es adecuado?** ¿Prefieres otro framework CSS (Bootstrap, etc.)?

2. **¿Los datos de prueba para endpoints de escritura son aceptables?** ¿O prefieres modo "dry-run" sin escribir datos reales?

3. **¿Necesitas autenticación en la página de pruebas?** ¿O puede ser pública/interna?

4. **¿Quieres las características opcionales?** (historial, export, modo dev)

5. **¿La ubicación `public/test-endpoints.php` es correcta?** ¿O prefieres otro path?

6. **¿Quieres que los tests de escritura (Prospecto, Oportunidad) ejecuten con datos reales?** ¿O simular sin persistir?

7. **¿El resumen al finalizar todas las pruebas debe mostrarse en modal o en la página?**

8. **¿Necesitas algún tipo de logging/auditoría** de las ejecuciones de pruebas?

---

## ✅ Próximos Pasos

Una vez que apruebes este diseño:

1. Crearé la estructura de archivos
2. Implementaré el backend (test-runner.php)
3. Implementaré el frontend (HTML + CSS + JS)
4. Probaré todos los endpoints
5. Documentaré el uso

---

**Versión del Documento**: 1.0.0  
**Fecha**: Octubre 2025  
**Estado**: ⏳ Pendiente de Revisión y Aprobación
