# Contexto del Proyecto

## Propósito
CECAPTA CallBlaster AI es un sistema de gestión para CECAPTA (Centro de Capacitación Profesional del Golfo). El sistema se integra con la API de IntegraApp para gestionar operaciones de negocio incluyendo:

- Gestión de empresas y sucursales
- Seguimiento de campañas de marketing
- Gestión de empleados
- Catálogo de productos y precios
- Registro de prospectos y gestión de oportunidades
- Flujos completos de venta

El objetivo principal es proporcionar un cliente API robusto y mantenible que siga los principios de arquitectura limpia para consumir la plataforma IntegraApp.

## Stack Tecnológico
- **PHP**: 8.3+ (con características modernas: readonly, enums, tipos estrictos)
- **Composer**: Gestión de dependencias y autoloading PSR-4
- **Guzzle HTTP Client**: ^7.8 para peticiones API robustas
- **PHPUnit**: ^10.5 (para pruebas, en progreso)
- **HTML/CSS/JavaScript**: Interfaz de landing page
- **Arquitectura**: Arquitectura Limpia (Hexagonal/Puertos y Adaptadores)

## Convenciones del Proyecto

### Estilo de Código
- **PSR-4**: Estándar de autoloading
- **PSR-12**: Estándar de estilo de código
- **Tipos Estrictos**: Siempre habilitados (`declare(strict_types=1);`)
- **Características Modernas de PHP**: 
  - Usar clases y propiedades `readonly` cuando sea aplicable
  - Usar enums para constantes con tipo seguro
  - Usar promoción de propiedades en constructores
  - Usar argumentos nombrados para claridad
- **Convenciones de Nomenclatura**:
  - Clases: PascalCase (ej: `ConsultarEmpresas`, `EmpresaDTO`)
  - Métodos: camelCase (ej: `execute()`, `findByAlias()`)
  - Propiedades: camelCase
  - Constantes: UPPER_SNAKE_CASE
- **Documentación**: Comentarios inline mínimos; el código debe ser autodocumentado. Comentar solo cuando se necesite aclaración.

### Patrones de Arquitectura
El proyecto sigue **Arquitectura Limpia** con 4 capas distintas:

1. **Capa de Dominio** (`src/Domain/`):
   - Entidades: Objetos de negocio (ej: `Empresa`, `Prospecto`, `Oportunidad`)
   - Objetos de Valor: Valores inmutables (ej: `Token`, `CURP`, `EstatusEmpresa`)
   - Interfaces de Repositorio: Puertos para acceso a datos
   - Excepciones de Dominio: Violaciones de reglas de negocio

2. **Capa de Aplicación** (`src/Application/`):
   - Casos de Uso: Orquestación de lógica de negocio (ej: `ConsultarEmpresas`, `RegistrarProspecto`)
   - DTOs: Objetos de transferencia de datos para resultados de casos de uso
   - Excepciones de Aplicación

3. **Capa de Infraestructura** (`src/Infrastructure/`):
   - Cliente HTTP: `IntegraApiClient` usando Guzzle
   - Implementaciones de Repositorio: Adaptadores API
   - Excepciones de Infraestructura

4. **Capa de Presentación**:
   - Ejemplos: Scripts CLI en directorio `examples/` (18 ejemplos funcionales)
   - Interfaz Web: Landing page en `main/`

**Principios Clave**:
- Las dependencias apuntan hacia adentro (Infraestructura → Aplicación → Dominio)
- La capa de dominio no tiene dependencias externas
- Usar interfaces/puertos para servicios externos
- DTOs para cruzar fronteras arquitectónicas

### Estrategia de Pruebas
- **Framework**: PHPUnit ^10.5 (configurado, pruebas pendientes de implementación)
- **Tipos de Pruebas**:
  - Pruebas unitarias: `tests/Unit/`
  - Pruebas de integración: `tests/Integration/`
- **Cobertura**: Apuntar a alta cobertura en capas de Dominio y Aplicación
- **Ejemplos como Pruebas**: 18 ejemplos funcionales sirven como verificación de integración
- **Ejecución de Pruebas**:
  ```bash
  vendor/bin/phpunit tests/Unit
  vendor/bin/phpunit tests/Integration
  vendor/bin/phpunit  # todas las pruebas
  ```

### Flujo de Trabajo Git
- **Rama Principal**: `main` (estable, lista para producción)
- **Ramas de Funcionalidad**: `feature/<nombre-funcionalidad>`
- **Convención de Commits**: Mensajes descriptivos en español o inglés
- **Ejemplos de Commits**:
  - "Agregar Landing Page para Call Blaster AI"
  - "Refactor: Encapsular funcionalidad en carpeta api_tests"
  - "Configurar interfaz web para acceso directo"
