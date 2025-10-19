# Guía de Uso - Módulo de Prospectos y Oportunidades

## 📋 Resumen Rápido

Este módulo permite registrar el flujo completo de ventas en IntegraApp:

1. **Registrar Prospecto** → Obtener ID del prospecto
2. **Crear Oportunidad** → Obtener ID de la oportunidad
3. **Agregar Productos** → Completar la oportunidad de venta

---

## 🚀 Inicio Rápido

### Ejecutar Ejemplo Completo

```bash
php examples/18-flujo-completo-venta.php
```

Este ejemplo ejecuta todo el flujo de venta de principio a fin.

---

## 📝 Paso 1: Registrar Prospecto

### Endpoint
```
GET /Prospectos/Agregar/{token}/{curp}/{nombreCompleto}/{lada}/{telefono}
```

### Código PHP

```php
use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;

$token = 'tu-token-aqui';
$apiClient = new IntegraApiClient();
$registrarProspecto = new RegistrarProspecto(
    new ProspectoApiRepository($apiClient)
);

$prospectoId = $registrarProspecto->execute(
    $token,
    'PEJJ920615HDFRRN05',    // CURP válido
    'Juan Pérez Jiménez',     // Nombre completo
    '999',                    // Lada telefónica
    '5551234567'              // Teléfono 10 dígitos
);

echo "Prospecto ID: {$prospectoId}\n";
```

### Validaciones

- **CURP**: 18 caracteres, formato válido mexicano
- **Lada**: 2-4 dígitos numéricos
- **Teléfono**: 10 dígitos exactos

### Respuesta API

- **Éxito**: Número entero (ID del prospecto)
- **Error**: Cadena que inicia con `-1`

### Ejemplo Ejecutable

```bash
php examples/15-registrar-prospecto.php
```

---

## 🎯 Paso 2: Crear Oportunidad

### Endpoint
```
GET /Oportunidades/AgregarCabecero/{token}/{empresaId}/{sucursalId}/
    {empleadoId}/{campañaId}/{prospectoId}/{eventoProgramar}/
    {eventoTipo}/{eventoFecha}/{notas}/{etapaId}/{fechaCierre}/{probabilidad}
```

### Código PHP

```php
use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

$crearOportunidad = new CrearOportunidad(
    new OportunidadApiRepository($apiClient)
);

$oportunidadId = $crearOportunidad->execute(
    $token,
    24,                 // empresaId (ID de tu empresa)
    5,                  // sucursalId
    10,                 // empleadoId (responsable)
    3,                  // campañaId
    $prospectoId,       // ID del prospecto del paso 1
    true,               // eventoProgramar
    'LLAMADA',          // eventoSigTipo (LLAMADA, VISITA, EMAIL, etc.)
    (new DateTime('+3 days'))->format('Y-m-d H:i:s'),  // Fecha del evento
    'Cliente interesado en curso de PHP',              // Notas
    1,                  // etapaId (etapa del embudo)
    (new DateTime('+30 days'))->format('Y-m-d'),       // Fecha estimada cierre
    70                  // probabilidad (0-100)
);

echo "Oportunidad ID: {$oportunidadId}\n";
```

### Parámetros Obligatorios

- `empresaId`: ID de tu empresa en IntegraApp
- `sucursalId`: ID de la sucursal
- `empleadoId`: ID del empleado responsable
- `campañaId`: ID de la campaña de marketing
- `prospectoId`: ID del prospecto (del paso 1)
- `etapaId`: ID de la etapa del embudo de ventas
- `probabilidad`: 0-100 (porcentaje de probabilidad de cierre)

### Parámetros Opcionales

- `eventoSigTipo`: Tipo de siguiente evento (puede ser `null` o cadena vacía)
- `eventoSigFechaHora`: Fecha del siguiente evento (puede ser `null`)
- `notas`: Notas adicionales (puede ser `null`)
- `fechaEstimadaCierre`: Fecha estimada de cierre (puede ser `null`)

### Respuesta API

- **Éxito**: Número entero (ID de la oportunidad)
- **Error**: Cadena que inicia con `-1`

### Ejemplo Ejecutable

```bash
php examples/16-crear-oportunidad.php
```

---

## 🛒 Paso 3: Agregar Productos

### Endpoint
```
GET /Oportunidades/AgregarProducto/{token}/{oportunidadId}/{productoId}/
    {cantidad}/{esquemaImpuestosId}/{precioId}/{precioValor}/{notas}
```

### Código PHP - Un Producto

