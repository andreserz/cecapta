# Guía de Uso - Interfaz Web de Pruebas

## 📋 Información General

**URL de Acceso**: `http://tu-dominio.com/pruebas.php`  
**Autenticación**: Palabra clave requerida  
**Palabra Clave**: `CECAPTA`  

---

## 🚀 Acceso a la Interfaz

### Paso 1: Abrir la Página

Navega a: `http://localhost/pruebas.php` (o tu dominio correspondiente)

### Paso 2: Autenticación

1. Se mostrará un formulario de acceso
2. Ingresa la palabra clave: **CECAPTA**
3. Haz clic en "Acceder"

![Pantalla de Login](imagenes/login-screen.png)

### Paso 3: Interfaz Principal

Una vez autenticado, verás la interfaz de pruebas con:
- Título: "🔷 Validación de servicios para Call Blaster AI"
- Botones de control
- Lista de 8 endpoints para probar

---

## 🎯 Funcionalidades

### 1. Ejecutar Prueba Individual

**Para probar un endpoint específico**:

1. Localiza el endpoint en la lista
2. Haz clic en el botón **"▶ Ejecutar"**
3. El acordeón se expandirá automáticamente
4. Verás el progreso con un spinner
5. Una vez completado, se mostrará:
   - Estado (✅ Exitoso o ❌ Error)
   - Tiempo de respuesta
   - Código HTTP
   - Respuesta de la API (JSON formateado)

**Estados Posibles**:
- ⚪ **Pendiente**: No ejecutado
- ⏳ **Ejecutando**: En proceso
- ✅ **Exitoso**: Completado sin errores
- ❌ **Error**: Falló la ejecución

---

### 2. Ejecutar Todas las Pruebas

**Para ejecutar todos los endpoints secuencialmente**:

1. Haz clic en **"🚀 Ejecutar Todas las Pruebas"**
2. Se ejecutarán una por una en orden
3. Verás una barra de progreso en tiempo real
4. Los acordeones se actualizarán conforme se ejecuten
5. Al finalizar, aparecerá un resumen con:
   - Total de pruebas exitosas
   - Total de pruebas fallidas
   - Tiempo total

**Notas Importantes**:
- Las pruebas se ejecutan secuencialmente (una tras otra)
- Las pruebas de ventas (6, 7, 8) tienen dependencias
- Si una prueba falla, las siguientes continuarán ejecutándose

---

### 3. Limpiar Resultados

**Para resetear la interfaz**:

1. Haz clic en **"🔄 Limpiar Resultados"**
2. Confirma la acción
3. Todos los estados volverán a "Pendiente"
4. Se cerrarán todos los acordeones
5. Se ocultará la barra de progreso

**Nota**: Esta acción NO elimina datos de la API, solo limpia la interfaz.

---

## 📊 Endpoints Disponibles

### Grupo 1: Consultas (No Requieren Dependencias)

#### 1. Consultar Empresas
- **Descripción**: Obtiene lista de empresas
- **Endpoint**: `GET /Empresas/ConsultarTabla`
- **Respuesta**: Array de empresas con ID, nombre, alias, estatus

#### 2. Consultar Sucursales
- **Descripción**: Obtiene sucursales de la empresa
- **Endpoint**: `GET /Sucursales/ConsultarXEmpresa`
- **Usa**: `empresa_id` desde configuración

#### 3. Consultar Campañas
- **Descripción**: Obtiene campañas de marketing
- **Endpoint**: `GET /Campañas/ConsultarXEmpresa`
- **Usa**: `empresa_id` desde configuración

#### 4. Consultar Empleados
- **Descripción**: Obtiene lista de empleados
- **Endpoint**: `GET /Empleados/ConsultarXEmpresa`
- **Usa**: `empresa_id` desde configuración

#### 5. Consultar Productos
- **Descripción**: Obtiene catálogo de productos
- **Endpoint**: `GET /Productos/ConsultarXEmpresa`
- **Usa**: `empresa_id` desde configuración

