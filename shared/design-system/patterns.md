# Patrones de UI Comunes

Patrones de diseño reutilizables para el sistema CECAPTA CallBlaster AI.

## Layouts

### Layout Sin Scroll (Wizard Style)
```html
<body class="bg-gray-900 text-gray-100 h-screen flex flex-col overflow-hidden">
  <!-- Header -->
  <header class="bg-gray-800 border-b border-gray-700 py-1 px-6">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-2xl font-bold">Título de la Aplicación</h1>
    </div>
  </header>
  
  <!-- Contenedor Principal -->
  <div class="flex-1 flex items-center justify-center p-4 overflow-hidden">
    <div class="w-full h-full max-w-7xl">
      <!-- Contenido aquí -->
    </div>
  </div>
</body>
```

### Layout con Sidebar
```html
<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-gray-800 overflow-y-auto">
    <div class="p-6">
      <!-- Contenido del sidebar -->
    </div>
  </aside>
  
  <!-- Contenido Principal -->
  <main class="flex-1 overflow-y-auto bg-gray-900">
    <div class="p-6">
      <!-- Contenido principal -->
    </div>
  </main>
</div>
```

### Layout Centrado
```html
<div class="min-h-screen flex items-center justify-center bg-gray-900 p-4">
  <div class="w-full max-w-md">
    <!-- Contenido centrado (ej: login form) -->
  </div>
</div>
```

## Animaciones

### Fade Enter
```css
.fade-enter {
  animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
```

**Uso:**
```html
<div class="fade-enter">
  Contenido con animación de entrada
</div>
```

### Float Animation
```css
.float-animation {
  animation: float 6s ease-in-out infinite;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-20px);
  }
}
```

**Uso:**
```html
<div class="float-animation">
  Elemento flotante decorativo
</div>
```

### Pulse Animation
```css
.pulse-slow {
  animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 1;
    transform: scale(1);
  }
  50% {
    opacity: 0.8;
    transform: scale(1.05);
  }
}
```

## Wizard/Stepper Pattern

### Barra de Progreso con Pasos
```html
<div class="mb-6">
  <!-- Texto de progreso -->
  <div class="flex justify-between items-center mb-2">
    <span class="text-sm font-medium text-gray-400">Paso 1 de 7</span>
    <span class="text-sm font-medium text-orange-500">14%</span>
  </div>
  
  <!-- Progress bar -->
  <progress class="progress progress-custom w-full" value="14" max="100"></progress>
</div>

<style>
.progress-custom {
  background-color: #374151;
}
.progress-custom::-webkit-progress-value {
  background-color: var(--naranja-primario);
}
.progress-custom::-moz-progress-bar {
  background-color: var(--naranja-primario);
}
</style>
```

### Sidebar de Pasos
```html
<aside class="w-1/3 bg-gray-800 rounded-lg p-6">
  <h2 class="text-xl font-bold mb-6 text-orange-500">Pasos</h2>
  <ul class="space-y-4">
    <!-- Paso completado -->
    <li class="flex items-center gap-3 text-green-500">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
      </svg>
      <span class="text-sm">1. Información Básica</span>
    </li>
    
    <!-- Paso activo -->
    <li class="flex items-center gap-3 text-orange-500 font-semibold">
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/>
      </svg>
      <span class="text-sm">2. Configuración</span>
    </li>
    
    <!-- Paso pendiente -->
    <li class="flex items-center gap-3 text-gray-400">
      <span class="w-5 h-5 flex items-center justify-center text-sm">3</span>
      <span class="text-sm">3. Finalizar</span>
    </li>
  </ul>
</aside>
```

### Botones de Navegación
```html
<div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-700">
  <!-- Botón Anterior -->
  <button class="btn btn-outline" id="btnAnterior">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
    </svg>
    Anterior
  </button>
  
  <!-- Botón Siguiente -->
  <button class="btn btn-primary-custom" id="btnSiguiente">
    Siguiente
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
  </button>
</div>
```

## Login/Auth Patterns

### Login Card
```html
<div class="min-h-screen flex items-center justify-center bg-gray-900 p-4">
  <div class="bg-gray-800 p-8 rounded-lg shadow-lg max-w-md w-full">
    <h1 class="text-2xl font-bold text-gray-100 mb-6 text-center">
      🔒 Acceso Restringido
    </h1>
    
    <form class="space-y-4">
      <div class="form-control">
        <label class="label">
          <span class="label-text text-gray-200">Usuario</span>
        </label>
        <input 
          type="text" 
          class="input input-bordered bg-gray-700 text-white" 
          placeholder="Tu usuario"
        >
      </div>
      
      <div class="form-control">
        <label class="label">
          <span class="label-text text-gray-200">Contraseña</span>
        </label>
        <input 
          type="password" 
          class="input input-bordered bg-gray-700 text-white" 
          placeholder="Tu contraseña"
        >
      </div>
      
      <button type="submit" class="btn btn-primary-custom w-full">
        Iniciar Sesión
      </button>
    </form>
  </div>
</div>
```