```php
use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;

$agregarProducto = new AgregarProductoAOportunidad(
    new OportunidadApiRepository($apiClient)
);

$resultado = $agregarProducto->execute(
    $token,
    $oportunidadId,     // ID de la oportunidad del paso 2
    101,                // productoId
    2,                  // cantidad
    1,                  // esquemaImpuestosId (ej: IVA 16%)
    5,                  // precioId
    3500.00,            // precioValor (precio unitario)
    'Incluye material digital'  // notas (opcional)
);

if ($resultado) {
    echo "✅ Producto agregado\n";
}
```

### Código PHP - Múltiples Productos

```php
$productos = [
    [
        'productoId' => 101,
        'cantidad' => 1,
        'esquemaImpuestosId' => 1,
        'precioId' => 5,
        'precioValor' => 3500.00,
        'notas' => 'Curso PHP Avanzado'
    ],
    [
        'productoId' => 102,
        'cantidad' => 1,
        'esquemaImpuestosId' => 1,
        'precioId' => 6,
        'precioValor' => 4000.00,
        'notas' => 'Curso Laravel'
    ],
    [
        'productoId' => 205,
        'cantidad' => 1,
        'esquemaImpuestosId' => 1,
        'precioId' => 8,
        'precioValor' => 1500.00,
        'notas' => 'Certificación'
    ]
];

$resultado = $agregarProducto->executeMultiple(
    $token,
    $oportunidadId,
    $productos
);

echo "✅ Productos agregados: {$resultado['exito']}\n";
echo "❌ Productos fallidos: " . count($resultado['fallidos']) . "\n";
```

### Parámetros

- `oportunidadId`: ID de la oportunidad
- `productoId`: ID del producto en el catálogo
- `cantidad`: Cantidad del producto (entero positivo)
- `esquemaImpuestosId`: ID del esquema de impuestos
- `precioId`: ID del precio aplicable
- `precioValor`: Valor unitario del precio (float)
- `notas`: Notas sobre el producto (opcional)

### Respuesta API

- **Éxito**: `1`
- **Error**: Cadena que inicia con `-1`

### Ejemplo Ejecutable

```bash
php examples/17-agregar-productos-oportunidad.php
```

---

## 🔄 Flujo Completo Integrado

### Código Completo

```php
<?php

require_once __DIR__ . '/bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$apiClient = new IntegraApiClient();

// === PASO 1: REGISTRAR PROSPECTO ===
$registrarProspecto = new RegistrarProspecto(
    new ProspectoApiRepository($apiClient)
);

$prospectoId = $registrarProspecto->execute(
    $token,
    'GAMJ850312HDFNRN03',
    'José María García Núñez',
    '999',
    '1234567890'
);

echo "✅ Prospecto registrado: {$prospectoId}\n";

// === PASO 2: CREAR OPORTUNIDAD ===
$crearOportunidad = new CrearOportunidad(
    new OportunidadApiRepository($apiClient)
);

$oportunidadId = $crearOportunidad->execute(
    $token,
    24,             // empresaId
    5,              // sucursalId
    10,             // empleadoId
    3,              // campañaId
    $prospectoId,
    true,
    'VISITA',
    (new DateTime('+5 days'))->format('Y-m-d H:i:s'),
    'Cliente corporativo interesado',
    1,
    (new DateTime('+45 days'))->format('Y-m-d'),
    70
);

echo "✅ Oportunidad creada: {$oportunidadId}\n";

// === PASO 3: AGREGAR PRODUCTOS ===
$agregarProducto = new AgregarProductoAOportunidad(
    new OportunidadApiRepository($apiClient)
);

$productos = [
    ['productoId' => 101, 'cantidad' => 2, 'esquemaImpuestosId' => 1, 
     'precioId' => 5, 'precioValor' => 3500.00, 'notas' => 'Para 2 empleados'],
    ['productoId' => 102, 'cantidad' => 2, 'esquemaImpuestosId' => 1, 
     'precioId' => 6, 'precioValor' => 4000.00, 'notas' => 'Para 2 empleados'],
    ['productoId' => 205, 'cantidad' => 2, 'esquemaImpuestosId' => 1, 
     'precioId' => 8, 'precioValor' => 1500.00, 'notas' => null]
];

$resultado = $agregarProducto->executeMultiple($token, $oportunidadId, $productos);

echo "✅ Productos agregados: {$resultado['exito']}\n";
echo "════════════════════════════════\n";
echo "🎉 Venta completada exitosamente\n";
```

### Ejecutar

```bash
php examples/18-flujo-completo-venta.php
```

---

## ⚠️ Manejo de Errores

### Errores Comunes

#### 1. CURP Inválido

```php
try {
    $prospectoId = $registrarProspecto->execute($token, 'INVALIDO', ...);
} catch (\InvalidArgumentException $e) {
    echo "Error: {$e->getMessage()}\n";
    // CURP inválido: 'INVALIDO'. Debe tener 18 caracteres alfanuméricos
}
```

#### 2. Respuesta de API con Error