- **Flujo de Trabajo**:
  1. Crear rama de funcionalidad desde `main`
  2. Implementar cambios con commits descriptivos
  3. Probar localmente con ejemplos
  4. Fusionar a `main` cuando esté estable

## Contexto del Dominio

### Dominio de Negocio: Gestión de Centro de Capacitación Profesional
CECAPTA es un centro de capacitación profesional que necesita gestionar:

- **Empresas**: Múltiples empresas con estatus activo/inactivo
- **Sucursales**: Múltiples ubicaciones por empresa
- **Campañas**: Campañas de marketing en plataformas (Facebook, Google, WhatsApp, etc.)
- **Empleados**: Personal que gestiona ventas y operaciones
- **Productos**: Cursos de capacitación y servicios con múltiples listas de precios
- **Prospectos**: Clientes potenciales con identificación CURP
- **Oportunidades**: Oportunidades de venta con productos, etapas y probabilidades

### Integración con API
- **API Externa**: IntegraApp (https://integraapp.net/API/)
- **Autenticación**: Basada en token (pasado en URLs)
- **Formato de Respuesta**: JSON (excepto algunos endpoints específicos)
- **Endpoints Clave**: 8 implementados (Empresas, Sucursales, Campañas, Empleados, Productos, Prospectos, Oportunidades, OportunidadProductos)

### Objetos de Valor
- **Token**: Token de autenticación API
- **CURP**: Identificación ciudadana mexicana (18 caracteres, formato validado)
- **EstatusEmpresa**: Enum de estatus de empresa (ACTIVO, INACTIVO, SUSPENDIDO, CANCELADO)
- **EstatusSucursal**: Enum de estatus de sucursal
- **PlataformaCampana**: Enum de plataforma de campaña

## Restricciones Importantes

### Restricciones Técnicas
- **Versión de PHP**: Debe ser >= 8.3 (el proyecto usa características modernas de PHP)
- **Extensiones Requeridas**: ext-json, ext-curl, ext-mbstring
- **Token API**: Requerido para todas las operaciones API (almacenado en config, nunca committeado)
- **Timeout**: Las llamadas API tienen timeout por defecto de 30s (configurable)
- **Sin Base de Datos**: Actualmente sin estado, todos los datos desde API IntegraApp

### Restricciones de Negocio
- **Validación CURP**: Debe seguir el formato mexicano de CURP (18 caracteres: 4 letras + 6 dígitos + 6 alfanuméricos + 2 dígitos)
- **IDs de Empresa**: Referencias hardcodeadas a empresas específicas (ej: empresaId: 24 para CECAPTA)
- **DTOs de Solo Lectura**: Todos los DTOs son readonly para prevenir mutación accidental

### Restricciones de Seguridad
- **Seguridad del Token**: Los tokens API no deben ser committeados al repositorio (.env en .gitignore)
- **Sin Datos Sensibles**: No loggear ni exponer información personal de clientes
- **HTTPS**: Las llamadas API usan HTTPS

## Dependencias Externas

### Dependencias Principales
- **guzzlehttp/guzzle**: ^7.8 - Cliente HTTP para peticiones API
- **phpunit/phpunit**: ^10.5 - Framework de pruebas (solo dev)

### Servicios Externos
- **API IntegraApp**: Servicio externo principal
  - URL Base: https://integraapp.net/API/
  - Autenticación: Basada en token
  - Formato de Respuesta: JSON
  - Límites de Rate: Desconocidos (manejar con gracia)
  
### Endpoints API Utilizados
1. `/Empresas/ConsultarTabla/{token}` - Listar empresas
2. `/Sucursales/ConsultarSucursales/{token}/{empresaId}` - Listar sucursales
3. `/Campañas/ConsultarCampañas/{token}` - Listar campañas
4. `/Empleados/ConsultarEmpleados/{token}` - Listar empleados
5. `/Productos/ConsultarListadoConPrecios/{token}` - Listar productos con precios
6. `/Prospectos/RegistrarProspecto/{token}` - Registrar prospecto (POST)
7. `/Oportunidades/CrearOportunidad/{token}` - Crear oportunidad (POST)
8. `/Oportunidades/AgregarProductoAOportunidad/{token}` - Agregar producto a oportunidad (POST)

### Infraestructura
- **Servidor Web**: Se ejecuta en `/var/www/cecapta.callblasterai.com/`
- **Dominio**: cecapta.callblasterai.com
- **Sistema Operativo**: Entorno Linux
