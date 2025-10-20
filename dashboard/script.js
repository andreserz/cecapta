// Estado de la aplicación
const estado = {
    preguntaActual: 0,
    respuestas: [],
    preguntasCompletadas: new Set()
};

// Referencias a elementos del DOM
let questionTitle, inputContainer, btnAnterior, btnSiguiente;
let progressBar, progressText, progressPercent;
let errorMessage, errorText;
let stepsList;
let modalExito, modalError, mensajeExito, mensajeError;

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    // Obtener referencias a elementos del DOM
    questionTitle = document.getElementById('questionTitle');
    inputContainer = document.getElementById('inputContainer');
    btnAnterior = document.getElementById('btnAnterior');
    btnSiguiente = document.getElementById('btnSiguiente');
    progressBar = document.getElementById('progressBar');
    progressText = document.getElementById('progressText');
    progressPercent = document.getElementById('progressPercent');
    errorMessage = document.getElementById('errorMessage');
    errorText = document.getElementById('errorText');
    stepsList = document.getElementById('stepsList');
    modalExito = document.getElementById('modalExito');
    modalError = document.getElementById('modalError');
    mensajeExito = document.getElementById('mensajeExito');
    mensajeError = document.getElementById('mensajeError');
    
    // Inicializar respuestas vacías o con valores por defecto
    estado.respuestas = window.preguntasData.map(pregunta => pregunta.valor_defecto || '');
    
    // Renderizar sidebar de pasos
    renderizarSidebar();
    
    // Mostrar primera pregunta
    mostrarPregunta(0);
    
    // Event listeners para botones
    btnAnterior.addEventListener('click', navegarAnterior);
    btnSiguiente.addEventListener('click', navegarSiguiente);
    
    // Navegación con teclado
    document.addEventListener('keydown', manejarTeclado);
});

// Renderizar sidebar de pasos (desktop)
function renderizarSidebar() {
    if (!stepsList) return;
    
    stepsList.innerHTML = '';
    
    window.preguntasData.forEach((pregunta, index) => {
        const li = document.createElement('li');
        li.className = 'step-item flex items-center gap-3 p-2 rounded';
        
        const numero = index + 1;
        const titulo = pregunta.titulo.substring(0, 40) + (pregunta.titulo.length > 40 ? '...' : '');
        
        // Icono según estado
        let icono = '';
        if (estado.preguntasCompletadas.has(index)) {
            icono = '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>';
            li.classList.add('completed');
        } else if (index === estado.preguntaActual) {
            icono = '<svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd"/></svg>';
            li.classList.add('active');
        } else {
            icono = `<span class="w-5 h-5 flex items-center justify-center text-sm flex-shrink-0">${numero}</span>`;
            li.classList.add('pending');
        }
        
        li.innerHTML = `${icono}<span class="text-sm">${numero}. ${titulo}</span>`;
        stepsList.appendChild(li);
    });
}

// Mostrar pregunta específica
function mostrarPregunta(index) {
    const pregunta = window.preguntasData[index];
    
    // Actualizar título con animación
    questionTitle.classList.remove('fade-enter');
    void questionTitle.offsetWidth; // Trigger reflow
    questionTitle.classList.add('fade-enter');
    questionTitle.textContent = pregunta.titulo;
    
    // Crear campo de entrada según tipo
    inputContainer.classList.remove('fade-enter');
    void inputContainer.offsetWidth;
    inputContainer.classList.add('fade-enter');
    inputContainer.innerHTML = crearCampoInput(pregunta, estado.respuestas[index]);
    
    // Actualizar progreso
    actualizarProgreso();
    
    // Actualizar sidebar
    renderizarSidebar();
    
    // Actualizar botones
    actualizarBotones();
    
    // Ocultar error
    ocultarError();
    
    // Enfocar campo de entrada
    setTimeout(() => {
        const input = inputContainer.querySelector('input, textarea, select');
        if (input) input.focus();
    }, 100);
}

// Crear campo de entrada según tipo
function crearCampoInput(pregunta, valorActual) {
    // Usar valor actual, o valor por defecto si no hay valor actual y existe valor por defecto
    const valor = valorActual || pregunta.valor_defecto || '';
    
    switch (pregunta.tipo) {
        case 'text':
        case 'url':
            return `
                <input 
                    type="${pregunta.tipo}" 
                    id="campoRespuesta"
                    class="input input-bordered w-full input-lg bg-gray-700 text-white"
                    placeholder="${pregunta.placeholder}"
                    value="${valor}"
                    maxlength="${pregunta.maxlength}"
                    autocomplete="off"
                />
            `;
            
        case 'textarea':
            return `
                <textarea 
                    id="campoRespuesta"
                    class="textarea textarea-bordered w-full h-40 bg-gray-700 text-white text-base"
                    placeholder="${pregunta.placeholder}"
                    maxlength="${pregunta.maxlength}"
                >${valor}</textarea>
                <div class="text-right text-sm text-gray-400 mt-1">
                    <span id="charCount">${valor.length}</span> / ${pregunta.maxlength}
                </div>
            `;
            
        case 'select':
            const opciones = pregunta.opciones.map(opcion => 
                `<option value="${opcion}" ${valor === opcion ? 'selected' : ''}>${opcion}</option>`
            ).join('');
            
            return `
                <select 
                    id="campoRespuesta"
                    class="select select-bordered w-full select-lg bg-gray-700 text-white"
                >
                    <option value="" disabled ${!valor ? 'selected' : ''}>Selecciona una opción</option>
                    ${opciones}
                </select>
            `;
            
        default:
            return '';
    }
}

