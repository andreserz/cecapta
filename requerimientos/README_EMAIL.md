# Configuración de Correo SMTP - Módulo Requerimientos

## Descripción

El módulo de requerimientos utiliza PHPMailer para enviar notificaciones por correo electrónico cuando se finaliza un formulario. Esta configuración permite envío confiable mediante SMTP autenticado.

## Configuración Actual

**Servidor:** smtp.ionos.mx  
**Puerto:** 465  
**Encriptación:** SSL  
**Usuario:** admin@callblasterai.com  
**Destinatarios:**
- ozeamartinez@gmail.com
- andres.reyes.zamorategui@gmail.com

## Estructura de Archivos

```
requerimientos/
├── config/
│   └── email.php              # Configuración SMTP (NO incluir en git)
├── lib/
│   └── EmailHelper.php        # Clase helper para envío
├── vendor/                    # PHPMailer (instalado vía Composer)
├── guardar.php               # Script que envía correos
├── test_email.php            # Script de prueba
└── .gitignore                # Excluye credenciales
```

## Archivo de Configuración

### Ubicación
`/var/www/cecapta.callblasterai.com/requerimientos/config/email.php`

### Formato
```php
<?php
return [
    'smtp_host' => 'smtp.ionos.mx',
    'smtp_port' => 465,
    'smtp_encryption' => 'ssl', // 'ssl' para 465, 'tls' para 587
    'smtp_username' => 'admin@callblasterai.com',
    'smtp_password' => 'No56Ay34',
    'from_email' => 'admin@callblasterai.com',
    'from_name' => 'CallBlaster AI - Sistema de Requerimientos',
    'to_emails' => [
        'ozeamartinez@gmail.com',
        'andres.reyes.zamorategui@gmail.com'
    ],
    'charset' => 'UTF-8',
    'timeout' => 30,
    'debug' => 0 // 0=off, 1=client, 2=client+server
];
```

### Permisos
```bash
chmod 600 config/email.php
```

## Proveedores SMTP Comunes

### Gmail
```php
'smtp_host' => 'smtp.gmail.com',
'smtp_port' => 587,
'smtp_encryption' => 'tls',
'smtp_username' => 'tucorreo@gmail.com',
'smtp_password' => 'contraseña_aplicacion', // NO uses tu contraseña normal
```

**Nota:** Requiere habilitar "Contraseñas de aplicación" en la cuenta de Google.

### Outlook/Hotmail
```php
'smtp_host' => 'smtp-mail.outlook.com',
'smtp_port' => 587,
'smtp_encryption' => 'tls',
'smtp_username' => 'tucorreo@outlook.com',
'smtp_password' => 'tu_contraseña',
```

### SendGrid
```php
'smtp_host' => 'smtp.sendgrid.net',
'smtp_port' => 587,
'smtp_encryption' => 'tls',
'smtp_username' => 'apikey',
'smtp_password' => 'tu_api_key_de_sendgrid',
```

### Mailgun
```php
'smtp_host' => 'smtp.mailgun.org',
'smtp_port' => 587,
'smtp_encryption' => 'tls',
'smtp_username' => 'postmaster@tu-dominio.mailgun.org',
'smtp_password' => 'tu_contraseña',
```

## Pruebas

### Script de Prueba
```bash
cd /var/www/cecapta.callblasterai.com/requerimientos
php test_email.php
```

### Resultado Esperado
```
=== PRUEBA DE ENVÍO DE CORREO SMTP ===

Servidor: smtp.ionos.mx:465
Usuario: admin@callblasterai.com
...

✅ CORREO ENVIADO EXITOSAMENTE

Verifica que el correo haya llegado a:
  - ozeamartinez@gmail.com
  - andres.reyes.zamorategui@gmail.com
```

## Troubleshooting

### Error: "Could not authenticate"
- **Causa:** Usuario o contraseña incorrectos
- **Solución:** Verifica las credenciales en `config/email.php`

### Error: "Connection timeout"
- **Causa:** Firewall bloqueando el puerto o host incorrecto
- **Solución:** 
  - Verifica que el puerto 465 (SSL) o 587 (TLS) esté abierto
  - Confirma el host SMTP correcto

### Error: "SSL certificate problem"
- **Causa:** Certificado SSL no válido
- **Solución temporal:** (NO recomendado para producción)
  ```php
  $this->mailer->SMTPOptions = [
      'ssl' => [
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true
      ]
  ];
  ```

### Error: "SMTP ERROR: Failed to connect"
- **Causa:** Puerto o tipo de encriptación incorrectos
- **Solución:**
  - Puerto 465 → Usar `'smtp_encryption' => 'ssl'`
  - Puerto 587 → Usar `'smtp_encryption' => 'tls'`

### Correos no llegan (sin errores)
- **Posibles causas:**
  - Correo en spam/basura
  - Filtros del servidor
  - Límites de envío del proveedor SMTP
- **Solución:**
  - Revisar carpeta de spam
  - Agregar remitente a lista blanca
  - Verificar logs del servidor SMTP

## Debug

### Habilitar Debug
En `config/email.php`:
```php
'debug' => 2, // Muestra toda la comunicación SMTP
```

### Ver Logs
```bash
tail -f /var/log/nginx/error.log
# o
tail -f /var/log/php-fpm/www-error.log
```

## Seguridad

### ✅ Buenas Prácticas
- Archivo de configuración con permisos 600
- Credenciales en archivo separado
- No incluir config/email.php en git
- Usar contraseñas fuertes
- Considerar autenticación de dos factores

### ❌ NO Hacer
- No hardcodear credenciales en código
- No usar `debug => 2` en producción
- No compartir el archivo de configuración
- No usar contraseña de cuenta principal (Gmail)

## Mantenimiento

### Cambiar Credenciales
1. Editar `config/email.php`
2. Probar con `php test_email.php`
3. Verificar recepción de correos

### Cambiar Destinatarios
Modificar array `to_emails` en `config/email.php`:
```php
'to_emails' => [
    'nuevo1@example.com',
    'nuevo2@example.com'
],
```

### Actualizar PHPMailer
```bash
cd /var/www/cecapta.callblasterai.com/requerimientos
composer update phpmailer/phpmailer
```

## Soporte

Para problemas o dudas:
- Revisar documentación de PHPMailer: https://github.com/PHPMailer/PHPMailer
- Verificar configuración del proveedor SMTP
- Revisar logs del servidor

---

**Última actualización:** 2025-10-22  
**Versión PHPMailer:** 7.0.0  
**PHP:** 7.4+
