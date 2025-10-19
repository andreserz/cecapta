# Arquitectura del Cliente IntegraApp API

## 📋 Tabla de Contenidos

1. [Introducción](#introducción)
2. [Arquitectura Limpia](#arquitectura-limpia)
3. [Estructura de Capas](#estructura-de-capas)
4. [Diagramas](#diagramas)
5. [Patrones de Diseño](#patrones-de-diseño)
6. [Dependencias](#dependencias)
7. [Flujo de Datos](#flujo-de-datos)

---

## 🎯 Introducción

Este proyecto implementa un **cliente PHP** para consumir la API de **IntegraApp** siguiendo los principios de **Arquitectura Limpia (Clean Architecture)** propuestos por Robert C. Martin.

### Objetivos

- ✅ Separación clara de responsabilidades
- ✅ Independencia de frameworks
- ✅ Testabilidad completa
- ✅ Escalabilidad y mantenibilidad
- ✅ Cumplimiento de principios SOLID

---

## 🏛️ Arquitectura Limpia

La arquitectura limpia organiza el código en **capas concéntricas**, donde cada capa solo puede depender de las capas más internas, nunca de las externas.

### Principios Fundamentales

1. **Independencia de Frameworks**: No dependemos de Laravel, Symfony, etc.
2. **Testeable**: Lógica de negocio fácilmente testeable sin dependencias externas
3. **Independencia de UI**: La lógica no depende de la presentación
4. **Independencia de Base de Datos**: No hay acoplamiento con sistemas de almacenamiento
5. **Independencia de Agentes Externos**: La lógica no sabe sobre APIs externas

### Regla de Dependencia

```
Presentación → Aplicación → Dominio
    ↓              ↓
Infraestructura ←--┘
```

Las dependencias **solo apuntan hacia adentro** (hacia el dominio).

---

## 📦 Estructura de Capas

### 1️⃣ Capa de Dominio (Núcleo)

**Ubicación**: `src/Domain/`

La capa más interna, contiene la **lógica de negocio pura**:

```
Domain/
├── Entity/
│   ├── Empresa.php              # Entidad de negocio
│   ├── Prospecto.php            # Entidad Prospecto
│   ├── Oportunidad.php          # Entidad Oportunidad
│   └── OportunidadProducto.php  # Producto de oportunidad
├── ValueObject/
│   ├── Token.php                # Value Object para tokens
│   ├── EstatusEmpresa.php       # Enum de estados
│   ├── ProspectoId.php          # ID de prospecto
│   ├── OportunidadId.php        # ID de oportunidad
│   └── CURP.php                 # CURP validado
├── Repository/
│   ├── EmpresaRepositoryInterface.php       # Puerto (Interface)
│   ├── ProspectoRepositoryInterface.php     # Puerto para prospectos
│   └── OportunidadRepositoryInterface.php   # Puerto para oportunidades
└── Exception/
    └── DomainException.php      # Excepciones del dominio
```

**Características**:
- ❌ **No tiene dependencias externas**
- ✅ Define **interfaces** (puertos) que implementará la infraestructura
- ✅ Contiene **entidades** y **value objects**
- ✅ Reglas de negocio puras

**Ejemplo - Entidad**:
```php
final readonly class Empresa
{
    public function __construct(
        private int $idBd,
        private string $nombre,
        private string $alias,
        private EstatusEmpresa $estatus
    ) {}
    
    public function isActiva(): bool
    {
        return $this->estatus->isActivo();
    }
}
```

---

### 2️⃣ Capa de Aplicación

**Ubicación**: `src/Application/`

Contiene los **casos de uso** del sistema:

```
Application/
├── UseCase/
│   └── ConsultarEmpresas.php    # Caso de uso principal
├── DTO/
│   └── EmpresaDTO.php           # Data Transfer Object
└── Exception/
    └── ApplicationException.php # Excepciones de aplicación
```

**Características**:
- ✅ Orquesta el flujo de datos entre capas
- ✅ Implementa **casos de uso** específicos
- ✅ Depende solo del **Dominio**
- ✅ Utiliza **DTOs** para transferir datos

**Ejemplo - Caso de Uso**:
```php
final readonly class ConsultarEmpresas
{
    public function __construct(
        private EmpresaRepositoryInterface $empresaRepository
    ) {}
    
    public function execute(string $tokenValue): array
    {
        $token = new Token($tokenValue);
        $empresas = $this->empresaRepository->consultarTabla($token);
        return array_map(
            fn($empresa) => EmpresaDTO::fromEntity($empresa),
            $empresas
        );
    }
}
```

---

### 3️⃣ Capa de Infraestructura

**Ubicación**: `src/Infrastructure/`

Implementa los **detalles técnicos**:

```
Infrastructure/
├── Http/
│   └── IntegraApiClient.php           # Cliente HTTP (Guzzle)
├── Repository/
│   └── EmpresaApiRepository.php       # Implementación del repositorio
└── Exception/
    ├── InfrastructureException.php
    ├── ApiConnectionException.php
    ├── ApiResponseException.php
    └── RepositoryException.php
```

**Características**:
- ✅ Implementa las **interfaces** definidas en el Dominio
- ✅ Contiene código relacionado con **APIs externas**
- ✅ Utiliza **Guzzle** como cliente HTTP
- ✅ Adapta respuestas externas a entidades del dominio

**Ejemplo - Adaptador**:
```php
final class EmpresaApiRepository implements EmpresaRepositoryInterface
{
    public function __construct(
        private readonly IntegraApiClient $apiClient
    ) {}
    
    public function consultarTabla(Token $token): array
    {
        $endpoint = '/Empresas/ConsultarTabla/' . $token->getValue();
        $rawData = $this->apiClient->get($endpoint);
        return $this->mapToEntities($rawData);
    }
}
```

---

### 4️⃣ Capa de Presentación

**Ubicación**: `examples/`

Punto de entrada para usuarios:

```
examples/
├── 01-consultar-empresas.php    # Ejemplo básico
├── 02-consultar-activas.php     # Filtrado de empresas
├── 03-buscar-por-alias.php      # Búsqueda específica
└── 04-formato-json.php          # Exportación JSON
```

**Características**:
- ✅ Scripts de ejemplo para usuarios
- ✅ Puede ser CLI, Web API, etc.
- ✅ Ensambla las dependencias (Dependency Injection)

---

## 📊 Diagramas

### Diagrama de Capas

```
┌─────────────────────────────────────────┐
│         Presentación (examples/)        │
│  • Scripts CLI de ejemplo               │
│  • Punto de entrada del usuario         │
└────────────────┬────────────────────────┘
                 │
                 ↓
┌─────────────────────────────────────────┐
│      Aplicación (Application/)          │
│  • Casos de Uso (ConsultarEmpresas)     │
│  • DTOs para transferencia de datos     │
└────────────────┬────────────────────────┘
                 │
      ┌──────────┴──────────┐
      ↓                     ↓
┌──────────────┐    ┌──────────────────────┐
│   Dominio    │    │   Infraestructura    │
│  (Domain/)   │    │ (Infrastructure/)    │
│              │    │                      │
│  • Entities  │←───│  • HTTP Client       │
│  • VOs       │    │  • Repository Impl   │
│  • Interfaces│    │  • Adaptadores       │
└──────────────┘    └──────────────────────┘
```

### Flujo de una Petición

```
Usuario
  │
  │ 1. Ejecuta script
  ↓
examples/01-consultar-empresas.php
  │
  │ 2. Crea UseCase con dependencias
  ↓
ConsultarEmpresas::execute(token)
  │
  │ 3. Usa repositorio (interfaz)
  ↓
EmpresaApiRepository::consultarTabla(token)
  │
  │ 4. Llama API externa
  ↓
IntegraApiClient::get(endpoint)
  │
  │ 5. HTTP Request → Guzzle
  ↓
API IntegraApp (https://integraapp.net)
  │
  │ 6. JSON Response
  ↓
IntegraApiClient (decodifica JSON)
  │
  │ 7. Array PHP
  ↓
EmpresaApiRepository (mapea a Entities)
  │
  │ 8. Array<Empresa>
  ↓
ConsultarEmpresas (convierte a DTOs)
  │
  │ 9. Array<EmpresaDTO>
  ↓
Script de ejemplo (muestra resultados)
  │
  ↓
Usuario ve resultados
```

---

## 🔧 Patrones de Diseño

### 1. Repository Pattern

**Propósito**: Abstraer el acceso a datos.

```php
// Interfaz en Domain (puerto)
interface EmpresaRepositoryInterface {
    public function consultarTabla(Token $token): array;
}

// Implementación en Infrastructure (adaptador)
class EmpresaApiRepository implements EmpresaRepositoryInterface {
    // Implementación concreta usando API
}
```

### 2. Value Object Pattern

**Propósito**: Objetos inmutables que representan valores.

```php
final readonly class Token {
    private string $value;
    
    public function __construct(string $value) {
        if (empty(trim($value))) {
            throw new InvalidArgumentException();
        }
        $this->value = trim($value);
    }
}
```

### 3. Data Transfer Object (DTO)

**Propósito**: Transferir datos entre capas sin lógica de negocio.

```php
final readonly class EmpresaDTO {
    public function __construct(
        public int $idBd,
        public string $nombre,
        public string $alias,
        public string $estatus,
        public bool $isActiva
    ) {}
}
```

### 4. Dependency Injection

**Propósito**: Inversión de control y testabilidad.

```php
class ConsultarEmpresas {
    public function __construct(
        private EmpresaRepositoryInterface $repository
    ) {}
}

// Uso
$useCase = new ConsultarEmpresas(
    new EmpresaApiRepository($apiClient)
);
```

### 5. Adapter Pattern

**Propósito**: Adaptar interfaces externas al dominio.

```php
class EmpresaApiRepository implements EmpresaRepositoryInterface {
    private function mapToEntities(array $rawData): array {
        // Adapta JSON de API a entidades del dominio
        return array_map(
            fn($item) => Empresa::fromArray($item),
            $rawData
        );
    }
}
```

---

## 📚 Dependencias

### Dependencias Principales

| Paquete | Versión | Propósito |
|---------|---------|-----------|
| **PHP** | ^8.3 | Lenguaje base con características modernas |
| **Guzzle** | ^7.8 | Cliente HTTP para peticiones a API |

### Dependencias de Desarrollo

| Paquete | Versión | Propósito |
|---------|---------|-----------|
| **PHPUnit** | ^10.5 | Testing unitario y de integración |

### Por qué Guzzle

✅ **Estándar de la industria** para clientes HTTP en PHP  
✅ **Robusto y bien mantenido**  
✅ **Manejo avanzado de errores**  
✅ **Compatible con PSR-7 y PSR-18**  
✅ **Amplia documentación**  

---

## 🔄 Flujo de Datos

### Consulta de Empresas

```
┌─────────┐     ┌───────────┐     ┌──────────┐     ┌─────────┐
│ Usuario │────▶│  UseCase  │────▶│Repository│────▶│   API   │
└─────────┘     └───────────┘     └──────────┘     └─────────┘
    ▲                  │                 │                │
    │                  │                 │                │
    │              ┌───▼─────┐      ┌────▼────┐     ┌────▼─────┐
    │              │   DTO   │◀─────│ Entity  │◀────│ Raw JSON │
    │              └─────────┘      └─────────┘     └──────────┘
    └─────────────────┘
```

### Transformación de Datos

1. **API Response** (JSON):
```json
{
  "IdBD": 24,
  "Nombre": "CENTRO DE CAPACITACION...",
  "Alias": "CECAPTA",
  "Estatus": "ACTIVO"
}
```

2. **Entidad de Dominio**:
```php
Empresa {
  idBd: 24,
  nombre: "CENTRO DE CAPACITACION...",
  alias: "CECAPTA",
  estatus: EstatusEmpresa::ACTIVO
}
```

3. **DTO para Presentación**:
```php
EmpresaDTO {
  idBd: 24,
  nombre: "CENTRO DE CAPACITACION...",
  alias: "CECAPTA",
  estatus: "ACTIVO",
  isActiva: true
}
```

---

## 🧪 Testabilidad

La arquitectura permite testear cada capa independientemente:

### Test de Dominio
```php
$empresa = new Empresa(24, "Nombre", "ALIAS", EstatusEmpresa::ACTIVO);
assertTrue($empresa->isActiva());
```

### Test de Aplicación (con Mock)
```php
$mockRepo = $this->createMock(EmpresaRepositoryInterface::class);
$mockRepo->expects($this->once())
         ->method('consultarTabla')
         ->willReturn([/* empresas */]);

$useCase = new ConsultarEmpresas($mockRepo);
$result = $useCase->execute('token123');
```

### Test de Integración
```php
$apiClient = new IntegraApiClient();
$repository = new EmpresaApiRepository($apiClient);
$empresas = $repository->consultarTabla(new Token('real-token'));
assertCount(3, $empresas);
```

---

## 🚀 Escalabilidad

### Agregar Nuevo Endpoint

1. **Crear nueva entidad** en `Domain/Entity/`
2. **Definir interfaz** de repositorio en `Domain/Repository/`
3. **Implementar caso de uso** en `Application/UseCase/`
4. **Implementar repositorio** en `Infrastructure/Repository/`
5. **Crear ejemplo** en `examples/`

### Cambiar Cliente HTTP

Si en el futuro queremos cambiar Guzzle por otro cliente:

1. Solo modificar `Infrastructure/Http/IntegraApiClient.php`
2. El resto del código **no se ve afectado** (principio de inversión de dependencias)

---

## 🎯 Endpoints Implementados

### ✅ Completados (8/8)

#### Endpoints de Consulta (5)
1. **Empresas** - Consultar tabla de empresas
2. **Sucursales** - Consultar sucursales por empresa
3. **Campañas** - Consultar campañas publicitarias
4. **Empleados** - Consultar empleados
5. **Productos** - Consultar productos y precios

#### Endpoints de Registro/Creación (3)
6. **Prospectos** - Agregar nuevo prospecto
7. **Oportunidades** - Agregar cabecero de oportunidad
8. **Productos de Oportunidad** - Agregar productos a oportunidad

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

#### Ejemplos de Registro y Ventas (4)
- `15-registrar-prospecto.php` - Registra nuevo prospecto
- `16-crear-oportunidad.php` - Crea oportunidad de venta
- `17-agregar-productos-oportunidad.php` - Agrega productos
- `18-flujo-completo-venta.php` - Flujo completo de venta

---

## 📖 Referencias

- [Clean Architecture - Robert C. Martin](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [SOLID Principles](https://en.wikipedia.org/wiki/SOLID)
- [Hexagonal Architecture](https://alistair.cockburn.us/hexagonal-architecture/)
- [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
- [Guzzle Documentation](https://docs.guzzlephp.org/)

---

## 📝 Conclusión

Esta arquitectura proporciona:

✅ **Mantenibilidad**: Código organizado y fácil de mantener  
✅ **Testabilidad**: Cada componente es testeable independientemente  
✅ **Escalabilidad**: Fácil agregar nuevos endpoints o funcionalidades  
✅ **Flexibilidad**: Cambiar implementaciones sin afectar el dominio  
✅ **Claridad**: Separación clara de responsabilidades  

---

**Última actualización**: Octubre 2025  
**Versión**: 2.0.0 - Incluye módulos de Prospectos y Oportunidades
