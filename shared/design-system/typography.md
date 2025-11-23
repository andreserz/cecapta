# Guía de Tipografía - Inter Font Family

## Familia de Fuente

**Inter** es la fuente corporativa oficial para todo el proyecto CECAPTA CallBlaster AI.

### Características
- Diseñada para pantallas digitales
- Excelente legibilidad en todos los tamaños
- Optimizada para interfaces de usuario
- Soporte completo para caracteres en español
- Carga local (sin dependencias externas)

## Ubicación

Las fuentes se encuentran en: `/shared/fonts/inter/`

### Archivos Disponibles
- `inter-400.ttf` - Regular (400)
- `inter-500.ttf` - Medium (500)
- `inter-600.ttf` - SemiBold (600)
- `inter-700.ttf` - Bold (700)
- `inter-local.css` - Archivo de configuración @font-face

## Implementación

### 1. Incluir en HTML

```html
<head>
  <link href="/shared/fonts/inter/inter-local.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
```

### 2. Configuración CSS

El archivo `inter-local.css` contiene:

```css
@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url('inter-400.ttf') format('truetype');
}

@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url('inter-500.ttf') format('truetype');
}

@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url('inter-600.ttf') format('truetype');
}

@font-face {
  font-family: 'Inter';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url('inter-700.ttf') format('truetype');
}
```

## Pesos de Fuente

### Regular (400)
**Uso:** Texto de párrafos, contenido general

```html
<p class="font-normal">
  Este es texto en peso regular (400)
</p>
```

```css
.texto-normal {
  font-weight: 400;
}
```

### Medium (500)
**Uso:** Subtítulos, texto destacado

```html
<p class="font-medium">
  Este es texto en peso medium (500)
</p>
```

```css
.texto-medium {
  font-weight: 500;
}
```

### SemiBold (600)
**Uso:** Títulos de sección, navegación

```html
<h3 class="font-semibold">
  Este es texto en peso semibold (600)
</h3>
```

```css
.texto-semibold {
  font-weight: 600;
}
```

### Bold (700)
**Uso:** Títulos principales, énfasis fuerte

```html
<h1 class="font-bold">
  Este es texto en peso bold (700)
</h1>
```

```css
.texto-bold {
  font-weight: 700;
}
```

## Jerarquía Tipográfica

### Títulos (Headings)

```html
<!-- H1 - Título Principal -->
<h1 class="text-4xl font-bold">
  Título Principal
</h1>

<!-- H2 - Título de Sección -->
<h2 class="text-3xl font-bold">
  Título de Sección
</h2>

<!-- H3 - Subtítulo -->
<h3 class="text-2xl font-semibold">
  Subtítulo
</h3>

<!-- H4 - Título Menor -->
<h4 class="text-xl font-semibold">
  Título Menor
</h4>

<!-- H5 - Título Pequeño -->
<h5 class="text-lg font-medium">
  Título Pequeño
</h5>
```

### Tamaños Recomendados

| Elemento | Tamaño | Peso | Clase Tailwind |
|----------|--------|------|----------------|
| H1 Hero  | 48px   | 700  | `text-5xl font-bold` |
| H1       | 36px   | 700  | `text-4xl font-bold` |
| H2       | 30px   | 700  | `text-3xl font-bold` |
| H3       | 24px   | 600  | `text-2xl font-semibold` |
| H4       | 20px   | 600  | `text-xl font-semibold` |
| H5       | 18px   | 500  | `text-lg font-medium` |
| Body     | 16px   | 400  | `text-base font-normal` |
| Small    | 14px   | 400  | `text-sm font-normal` |
| Tiny     | 12px   | 400  | `text-xs font-normal` |

## Texto de Párrafo

### Tamaño Normal
```html
<p class="text-base font-normal leading-relaxed">
  Este es un párrafo con tamaño base (16px) y peso normal.
  El interlineado relaxed mejora la legibilidad.
</p>
```

### Tamaño Grande
```html
<p class="text-lg font-normal leading-relaxed">
  Este es un párrafo con tamaño grande (18px).
  Útil para texto introductorio o destacado.
</p>
```

### Tamaño Pequeño
```html
<p class="text-sm font-normal leading-relaxed">
  Este es un párrafo con tamaño pequeño (14px).
  Útil para notas al pie o texto secundario.
</p>
```

## Interlineado (Line Height)

