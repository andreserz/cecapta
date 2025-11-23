# Plan de Implementación - Módulo de Prospectos y Oportunidades

## 📋 Información General

**Proyecto**: Cliente IntegraApp API - Módulo de Ventas  
**Versión**: 2.0.0  
**Fecha**: Octubre 2025  
**Arquitectura**: Clean Architecture (Arquitectura Limpia)  

---

## 🎯 Objetivo

Implementar un cliente PHP robusto para los endpoints de **Prospectos** y **Oportunidades** de la API IntegraApp, siguiendo la arquitectura limpia existente y permitiendo el registro completo del flujo de ventas:

1. Registrar prospectos (clientes potenciales)
2. Crear oportunidades de venta
3. Agregar productos a oportunidades

---

## 📊 Endpoints a Implementar

### 1. Agregar Prospecto

**URL**: `https://integraapp.net/API/Prospectos/Agregar/{psToken}/{psCURP}/{psNombreCompleto}/{psTelefonoLada}/{psTelefono10Digitos}`

**Método**: GET  
**Respuesta**: 
- Éxito: Número entero (ID del prospecto)
- Error: Cadena que empieza con `-1`

**Parámetros**:
- `psToken`: Token de autenticación
- `psCURP`: CURP del prospecto (18 caracteres)
- `psNombreCompleto`: Nombre completo del prospecto
- `psTelefonoLada`: Lada telefónica (2-4 dígitos)
- `psTelefono10Digitos`: Teléfono (10 dígitos)

---

### 2. Agregar Cabecero de Oportunidad

**URL**: `https://integraapp.net/API/Oportunidades/AgregarCabecero/{psToken}/{pnEmpresaId}/{pnSucursalId}/{pnEmpleadoId}/{pnCampañaId}/{pnProspectoId}/{pbEventoProgramar}/{psEventoSigTipo}/{psEventoSigFechaHora}/{psNotas}/{pnEtapaId}/{psFechaEstimadaCierre}/{pnProbabilidad}`

**Método**: GET  
**Respuesta**:
- Éxito: Número entero (ID de la oportunidad)
- Error: Cadena que empieza con `-1`

**Parámetros**:
- `psToken`: Token de autenticación
- `pnEmpresaId`: ID de la empresa
- `pnSucursalId`: ID de la sucursal
- `pnEmpleadoId`: ID del empleado responsable
- `pnCampañaId`: ID de la campaña
- `pnProspectoId`: ID del prospecto (del endpoint anterior)
- `pbEventoProgramar`: Boolean (true/false)
- `psEventoSigTipo`: Tipo de evento siguiente (opcional)
- `psEventoSigFechaHora`: Fecha/hora del evento (opcional, formato: Y-m-d H:i:s)
- `psNotas`: Notas adicionales (opcional)
- `pnEtapaId`: ID de la etapa del embudo de ventas
- `psFechaEstimadaCierre`: Fecha estimada de cierre (opcional, formato: Y-m-d)
- `pnProbabilidad`: Probabilidad de cierre (0-100)

---

### 3. Agregar Producto a Oportunidad

**URL**: `https://integraapp.net/API/Oportunidades/AgregarProducto/{psToken}/{pnOportunidadId}/{pnProductoId}/{pnCantidad}/{pnEsquemaImpuestosId}/{pnPrecioId}/{pnPrecioValor}/{psNotas}`

**Método**: GET  
**Respuesta**:
- Éxito: `1`
- Error: Cadena que empieza con `-1`

**Parámetros**:
- `psToken`: Token de autenticación
- `pnOportunidadId`: ID de la oportunidad (del endpoint anterior)
- `pnProductoId`: ID del producto
- `pnCantidad`: Cantidad del producto
- `pnEsquemaImpuestosId`: ID del esquema de impuestos
- `pnPrecioId`: ID del precio
- `pnPrecioValor`: Valor del precio unitario
- `psNotas`: Notas sobre el producto (opcional)

---

## 🏗️ Fases de Implementación

### ✅ Fase 1: Análisis y Validación (Completada)

**Objetivo**: Validar endpoints y entender respuestas

**Actividades**:
1. ✅ Probar endpoints con curl
2. ✅ Analizar formato de respuestas
3. ✅ Identificar validaciones necesarias
4. ✅ Documentar especificaciones

**Resultado**: Endpoints validados, respuestas documentadas