```php
try {
    $prospectoId = $registrarProspecto->execute(...);
} catch (\Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException $e) {
    echo "Error API: {$e->getMessage()}\n";
    // Error al agregar prospecto: -1 error
}
```

#### 3. Datos Inválidos

```php
try {
    $oportunidadId = $crearOportunidad->execute(
        $token,
        -1,  // ID negativo - INVÁLIDO
        ...
    );
} catch (\InvalidArgumentException $e) {
    echo "Validación: {$e->getMessage()}\n";
    // El ID de la empresa debe ser positivo
}
```

### Captura Completa

```php
try {
    // Tu código aquí
    $prospectoId = $registrarProspecto->execute(...);
    
} catch (\InvalidArgumentException $e) {
    // Error de validación de datos
    echo "❌ Validación: {$e->getMessage()}\n";
    
} catch (\Cecapta\IntegraApi\Infrastructure\Exception\RepositoryException $e) {
    // Error de la API
    echo "❌ API: {$e->getMessage()}\n";
    
} catch (\Cecapta\IntegraApi\Infrastructure\Exception\ApiConnectionException $e) {
    // Error de conexión
    echo "❌ Conexión: {$e->getMessage()}\n";
    
} catch (\Exception $e) {
    // Error general
    echo "❌ Error: {$e->getMessage()}\n";
}
```

---

## 📊 Información que Necesitas

### IDs Requeridos

Antes de usar el módulo, necesitas conocer estos IDs de tu cuenta IntegraApp:

| Campo | Descripción | Cómo obtenerlo |
|-------|-------------|----------------|
| **empresaId** | ID de tu empresa | `php examples/01-consultar-empresas.php` |
| **sucursalId** | ID de la sucursal | `php examples/05-consultar-sucursales.php` |
| **empleadoId** | ID del empleado | `php examples/11-consultar-empleados.php` |
| **campañaId** | ID de la campaña | `php examples/08-consultar-campañas.php` |
| **productoId** | ID del producto | `php examples/12-consultar-productos.php` |
| **precioId** | ID del precio | `php examples/12-consultar-productos.php` |
| **esquemaImpuestosId** | ID impuestos | Consultar con IntegraApp |
| **etapaId** | ID etapa embudo | Consultar con IntegraApp |

---

## 🔍 Pruebas

### Validar con Datos de Prueba

**IMPORTANTE**: Los endpoints intentarán crear registros reales en IntegraApp. 

Para probar sin afectar datos reales:

1. Usa un entorno de pruebas si está disponible
2. Verifica que los IDs existan en tu sistema
3. Usa CURPs de prueba válidos pero ficticios

### CURP de Prueba Válido

```php
// Formato válido pero ficticio
$curpPrueba = 'PEJJ920615HDFRRN05';
```

---

## 📚 Referencias Adicionales

- **[README.md](../README.md)** - Documentación principal
- **[architecture.md](architecture.md)** - Arquitectura del proyecto
- **[plan-prospectos-oportunidades.md](plan-prospectos-oportunidades.md)** - Plan detallado

---

## 💡 Consejos

### 1. Guardar IDs Generados

```php
// Guardar para uso posterior
file_put_contents('prospecto_id.txt', $prospectoId);
file_put_contents('oportunidad_id.txt', $oportunidadId);

// Leer después
$prospectoId = (int) file_get_contents('prospecto_id.txt');
```

### 2. Logging

```php
// Agregar logs para debugging
echo "[" . date('Y-m-d H:i:s') . "] Registrando prospecto...\n";
$prospectoId = $registrarProspecto->execute(...);
echo "[" . date('Y-m-d H:i:s') . "] Prospecto ID: {$prospectoId}\n";
```

### 3. Validar Antes de Enviar

```php
// Validar datos antes de llamar API
if (strlen($curp) !== 18) {
    throw new \InvalidArgumentException('CURP debe tener 18 caracteres');
}

if ($probabilidad < 0 || $probabilidad > 100) {
    throw new \InvalidArgumentException('Probabilidad debe estar entre 0 y 100');
}
```

---

## 🆘 Solución de Problemas

### Problema: "Error al agregar prospecto: -1 error"

**Causa**: La API rechazó los datos

**Soluciones**:
- Verificar que el CURP sea válido
- Verificar que el teléfono tenga formato correcto
- Verificar que el token sea válido

### Problema: "CURP inválido"

**Causa**: CURP no cumple formato mexicano

**Solución**: Usar un CURP con formato válido (18 caracteres, estructura correcta)

### Problema: "El ID de la empresa debe ser positivo"

**Causa**: ID inválido o negativo

**Solución**: Obtener el ID correcto usando los ejemplos de consulta

---

**Última actualización**: Octubre 2025  
**Versión**: 1.0.0
