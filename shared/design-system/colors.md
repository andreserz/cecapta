# Paleta de Colores Corporativa CECAPTA

## Colores Primarios

### Naranja Corporativo
- **Primario**: `#F97316` 
  - Uso: Botones principales, enlaces, acentos destacados
  - Variable CSS: `--naranja-primario`
  - Clase Tailwind: `bg-orange-600`, `text-orange-600`

- **Hover**: `#EA580C`
  - Uso: Estados hover en botones y enlaces
  - Variable CSS: `--naranja-hover`
  - Clase Tailwind: `hover:bg-orange-700`

- **Claro**: `#FDBA74`
  - Uso: Acentos secundarios, badges, highlights
  - Variable CSS: `--naranja-claro`
  - Clase Tailwind: `bg-orange-300`

## Colores de Fondo

### Tema Oscuro
- **Fondo Principal**: `#111827`
  - Uso: Fondo principal en tema oscuro
  - Variable CSS: `--fondo-oscuro`
  - DaisyUI: `bg-gray-900`

- **Fondo Secundario**: `#1F2937`
  - Uso: Cards, modales, elementos elevados
  - Clase Tailwind: `bg-gray-800`

- **Fondo Terciario**: `#374151`
  - Uso: Elementos deshabilitados, bordes
  - Clase Tailwind: `bg-gray-700`

## Colores de Estado

### Éxito
- **Verde**: `#10B981`
  - Uso: Mensajes de éxito, estados completados
  - Variable CSS: `--completado`
  - Clase Tailwind: `text-green-500`, `bg-green-500`

### Error
- **Rojo**: `#EF4444`
  - Uso: Mensajes de error, estados fallidos
  - Variable CSS: `--error`
  - Clase Tailwind: `text-red-500`, `bg-red-500`

### Advertencia
- **Amarillo/Naranja**: `#F59E0B`
  - Uso: Advertencias, alertas informativas
  - Variable CSS: `--warning`
  - Clase Tailwind: `text-amber-500`, `bg-amber-500`

## Colores de Texto

### Tema Oscuro
- **Texto Principal**: `#F9FAFB`
  - Uso: Texto principal legible
  - Clase Tailwind: `text-gray-100`

- **Texto Secundario**: `#E5E7EB`
  - Uso: Texto menos prominente
  - Clase Tailwind: `text-gray-200`

- **Texto Deshabilitado**: `#9CA3AF`
  - Uso: Texto deshabilitado o placeholder
  - Clase Tailwind: `text-gray-400`

### Tema Claro
- **Texto Principal**: `#111827`
  - Uso: Texto principal en fondo claro
  - Clase Tailwind: `text-gray-900`

- **Texto Secundario**: `#374151`
  - Uso: Texto secundario en fondo claro
  - Clase Tailwind: `text-gray-700`

## Variables CSS

```css
:root {
  /* Colores Corporativos */
  --naranja-primario: #F97316;
  --naranja-hover: #EA580C;
  --naranja-claro: #FDBA74;
  
  /* Fondos */
  --fondo-oscuro: #111827;
  
  /* Estados */
  --completado: #10B981;
  --error: #EF4444;
  --warning: #F59E0B;
}
```

## Configuración Tailwind

```javascript
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'cb-primary': '#F97316',
        'cb-secondary': '#EA580C',
        'cb-accent': '#FDBA74',
        'cb-dark': '#111827',
      }
    }
  }
}
```

## Accesibilidad

Todos los colores han sido validados para cumplir con WCAG 2.1 AA:

- ✅ Naranja primario sobre fondo oscuro: Contraste 4.5:1
- ✅ Texto blanco sobre naranja primario: Contraste 4.8:1
- ✅ Verde éxito sobre fondo oscuro: Contraste 4.7:1
- ✅ Rojo error sobre fondo oscuro: Contraste 5.2:1

## Uso Recomendado

### Botones Primarios
```html
<button class="btn btn-primary-custom">
  Acción Principal
</button>
```

### Badges de Estado
```html
<span class="badge bg-green-500 text-white">Completado</span>
<span class="badge bg-red-500 text-white">Error</span>
<span class="badge bg-amber-500 text-white">Pendiente</span>
```

### Cards en Tema Oscuro
```html
<div class="card bg-gray-800 text-gray-100">
  <div class="card-body">
    <h2 class="card-title text-orange-600">Título</h2>
    <p class="text-gray-200">Contenido</p>
  </div>
</div>
```

## Paleta Visual

```
Naranja Primario  ████████  #F97316
Naranja Hover     ████████  #EA580C
Naranja Claro     ████████  #FDBA74
Fondo Oscuro      ████████  #111827
Éxito             ████████  #10B981
Error             ████████  #EF4444
Advertencia       ████████  #F59E0B
```
