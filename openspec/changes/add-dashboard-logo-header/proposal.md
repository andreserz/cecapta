# Propuesta: Agregar Logotipo y Título al Dashboard

## Por Qué

El dashboard actual no tiene branding ni identificación visual. Agregar el logotipo de Call Blaster y un título "Requerimientos" mejorará:
- La identidad visual del dashboard
- La profesionalidad de la interfaz
- La coherencia con el resto del sitio web
- La claridad sobre el propósito de la página

## Qué Cambia

- **Nuevo header**: Agregar sección superior con logotipo y título
- **Logotipo**: Usar `Logo_Claro_Trans.png` existente en `/main/img/`
- **Título**: "Requerimientos" junto al logotipo
- **Diseño**: Mantener tema oscuro y estilo corporativo

### Ubicación Visual

El header se ubicará en la parte superior del dashboard, antes de la barra de progreso:

```
┌─────────────────────────────────────────┐
│  [LOGO] REQUERIMIENTOS                  │  ← NUEVO
├─────────────────────────────────────────┤
│  Paso 1 de 7      [█████░░░░] 14%      │
│  ... resto del wizard ...               │
└─────────────────────────────────────────┘
```

### Características del Header

1. **Logotipo**:
   - Archivo: `/main/img/Logo_Claro_Trans.png` (13 KB)
   - Tamaño: ~40-50px de altura
   - Posición: Alineado a la izquierda

2. **Título "Requerimientos"**:
   - Tipografía: Inter (consistente con el wizard)
   - Tamaño: text-2xl (1.5rem) en móvil, text-3xl (1.875rem) en desktop
   - Color: Texto claro (#F9FAFB)
   - Peso: font-bold (700)

3. **Layout**:
   - Flexbox horizontal con gap entre logo y texto
   - Centrado verticalmente
   - Padding adecuado (py-4 px-6)
   - Fondo semi-transparente opcional para diferenciación

## Impacto

### Capacidades Afectadas
- **MODIFICADA**: `chatbot-configuration` - Agregar header con branding

### Archivos Afectados
- **Modificados**:
  - `./dashboard/index.php` - Agregar estructura HTML del header
  - Estilos inline o en `<style>` (opcional, Tailwind cubre todo)

### Cambios Visuales
- Altura total del dashboard aumenta ~60-80px
- El contenido del wizard se desplaza ligeramente hacia abajo
- **Sin scroll**: El diseño responsive se ajusta para mantener todo visible

## Consideraciones de Diseño

### Responsive
- **Móvil** (< 768px): Logo más pequeño (32px), título text-xl
- **Desktop** (≥ 1024px): Logo normal (48px), título text-3xl

### Accesibilidad
- Alt text en la imagen: "Call Blaster Logo"
- Contraste adecuado del texto sobre fondo oscuro

### Consistencia
- Mantener paleta naranja (#F97316) para coherencia
- Usar misma tipografía (Inter) del resto del wizard

## Alternativas Consideradas

1. **Solo texto sin logo**: ❌ Menos impacto visual
2. **Logo centrado arriba**: ❌ Menos espacio para contenido
3. **Logo + título actual**: ✅ Balance perfecto entre branding y funcionalidad

## Próximos Pasos

1. Aprobar esta propuesta
2. Implementar header en `index.php`
3. Probar responsive en móvil y desktop
4. Verificar que no afecte el comportamiento sin scroll
5. Archivar cambio