---

### ✅ Fase 2: Capa de Dominio (Completada)

**Objetivo**: Crear entidades y value objects del dominio

#### 2.1 Entidades Creadas

**Archivos**:
- `src/Domain/Entity/Prospecto.php`
- `src/Domain/Entity/Oportunidad.php`
- `src/Domain/Entity/OportunidadProducto.php`

**Características**:
- Entidades inmutables (readonly)
- Encapsulación de lógica de negocio
- Métodos de creación estáticos
- Getters para acceso a propiedades

#### 2.2 Value Objects Creados

**Archivos**:
- `src/Domain/ValueObject/ProspectoId.php`
- `src/Domain/ValueObject/OportunidadId.php`
- `src/Domain/ValueObject/CURP.php`

**Características**:
- Inmutables (readonly)
- Validación en constructor
- Igualdad por valor
- Type-safe

#### 2.3 Interfaces de Repositorio

**Archivos**:
- `src/Domain/Repository/ProspectoRepositoryInterface.php`
- `src/Domain/Repository/OportunidadRepositoryInterface.php`

**Métodos**:
- `ProspectoRepositoryInterface::agregar()`
- `OportunidadRepositoryInterface::agregarCabecero()`
- `OportunidadRepositoryInterface::agregarProducto()`

---

### ✅ Fase 3: Capa de Infraestructura (Completada)

**Objetivo**: Implementar comunicación con API

#### 3.1 Extensión del Cliente HTTP

**Archivo**: `src/Infrastructure/Http/IntegraApiClient.php`

**Cambios**:
- ✅ Agregado método `getString()` para respuestas no-JSON
- ✅ Manejo de respuestas tipo string
- ✅ Validación de códigos HTTP

#### 3.2 Repositorios API

**Archivos**:
- `src/Infrastructure/Repository/ProspectoApiRepository.php`
- `src/Infrastructure/Repository/OportunidadApiRepository.php`

**Implementaciones**:
- ✅ Construcción de endpoints con parámetros
- ✅ Codificación URL de parámetros
- ✅ Parseo de respuestas
- ✅ Validación de errores (respuestas con -1)
- ✅ Conversión a value objects
- ✅ Manejo de excepciones

---

### ✅ Fase 4: Capa de Aplicación (Completada)

**Objetivo**: Implementar casos de uso del negocio

#### 4.1 Casos de Uso Creados

**Archivos**:
- `src/Application/UseCase/RegistrarProspecto.php`
- `src/Application/UseCase/CrearOportunidad.php`
- `src/Application/UseCase/AgregarProductoAOportunidad.php`

**Funcionalidades**:

**RegistrarProspecto**:
- Validación de CURP
- Validación de teléfono
- Registro de prospecto
- Retorna ID generado

**CrearOportunidad**:
- Validación de IDs
- Validación de probabilidad (0-100)
- Parseo de fechas opcionales
- Creación de oportunidad
- Retorna ID generado

**AgregarProductoAOportunidad**:
- Validación de producto
- Validación de precio y cantidad
- Método para agregar producto individual
- Método para agregar múltiples productos
- Retorna resultado de operación

---

### ✅ Fase 5: Ejemplos y Documentación (Completada)

**Objetivo**: Crear ejemplos funcionales y documentación

#### 5.1 Ejemplos Creados

**Archivos**:
- `examples/15-registrar-prospecto.php`
- `examples/16-crear-oportunidad.php`
- `examples/17-agregar-productos-oportunidad.php`
- `examples/18-flujo-completo-venta.php`

**Características**:
- ✅ Código comentado y explicativo
- ✅ Manejo de errores
- ✅ Salida formateada y clara
- ✅ Ejemplos paso a paso
- ✅ Flujo completo integrado

#### 5.2 Documentación Actualizada

**Archivos**:
- ✅ `docs/architecture.md` - Arquitectura actualizada
- ✅ `docs/plan-prospectos-oportunidades.md` - Este documento
- ⏳ `README.md` - Pendiente de actualizar

---

## 📁 Estructura de Archivos Creados

