# Propuesta: Configurar Envío de Correos SMTP para Módulo Requerimientos

## Por Qué

El módulo `./requerimientos` actualmente usa la función `mail()` de PHP que depende de la configuración del servidor (sendmail/postfix). Esto presenta problemas de confiabilidad, autenticación y entrega. Se requiere implementar envío de correos mediante SMTP con credenciales configurables para asegurar la entrega exitosa de las notificaciones cuando se finaliza un formulario de requerimientos.

## Qué Cambia

- Crear archivo de configuración para credenciales SMTP
- Implementar clase o función para envío de correos mediante SMTP
- Reemplazar función `mail()` por envío SMTP en `guardar.php`
- Asegurar que las credenciales no se expongan en el código
- Mantener logs de envío para debugging

## Impacto

- **Archivos nuevos:**
  - `requerimientos/config/email.php` - Configuración de SMTP
  - `requerimientos/lib/EmailSender.php` - Clase para envío SMTP (opcional)

- **Archivos modificados:**
  - `requerimientos/guardar.php` - Usar SMTP en lugar de `mail()`

- **Configuración requerida:**
  - Host SMTP
  - Puerto SMTP (587 para TLS, 465 para SSL)
  - Usuario/correo de autenticación
  - Contraseña
  - Tipo de encriptación (TLS/SSL)
  - Correo remitente (FROM)
  - Nombre del remitente

- **Destinatarios fijos:**
  - ozeamartinez@gmail.com
  - andres.reyes.zamorategui@gmail.com

- **Comportamiento nuevo:**
  - Envío confiable de correos mediante SMTP autenticado
  - Mejor manejo de errores en envío
  - Logs de intentos de envío

- **Sin breaking changes** - La funcionalidad existente se mantiene, solo mejora la confiabilidad

## Seguridad

- Credenciales en archivo separado fuera del document root (recomendado)
- Archivo de configuración con permisos restrictivos (600 o 640)
- No incluir credenciales en control de versiones
- Usar variables de entorno como alternativa (opcional)

## Opciones de Implementación

### Opción 1: PHPMailer (Recomendado)
- Librería madura y ampliamente usada
- Soporte completo SMTP
- Manejo de errores robusto
- Instalación vía Composer

### Opción 2: SwiftMailer
- Alternativa robusta
- Similar a PHPMailer

### Opción 3: Implementación nativa
- Usar `fsockopen()` o `stream_socket_client()`
- Mayor control pero más código a mantener
- No recomendado para producción
