# Propuesta: Navegación Condicional con Dependencias entre Preguntas

## Por Qué

Actualmente el wizard de requerimientos permite navegar libremente entre preguntas sin validar dependencias lógicas. Se necesita implementar un sistema de dependencias donde ciertas preguntas solo permitan avanzar si se cumple una condición específica de una pregunta anterior, mejorando la validación del flujo y la calidad de los datos recopilados.

## Qué Cambia

- Agregar propiedad opcional `dependencia_previa` en el schema JSON de preguntas
- Implementar validación de dependencias antes de permitir navegación hacia adelante
- Mantener navegación libre hacia atrás (botón "Anterior")
- Bloquear navegación hacia adelante si la dependencia no se cumple
- Mostrar mensaje de error indicando el requisito no cumplido

## Impacto

### Archivos Afectados

- `requerimientos/preguntas/requirements.json` - Agregar campo `dependencia_previa` (opcional)
- `requerimientos/script.js` - Implementar lógica de validación de dependencias
- `requerimientos/index.php` - Sin cambios (lectura del JSON ya soporta campos adicionales)
- `requerimientos/README.md` - Documentar nueva funcionalidad

### Schema JSON Extendido

```json
{
  "titulo": "Pregunta ejemplo",
  "tipo": "text",
  "nombre": "campo_ejemplo",
  "dependencia_previa": {
    "campo": "nombre_campo_anterior",
    "condicion": "no_vacio|valor_especifico|contiene",
    "valor": "valor_esperado (opcional)"
  }
}
```

### Tipos de Condiciones Soportadas

1. `no_vacio` - El campo anterior debe tener algún valor
2. `valor_especifico` - El campo anterior debe ser igual a `valor`
3. `contiene` - El campo anterior debe contener `valor`
4. `mayor_que` - El campo anterior debe tener longitud mayor que `valor`

### Comportamiento Nuevo

- **Sin dependencia**: Navegación normal (como actualmente)
- **Con dependencia cumplida**: Permite avanzar normalmente
- **Con dependencia NO cumplida**: 
  - Bloquea botón "Siguiente" o muestra error al intentar avanzar
  - Muestra mensaje específico indicando qué falta
  - Permite retroceder libremente con "Anterior"

### Breaking Changes

**Ninguno** - La funcionalidad es totalmente opcional y retrocompatible:
- Preguntas sin `dependencia_previa` funcionan como siempre
- JSON actual sigue siendo 100% válido
- No requiere migración de datos existentes

## Ejemplo de Uso

```json
[
  {
    "titulo": "¿Tu empresa tiene sitio web?",
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
      "valor": "Sí"
    }
  }
]
```

En este ejemplo, la pregunta sobre la URL solo aparecerá/permitirá avanzar si el usuario seleccionó "Sí" en la pregunta anterior.