---

### Grupo 2: Registro y Ventas (Con Dependencias)

#### 6. Registrar Prospecto ⚠️
- **Descripción**: Registra un nuevo prospecto
- **Endpoint**: `POST /Prospectos/Agregar`
- **Datos**: CURP, nombre, teléfono (desde config)
- **⚠️ IMPORTANTE**: Crea datos REALES en la API
- **Respuesta**: ID del prospecto creado

#### 7. Crear Oportunidad ⚠️
- **Descripción**: Crea oportunidad de venta
- **Endpoint**: `POST /Oportunidades/AgregarCabecero`
- **Requiere**: Prospecto del paso 6
- **⚠️ IMPORTANTE**: Crea datos REALES en la API
- **Respuesta**: ID de la oportunidad creada

#### 8. Agregar Producto a Oportunidad ⚠️
- **Descripción**: Agrega producto a oportunidad
- **Endpoint**: `POST /Oportunidades/AgregarProducto`
- **Requiere**: Oportunidad del paso 7
- **⚠️ IMPORTANTE**: Crea datos REALES en la API
- **Respuesta**: Confirmación de éxito

---

## ⚠️ Consideraciones Importantes

### Datos Reales

**TODOS los endpoints escriben datos reales en la API de IntegraApp**:

- ✅ Las consultas (1-5) solo leen datos, sin modificaciones
- ⚠️ Las pruebas de ventas (6-8) **CREAN DATOS REALES**:
  - **Prospecto**: Se registra un prospecto de prueba
  - **Oportunidad**: Se crea una oportunidad real
  - **Producto**: Se agrega un producto a la oportunidad

**Recomendación**: Ejecuta estas pruebas en un entorno de desarrollo o pruebas, no en producción.

### Dependencias Entre Pruebas

Las pruebas 7 y 8 requieren que las anteriores sean exitosas:

```
6. Registrar Prospecto
   ↓ (requiere ID)
7. Crear Oportunidad
   ↓ (requiere ID)
8. Agregar Producto
```

Si intentas ejecutar la prueba 7 sin haber ejecutado la 6 primero, recibirás un error indicando la dependencia.

---

## 🔧 Configuración

### Archivo: `config/pruebas.php`

Puedes modificar los datos de prueba editando este archivo:

```php
return [
    'api_token' => 'tu-token-aqui',
    'access_key' => 'CECAPTA',
    
    'test_data' => [
        'empresa_id' => 24,
        'sucursal_id' => 5,
        // ... más IDs
    ],
    
    'test_prospecto' => [
        'curp' => 'PEJJ920615HDFRRN05',
        'nombre' => 'Juan Test Pérez',
        // ... más datos
    ],
];
```

**Nota**: El token de API nunca se muestra en la interfaz por seguridad.

---

## 📱 Interfaz Responsive

La interfaz se adapta a diferentes tamaños de pantalla:

- **Desktop**: Layout completo con 2 columnas de botones
- **Tablet**: Adaptado con espaciado ajustado
- **Móvil**: Vista en columna única optimizada

---

## 🎨 Interpretación de Resultados

### Resultado Exitoso ✅

```
✓ Prueba completada exitosamente

Tiempo de Respuesta: 1.234s
Código HTTP: 200
Timestamp: 2025-10-15 18:30:45

📊 Resumen: 3 empresa(s) encontrada(s)

📋 Respuesta de la API:
{
  "empresas": [...]
}
```

### Resultado con Error ❌

```
✗ Error en la ejecución

Tiempo de Respuesta: 0.234s
Timestamp: 2025-10-15 18:30:45

⚠️ Error:
ApiConnectionException: Error de conexión con la API

Tipo de Excepción:
Cecapta\IntegraApi\Infrastructure\Exception\ApiConnectionException

🔍 Detalles Técnicos:
{
  "endpoint": "consultar-empresas",
  "timestamp": "2025-10-15 18:30:45"
}
```