// Actualizar barra de progreso
function actualizarProgreso() {
    const total = window.preguntasData.length;
    const actual = estado.preguntaActual + 1;
    const porcentaje = Math.round((actual / total) * 100);
    
    progressBar.value = porcentaje;
    progressText.textContent = `Paso ${actual} de ${total}`;
    progressPercent.textContent = `${porcentaje}%`;
}

// Actualizar estado de botones
function actualizarBotones() {
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    const esPrimeraPregunta = estado.preguntaActual === 0;
    
    // Botón anterior
    if (esPrimeraPregunta) {
        btnAnterior.disabled = true;
        btnAnterior.classList.add('btn-disabled');
    } else {
        btnAnterior.disabled = false;
        btnAnterior.classList.remove('btn-disabled');
    }
    
    // Botón siguiente/finalizar
    if (esUltimaPregunta) {
        btnSiguiente.innerHTML = `
            Finalizar
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        `;
    } else {
        btnSiguiente.innerHTML = `
            Siguiente
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        `;
    }
}

// Validar respuesta actual
function validarRespuestaActual() {
    const input = document.getElementById('campoRespuesta');
    if (!input) return false;
    
    const valor = input.value.trim();
    const pregunta = window.preguntasData[estado.preguntaActual];
    
    // Validar campo vacío
    if (!valor) {
        mostrarError('Por favor completa este campo antes de continuar');
        input.focus();
        return false;
    }
    
    // Validar URL si es tipo URL
    if (pregunta.tipo === 'url') {
        try {
            new URL(valor);
        } catch (e) {
            mostrarError('Por favor ingresa una URL válida (ejemplo: https://ejemplo.com)');
            input.focus();
            return false;
        }
    }
    
    return true;
}

// Guardar respuesta actual
function guardarRespuestaActual() {
    const input = document.getElementById('campoRespuesta');
    if (!input) return;
    
    estado.respuestas[estado.preguntaActual] = input.value.trim();
    estado.preguntasCompletadas.add(estado.preguntaActual);
}

// Navegación anterior
function navegarAnterior() {
    if (estado.preguntaActual > 0) {
        guardarRespuestaActual();
        estado.preguntaActual--;
        mostrarPregunta(estado.preguntaActual);
    }
}

// Navegación siguiente o finalizar
function navegarSiguiente() {
    if (!validarRespuestaActual()) {
        return;
    }
    
    guardarRespuestaActual();
    
    const esUltimaPregunta = estado.preguntaActual === window.preguntasData.length - 1;
    
    if (esUltimaPregunta) {
        finalizarConfiguracion();
    } else {
        estado.preguntaActual++;
        mostrarPregunta(estado.preguntaActual);
    }
}

// Finalizar y guardar configuración
async function finalizarConfiguracion() {
    // Deshabilitar botón y mostrar loading
    btnSiguiente.disabled = true;
    btnSiguiente.innerHTML = `
        <span class="loading loading-spinner"></span>
        Guardando configuración...
    `;
    
    // Preparar datos
    const configuracion = {};
    window.preguntasData.forEach((pregunta, index) => {
        configuracion[pregunta.nombre] = estado.respuestas[index];
    });
    
    try {
        const response = await fetch('guardar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(configuracion)
        });
        
        const resultado = await response.json();
        
        if (response.ok && resultado.exito) {
            // Mostrar modal de éxito
            mensajeExito.textContent = `Tu configuración ha sido guardada exitosamente en el archivo: ${resultado.archivo}`;
            modalExito.showModal();
        } else {
            throw new Error(resultado.error || 'Error desconocido');
        }
        
    } catch (error) {
        console.error('Error al guardar:', error);
        mensajeError.textContent = `Error al guardar la configuración: ${error.message}. Por favor verifica tu conexión e intenta nuevamente.`;
        modalError.showModal();
        
        // Re-habilitar botón
        btnSiguiente.disabled = false;
        actualizarBotones();
    }
}

// Mostrar mensaje de error
function mostrarError(mensaje) {
    errorText.textContent = mensaje;
    errorMessage.classList.remove('hidden');
    
    // Ocultar después de 5 segundos
    setTimeout(() => {
        ocultarError();
    }, 5000);
}

// Ocultar mensaje de error
function ocultarError() {
    errorMessage.classList.add('hidden');
}

// Manejar navegación con teclado
function manejarTeclado(e) {
    const input = document.getElementById('campoRespuesta');
    
    // Enter en campos de texto (no textarea)
    if (e.key === 'Enter' && input && input.tagName !== 'TEXTAREA') {
        e.preventDefault();
        navegarSiguiente();
    }
    
    // Shift + Enter para retroceder
    if (e.key === 'Enter' && e.shiftKey && input) {
        e.preventDefault();
        navegarAnterior();
    }
}

// Contador de caracteres para textarea
document.addEventListener('input', (e) => {
    if (e.target.id === 'campoRespuesta' && e.target.tagName === 'TEXTAREA') {
        const charCount = document.getElementById('charCount');
        if (charCount) {
            charCount.textContent = e.target.value.length;
        }
    }
});
