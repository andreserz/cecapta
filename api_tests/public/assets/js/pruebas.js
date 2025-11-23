/**
 * JavaScript para Interfaz de Pruebas de Endpoints
 * Validación de servicios para Call Blaster AI
 * Actualizado con diseño corporativo CECAPTA
 */

// Renderizar acordeones de pruebas
function renderTests() {
    const container = document.getElementById('testsContainer');
    container.innerHTML = '';
    
    tests.forEach((test, index) => {
        const accordionHTML = `
            <div id="test-${test.id}" class="card bg-gray-800 shadow-xl border border-gray-700 fade-enter" style="animation-delay: ${0.2 + (index * 0.05)}s;">
                <!-- Accordion Header -->
                <div class="accordion-header flex items-center justify-between p-4 cursor-pointer hover:bg-gray-700 transition-colors rounded-t-lg"
                     onclick="toggleAccordion('${test.id}')">
                    <div class="flex items-center gap-3 flex-1">
                        <span id="icon-${test.id}" class="text-xl text-orange-500">▶</span>
                        <h3 class="font-semibold text-gray-100">${test.name}</h3>
                    </div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <span id="status-${test.id}" class="badge badge-lg bg-gray-700 text-gray-300 border-gray-600">
                            ⚪ Pendiente
                        </span>
                        <button 
                            id="btn-${test.id}"
                            onclick="event.stopPropagation(); runTest('${test.id}')"
                            class="btn btn-primary-custom btn-sm"
                        >
                            ▶ Ejecutar
                        </button>
                    </div>
                </div>
                
                <!-- Accordion Content -->
                <div id="content-${test.id}" class="accordion-content">
                    <div class="p-6 border-t border-gray-700 bg-gray-900">
                        <div id="result-${test.id}" class="text-gray-400">
                            <p class="text-sm">Haz clic en "Ejecutar" para realizar la prueba</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += accordionHTML;
    });
}

// Toggle accordion
function toggleAccordion(testId) {
    const content = document.getElementById(`content-${testId}`);
    const icon = document.getElementById(`icon-${testId}`);
    
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        icon.textContent = '▶';
    } else {
        content.classList.add('active');
        icon.textContent = '▼';
    }
}

// Ejecutar prueba individual
async function runTest(testId) {
    const test = tests.find(t => t.id === testId);
    if (!test) return;
    
    // Verificar dependencias
    if (test.requires && !testResults[test.requires]?.success) {
        showModal('error', 'Dependencia Requerida', `Esta prueba requiere que "${tests.find(t => t.id === test.requires).name}" se ejecute primero y sea exitosa.`);
        return;
    }
    
    // Actualizar UI - Estado ejecutando
    updateTestState(testId, 'running');
    
    // Expandir acordeón si está cerrado
    const content = document.getElementById(`content-${testId}`);
    if (!content.classList.contains('active')) {
        toggleAccordion(testId);
    }
    
    try {
        const response = await fetch('api/ejecutar-prueba.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                endpoint: test.endpoint,
                dependencies: test.requires ? {
                    [test.requires]: testResults[test.requires]?.data
                } : {}
            })
        });
        
        const result = await response.json();
        
        // Guardar resultado
        testResults[testId] = result;
        
        // Actualizar UI
        if (result.success) {
            updateTestState(testId, 'success', result);
        } else {
            updateTestState(testId, 'error', result);
        }
        
    } catch (error) {
        console.error('Error en prueba:', error);
        testResults[testId] = {
            success: false,
            error: error.message
        };
        updateTestState(testId, 'error', {
            success: false,
            error: `Error de conexión: ${error.message}`
        });
    }
}

// Actualizar estado visual de la prueba
function updateTestState(testId, state, result = null) {
    const statusEl = document.getElementById(`status-${testId}`);
    const btnEl = document.getElementById(`btn-${testId}`);
    const resultEl = document.getElementById(`result-${testId}`);
    
    switch (state) {
        case 'running':
            statusEl.className = 'badge badge-lg bg-blue-500 text-white border-blue-400';
            statusEl.innerHTML = '<span class="loading loading-spinner loading-xs mr-1"></span> Ejecutando...';
            btnEl.disabled = true;
            btnEl.classList.add('btn-disabled');
            resultEl.innerHTML = `
                <div class="flex items-center gap-2 text-blue-400">
                    <span class="loading loading-spinner loading-sm"></span>
                    <span>Ejecutando prueba...</span>
                </div>
            `;
            break;
            
        case 'success':
            statusEl.className = 'badge badge-lg badge-success';
            statusEl.textContent = '✓ Éxito';
            btnEl.disabled = false;
            btnEl.classList.remove('btn-disabled');
            btnEl.textContent = '↻ Repetir';
            resultEl.innerHTML = renderResult(result);
            break;
            
        case 'error':
            statusEl.className = 'badge badge-lg badge-error';
            statusEl.textContent = '✗ Error';
            btnEl.disabled = false;
            btnEl.classList.remove('btn-disabled');
            btnEl.textContent = '↻ Reintentar';
            resultEl.innerHTML = renderResult(result);
            break;
    }
}

// Renderizar resultado de prueba
function renderResult(result) {
    if (!result) return '';
    
    let html = '';
    
    // Información básica
    html += '<div class="space-y-4">';
    
    // Status y tiempo
    html += '<div class="flex items-center justify-between flex-wrap gap-2">';
    html += `<span class="text-sm ${result.success ? 'text-green-400' : 'text-red-400'} font-medium">`;
    html += result.success ? '✓ Prueba exitosa' : '✗ Prueba fallida';
    html += '</span>';
    if (result.duration) {
        html += `<span class="text-xs text-gray-400">Tiempo: ${result.duration}ms</span>`;
    }
    html += '</div>';
    
    // Mensaje de error si existe
    if (result.error) {
        html += `<div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm">${escapeHtml(result.error)}</span>
        </div>`;
    }
    
    // Datos de respuesta
    if (result.data) {
        html += '<div>';
        html += '<h4 class="text-sm font-semibold text-gray-300 mb-2">Datos de Respuesta:</h4>';
        html += '<div class="json-viewer text-xs">';
        html += '<pre>' + JSON.stringify(result.data, null, 2) + '</pre>';
        html += '</div>';
        html += '</div>';
    }
    
    // Detalles de request si existen
    if (result.request) {
        html += '<details class="collapse collapse-arrow bg-gray-800 border border-gray-700">';
        html += '<summary class="collapse-title text-sm font-medium text-gray-300">Detalles de Request</summary>';
        html += '<div class="collapse-content text-xs text-gray-400">';
        html += '<pre>' + JSON.stringify(result.request, null, 2) + '</pre>';
        html += '</div>';
        html += '</details>';
    }
    
    html += '</div>';
    
    return html;
}

// Ejecutar todas las pruebas
async function runAllTests() {
    if (isRunningAll) return;
    
    isRunningAll = true;
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const btnRunAll = document.getElementById('btnRunAll');
    
    // Mostrar barra de progreso
    progressContainer.classList.remove('hidden');
    btnRunAll.disabled = true;
    btnRunAll.classList.add('btn-disabled');
    btnRunAll.innerHTML = '<span class="loading loading-spinner"></span><span>Ejecutando...</span>';
    
    let completed = 0;
    const total = tests.length;
    
    for (const test of tests) {
        await runTest(test.id);
        completed++;
        
        // Actualizar progreso
        const percent = Math.round((completed / total) * 100);
        progressBar.value = percent;
        progressText.textContent = `${completed} / ${total}`;
        
        // Pequeña pausa entre pruebas
        await new Promise(resolve => setTimeout(resolve, 500));
    }
    
    // Ocultar barra de progreso
    setTimeout(() => {
        progressContainer.classList.add('hidden');
        progressBar.value = 0;
        isRunningAll = false;
        btnRunAll.disabled = false;
        btnRunAll.classList.remove('btn-disabled');
        btnRunAll.innerHTML = '<span>🚀</span><span>Ejecutar Todas las Pruebas</span>';
        
        // Mostrar resumen
        showSummary();
    }, 1000);
}

// Mostrar resumen de pruebas
function showSummary() {
    const total = tests.length;
    const executed = Object.keys(testResults).length;
    const successful = Object.values(testResults).filter(r => r.success).length;
    const failed = executed - successful;
    
    let message = `
        <div class="space-y-2">
            <p class="text-lg font-semibold">Resumen de Pruebas</p>
            <div class="stats stats-vertical lg:stats-horizontal shadow bg-gray-800">
                <div class="stat">
                    <div class="stat-title text-gray-400">Total</div>
                    <div class="stat-value text-gray-100">${total}</div>
                </div>
                <div class="stat">
                    <div class="stat-title text-green-400">Exitosas</div>
                    <div class="stat-value text-green-500">${successful}</div>
                </div>
                <div class="stat">
                    <div class="stat-title text-red-400">Fallidas</div>
                    <div class="stat-value text-red-500">${failed}</div>
                </div>
            </div>
        </div>
    `;
    
    showModal('info', 'Pruebas Completadas', message);
}

// Limpiar todos los resultados
function clearAllResults() {
    testResults = {};
    renderTests();
    const progressContainer = document.getElementById('progressContainer');
    progressContainer.classList.add('hidden');
}

// Mostrar modal
function showModal(type, title, message) {
    const modalHTML = `
        <dialog id="dynamicModal" class="modal modal-open">
            <div class="modal-box bg-gray-800">
                <h3 class="font-bold text-lg mb-4 ${type === 'error' ? 'text-error' : type === 'success' ? 'text-success' : 'text-orange-500'}">
                    ${escapeHtml(title)}
                </h3>
                <div class="py-4 text-gray-300">
                    ${message}
                </div>
                <div class="modal-action">
                    <button class="btn btn-primary-custom" onclick="document.getElementById('dynamicModal').close(); document.getElementById('dynamicModal').remove();">
                        Cerrar
                    </button>
                </div>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button onclick="document.getElementById('dynamicModal').remove();">close</button>
            </form>
        </dialog>
    `;
    
    // Agregar modal al body
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = modalHTML;
    document.body.appendChild(tempDiv.firstElementChild);
}

// Escape HTML para prevenir XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