```html
<!-- Compacto -->
<p class="leading-tight">Interlineado compacto</p>

<!-- Normal -->
<p class="leading-normal">Interlineado normal</p>

<!-- Relajado (recomendado para lectura) -->
<p class="leading-relaxed">Interlineado relajado</p>

<!-- Espacioso -->
<p class="leading-loose">Interlineado espacioso</p>
```

## Ejemplos de Uso

### Card con Jerarquía Tipográfica
```html
<div class="card bg-gray-800 text-gray-100">
  <div class="card-body">
    <h2 class="card-title text-2xl font-bold text-orange-600">
      Título del Card
    </h2>
    <h3 class="text-lg font-semibold text-gray-200 mt-2">
      Subtítulo del Card
    </h3>
    <p class="text-base font-normal text-gray-300 mt-4 leading-relaxed">
      Este es el contenido principal del card. Utiliza el peso regular
      y tamaño base para óptima legibilidad.
    </p>
    <span class="text-sm font-medium text-gray-400 mt-2">
      Texto adicional o metadatos
    </span>
  </div>
</div>
```

### Formulario con Labels
```html
<div class="form-control">
  <label class="label">
    <span class="label-text text-base font-medium">
      Nombre Completo
    </span>
  </label>
  <input 
    type="text" 
    class="input input-bordered text-base font-normal"
    placeholder="Ingresa tu nombre"
  >
  <label class="label">
    <span class="label-text-alt text-sm font-normal text-gray-400">
      Este campo es requerido
    </span>
  </label>
</div>
```

### Hero Section
```html
<section class="hero min-h-screen">
  <div class="hero-content text-center">
    <div class="max-w-4xl">
      <h1 class="text-5xl md:text-7xl font-bold mb-6">
        Call Blaster AI
      </h1>
      <p class="text-2xl md:text-3xl font-semibold mb-4">
        Atención instantánea, seguimiento impecable
      </p>
      <p class="text-xl md:text-2xl font-normal mb-8">
        La revolución en servicio al cliente para CECAPTA
      </p>
    </div>
  </div>
</section>
```

## Accesibilidad

### Tamaños Mínimos
- Texto de párrafo: mínimo 16px (text-base)
- Texto secundario: mínimo 14px (text-sm)
- Nunca usar menos de 12px excepto para casos especiales

### Contraste
- Peso 400 (Regular): Requiere mayor contraste
- Peso 600+ (SemiBold/Bold): Puede usar menor contraste
- Siempre validar con herramientas WCAG

### Responsive
```html
<!-- Título responsive -->
<h1 class="text-3xl md:text-4xl lg:text-5xl font-bold">
  Título Responsive
</h1>

<!-- Párrafo responsive -->
<p class="text-base md:text-lg lg:text-xl font-normal">
  Párrafo que se adapta al tamaño de pantalla
</p>
```

## Clases de Utilidad Personalizadas

```css
/* Texto destacado con color corporativo */
.text-highlight {
  color: var(--naranja-primario);
  font-weight: 600;
}

/* Texto de título grande */
.text-title-hero {
  font-size: 3rem;
  font-weight: 700;
  line-height: 1.2;
}

/* Texto de párrafo optimizado */
.text-body-optimized {
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.75;
  color: #E5E7EB;
}
```

## Checklist de Implementación

- [ ] Incluir `inter-local.css` en todas las páginas
- [ ] Establecer `font-family: 'Inter'` en body
- [ ] Usar pesos apropiados según jerarquía
- [ ] Validar legibilidad en diferentes tamaños
- [ ] Verificar carga correcta de fuentes
- [ ] Probar en diferentes navegadores
- [ ] Validar accesibilidad y contraste

## Performance

### Font-Display: Swap
Todas las fuentes usan `font-display: swap` para:
- Mostrar texto inmediatamente con fuente fallback
- Cambiar a Inter cuando esté disponible
- Evitar FOIT (Flash of Invisible Text)

### Fuentes Locales vs. CDN
**Ventajas de carga local:**
- ✅ Sin dependencia de Google Fonts
- ✅ Mayor privacidad (GDPR compliant)
- ✅ Menor latencia
- ✅ Control total de versiones
- ✅ Funciona offline

## Fallbacks

```css
body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 
               'Helvetica Neue', Arial, sans-serif;
}
```

Si Inter no carga, el navegador usará:
1. Sistema de fuentes de Apple (-apple-system)
2. Sistema de fuentes de Chrome (BlinkMacSystemFont)
3. Segoe UI (Windows)
4. Helvetica Neue (macOS)
5. Arial (universal)
6. Fuente sans-serif por defecto
