<div class="space-y-6">
    <!-- Header del Módulo -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-7 rounded-3xl shadow-xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="p-3 bg-indigo-500/20 text-indigo-300 rounded-2xl border border-indigo-500/30">
                <i data-lucide="file-text" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight">Historias Clínicas — Odontología</h1>
                <p class="text-xs text-slate-300 mt-1">Busca un paciente para acceder o registrar su historia clínica y odontograma de forma rápida.</p>
            </div>
        </div>
    </div>
    <!-- Barra de Herramientas: Búsqueda y Paginación -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between gap-4 items-center">
        <!-- Buscador Instantáneo -->
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" id="search-input" placeholder="Escribe nombre, apellido o documento..." class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition shadow-inner" autofocus>
            <button type="button" id="clear-btn" class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <!-- Selector de Registros por Página -->
        <div class="flex items-center gap-2 text-xs text-slate-500 font-medium w-full md:w-auto justify-end">
            <span>Mostrar:</span>
            <select id="rows-per-page" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:border-indigo-500 transition">
                <option value="5" selected>5</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>
    <!-- Lista de Pacientes / Resultados -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <span class="text-xs font-semibold text-slate-600" id="search-status"> Todos los Pacientes Registrados: </span>
            <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-100/50" id="patient-count"><?= count($pacientes) ?><?= count($pacientes) === 1 ? 'paciente' : 'pacientes' ?></span>
        </div>
        <?php if (!empty($pacientes)): ?>
            <div class="divide-y divide-slate-100" id="patients-list">
                <?php foreach ($pacientes as$paciente): ?>
                    <?php
                    $searchData = mb_strtolower($paciente['nombre'] . ' ' . $paciente['apellido'] . ' ' . $paciente['documento']);

                    // Cálculo exacto de la edad
                    $edad = null;
                    $esMenorEdad = false;
                    if (!empty($paciente['fecha_nacimiento'])) {
                        $nacimiento = new DateTime($paciente['fecha_nacimiento']);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($nacimiento)->y;
                        $esMenorEdad = $edad < 18;
                    }
                    ?>
                    <div class="patient-card p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-indigo-50/30 transition duration-150" data-search="<?= htmlspecialchars($searchData) ?>">
                        <!-- Info del Paciente -->
                        <div class="flex items-center space-x-4">
                            <!-- Avatar con Iniciales Estilizado -->
                            <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-indigo-700 text-white rounded-2xl flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/20 shrink-0"><?= strtoupper(substr($paciente['nombre'] ?? 'P', 0, 1) . substr($paciente['apellido'] ?? '', 0, 1)) ?></div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-extrabold text-slate-900 text-sm"><?= htmlspecialchars($paciente['nombre'] . ' ' .$paciente['apellido']) ?></h3>
                                    <!-- Insignia Mayor / Menor de Edad -->
                                    <?php if ($edad !== null): ?>
                                        <?php if ($esMenorEdad): ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-100 shadow-2xs">
                                                <i data-lucide="shield-alert" class="w-3 h-3 text-amber-500"></i>
                                                Menor (
                                                <?= $edad ?>
                                                )
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-100 shadow-2xs">
                                                <i data-lucide="shield-check" class="w-3 h-3 text-blue-500"></i>
                                                Mayor (
                                                <?= $edad ?>
                                                )
                                            </span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs text-slate-500 font-medium">
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="id-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                        Doc:
                                        <strong class="text-slate-700"><?= htmlspecialchars($paciente['documento']) ?></strong>
                                    </span>
                                    <?php if (!empty($paciente['telefono'])): ?>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <?= htmlspecialchars($paciente['telefono']) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if (!empty($paciente['email'])): ?>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                            <?= htmlspecialchars($paciente['email']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- Acciones -->
                        <div class="w-full sm:w-auto flex justify-end">
                            <a href="<?= BASE_URL ?>/historias/ver/<?= $paciente['id'] ?>" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white px-4 py-2.5 rounded-xl text-xs font-semibold border border-indigo-100 hover:border-indigo-600 transition duration-200 shadow-2xs group">
                                <i data-lucide="folder-open" class="w-4 h-4 text-indigo-600 group-hover:text-white transition"></i>
                                <span>Ver Historia Clínica</span>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Estado Vacío por Búsqueda sin Resultados -->
            <div id="no-results" class="hidden p-16 text-center text-slate-400">
                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <i data-lucide="search-x" class="w-6 h-6"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-700">No se encontraron pacientes</h3>
                <p class="text-xs text-slate-400 mt-1"> No hay ningún paciente registrado que coincida con el término ingresado. </p>
            </div>
        <?php else: ?>
            <!-- Estado Vacío General (Sin Pacientes en la Base de Datos) -->
            <div class="p-16 text-center">
                <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                    <i data-lucide="user-x" class="w-6 h-6"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-700">No hay pacientes registrados</h3>
                <p class="text-xs text-slate-400 mt-1"> Aún no existen registros de pacientes en la base de datos. </p>
            </div>
        <?php endif; ?>
        <!-- Paginador Footer -->
        <?php if (!empty($pacientes)): ?>
            <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-200/80 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-xs text-slate-500 font-medium" id="pagination-info"> Mostrando registros... </div>
                <div class="flex items-center gap-1.5" id="pagination-buttons">
                    <!-- Botones de paginación generados por JS -->
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- Script de Paginación y Búsqueda Instantánea -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    
        const searchInput = document.getElementById('search-input');
        const clearBtn = document.getElementById('clear-btn');
        const rowsPerPageSelect = document.getElementById('rows-per-page');
        const allCards = Array.from(document.querySelectorAll('.patient-card'));
        const noResults = document.getElementById('no-results');
        const searchStatus = document.getElementById('search-status');
        const patientCount = document.getElementById('patient-count');
        const paginationInfo = document.getElementById('pagination-info');
        const paginationButtons = document.getElementById('pagination-buttons');
    
        if (!searchInput) return;
    
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);
        let filteredCards = [...allCards];
    
        function renderList() {
            // Ocultar todas las tarjetas primero
            allCards.forEach((card) => (card.style.display = 'none'));
    
            const totalRows = filteredCards.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
    
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
    
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const currentCards = filteredCards.slice(start, end);
    
            // Mostrar solo las tarjetas de la página actual
            currentCards.forEach((card) => (card.style.display = ''));
    
            // Gestionar visibilidad de mensajes vacíos
            const query = searchInput.value.trim();
            if (totalRows === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
    
            // Actualizar textos informativos
            patientCount.textContent = `${totalRows} ${totalRows === 1 ? 'paciente' : 'pacientes'}`;
            if (query.length > 0) {
                searchStatus.textContent = 'Resultados filtrados:';
            } else {
                searchStatus.textContent = 'Todos los Pacientes Registrados:';
            }
    
            const startText = totalRows > 0 ? start + 1 : 0;
            const endText = Math.min(end, totalRows);
            if (paginationInfo) {
                paginationInfo.textContent = `Mostrando ${startText} a ${endText} de ${totalRows} pacientes`;
            }
    
            renderPaginationControls(totalPages);
        }
    
        function renderPaginationControls(totalPages) {
            if (!paginationButtons) return;
            paginationButtons.innerHTML = '';
    
            // Botón Anterior
            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '<i data-lucide="chevron-left" class="w-4 h-4"></i>';
            prevBtn.className = `p-2 rounded-xl border text-xs font-bold transition flex items-center justify-center ${currentPage === 1 ? 'bg-slate-100 text-slate-300 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50 shadow-2xs'}`;
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderList();
                }
            });
            paginationButtons.appendChild(prevBtn);
    
            // Números de página
            let maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
            if (endPage - startPage + 1 < maxVisiblePages) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }
    
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.textContent = i;
                pageBtn.className = `px-3.5 py-2 rounded-xl text-xs font-bold border transition shadow-2xs ${i === currentPage ? 'bg-indigo-600 text-white border-indigo-600 shadow-indigo-600/30' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50'}`;
                pageBtn.addEventListener('click', () => {
                    currentPage = i;
                    renderList();
                });
                paginationButtons.appendChild(pageBtn);
            }
    
            // Botón Siguiente
            const nextBtn = document.createElement('button');
            nextBtn.innerHTML = '<i data-lucide="chevron-right" class="w-4 h-4"></i>';
            nextBtn.className = `p-2 rounded-xl border text-xs font-bold transition flex items-center justify-center ${currentPage === totalPages || totalPages === 0 ? 'bg-slate-100 text-slate-300 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50 shadow-2xs'}`;
            nextBtn.disabled = currentPage === totalPages || totalPages === 0;
            nextBtn.addEventListener('click', () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    renderList();
                }
            });
            paginationButtons.appendChild(nextBtn);
    
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    
        // Búsqueda en tiempo real
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
    
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
    
            filteredCards = allCards.filter((card) => {
                const searchData = card.getAttribute('data-search');
                return searchData.includes(query);
            });
    
            currentPage = 1;
            renderList();
        });
    
        // Limpiar búsqueda
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearBtn.classList.add('hidden');
            filteredCards = [...allCards];
            currentPage = 1;
            renderList();
            searchInput.focus();
        });
    
        // Cambiar cantidad de registros por página
        rowsPerPageSelect.addEventListener('change', (e) => {
            rowsPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderList();
        });
    
        // Renderizado inicial
        renderList();
    });
</script>