```
src/
├── Domain/
│   ├── Entity/
│   │   ├── Prospecto.php                    [NUEVO]
│   │   ├── Oportunidad.php                  [NUEVO]
│   │   └── OportunidadProducto.php          [NUEVO]
│   ├── ValueObject/
│   │   ├── ProspectoId.php                  [NUEVO]
│   │   ├── OportunidadId.php                [NUEVO]
│   │   └── CURP.php                         [NUEVO]
│   └── Repository/
│       ├── ProspectoRepositoryInterface.php [NUEVO]
│       └── OportunidadRepositoryInterface.php [NUEVO]
│
├── Application/
│   └── UseCase/
│       ├── RegistrarProspecto.php           [NUEVO]
│       ├── CrearOportunidad.php             [NUEVO]
│       └── AgregarProductoAOportunidad.php  [NUEVO]
│
└── Infrastructure/
    ├── Http/
    │   └── IntegraApiClient.php             [MODIFICADO]
    └── Repository/
        ├── ProspectoApiRepository.php       [NUEVO]
        └── OportunidadApiRepository.php     [NUEVO]

examples/
├── 15-registrar-prospecto.php               [NUEVO]
├── 16-crear-oportunidad.php                 [NUEVO]
├── 17-agregar-productos-oportunidad.php     [NUEVO]
└── 18-flujo-completo-venta.php              [NUEVO]

docs/
├── architecture.md                          [ACTUALIZADO]
├── plan-prospectos-oportunidades.md         [NUEVO]
└── README.md                                [PENDIENTE]
```

**Resumen**:
- ✅ 14 archivos nuevos creados
- ✅ 1 archivo modificado
- ✅ 2 archivos de documentación actualizados
- ⏳ 1 archivo de documentación pendiente

---

## 🔄 Flujo de Datos Implementado

### Flujo Completo de Venta

```
┌─────────────────────────────────────────────────┐
│  1. USUARIO                                     │
│     Inicia flujo de venta                       │
└──────────────────┬──────────────────────────────┘
                   │
                   ↓
┌─────────────────────────────────────────────────┐
│  2. REGISTRAR PROSPECTO                         │
│     RegistrarProspecto::execute()               │
│     ├─ Valida CURP                              │
│     ├─ Valida teléfono                          │
│     └─ ProspectoApiRepository::agregar()        │
│        └─ API: /Prospectos/Agregar              │
│           Respuesta: ID del prospecto           │
└──────────────────┬──────────────────────────────┘
                   │
                   ↓
┌─────────────────────────────────────────────────┐
│  3. CREAR OPORTUNIDAD                           │
│     CrearOportunidad::execute()                 │
│     ├─ Valida IDs (empresa, sucursal, etc.)    │
│     ├─ Parsea fechas opcionales                │
│     └─ OportunidadApiRepository::agregarCabecero()│
│        └─ API: /Oportunidades/AgregarCabecero   │
│           Respuesta: ID de la oportunidad       │
└──────────────────┬──────────────────────────────┘
                   │
                   ↓
┌─────────────────────────────────────────────────┐
│  4. AGREGAR PRODUCTOS (múltiples veces)         │
│     AgregarProductoAOportunidad::execute()      │
│     ├─ Valida producto y precio                │
│     └─ OportunidadApiRepository::agregarProducto()│
│        └─ API: /Oportunidades/AgregarProducto   │
│           Respuesta: 1 (éxito)                  │
└──────────────────┬──────────────────────────────┘
                   │
                   ↓
┌─────────────────────────────────────────────────┐
│  5. RESULTADO FINAL                             │
│     - Prospecto registrado                      │
│     - Oportunidad creada                        │
│     - Productos agregados                       │
│     - Listo para seguimiento                    │
└─────────────────────────────────────────────────┘
```

---

## ✅ Validaciones Implementadas

### Validación de CURP

**Clase**: `CURP` (Value Object)

**Reglas**:
- ✅ 18 caracteres exactos
- ✅ Formato: `AAAA######AAAAAA##`
- ✅ Letras mayúsculas
- ✅ Dígitos en posiciones correctas
- ✅ Carácter de sexo (H/M) en posición 11

### Validación de Teléfono

**Clase**: `RegistrarProspecto` (Use Case)

**Reglas**:
- ✅ Lada: 2-4 dígitos numéricos
- ✅ Teléfono: 10 dígitos exactos
- ✅ Solo números

### Validación de IDs

**Clases**: `ProspectoId`, `OportunidadId` (Value Objects)

**Reglas**:
- ✅ Enteros positivos (> 0)
- ✅ Type-safe con PHP 8.3

