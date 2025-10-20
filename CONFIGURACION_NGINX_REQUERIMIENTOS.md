# CONFIGURACIÓN DE NGINX ACTUALIZADA

## Cambio de directorio: dashboard → requerimientos

**IMPORTANTE**: Se ha cambiado el directorio de `dashboard` a `requerimientos`.

### URL actualizada:
- **Antes**: https://cecapta.callblasterai.com/dashboard/
- **Ahora**: https://cecapta.callblasterai.com/requerimientos/

## Configuración de Nginx a aplicar

Edita el archivo: `/etc/nginx/sites-available/cecapta.callblasterai.com`

### REMOVER estas líneas (configuración antigua):

```nginx
# Dashboard - Chatbot Configuration Wizard
location /dashboard {
    alias /var/www/cecapta.callblasterai.com/dashboard;
    index index.php;
    
    try_files $uri $uri/ @dashboard_rewrite;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $request_filename;
        fastcgi_read_timeout 300;
    }
}

location @dashboard_rewrite {
    rewrite ^/dashboard$ /dashboard/ permanent;
    rewrite ^/dashboard/(.*)$ /dashboard/index.php?$1 last;
}

# Deny access to dashboard/respuestas directory (JSON files)
location /dashboard/respuestas/ {
    deny all;
    return 403;
}
```

### AGREGAR estas líneas (configuración nueva):

```nginx
# Requerimientos - Chatbot Configuration Wizard
location /requerimientos {
    alias /var/www/cecapta.callblasterai.com/requerimientos;
    index index.php;
    
    try_files $uri $uri/ @requerimientos_rewrite;
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $request_filename;
        fastcgi_read_timeout 300;
    }
}

location @requerimientos_rewrite {
    rewrite ^/requerimientos$ /requerimientos/ permanent;
    rewrite ^/requerimientos/(.*)$ /requerimientos/index.php?$1 last;
}

# Deny access to requerimientos/respuestas directory (JSON files)
location /requerimientos/respuestas/ {
    deny all;
    return 403;
}
```

## Comandos para aplicar los cambios

```bash
# 1. Editar la configuración de nginx
sudo nano /etc/nginx/sites-available/cecapta.callblasterai.com

# 2. Verificar la configuración
sudo nginx -t

# 3. Recargar nginx
sudo systemctl reload nginx

# 4. Verificar que funciona
curl -I https://cecapta.callblasterai.com/requerimientos/

# 5. Verificar que la protección funciona
curl -I https://cecapta.callblasterai.com/requerimientos/respuestas/
# Debe retornar: 403 Forbidden
```

## Verificar permisos

```bash
# Verificar permisos del directorio
ls -la /var/www/cecapta.callblasterai.com/requerimientos/

# Verificar permisos del directorio de respuestas
ls -la /var/www/cecapta.callblasterai.com/requerimientos/respuestas/

# Ajustar permisos si es necesario
sudo chown -R www-data:www-data /var/www/cecapta.callblasterai.com/requerimientos/
sudo chmod 755 /var/www/cecapta.callblasterai.com/requerimientos/
sudo chmod 755 /var/www/cecapta.callblasterai.com/requerimientos/respuestas/
```

## Resultado final

- ✅ Directorio cambiado de `dashboard` a `requerimientos`
- ✅ URL actualizada: https://cecapta.callblasterai.com/requerimientos/
- ✅ Todas las fuentes Inter y Roboto mantenidas en `./fonts/`
- ✅ Configuración de nginx actualizada
- ✅ Protección de archivos JSON mantenida
- ✅ Documentación actualizada

## Opcional: Limpieza

Si quieres eliminar el directorio antiguo después de verificar que todo funciona:

```bash
# SOLO después de verificar que /requerimientos/ funciona correctamente
rm -rf /var/www/cecapta.callblasterai.com/dashboard/
```