---

## 🔍 Características Adicionales

### Copiar Respuesta

Cada respuesta exitosa incluye un botón "📋 Copiar" que permite copiar el JSON al portapapeles.

### Re-ejecutar Pruebas

Después de ejecutar una prueba, el botón cambia a:
- **"🔄 Re-ejecutar"** (si fue exitosa)
- **"🔄 Reintentar"** (si falló)

Puedes ejecutar la misma prueba múltiples veces.

### Acordeones Colapsables

- Haz clic en el encabezado del acordeón para expandir/contraer
- El icono cambia: ▶ (cerrado) ↔ ▼ (abierto)
- Los detalles solo se muestran cuando está expandido

---

## 🐛 Solución de Problemas

### "No autenticado"

**Problema**: La sesión expiró

**Solución**: Recarga la página e ingresa la palabra clave nuevamente

---

### "Error de conexión"

**Problema**: No se puede conectar con la API

**Soluciones**:
1. Verifica tu conexión a internet
2. Verifica que la API esté accesible
3. Revisa el token en `config/pruebas.php`

---

### "Endpoint no reconocido"

**Problema**: Error en la configuración

**Solución**: Contacta al administrador del sistema

---

### "Se requiere ejecutar X primero"

**Problema**: Intentaste ejecutar una prueba con dependencias

**Solución**: Ejecuta las pruebas en orden o usa "Ejecutar Todas"

---

## 📊 Casos de Uso Comunes

### Caso 1: Validación Rápida de Consultas

```
1. Acceder con palabra clave
2. Clic en "🚀 Ejecutar Todas las Pruebas"
3. Revisar resumen final
4. Validar que las 5 primeras (consultas) sean exitosas
```

### Caso 2: Prueba de Flujo de Venta Completo

```
1. Ejecutar pruebas 6, 7, 8 en orden
2. Validar que se generen los IDs
3. Verificar en IntegraApp que se crearon los registros
4. Limpiar resultados después de validar
```

### Caso 3: Debug de Endpoint Específico

```
1. Ejecutar solo el endpoint problemático
2. Expandir acordeón para ver detalles
3. Copiar respuesta JSON
4. Analizar el error en detalles técnicos
5. Re-intentar después de ajustes
```

---

## 🔒 Seguridad

### Buenas Prácticas

✅ **Nunca** compartas la palabra clave  
✅ Cierra sesión cuando termines (botón "🚪 Salir")  
✅ No ejecutes pruebas de escritura en producción  
✅ Revisa los datos de prueba antes de ejecutar  

### Protecciones Implementadas

- Autenticación por sesión
- Token API oculto del frontend
- Validación de sesión en cada petición
- Inputs sanitizados

---

## 📚 Recursos Adicionales

- **[README.md](../README.md)** - Documentación principal del proyecto
- **[architecture.md](architecture.md)** - Arquitectura del sistema
- **[uso-prospectos-oportunidades.md](uso-prospectos-oportunidades.md)** - Guía de módulo de ventas

---

## 💡 Tips y Tricks

### Tip 1: Revisar Logs
Si algo falla, revisa los logs del navegador (F12 → Console)

### Tip 2: Ejecutar Consultas Primero
Antes de probar ventas, ejecuta las consultas para validar conectividad

### Tip 3: Limpiar Entre Sesiones
Usa "Limpiar Resultados" entre diferentes sesiones de prueba

### Tip 4: Guardar Respuestas
Usa el botón "Copiar" para guardar respuestas importantes

---

## 🆘 Soporte

Para asistencia:
1. Revisa esta documentación
2. Revisa la consola del navegador
3. Contacta al equipo de desarrollo

---

**Última actualización**: Octubre 2025  
**Versión**: 1.0.0 - Fase 1
