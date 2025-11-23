# Catálogo de Componentes DaisyUI

Este documento lista todos los componentes DaisyUI utilizados en el sistema de diseño CECAPTA.

## Botones

### Botón Primario Corporativo
```html
<button class="btn btn-primary-custom">
  Acción Principal
</button>
```

**CSS Requerido:**
```css
.btn-primary-custom {
  background-color: var(--naranja-primario);
  border-color: var(--naranja-primario);
  color: white;
}
.btn-primary-custom:hover {
  background-color: var(--naranja-hover);
  border-color: var(--naranja-hover);
}
```

### Variantes de Botones
```html
<!-- Botón estándar -->
<button class="btn">Botón</button>

<!-- Botón con outline -->
<button class="btn btn-outline">Outline</button>

<!-- Botón grande -->
<button class="btn btn-lg">Grande</button>

<!-- Botón pequeño -->
<button class="btn btn-sm">Pequeño</button>

<!-- Botón deshabilitado -->
<button class="btn btn-disabled" disabled>Deshabilitado</button>

<!-- Botón con loading -->
<button class="btn">
  <span class="loading loading-spinner"></span>
  Cargando
</button>
```

## Cards

### Card Básico
```html
<div class="card bg-base-100 shadow-xl">
  <div class="card-body">
    <h2 class="card-title">Título del Card</h2>
    <p>Contenido del card</p>
    <div class="card-actions justify-end">
      <button class="btn btn-primary-custom">Acción</button>
    </div>
  </div>
</div>
```

### Card con Imagen
```html
<div class="card bg-base-100 shadow-xl">
  <figure>
    <img src="imagen.jpg" alt="Descripción">
  </figure>
  <div class="card-body">
    <h2 class="card-title">Título</h2>
    <p>Contenido</p>
  </div>
</div>
```

### Card en Tema Oscuro
```html
<div class="card bg-gray-800 text-gray-100 shadow-xl">
  <div class="card-body">
    <h2 class="card-title text-orange-600">Título</h2>
    <p class="text-gray-200">Contenido</p>
  </div>
</div>
```

## Modales

### Modal Básico
```html
<dialog id="miModal" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Título del Modal</h3>
    <p class="py-4">Contenido del modal</p>
    <div class="modal-action">
      <button class="btn" onclick="miModal.close()">Cerrar</button>
      <button class="btn btn-primary-custom">Aceptar</button>
    </div>
  </div>
</dialog>
```

**JavaScript para abrir:**
```javascript
document.getElementById('miModal').showModal();
```

### Modal de Éxito
```html
<dialog id="modalExito" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg text-success mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      ¡Éxito!
    </h3>
    <p class="py-4">La operación se completó correctamente.</p>
  </div>
</dialog>
```

### Modal de Error
```html
<dialog id="modalError" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg text-error mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      Error
    </h3>
    <p class="py-4">Ocurrió un error. Por favor intenta nuevamente.</p>
  </div>
</dialog>
```

## Formularios

### Input de Texto
```html
<input 
  type="text" 
  class="input input-bordered w-full" 
  placeholder="Ingresa texto"
>
```

### Input con Label
```html
<div class="form-control w-full">
  <label class="label">
    <span class="label-text">Nombre</span>
  </label>
  <input 
    type="text" 
    class="input input-bordered w-full" 
    placeholder="Tu nombre"
  >
</div>
```

### Textarea
```html
<textarea 
  class="textarea textarea-bordered w-full h-32" 
  placeholder="Escribe aquí"
></textarea>
```

### Select
```html
<select class="select select-bordered w-full">
  <option disabled selected>Selecciona una opción</option>
  <option>Opción 1</option>
  <option>Opción 2</option>
  <option>Opción 3</option>
</select>
```

### Checkbox
```html
<div class="form-control">
  <label class="label cursor-pointer">
    <span class="label-text">Acepto los términos</span>
    <input type="checkbox" class="checkbox" />
  </label>
</div>
```

## Progress Bar

### Barra de Progreso
```html
<progress class="progress progress-custom w-full" value="70" max="100"></progress>
```

**CSS Requerido:**
```css
.progress-custom {
  background-color: #374151;
}
.progress-custom::-webkit-progress-value {
  background-color: var(--naranja-primario);
}
.progress-custom::-moz-progress-bar {
  background-color: var(--naranja-primario);
}
```

### Progress con Texto
```html
<div class="mb-2 flex justify-between text-sm">
  <span>Progreso</span>
  <span>70%</span>
</div>
<progress class="progress progress-custom w-full" value="70" max="100"></progress>
```

## Loading Spinners

```html
<!-- Spinner pequeño -->
<span class="loading loading-spinner loading-sm"></span>

<!-- Spinner mediano -->
<span class="loading loading-spinner loading-md"></span>

<!-- Spinner grande -->
<span class="loading loading-spinner loading-lg"></span>

<!-- Spinner con color -->
<span class="loading loading-spinner text-orange-600"></span>
```

## Alerts

### Alert de Información
```html
<div class="alert alert-info">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span>Información importante</span>
</div>
```

### Alert de Éxito
```html
<div class="alert alert-success">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span>¡Operación exitosa!</span>
</div>
```

### Alert de Error
```html
<div class="alert alert-error">
  <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
  </svg>
  <span>Error al procesar</span>
</div>
```

## Badges

```html
<!-- Badge básico -->
<span class="badge">Badge</span>

<!-- Badge con color -->
<span class="badge badge-primary">Primario</span>
<span class="badge bg-orange-600 text-white">Naranja</span>
<span class="badge bg-green-500 text-white">Éxito</span>
<span class="badge bg-red-500 text-white">Error</span>

<!-- Badge outline -->
<span class="badge badge-outline">Outline</span>

<!-- Badge grande -->
<span class="badge badge-lg">Grande</span>

<!-- Badge pequeño -->
<span class="badge badge-sm">Pequeño</span>
```

## Navbar

```html
<nav class="navbar bg-gray-800 text-gray-100">
  <div class="navbar-start">
    <div class="dropdown">
      <label tabindex="0" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </label>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li><a>Inicio</a></li>
        <li><a>Servicios</a></li>
        <li><a>Contacto</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost normal-case text-xl">CECAPTA</a>
  </div>
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a>Inicio</a></li>
      <li><a>Servicios</a></li>
      <li><a>Contacto</a></li>
    </ul>
  </div>
  <div class="navbar-end">
    <a class="btn btn-primary-custom">Acción</a>
  </div>
</nav>
```

## Tabs

```html
<div class="tabs tabs-boxed">
  <a class="tab">Tab 1</a>
  <a class="tab tab-active">Tab 2</a>
  <a class="tab">Tab 3</a>
</div>
```

## Uso General

Todos estos componentes deben usarse con:
- DaisyUI 4.4.19
- Tailwind CSS
- Fuentes Inter
- Variables CSS corporativas
- Tema night o light según el módulo