### Validación de Probabilidad

**Clase**: `CrearOportunidad` (Use Case)

**Reglas**:
- ✅ Rango: 0-100
- ✅ Tipo entero

### Validación de Productos

**Clase**: `AgregarProductoAOportunidad` (Use Case)

**Reglas**:
- ✅ IDs positivos
- ✅ Cantidad > 0
- ✅ Precio >= 0

---

## 🧪 Casos de Prueba Sugeridos

### Pruebas Unitarias (Pendiente)

1. **Value Objects**
   - ✅ CURP válido
   - ✅ CURP inválido (formato incorrecto)
   - ✅ ProspectoId positivo
   - ✅ ProspectoId negativo (debe fallar)

2. **Casos de Uso**
   - ✅ Registro exitoso de prospecto
   - ✅ Validación de datos inválidos
   - ✅ Creación exitosa de oportunidad
   - ✅ Agregar producto válido

### Pruebas de Integración (Pendiente)

1. **Repositorios**
   - API responde con ID válido
   - API responde con error (-1)
   - Timeout de conexión
   - Respuesta malformada

2. **Flujo Completo**
   - Prospecto → Oportunidad → Productos
   - Manejo de errores en cada paso
   - Rollback en caso de fallo

---

## 📊 Métricas del Proyecto

### Código Generado

| Componente | Archivos | Líneas de Código |
|------------|----------|------------------|
| Entidades | 3 | ~300 |
| Value Objects | 3 | ~150 |
| Interfaces | 2 | ~100 |
| Repositorios | 2 | ~250 |
| Casos de Uso | 3 | ~400 |
| Ejemplos | 4 | ~400 |
| **TOTAL** | **17** | **~1,600** |

### Cobertura de Funcionalidad

- ✅ Registro de prospectos: 100%
- ✅ Creación de oportunidades: 100%
- ✅ Agregar productos: 100%
- ✅ Validaciones: 100%
- ⏳ Tests automatizados: 0%

---

## 🚀 Próximos Pasos

### Corto Plazo

1. ⏳ **Actualizar README.md** con nueva funcionalidad
2. ⏳ **Crear tests automatizados** con PHPUnit
3. ⏳ **Validar con datos reales** en entorno de pruebas

### Mediano Plazo

1. **Agregar DTOs** para casos de uso
2. **Implementar caché** para consultas frecuentes
3. **Logging** de operaciones críticas
4. **Retry logic** para fallos transitorios

### Largo Plazo

1. **Dashboard de seguimiento** de oportunidades
2. **Notificaciones** de eventos programados
3. **Reportes** de conversión de prospectos
4. **Integración** con CRM externo

---

## 🎓 Lecciones Aprendidas

### Desafíos Encontrados

1. **Respuestas No-JSON**: Los nuevos endpoints retornan string simple, no JSON
   - **Solución**: Método `getString()` en `IntegraApiClient`

2. **Parámetros Opcionales**: Manejo de fechas y notas opcionales
   - **Solución**: Formateo condicional con valores vacíos

3. **Validación de CURP**: Formato específico mexicano
   - **Solución**: Value Object con regex de validación

### Buenas Prácticas Aplicadas

✅ **Separación de Responsabilidades**: Cada capa tiene un propósito claro  
✅ **Inmutabilidad**: Entidades y VOs readonly  
✅ **Type Safety**: PHP 8.3 strict types  
✅ **Validación Temprana**: En constructores de VOs  
✅ **Código Auto-documentado**: Nombres claros y PHPDoc  

---

## 📚 Referencias

- [API IntegraApp](https://integraapp.net/API/)
- [Clean Architecture - Robert C. Martin](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [PHP 8.3 Documentation](https://www.php.net/releases/8.3/)
- [CURP - Wikipedia](https://es.wikipedia.org/wiki/Clave_%C3%9Anica_de_Registro_de_Poblaci%C3%B3n)

---

## 👥 Equipo

**Desarrollador**: CECAPTA Development Team  
**Cliente**: CECAPTA - Centro de Capacitación Profesional del Golfo  
**Fecha de Inicio**: Octubre 2025  
**Fecha de Finalización**: Octubre 2025  
**Estado**: ✅ Completado (Pendiente actualización README)

---

**Última actualización**: Octubre 2025  
**Versión del documento**: 1.0.0