## Hero Section Patterns

### Hero con Gradiente
```html
<section class="hero min-h-screen hero-gradient relative overflow-hidden">
  <!-- Elementos de fondo animados -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute top-20 left-10 w-72 h-72 bg-orange-500/20 rounded-full blur-xl opacity-40 float-animation"></div>
    <div class="absolute top-40 right-10 w-72 h-72 bg-white/10 rounded-full blur-xl opacity-30 float-animation" style="animation-delay: 1s;"></div>
  </div>
  
  <!-- Contenido -->
  <div class="hero-content text-center relative z-10">
    <div class="max-w-4xl">
      <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 fade-enter">
        Título Principal
      </h1>
      <p class="text-xl md:text-2xl text-white/90 mb-8 fade-enter">
        Descripción del servicio o producto
      </p>
      <button class="btn btn-primary-custom btn-lg fade-enter">
        Call to Action
      </button>
    </div>
  </div>
</section>

<style>
.hero-gradient {
  background: linear-gradient(135deg, #1F2937 0%, #111827 50%, #0F172A 100%);
}
</style>
```

## Card Patterns

### Card de Información con Icono
```html
<div class="card bg-gray-800 shadow-xl hover:shadow-2xl transition-shadow">
  <div class="card-body">
    <!-- Icono -->
    <div class="w-12 h-12 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4">
      <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
      </svg>
    </div>
    
    <!-- Contenido -->
    <h2 class="card-title text-orange-500">Título del Servicio</h2>
    <p class="text-gray-300">
      Descripción breve del servicio o característica.
    </p>
  </div>
</div>
```

### Card de Estado
```html
<div class="card bg-gray-800 shadow-xl">
  <div class="card-body">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="card-title text-gray-100">Prueba API</h2>
        <p class="text-sm text-gray-400">GET /api/endpoint</p>
      </div>
      <div>
        <!-- Badge de estado -->
        <span class="badge bg-green-500 text-white">Éxito</span>
      </div>
    </div>
    
    <!-- Detalles -->
    <div class="mt-4 text-sm text-gray-300">
      <p>Tiempo: 250ms</p>
      <p>Status: 200 OK</p>
    </div>
  </div>
</div>
```

## Table Patterns

### Tabla Responsive
```html
<div class="overflow-x-auto">
  <table class="table w-full">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>Email</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Juan Pérez</td>
        <td>juan@example.com</td>
        <td><span class="badge bg-green-500 text-white">Activo</span></td>
        <td>
          <button class="btn btn-sm btn-primary-custom">Editar</button>
        </td>
      </tr>
    </tbody>
  </table>
</div>
```

## Loading States

### Skeleton Loading
```html
<div class="card bg-gray-800 animate-pulse">
  <div class="card-body">
    <div class="h-6 bg-gray-700 rounded w-3/4 mb-4"></div>
    <div class="h-4 bg-gray-700 rounded w-full mb-2"></div>
    <div class="h-4 bg-gray-700 rounded w-5/6"></div>
  </div>
</div>
```

### Loading Overlay
```html
<div class="relative">
  <!-- Contenido -->
  <div class="card bg-gray-800">
    <div class="card-body">
      Contenido aquí
    </div>
  </div>
  
  <!-- Overlay de carga -->
  <div class="absolute inset-0 bg-gray-900/75 flex items-center justify-center rounded-lg" id="loadingOverlay">
    <div class="text-center">
      <span class="loading loading-spinner loading-lg text-orange-500"></span>
      <p class="text-white mt-2">Cargando...</p>
    </div>
  </div>
</div>
```

## Empty States

### Sin Resultados
```html
<div class="text-center py-12">
  <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
  </svg>
  <h3 class="text-xl font-semibold text-gray-300 mb-2">
    No hay resultados
  </h3>
  <p class="text-gray-400 mb-4">
    No se encontraron elementos para mostrar.
  </p>
  <button class="btn btn-primary-custom">
    Crear Nuevo
  </button>
</div>
```

## Focus States

Todos los elementos interactivos deben tener estado de foco visible:

```css
*:focus-visible {
  outline: 2px solid var(--naranja-primario);
  outline-offset: 2px;
}
```

## Responsive Patterns

### Stack en Mobile
```html
<div class="flex flex-col lg:flex-row gap-6">
  <div class="flex-1">Columna 1</div>
  <div class="flex-1">Columna 2</div>
  <div class="flex-1">Columna 3</div>
</div>
```

### Grid Responsive
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <div>Item 1</div>
  <div>Item 2</div>
  <div>Item 3</div>
</div>
```

## Uso de Patrones

Todos estos patrones deben combinarse con:
- Colores corporativos de `colors.md`
- Componentes de `components.md`
- Tipografía de `typography.md`
- Variables CSS definidas en `theme-config.css`
