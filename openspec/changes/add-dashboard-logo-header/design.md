# Diseño Técnico: Header con Logo y Título

## Contexto

El dashboard actual carece de branding visual y identificación clara. Los usuarios no tienen una referencia inmediata de que están en la plataforma Call Blaster al acceder al wizard de configuración.

### Restricciones
- **Sin scroll**: El header no debe causar desplazamiento vertical
- **Responsive**: Debe adaptarse a todos los tamaños de pantalla
- **Performance**: No debe afectar tiempos de carga significativamente
- **Consistencia**: Debe mantener el tema oscuro y estilo corporativo

## Objetivos / No-Objetivos

### Objetivos
✅ Agregar identidad visual con logo corporativo
✅ Incluir título descriptivo "Requerimientos"
✅ Mantener diseño responsive sin scroll
✅ Preservar toda la funcionalidad existente del wizard
✅ Mejorar profesionalidad de la interfaz

### No-Objetivos
❌ No agregar navegación adicional en el header
❌ No incluir menús o enlaces externos
❌ No modificar la funcionalidad del wizard
❌ No cambiar la paleta de colores existente

## Decisiones Técnicas

### 1. Ubicación del Header

**Decisión**: Header estático en la parte superior, dentro del contenedor principal

**Alternativas consideradas**:
- **Header fixed**: Rechazado porque reduciría espacio útil y podría causar problemas con modales
- **Header fuera del contenedor**: Rechazado por complejidad de layout
- **Header dentro, arriba del wizard**: ✅ Seleccionado por simplicidad

**Justificación**:
- Mantiene estructura de documento simple
- No interfiere con el layout flex existente
- Fácil de mantener y modificar

### 2. Ruta del Logo

**Decisión**: Ruta relativa desde dashboard: `../main/img/Logo_Claro_Trans.png`

**Alternativas consideradas**:
- **Copiar logo a dashboard**: Rechazado por duplicación innecesaria
- **Ruta absoluta desde root**: Rechazado por acoplamiento
- **Ruta relativa**: ✅ Seleccionado por flexibilidad

**Estructura de rutas**:
```
/var/www/cecapta.callblasterai.com/
├── main/
│   └── img/
│       └── Logo_Claro_Trans.png  ← Logo original
└── dashboard/
    └── index.php  ← Referencia relativa: ../main/img/Logo_Claro_Trans.png
```

### 3. Tamaño del Logo

**Decisión**: Responsive con Tailwind classes

- **Móvil** (< 768px): `h-10 w-auto` (40px altura)
- **Desktop** (≥ 768px): `h-12 w-auto` (48px altura)

**Justificación**:
- Mantiene proporción del logo (w-auto)
- Tamaño adecuado para legibilidad
- No domina visualmente el espacio
- Suficiente para reconocimiento de marca

### 4. Tipografía del Título

**Decisión**: Inter Bold, escalado responsive

```html
<h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-100">
  Requerimientos
</h1>
```

**Justificación**:
- Consistente con el resto del wizard (Inter)
- Bold para jerarquía visual
- Escalado responsive para legibilidad
- Color claro sobre fondo oscuro (accesibilidad)

### 5. Layout del Header

**Decisión**: Flexbox horizontal con gap

```html
<header class="bg-gray-800 border-b border-gray-700 py-4 px-6">
  <div class="flex items-center gap-4">
    <img src="..." class="h-10 md:h-12 w-auto" alt="Call Blaster Logo">
    <h1 class="...">Requerimientos</h1>
  </div>
</header>
```

**Propiedades clave**:
- `flex items-center`: Alineación vertical centrada
- `gap-4`: Espacio uniforme entre logo y título (1rem)
- `py-4 px-6`: Padding consistente con el wizard
- `border-b`: Separación visual sutil

## Estructura HTML Propuesta

```html
<body class="bg-gray-900 text-gray-100 h-screen flex flex-col">
    
    <!-- NUEVO: Header con Logo y Título -->
    <header class="bg-gray-800 border-b border-gray-700 py-4 px-6">
        <div class="max-w-7xl mx-auto flex items-center gap-4">
            <img 
                src="../main/img/Logo_Claro_Trans.png" 
                alt="Call Blaster Logo"
                class="h-10 md:h-12 w-auto"
                loading="eager"
            >
            <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-100">
                Requerimientos
            </h1>
        </div>
    </header>
    
    <!-- Contenedor Principal (EXISTENTE, ajustado) -->
    <div class="flex-1 flex items-center justify-center p-4 overflow-hidden">
        <div class="w-full h-full max-w-7xl flex flex-col lg:flex-row gap-6">
            <!-- Sidebar y wizard existente -->
            ...
        </div>
    </div>
    
</body>
```

