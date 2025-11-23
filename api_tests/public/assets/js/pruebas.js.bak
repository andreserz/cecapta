/**
 * JavaScript para Interfaz de Pruebas de Endpoints
 * Validación de servicios para Call Blaster AI
 */

// Renderizar acordeones de pruebas
function renderTests() {
    const container = document.getElementById('testsContainer');
    container.innerHTML = '';
    
    tests.forEach(test => {
        const accordionHTML = `
            <div id="test-${test.id}" class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                <!-- Accordion Header -->
                <div class="accordion-header flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 transition-colors"
                     onclick="toggleAccordion('${test.id}')">
                    <div class="flex items-center gap-3 flex-1">
                        <span id="icon-${test.id}" class="text-xl">▶</span>
                        <h3 class="font-semibold text-gray-800">${test.name}</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="status-${test.id}" class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                            ⚪ Pendiente
                        </span>
                        <button 
                            id="btn-${test.id}"
                            onclick="event.stopPropagation(); runTest('${test.id}')"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm font-medium"
                        >
                            ▶ Ejecutar
                        </button>
                    </div>
                </div>
                
                <!-- Accordion Content -->
                <div id="content-${test.id}" class="accordion-content">
                    <div class="p-6 border-t border-gray-200 bg-gray-50">
                        <div id="result-${test.id}" class="text-gray-600">
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
        alert(`Esta prueba requiere que "${tests.find(t => t.id === test.requires).name}" se ejecute primero y sea exitosa.`);
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
        
        // Actualizar UI con resultado
        if (result.status === 'success') {
            updateTestState(testId, 'success', result);
        } else {
            updateTestState(testId, 'error', result);
        }
        
    } catch (error) {
        console.error('Error ejecutando prueba:', error);
        updateTestState(testId, 'error', {
            error: {
                message: 'Error de conexión: ' + error.message
            }
        });
    }
}

// Actualizar estado de prueba
function updateTestState(testId, state, data = null) {
    const statusEl = document.getElementById(`status-${testId}`);
    const resultEl = document.getElementById(`result-${testId}`);
    const btnEl = document.getElementById(`btn-${testId}`);
    
    // Actualizar badge de estado
    switch (state) {
        case 'running':
            statusEl.className = 'px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-700';
            statusEl.innerHTML = '⏳ Ejecutando';
            btnEl.disabled = true;
            btnEl.classList.add('opacity-50', 'cursor-not-allowed');
            
            resultEl.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="spinner"></div>
                    <span class="text-sm text-gray-600">Ejecutando prueba...</span>
                </div>
            `;
            break;
            
        case 'success':
            statusEl.className = 'px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700';
            statusEl.innerHTML = '✅ Exitoso';
            btnEl.disabled = false;
            btnEl.classList.remove('opacity-50', 'cursor-not-allowed');
            btnEl.innerHTML = '🔄 Re-ejecutar';
            
            resultEl.innerHTML = renderSuccessResult(data);
            break;
            
        case 'error':
            statusEl.className = 'px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700';
            statusEl.innerHTML = '❌ Error';
            btnEl.disabled = false;
            btnEl.classList.remove('opacity-50', 'cursor-not-allowed');
            btnEl.innerHTML = '🔄 Reintentar';
            
            resultEl.innerHTML = renderErrorResult(data);
            break;
    }
}

// Renderizar resultado exitoso
function renderSuccessResult(data) {
    const summary = data.summary || {};
    const responsePreview = data.response ? JSON.stringify(data.response, null, 2) : '';
    
    return `
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-green-600">
                <span class="text-2xl">✓</span>
                <span class="font-semibold">Prueba completada exitosamente</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-3 rounded border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">Tiempo de Respuesta</div>
                    <div class="text-lg font-semibold text-gray-800">${data.execution_time?.toFixed(3) || '0.000'}s</div>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">Código HTTP</div>
                    <div class="text-lg font-semibold text-gray-800">${data.http_code || 'N/A'}</div>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">Timestamp</div>
                    <div class="text-sm font-medium text-gray-800">${data.timestamp || ''}</div>
                </div>
            </div>
            
            ${summary.message ? `
                <div class="bg-blue-50 border border-blue-200 rounded p-3">
                    <div class="text-sm text-blue-800">
                        <strong>📊 Resumen:</strong> ${summary.message}
                    </div>
                </div>
            ` : ''}
            
            ${summary.ids ? `
                <div class="bg-green-50 border border-green-200 rounded p-3">
                    <div class="text-sm text-green-800">
                        <strong>🔑 IDs Generados:</strong>
                        <ul class="list-disc list-inside mt-2">
                            ${Object.entries(summary.ids).map(([key, value]) => 
                                `<li>${key}: <code class="bg-green-100 px-2 py-1 rounded">${value}</code></li>`
                            ).join('')}
                        </ul>
                    </div>
                </div>
            ` : ''}
            
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">📋 Respuesta de la API:</span>
                    <button onclick="copyToClipboard('${escapeForAttribute(responsePreview)}')" 
                            class="text-xs text-blue-600 hover:text-blue-800">
                        📋 Copiar
                    </button>
                </div>
                <div class="json-viewer">
                    <pre>${escapeHtml(responsePreview)}</pre>
                </div>
            </div>
        </div>
    `;
}

// Renderizar resultado con error
function renderErrorResult(data) {
    const error = data.error || {};
    
    return `
        <div class="space-y-4">
            <div class="flex items-center gap-2 text-red-600">
                <span class="text-2xl">✗</span>
                <span class="font-semibold">Error en la ejecución</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-3 rounded border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">Tiempo de Respuesta</div>
                    <div class="text-lg font-semibold text-gray-800">${data.execution_time?.toFixed(3) || '0.000'}s</div>
                </div>
                <div class="bg-white p-3 rounded border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">Timestamp</div>
                    <div class="text-sm font-medium text-gray-800">${data.timestamp || ''}</div>
                </div>
            </div>
            
            <div class="bg-red-50 border border-red-200 rounded p-4">
                <div class="text-sm text-red-800">
                    <strong>⚠️ Error:</strong>
                    <p class="mt-2">${escapeHtml(error.message || 'Error desconocido')}</p>
                </div>
            </div>
            
            ${error.type ? `
                <div class="bg-gray-50 border border-gray-200 rounded p-3">
                    <div class="text-xs text-gray-500 mb-1">Tipo de Excepción</div>
                    <div class="text-sm font-mono text-gray-800">${escapeHtml(error.type)}</div>
                </div>
            ` : ''}
            
            ${data.details ? `
                <div>
                    <div class="text-sm font-medium text-gray-700 mb-2">🔍 Detalles Técnicos:</div>
                    <div class="json-viewer">
                        <pre>${escapeHtml(JSON.stringify(data.details, null, 2))}</pre>
                    </div>
                </div>
            ` : ''}
        </div>
    `;
}

// Ejecutar todas las pruebas
async function runAllTests() {
    if (isRunningAll) return;
    
    isRunningAll = true;
    const btnRunAll = document.getElementById('btnRunAll');
    const btnClear = document.getElementById('btnClear');
    const progressContainer = document.getElementById('progressContainer');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    
    // Deshabilitar botones
    btnRunAll.disabled = true;
    btnRunAll.classList.add('opacity-50', 'cursor-not-allowed');
    btnClear.disabled = true;
    btnClear.classList.add('opacity-50', 'cursor-not-allowed');
    
    // Mostrar barra de progreso
    progressContainer.classList.remove('hidden');
    
    let completed = 0;
    const total = tests.length;
    
    for (const test of tests) {
        // Actualizar progreso
        progressBar.style.width = `${(completed / total) * 100}%`;
        progressText.textContent = `${completed} / ${total}`;
        
        // Ejecutar prueba
        await runTest(test.id);
        
        // Esperar un poco entre pruebas
        await new Promise(resolve => setTimeout(resolve, 500));
        
        completed++;
    }
    
    // Actualizar progreso final
    progressBar.style.width = '100%';
    progressText.textContent = `${total} / ${total}`;
    
    // Calcular resultados
    const successful = Object.values(testResults).filter(r => r.status === 'success').length;
    const failed = Object.values(testResults).filter(r => r.status === 'error').length;
    
    // Mostrar resumen
    setTimeout(() => {
        alert(`✅ Pruebas completadas!\n\nExitosas: ${successful}\nFallidas: ${failed}\nTotal: ${total}`);
        
        // Rehabilitar botones
        btnRunAll.disabled = false;
        btnRunAll.classList.remove('opacity-50', 'cursor-not-allowed');
        btnClear.disabled = false;
        btnClear.classList.remove('opacity-50', 'cursor-not-allowed');
        
        isRunningAll = false;
    }, 500);
}

// Limpiar todos los resultados
function clearAllResults() {
    if (!confirm('¿Estás seguro de que quieres limpiar todos los resultados?')) {
        return;
    }
    
    testResults = {};
    
    // Cerrar todos los acordeones y resetear estados
    tests.forEach(test => {
        const content = document.getElementById(`content-${test.id}`);
        const icon = document.getElementById(`icon-${test.id}`);
        const statusEl = document.getElementById(`status-${test.id}`);
        const resultEl = document.getElementById(`result-${test.id}`);
        const btnEl = document.getElementById(`btn-${test.id}`);
        
        // Cerrar acordeón
        content.classList.remove('active');
        icon.textContent = '▶';
        
        // Resetear estado
        statusEl.className = 'px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600';
        statusEl.innerHTML = '⚪ Pendiente';
        
        // Resetear contenido
        resultEl.innerHTML = '<p class="text-sm">Haz clic en "Ejecutar" para realizar la prueba</p>';
        
        // Resetear botón
        btnEl.disabled = false;
        btnEl.classList.remove('opacity-50', 'cursor-not-allowed');
        btnEl.innerHTML = '▶ Ejecutar';
    });
    
    // Ocultar barra de progreso
    const progressContainer = document.getElementById('progressContainer');
    progressContainer.classList.add('hidden');
    document.getElementById('progressBar').style.width = '0%';
    document.getElementById('progressText').textContent = '0 / 8';
}

// Copiar al portapapeles
function copyToClipboard(text) {
    const decoded = decodeURIComponent(text.replace(/\+/g, ' '));
    navigator.clipboard.writeText(decoded).then(() => {
        alert('✅ Copiado al portapapeles');
    }).catch(err => {
        console.error('Error al copiar:', err);
    });
}

// Escapar HTML
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Escapar para atributo
function escapeForAttribute(text) {
    return encodeURIComponent(text);
}
