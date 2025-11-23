# CONFIGURACIÓN DE NGINX REQUERIDA

Para proteger los archivos JSON de acceso directo, agrega esta configuración a tu archivo de configuración de Nginx:

```nginx
# Dentro del bloque server {} o location {}
location ~ ^/dashboard/respuestas/.*\.json$ {
    deny all;
    return 403;
}
```

O de forma más específica:

```nginx
location /dashboard/respuestas/ {
    deny all;
}

# Permitir solo acceso desde scripts PHP internos
location ~ ^/dashboard/(index|guardar)\.php$ {
    include fastcgi_params;
    fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;  # Ajusta según tu versión de PHP
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
}
```

Después de agregar la configuración, recarga Nginx:
```bash
sudo nginx -t
sudo systemctl reload nginx
```