**Cambios clave**:
1. `body` ahora es `flex flex-col` para header + contenido
2. Header con estructura semántica `<header>`
3. Contenedor principal ajustado con `flex-1` para ocupar espacio restante
4. `overflow-hidden` en contenedor para prevenir scroll

## Ajustes de Layout

### Antes (sin header)
```
body (h-screen flex items-center justify-center)
  └── contenedor wizard (max-w-7xl)
      ├── sidebar
      └── main
```

### Después (con header)
```
body (h-screen flex flex-col)
  ├── header (altura fija ~64px)
  └── contenedor wizard (flex-1)
      ├── sidebar
      └── main
```

## Consideraciones de Responsive

### Móvil (< 768px)

```
┌──────────────────────────┐
│ [Logo 40px] Requerimientos│ ← Header compacto
├──────────────────────────┤
│ Paso 1 de 7     [███░] 14%│
│                          │
│    ¿Pregunta?            │
│    [Input]               │
│                          │
│ [Ant] [Sig]              │
└──────────────────────────┘
```

### Desktop (≥ 1024px)

```
┌─────────────────────────────────────────┐
│ [Logo 48px] Requerimientos              │ ← Header normal
├─────┬───────────────────────────────────┤
│ 1.✓ │ Paso 1 de 7     [████████░] 14%  │
│ 2.▶ │                                   │
│ 3.  │      ¿Pregunta?                   │
│ ... │      [Input]                      │
│     │                                   │
│     │ [Anterior] [Siguiente]            │
└─────┴───────────────────────────────────┘
```

## Performance

### Optimizaciones

1. **Loading Strategy**:
   - `loading="eager"` en el logo (above the fold)
   - No lazy load para evitar flash of unstyled content

2. **Cache**:
   - El logo ya está en el servidor (no requiere fetch externo)
   - Navegador cacheará automáticamente

3. **Tamaño**:
   - Logo actual: 13 KB (aceptable)
   - PNG con transparencia (necesaria para tema oscuro)
   - No requiere optimización adicional

### Impacto Esperado
- **Tiempo de carga**: +10-20ms (insignificante)
- **Tamaño página**: +13 KB (mínimo)
- **Renders**: Sin cambio (imagen carga rápido)

## Accesibilidad

### WCAG 2.1 Compliance

1. **Alt Text**: "Call Blaster Logo" (descriptivo)
2. **Contraste**: Título texto claro sobre fondo oscuro (ratio > 7:1)
3. **Keyboard**: Logo no es interactivo (no necesita tab index)
4. **Screen Readers**: Estructura semántica con `<header>` y `<h1>`

### Testing
- [ ] Probar con NVDA/JAWS
- [ ] Verificar orden de lectura
- [ ] Confirmar que no interfiere con navegación del wizard

## Riesgos y Mitigaciones

### Riesgo 1: Scroll vertical inesperado
**Probabilidad**: Baja | **Impacto**: Medio

**Mitigación**:
- Usar `flex-col` en body para layout controlado
- `flex-1` en contenedor para ocupar espacio restante
- Probar en múltiples resoluciones

### Riesgo 2: Logo no se ve en tema oscuro
**Probabilidad**: Muy Baja | **Impacto**: Alto

**Mitigación**:
- El PNG tiene transparencia (visible en oscuro)
- Verificar visualmente en el dashboard
- Logo es "Claro" según nombre del archivo

### Riesgo 3: Rompe layout mobile
**Probabilidad**: Baja | **Impacto**: Medio

**Mitigación**:
- Tamaño reducido en móvil (40px)
- Padding ajustado (px-4 en móvil)
- Testing exhaustivo en resoluciones pequeñas

## Testing Plan

### Checklist Visual

- [ ] Logo visible y nítido en todas las resoluciones
- [ ] Título legible con contraste adecuado
- [ ] Alineación vertical correcta (logo + título)
- [ ] Espaciado consistente (gap entre elementos)
- [ ] Borde inferior sutil pero visible
- [ ] Sin scroll vertical/horizontal

### Checklist Funcional

- [ ] Wizard funciona igual que antes
- [ ] Navegación entre pasos sin problemas
- [ ] Modales aparecen correctamente
- [ ] Guardado funciona normal
- [ ] Responsive transitions suaves

### Navegadores

- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile Safari (iOS)
- [ ] Chrome Mobile (Android)

## Rollback Plan

Si el header causa problemas:

1. Comentar sección `<header>` en index.php
2. Revertir cambios de `body` class
3. Restaurar contenedor principal original
4. Recargar página en navegador

El cambio es aislado y fácil de revertir sin afectar funcionalidad.

## Referencias

- Logo actual: `/main/img/Logo_Claro_Trans.png` (13 KB)
- Tailwind CSS: https://tailwindcss.com/docs
- WCAG 2.1: https://www.w3.org/WAI/WCAG21/quickref/
