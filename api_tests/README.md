# Cliente IntegraApp API - PHP 8.3

![PHP Version](https://img.shields.io/badge/PHP-8.3-blue)
![License](https://img.shields.io/badge/license-MIT-green)
![Architecture](https://img.shields.io/badge/architecture-Clean%20Architecture-yellow)

Cliente PHP robusto para consumir la API de IntegraApp, implementado con **Arquitectura Limpia** y las mejores prácticas de desarrollo.

---

## 📋 Tabla de Contenidos

- [Características](#características)
- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Configuración](#configuración)
- [Uso Rápido](#uso-rápido)
- [Ejemplos](#ejemplos)
- [Arquitectura](#arquitectura)
- [Documentación](#documentación)
- [Solución de Problemas](#solución-de-problemas)
- [Contribución](#contribución)
- [Licencia](#licencia)

---

## ✨ Características

✅ **Arquitectura Limpia** (Clean Architecture)  
✅ **PHP 8.3** con características modernas (readonly, enums, tipos estrictos)  
✅ **Guzzle HTTP Client** para peticiones robustas  
✅ **Manejo completo de errores**  
✅ **Testeable y mantenible**  
✅ **Documentación exhaustiva**  
✅ **Ejemplos funcionales incluidos**  
✅ **Compatible con Composer**  
✅ **PSR-4 Autoloading**  

---

## 📦 Requisitos

### Requisitos del Sistema

- **PHP**: >= 8.3
- **Composer**: >= 2.0
- **Extensiones PHP**:
  - `ext-json`
  - `ext-curl`
  - `ext-mbstring`

### Dependencias

- `guzzlehttp/guzzle`: ^7.8

---

## 🚀 Instalación

### Paso 1: Clonar o descargar el proyecto

```bash
cd /var/www/cecapta.callbasterai.com
```

### Paso 2: Instalar dependencias con Composer

```bash
composer install
```

### Paso 3: Verificar instalación

```bash
php -v
# Debe mostrar PHP 8.3.x

composer --version
# Debe mostrar Composer 2.x
```

---

## ⚙️ Configuración

### Token de Autenticación

El cliente requiere un **token de autenticación** para acceder a la API de IntegraApp.

**Opción 1: Uso directo** (desarrollo)
```php
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
```

**Opción 2: Variables de entorno** (producción recomendado)

1. Crear archivo `.env`:
```bash
INTEGRA_API_TOKEN=vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv
```

2. Cargar en tu código:
```php
$token = getenv('INTEGRA_API_TOKEN');
```

---

## 🎯 Uso Rápido

### Ejemplo Básico: Consultar Empresas

```php
<?php

require_once __DIR__ . '/bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\ConsultarEmpresas;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\EmpresaApiRepository;

// 1. Configurar dependencias
$apiClient = new IntegraApiClient();
$empresaRepository = new EmpresaApiRepository($apiClient);
$consultarEmpresas = new ConsultarEmpresas($empresaRepository);

// 2. Consultar empresas
$token = 'vvm6ML6OyPumIc5Og2WrEZYa7KwGggoLvXKhjpx9LKktfuF74AOAH3J8pcTeUviv';
$empresas = $consultarEmpresas->execute($token);

// 3. Usar los resultados
foreach ($empresas as $empresa) {
    echo "{$empresa->alias}: {$empresa->nombre}\n";
}
```

### 🆕 Ejemplo: Flujo Completo de Venta

```php
<?php

require_once __DIR__ . '/bootstrap.php';

use Cecapta\IntegraApi\Application\UseCase\RegistrarProspecto;
use Cecapta\IntegraApi\Application\UseCase\CrearOportunidad;
use Cecapta\IntegraApi\Application\UseCase\AgregarProductoAOportunidad;
use Cecapta\IntegraApi\Infrastructure\Http\IntegraApiClient;
use Cecapta\IntegraApi\Infrastructure\Repository\ProspectoApiRepository;
use Cecapta\IntegraApi\Infrastructure\Repository\OportunidadApiRepository;

$token = 'tu-token-aqui';
$apiClient = new IntegraApiClient();

// 1. Registrar Prospecto
$registrarProspecto = new RegistrarProspecto(
    new ProspectoApiRepository($apiClient)
);
$prospectoId = $registrarProspecto->execute(
    $token,
    'PEJJ920615HDFRRN05',  // CURP
    'Juan Pérez Jiménez',   // Nombre
    '999',                  // Lada
    '5551234567'            // Teléfono
);

// 2. Crear Oportunidad
$crearOportunidad = new CrearOportunidad(
    new OportunidadApiRepository($apiClient)
);
$oportunidadId = $crearOportunidad->execute(
    $token,
    24,             // empresaId
    5,              // sucursalId
    10,             // empleadoId
    3,              // campañaId
    $prospectoId,   // prospectoId
    true,           // eventoProgramar
    'LLAMADA',      // eventoSigTipo
    (new DateTime('+3 days'))->format('Y-m-d H:i:s'),
    'Cliente interesado en curso PHP',
    1,              // etapaId
    (new DateTime('+30 days'))->format('Y-m-d'),
    70              // probabilidad
);

// 3. Agregar Productos
$agregarProducto = new AgregarProductoAOportunidad(
    new OportunidadApiRepository($apiClient)
);
$agregarProducto->execute(
    $token,
    $oportunidadId,
    101,        // productoId
    1,          // cantidad
    1,          // esquemaImpuestosId
    5,          // precioId
    3500.00,    // precioValor
    'Incluye material digital'
);

echo "✅ Venta completada!\n";
echo "Prospecto: {$prospectoId}\n";
echo "Oportunidad: {$oportunidadId}\n";
```

---

## 📚 Ejemplos

El proyecto incluye **4 ejemplos completos** en el directorio `examples/`:

### 1. Consultar todas las empresas

```bash
php examples/01-consultar-empresas.php
```

**Salida esperada**:
```
🔍 Consultando empresas...

✅ Se encontraron 3 empresas:

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  ID BD:   24
  Nombre:  CENTRO DE CAPACITACION PROFESIONAL DEL GOLFO
  Alias:   CECAPTA
  Estatus: ACTIVO ✓
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

### 2. Consultar solo empresas activas

```bash
php examples/02-consultar-activas.php
```

Filtra y muestra únicamente las empresas con estatus **ACTIVO**.

### 3. Buscar empresa por alias

```bash
php examples/03-buscar-por-alias.php
```

Busca una empresa específica utilizando su alias (ej: "CECAPTA").

### 4. Exportar a JSON

```bash
php examples/04-formato-json.php
```

Exporta los datos a formato JSON y los guarda en un archivo.

---

## 🏗️ Arquitectura

Este proyecto sigue los principios de **Clean Architecture** (Arquitectura Limpia), organizando el código en **4 capas**:

### Estructura de Directorios

```
src/
├── Domain/              # Capa de Dominio (núcleo)
│   ├── Entity/          # Entidades de negocio
│   ├── ValueObject/     # Objetos de valor inmutables
│   ├── Repository/      # Interfaces (puertos)
│   └── Exception/       # Excepciones del dominio
│
├── Application/         # Capa de Aplicación
│   ├── UseCase/         # Casos de uso
│   ├── DTO/             # Data Transfer Objects
│   └── Exception/       # Excepciones de aplicación
│
├── Infrastructure/      # Capa de Infraestructura
│   ├── Http/            # Cliente HTTP (Guzzle)
│   ├── Repository/      # Implementaciones de repositorios
│   └── Exception/       # Excepciones de infraestructura
│
└── Presentation/        # Capa de Presentación
    └── (ejemplos en /examples)
```

### Flujo de Datos

```
Usuario → Ejemplo → UseCase → Repository → API → Respuesta
```

Para más detalles, consulta [`docs/architecture.md`](docs/architecture.md).

---

## 📖 Documentación

### Documentos Disponibles

- **[architecture.md](docs/architecture.md)**: Arquitectura completa del proyecto
- **[plan.md](docs/plan.md)**: Plan detallado de actividades y fases
- **[plan-prospectos-oportunidades.md](docs/plan-prospectos-oportunidades.md)**: 🆕 Plan del módulo de ventas
- **README.md**: Este documento

### API del Cliente

#### Clase: `ConsultarEmpresas`

**Método**: `execute(string $tokenValue): array<EmpresaDTO>`

Consulta todas las empresas desde la API.

```php
$empresas = $consultarEmpresas->execute($token);
```

**Método**: `executeOnlyActivas(string $tokenValue): array<EmpresaDTO>`

Consulta solo empresas con estatus ACTIVO.

```php
$empresasActivas = $consultarEmpresas->executeOnlyActivas($token);
```

**Método**: `findByAlias(string $tokenValue, string $alias): ?EmpresaDTO`

Busca una empresa específica por su alias.

```php
$empresa = $consultarEmpresas->findByAlias($token, 'CECAPTA');
```

---

#### 🆕 Clase: `RegistrarProspecto`

**Método**: `execute(string $tokenValue, string $curp, string $nombreCompleto, string $telefonoLada, string $telefono10Digitos): int`

Registra un nuevo prospecto y retorna su ID.

```php
$prospectoId = $registrarProspecto->execute(
    $token,
    'PEJJ920615HDFRRN05',
    'Juan Pérez Jiménez',
    '999',
    '5551234567'
);
```

---

#### 🆕 Clase: `CrearOportunidad`

**Método**: `execute(...): int`

Crea una nueva oportunidad de venta y retorna su ID.

```php
$oportunidadId = $crearOportunidad->execute(
    $token,
    $empresaId,
    $sucursalId,
    $empleadoId,
    $campañaId,
    $prospectoId,
    $eventoProgramar,
    $eventoSigTipo,
    $eventoSigFechaHora,
    $notas,
    $etapaId,
    $fechaEstimadaCierre,
    $probabilidad
);
```

---

#### 🆕 Clase: `AgregarProductoAOportunidad`

**Método**: `execute(...): bool`

Agrega un producto a una oportunidad existente.

```php
$resultado = $agregarProducto->execute(
    $token,
    $oportunidadId,
    $productoId,
    $cantidad,
    $esquemaImpuestosId,
    $precioId,
    $precioValor,
    $notas
);
```

**Método**: `executeMultiple(string $tokenValue, int $oportunidadId, array $productos): array`

Agrega múltiples productos a una oportunidad.

```php
$resultado = $agregarProducto->executeMultiple($token, $oportunidadId, [
    ['productoId' => 101, 'cantidad' => 1, ...],
    ['productoId' => 102, 'cantidad' => 2, ...],
]);
// Retorna: ['exito' => 2, 'fallidos' => []]
```

---

#### DTO: `EmpresaDTO`

Propiedades públicas:

```php
readonly class EmpresaDTO {
    public int $idBd;        // ID de la empresa
    public string $nombre;   // Nombre completo
    public string $alias;    // Alias corto
    public string $estatus;  // Estado (ACTIVO, INACTIVO, etc.)
    public bool $isActiva;   // ¿Está activa?
}
```

Métodos:

- `toArray(): array` - Convierte a array asociativo
- `toJson(): string` - Convierte a JSON

---

## 🔧 Solución de Problemas

### Error: "Las dependencias de Composer no están instaladas"

**Causa**: No se ha ejecutado `composer install`.

**Solución**:
```bash
composer install
```

---

### Error: "Class '...' not found"

**Causa**: Problema con el autoloader.

**Solución**:
```bash
composer dump-autoload
```

---

### Error de conexión con la API

**Causa**: Red, firewall o token inválido.

**Solución**:
1. Verificar conectividad:
```bash
curl https://integraapp.net/API/Empresas/ConsultarTabla/TU_TOKEN
```

2. Verificar que el token sea válido
3. Revisar configuración de proxy/firewall

---

### Error: "Call to undefined function curl_init()"

**Causa**: Extensión `curl` no instalada.

**Solución**:
```bash
# Ubuntu/Debian
sudo apt-get install php8.3-curl

# CentOS/RHEL
sudo yum install php83-curl

# Reiniciar servidor web
sudo systemctl restart php8.3-fpm
```

---

### Timeout en peticiones

**Causa**: API lenta o timeout muy corto.

**Solución**: Aumentar timeout al crear el cliente:

```php
$apiClient = new IntegraApiClient(
    baseUrl: null,
    timeout: 60,        // 60 segundos
    connectTimeout: 20  // 20 segundos
);
```

---

### Respuesta JSON inválida

**Causa**: API retorna HTML o error en lugar de JSON.

**Solución**: Capturar excepción y revisar respuesta:

```php
try {
    $empresas = $consultarEmpresas->execute($token);
} catch (\Cecapta\IntegraApi\Infrastructure\Exception\ApiResponseException $e) {
    echo "Error en respuesta: " . $e->getMessage();
}
```

---

## 🧪 Testing

### Ejecutar Tests (cuando estén implementados)

```bash
# Tests unitarios
./vendor/bin/phpunit tests/Unit

# Tests de integración
./vendor/bin/phpunit tests/Integration

# Todos los tests
./vendor/bin/phpunit
```

### Cobertura de Código

```bash
./vendor/bin/phpunit --coverage-html coverage/
```

---

## 🛠️ Desarrollo

### Agregar Nuevo Endpoint

1. **Crear entidad** en `src/Domain/Entity/`
2. **Definir repositorio** en `src/Domain/Repository/`
3. **Crear caso de uso** en `src/Application/UseCase/`
4. **Implementar repositorio** en `src/Infrastructure/Repository/`
5. **Crear ejemplo** en `examples/`

Ejemplo completo en [`docs/architecture.md`](docs/architecture.md).

---

### Estándares de Código

Este proyecto sigue:

- **PSR-4**: Autoloading
- **PSR-12**: Estilo de código
- **PHP 8.3**: Características modernas
- **Strict Types**: Tipos estrictos habilitados

---

## 🤝 Contribución

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

### Guidelines

- Seguir arquitectura limpia existente
- Agregar tests para nuevas funcionalidades
- Documentar cambios en README y docs
- Usar tipos estrictos y readonly cuando sea posible

---

## 📄 Licencia

Este proyecto está licenciado bajo la Licencia MIT.

---

## 📞 Soporte

Para preguntas o problemas:

- **Documentación**: Ver carpeta `docs/`
- **Ejemplos**: Ver carpeta `examples/`
- **Issues**: Reportar en el repositorio del proyecto

---

## 🎯 Endpoints Implementados

### ✅ Completados (8/8)

#### Endpoints de Consulta (5)
1. **Empresas** - Consultar tabla de empresas
2. **Sucursales** - Consultar sucursales por empresa
3. **Campañas** - Consultar campañas publicitarias
4. **Empleados** - Consultar empleados
5. **Productos** - Consultar productos y precios

#### Endpoints de Registro y Ventas (3) 🆕
6. **Prospectos** - Registrar nuevos prospectos
7. **Oportunidades** - Crear oportunidades de venta
8. **Productos de Oportunidad** - Agregar productos a oportunidades

### 📚 Ejemplos Disponibles (18)

#### Ejemplos de Consulta (14)
- `01-consultar-empresas.php` - Lista todas las empresas
- `02-consultar-activas.php` - Filtra empresas activas
- `03-buscar-por-alias.php` - Busca empresa por alias
- `04-formato-json.php` - Exporta a JSON
- `05-consultar-sucursales.php` - Lista sucursales
- `06-consultar-sucursales-activas.php` - Filtra sucursales activas
- `07-buscar-sucursal-por-abreviatura.php` - Busca sucursal
- `08-consultar-campañas.php` - Lista campañas
- `09-consultar-campañas-vigentes.php` - Filtra campañas vigentes
- `10-agrupar-campañas-por-plataforma.php` - Agrupa por plataforma
- `11-consultar-empleados.php` - Lista empleados
- `12-consultar-productos.php` - Lista productos
- `13-productos-por-rango-precio.php` - Filtra por precio
- `14-productos-por-lista-precios.php` - Agrupa por lista

#### Ejemplos de Registro y Ventas (4) 🆕
- `15-registrar-prospecto.php` - Registra nuevo prospecto
- `16-crear-oportunidad.php` - Crea oportunidad de venta
- `17-agregar-productos-oportunidad.php` - Agrega productos
- `18-flujo-completo-venta.php` - **Flujo completo de venta**

## 🎯 Roadmap

### Próximas Características

- [ ] Tests automatizados (PHPUnit)
- [ ] Sistema de caché (Redis/Memcached)
- [ ] Rate limiting
- [ ] CLI interactivo
- [ ] Publicación en Packagist

---

## 📊 Estado del Proyecto

| Componente | Estado |
|------------|--------|
| Arquitectura | ✅ Completo |
| Domain Layer | ✅ Completo |
| Application Layer | ✅ Completo |
| Infrastructure Layer | ✅ Completo |
| Endpoints Implementados | ✅ 8/8 (100%) |
| Ejemplos | ✅ 18 ejemplos funcionales |
| Módulo de Consultas | ✅ Completo |
| Módulo de Ventas | ✅ Completo 🆕 |
| Documentación | ✅ Completo |
| Tests Automatizados | ⏳ Pendiente |
| CI/CD | ⏳ Pendiente |

---

## 👥 Autores

- **CECAPTA** - Centro de Capacitación Profesional del Golfo

---

## 🙏 Agradecimientos

- Robert C. Martin por Clean Architecture
- PHP-FIG por los PSRs
- Comunidad de Guzzle

---

## 📝 Changelog

### [2.0.0] - 2025-10-15 🆕

#### Agregado
- **Módulo de Prospectos y Oportunidades**
  - Entidades: Prospecto, Oportunidad, OportunidadProducto
  - Value Objects: ProspectoId, OportunidadId, CURP
  - Casos de uso: RegistrarProspecto, CrearOportunidad, AgregarProductoAOportunidad
  - Repositorios API para prospectos y oportunidades
  - Método getString() en IntegraApiClient para respuestas no-JSON
- **4 ejemplos nuevos de flujo de ventas**
  - Registro de prospecto
  - Creación de oportunidad
  - Agregar productos
  - Flujo completo integrado
- **Documentación ampliada**
  - plan-prospectos-oportunidades.md
  - architecture.md actualizado
  - README.md actualizado

### [1.0.0] - 2025-10-06

#### Agregado
- Arquitectura limpia completa
- Consulta de empresas desde API IntegraApp
- Value Objects (Token, EstatusEmpresa)
- Entidad Empresa
- Caso de uso ConsultarEmpresas
- Cliente HTTP con Guzzle
- 14 ejemplos funcionales de consultas
- Documentación completa
- Bootstrap y configuración

---

**Última actualización**: Octubre 2025  
**Versión**: 2.0.0
