# Configuración de Preguntas del Wizard

Este directorio contiene la configuración de las preguntas del wizard de requerimientos.

## 📄 Archivos

- **`requirements.json`**: Archivo principal con las preguntas activas del wizard
- **`backups/`**: Directorio de respaldos automáticos con timestamp
- **`requirements-ejemplo-dependencias.json`**: Ejemplos de preguntas con dependencias condicionales
- **`requirements_original.json`**: Versión original de respaldo

## 🔧 Cómo Editar las Preguntas

### 1. Hacer un Respaldo

Antes de editar, haz una copia de seguridad:

```bash
cp requirements.json requirements_backup_$(date +%Y%m%d_%H%M%S).json
```

### 2. Editar el Archivo JSON

Abre `requirements.json` con tu editor favorito y modifica las preguntas según necesites.

### 3. Estructura de una Pregunta

Cada pregunta es un objeto JSON con los siguientes campos:

```json
{
  "titulo": "¿Cuál es el nombre de tu empresa?",
  "tipo": "text",
  "placeholder": "Ejemplo: Empresa S.A de C.V.",
  "nombre": "nombre_empresa",
  "maxlength": 200,
  "valor_defecto": "",
  "dependencia_previa": null
}
```

### 4. Campos Disponibles

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `titulo` | string | ✅ Sí | Texto de la pregunta que verá el usuario |
| `tipo` | string | ✅ Sí | Tipo de campo: `text`, `textarea`, `select`, `url` |
| `nombre` | string | ✅ Sí | Identificador único (usar snake_case) |
| `placeholder` | string | ⚪ No | Texto de ayuda en el campo |
| `maxlength` | number | ⚪ No | Longitud máxima (default: 1000) |
| `valor_defecto` | string | ⚪ No | Valor inicial del campo |
| `opciones` | array | ⚠️ Sí* | Array de opciones (solo para tipo `select`) |
| `dependencia_previa` | object | ⚪ No | Condición para mostrar la pregunta |

*Requerido solo para campos tipo `select`

### 5. Tipos de Campo

#### Text (`text`)
Campo de texto simple, una línea:

```json
{
  "titulo": "¿Cuál es tu nombre?",
  "tipo": "text",
  "nombre": "nombre_usuario",
  "maxlength": 100
}
```

#### Textarea (`textarea`)
Campo de texto multilínea:

```json
{
  "titulo": "Describe tu empresa",
  "tipo": "textarea",
  "nombre": "descripcion_empresa",
  "maxlength": 2000
}
```

#### Select (`select`)
Menú desplegable con opciones predefinidas:

```json
{
  "titulo": "¿Cuál es el tono de comunicación deseado?",
  "tipo": "select",
  "nombre": "tono_comunicacion",
  "opciones": ["Formal", "Amigable", "Divertido", "Profesional"]
}
```

#### URL (`url`)
Campo validado para URLs:

```json
{
  "titulo": "URL de tu sitio web",
  "tipo": "url",
  "nombre": "url_website",
  "maxlength": 500
}
```

### 6. Dependencias Condicionales

Puedes hacer que una pregunta dependa de la respuesta anterior:

```json
{
  "titulo": "¿Deseas agregar tu sitio web?",
  "tipo": "select",
  "nombre": "tiene_website",
  "opciones": ["Sí", "No"]
},
{
  "titulo": "Proporciona la URL de tu sitio web",
  "tipo": "url",
  "nombre": "url_website",
  "dependencia_previa": {
    "campo": "tiene_website",
    "condicion": "valor_especifico",
    "valor": "Sí",
    "mensaje_error": "Solo si indicaste que tienes sitio web"
  }
}
```

#### Tipos de Condiciones

1. **`no_vacio`**: El campo anterior debe tener contenido
2. **`valor_especifico`**: El campo debe ser igual a `valor`
3. **`contiene`**: El campo debe contener el texto en `valor`
4. **`mayor_que`**: El campo debe tener longitud mayor que `valor` (número)

Ejemplo completo:

```json
{
  "dependencia_previa": {
    "campo": "nombre_campo_previo",
    "condicion": "contiene",
    "valor": "palabra clave",
    "mensaje_error": "Debes mencionar 'palabra clave' en la respuesta anterior"
  }
}
```

### 7. Validar el JSON

Después de editar, valida que el JSON sea correcto:

```bash
php -r "
\$json = file_get_contents('requirements.json');
\$data = json_decode(\$json, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo 'ERROR: ' . json_last_error_msg() . PHP_EOL;
    exit(1);
}
echo 'JSON válido ✓' . PHP_EOL;
echo 'Total de preguntas: ' . count(\$data) . PHP_EOL;
"
```

También puedes usar herramientas online como:
- https://jsonlint.com/
- https://jsonformatter.org/

### 8. Aplicar los Cambios

Los cambios se aplican automáticamente al recargar la página del wizard. No es necesario reiniciar ningún servicio.

## ⚠️ Consideraciones Importantes

### Nombres de Campos

- Usa **snake_case** (minúsculas con guiones bajos)
- Deben ser únicos en todo el archivo
- No uses espacios ni caracteres especiales
- Ejemplos: `nombre_empresa`, `tono_comunicacion`, `url_website`

### Orden de las Preguntas

El orden en el array JSON es el orden en que aparecerán en el wizard.

### Modificar Campos Existentes

Si modificas el `nombre` de una pregunta existente, las respuestas guardadas anteriormente con el nombre antiguo no se validarán correctamente.

### Agregar Nuevas Preguntas

Puedes agregar nuevas preguntas al final o insertarlas en medio del array. El wizard se adaptará automáticamente.

### Eliminar Preguntas

Puedes eliminar preguntas del array, pero ten en cuenta que las respuestas guardadas previamente pueden contener esos campos.

## 📝 Ejemplos Completos

Ver el archivo `requirements-ejemplo-dependencias.json` para ejemplos de:
- Preguntas con dependencias condicionales
- Diferentes tipos de validación
- Flujos complejos con múltiples condiciones

## 🔄 Restaurar desde Backup

Si algo sale mal, restaura desde un backup:

```bash
# Ver backups disponibles
ls -la backups/

# Restaurar desde un backup específico
cp backups/requirements_20251022_010100.json requirements.json

# O usar el backup manual
cp requirements_backup_FECHA.json requirements.json
```

## 🧪 Probar los Cambios

1. Abre el wizard en tu navegador
2. Verifica que todas las preguntas aparezcan correctamente
3. Prueba la navegación entre pasos
4. Verifica las validaciones
5. Completa el wizard y verifica que se guarden los datos

## 📞 Soporte

Si tienes dudas o problemas con la configuración de las preguntas, contacta al equipo de desarrollo.
