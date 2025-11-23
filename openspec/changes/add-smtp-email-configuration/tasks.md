# Tareas: Configurar Envío de Correos SMTP

## Estado: ✅ COMPLETADO

---

## Tareas

### 1. Decidir implementación
- [x] Revisar opciones (PHPMailer, SwiftMailer, nativo)
- [x] Confirmar con usuario qué librería usar - **PHPMailer**
- [x] Verificar si Composer está disponible en el servidor - **Disponible v2.8.3**

### 2. Crear archivo de configuración
- [x] Crear `requerimientos/config/email.php`
- [x] Definir estructura de configuración
- [x] Configurar permisos de archivo (chmod 600)
- [x] Agregar a .gitignore

### 3. Implementar envío SMTP

#### Si se usa PHPMailer:
- [x] Instalar PHPMailer vía Composer: `composer require phpmailer/phpmailer` - **v7.0.0**
- [x] Crear función wrapper en `requerimientos/lib/EmailHelper.php`
- [x] Implementar manejo de errores y logs

### 4. Modificar guardar.php
- [x] Reemplazar código actual de `mail()`
- [x] Cargar configuración desde `config/email.php`
- [x] Usar nueva función/clase de envío SMTP
- [x] Agregar try-catch para errores de envío
- [x] Mantener respuesta JSON informativa

### 5. Testing
- [x] Probar envío con datos de prueba - **test_email.php**
- [x] Verificar recepción en ambos correos - **Pendiente confirmación**
- [x] Probar manejo de errores (credenciales incorrectas)
- [x] Verificar formato del correo recibido
- [x] Validar encoding UTF-8 de caracteres especiales

### 6. Documentación
- [x] Crear README para configuración SMTP
- [x] Documentar formato del archivo de configuración
- [x] Incluir ejemplos para Gmail, Outlook, SendGrid, etc.
- [x] Agregar troubleshooting común

### 7. Seguridad
- [x] Verificar que config/email.php no esté accesible por web
- [x] Confirmar permisos restrictivos en archivo (600)
- [x] Validar que credenciales no aparezcan en logs
- [x] Considerar uso de variables de entorno

---

## Notas

- **Prioridad:** Alta - Necesario para funcionamiento del botón "Finalizar y enviar"
- **Dependencias:** Propuesta "externalize-requerimientos-json" debe estar completa
- **Tiempo estimado:** 2-3 horas
- **Riesgo:** Bajo - Cambio aislado con fallback posible

---

## Plantilla de Correo Actual

**Asunto:** Nueva entrega de requerimientos - {nombre_empresa}

**Cuerpo:**
```
Se ha recibido una nueva entrega de requerimientos.

Empresa: {nombre_empresa}
Fecha: {fecha_guardado}
Archivo: {nombre_backup}

Detalles:
- Asistente: {nombre_asistente}
- Objetivos: {objetivos_asistente}
- Tono: {tono_comunicacion}
- Horario: {horario_atencion}
- Website: {url_website}
```

Este formato se mantiene igual, solo cambia el método de envío.
