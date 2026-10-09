<style>
    /* Sistema visual unificado para Gestión de Usuarios */
    .usuarios-ui {
        --ui-ink: #142238;
        --ui-muted: #64748b;
        --ui-line: #e2eaf2;
        --ui-blue: #315ee8;
        --ui-teal: #0f9f9a;
        color: var(--ui-ink);
        width: 100%;
        min-width: 0;
    }
    .usuarios-ui > * {
        min-width: 0;
    }
    .usuarios-ui a,
    .usuarios-ui button,
    .usuarios-ui input,
    .usuarios-ui select {
        -webkit-tap-highlight-color: transparent;
    }
    .usuarios-ui a:focus-visible,
    .usuarios-ui button:focus-visible,
    .usuarios-ui input:focus-visible,
    .usuarios-ui select:focus-visible,
    .usuarios-ui textarea:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.24);
        outline-offset: 2px;
    }
    .usuarios-ui input:not([type='checkbox']):not([type='radio']):not([type='file']):not([type='hidden']),
    .usuarios-ui select,
    .usuarios-ui textarea {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d8e2ee;
        background-color: #f8fafc;
        color: #17253b;
        transition:
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }
    .usuarios-ui input:not([type='checkbox']):not([type='radio']):not([type='file']):not([type='hidden']):focus,
    .usuarios-ui select:focus,
    .usuarios-ui textarea:focus {
        border-color: #6487f4 !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.1);
    }
    .usuarios-ui input[type='checkbox'] {
        width: 17px;
        height: 17px;
        accent-color: #315ee8;
        flex: 0 0 auto;
    }
    .usuarios-ui form,
    .usuarios-ui .usuario-form-card {
        border-color: var(--ui-line) !important;
        border-radius: 22px !important;
        box-shadow: 0 8px 28px rgba(15, 35, 65, 0.055) !important;
    }
    .usuarios-ui .usuarios-section {
        border-radius: 18px;
    }
    .usuarios-ui .ui-elevate {
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease;
    }
    .usuarios-ui .ui-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(15, 35, 65, 0.08);
    }
    .usuarios-ui button[type='submit'] {
        min-height: 44px;
        border-radius: 12px !important;
        box-shadow: 0 7px 16px rgba(49, 94, 232, 0.18);
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease,
            filter 0.18s ease;
    }
    .usuarios-ui button[type='submit']:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(49, 94, 232, 0.24);
        filter: saturate(1.08);
    }
    .usuarios-ui .usuarios-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        border: 1px solid #1e3760;
        border-radius: 26px;
        background: linear-gradient(120deg, #101c35 0%, #1b3470 58%, #087e8b 100%);
        color: #fff;
        box-shadow: 0 16px 35px rgba(15, 35, 65, 0.16);
    }
    .usuarios-ui .usuarios-hero:after {
        content: '';
        position: absolute;
        z-index: -1;
        width: 240px;
        height: 240px;
        right: -65px;
        top: -110px;
        border-radius: 50%;
        background: rgba(125, 211, 252, 0.13);
        box-shadow:
            0 0 0 32px rgba(255, 255, 255, 0.025),
            0 0 0 66px rgba(255, 255, 255, 0.02);
    }
    .usuarios-ui .usuarios-panel {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid var(--ui-line);
        border-radius: 20px;
        box-shadow: 0 7px 24px rgba(15, 35, 65, 0.045);
    }
    .usuarios-ui .usuario-row {
        transition: background 0.18s ease;
    }
    .usuarios-ui .usuario-row:hover {
        background: #f4f8ff;
    }
    .usuarios-ui .usuarios-index table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .usuarios-ui .usuarios-index thead th {
        background: #f5f8fc;
    }
    .usuarios-ui .usuarios-index tbody td {
        vertical-align: middle;
    }
    .usuarios-ui .usuarios-index tbody tr:last-child td {
        border-bottom: 0;
    }
    .usuarios-ui .usuarios-index #search-table {
        background: #f7f9fc;
    }
    .usuarios-ui .usuarios-index #pagination-buttons button {
        min-width: 38px;
        min-height: 38px;
    }
    .usuarios-ui .usuarios-create .tab-button,
    .usuarios-ui .usuarios-edit-page .tab-button {
        min-height: 42px;
        border-radius: 12px 12px 0 0;
    }
    .usuarios-ui .tab-panel label:has(input.chk-permiso) {
        min-height: 48px;
        border-radius: 13px;
        transition:
            border-color 0.18s ease,
            background 0.18s ease,
            transform 0.18s ease;
    }
    .usuarios-ui .tab-panel label:has(input.chk-permiso):hover {
        border-color: #bdcdfa;
        background: #f5f8ff;
        transform: translateY(-1px);
    }
    .usuarios-ui #preview_container {
        width: 132px;
        height: 132px;
        border-radius: 24px !important;
        border: 4px solid #fff !important;
        box-shadow:
            0 0 0 1px #dbe5f0,
            0 10px 24px rgba(15, 35, 65, 0.1) !important;
    }
    .usuarios-ui #webcam_container {
        width: min(100%, 260px);
        height: 220px;
        border-radius: 18px;
        box-shadow: 0 10px 24px rgba(15, 35, 65, 0.14);
    }
    .usuarios-ui #user-signature-pad {
        touch-action: none;
        display: block;
    }
    .usuarios-ui .usuarios-view .profile-banner {
        min-height: 156px;
        background: linear-gradient(120deg, #14264a, #315ee8 58%, #0d9488) !important;
    }
    .usuarios-ui .usuarios-view .profile-avatar {
        border: 5px solid white;
        box-shadow: 0 12px 30px rgba(15, 35, 65, 0.18);
    }
    @media (max-width: 640px) {
        .usuarios-ui {
            font-size: 14px;
        }
        .usuarios-ui .usuarios-hero {
            border-radius: 20px;
            padding: 20px !important;
        }
        .usuarios-ui form {
            padding: 18px !important;
        }
        .usuarios-ui .usuarios-index .overflow-x-auto {
            max-width: 100%;
        }
        .usuarios-ui .usuarios-index table {
            min-width: 720px;
        }
        .usuarios-ui .usuarios-index .pagination-footer {
            padding: 14px !important;
        }
        .usuarios-ui #tabs-header {
            padding-bottom: 4px;
            scrollbar-width: thin;
        }
        .usuarios-ui .tab-panel {
            padding: 12px !important;
        }
        .usuarios-ui #preview_container {
            width: 116px;
            height: 116px;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .usuarios-ui *,
        .usuarios-ui *:before,
        .usuarios-ui *:after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>
<div class="usuarios-ui usuarios-index space-y-6">
    <!-- Header y Acción Principal -->
    <div class="usuarios-hero flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-white p-6 sm:p-8 relative">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="p-3 bg-indigo-500/20 text-indigo-300 rounded-2xl border border-indigo-500/30">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight">Gestión de Usuarios y Roles</h1>
                <p class="text-xs text-slate-300 mt-1">Administra las cuentas, fotos de perfil y accesos a los módulos del sistema.</p>
            </div>
        </div>
        <div class="relative z-10">
            <a href="<?= BASE_URL ?>/usuarios/crear" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition-all duration-300 hover:scale-105">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Registrar Nuevo Usuario</span>
            </a>
        </div>
    </div>
    <!-- Barra de Herramientas: Búsqueda y Paginación -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between gap-4 items-center">
        <!-- Buscador Instantáneo -->
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" id="search-table" placeholder="Buscar por nombre, correo o rol..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition shadow-inner">
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
    <!-- Tabla de Usuarios -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600" id="usuarios-table">
                <thead class="bg-slate-50/80 border-b border-slate-200/80 font-extrabold text-slate-400 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-4 px-6">Usuario</th>
                        <th class="py-4 px-6">Correo Electrónico</th>
                        <th class="py-4 px-6">Rol</th>
                        <th class="py-4 px-6">Estado</th>
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="table-body">
                    <?php foreach ($usuarios as$u): ?>
                        <?php
                        $rol = $u['rol'] ?? 'usuario';
                        $estadoTexto = $u['estado'] ? 'activo' : 'inactivo';
                        $searchContext = mb_strtolower($u['nombre'] . ' ' . $u['email'] . ' ' . $rol . ' ' . $estadoTexto);
                        ?>
                        <tr class="usuario-row hover:bg-indigo-50/30 transition duration-150" data-search="<?= htmlspecialchars($searchContext) ?>">
                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center gap-3.5">
                                <?php if (!empty($u['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' .$u['foto'])): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($u['foto']) ?>" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 shadow-sm shrink-0">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white font-black flex items-center justify-center text-xs shadow-md shadow-indigo-500/20 shrink-0 uppercase"><?= mb_substr($u['nombre'] ?? 'US', 0, 2) ?></div>
                                <?php endif; ?>
                                <div>
                                    <span class="block text-slate-900 text-sm font-extrabold"><?= htmlspecialchars($u['nombre']) ?></span>
                                    <span class="text-[10px] text-slate-400 font-normal">ID: #<?= $u['id'] ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-medium text-slate-600"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold uppercase shadow-2xs
                                <?= $rol === 'admin' ? 'bg-red-50 text-red-700 border border-red-100' : '' ?>
                                <?= $rol === 'doctor' ? 'bg-green-50 text-green-700 border border-green-100' : '' ?>
                                <?= $rol === 'auxiliar' ? 'bg-yellow-50 text-yellow-700 border border-yellow-100' : '' ?>
                                <?= !in_array($rol, ['admin', 'doctor', 'auxiliar']) ? 'bg-slate-100 text-slate-700 border border-slate-200' : '' ?>"><?= htmlspecialchars($rol) ?></span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold shadow-2xs <?= $u['estado'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-rose-50 text-rose-700 border border-rose-100' ?>"><?= $u['estado'] ? 'Activo' : 'Inactivo' ?></span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1 bg-slate-50 p-1 rounded-2xl border border-slate-200/80 shadow-2xs">
                                    <a href="<?= BASE_URL ?>/usuarios/ver/<?= $u['id'] ?>" title="Ver Perfil" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-xl transition shadow-2xs">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/usuarios/editar/<?= $u['id'] ?>" title="Editar Usuario" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-white rounded-xl transition shadow-2xs">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <a href="<?= BASE_URL ?>/usuarios/eliminar/<?= $u['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" title="Eliminar" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-white rounded-xl transition shadow-2xs">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Mensaje Vacío (Oculto por defecto) -->
            <div id="no-results" class="hidden py-16 text-center text-slate-400">
                <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                <p class="text-sm font-semibold text-slate-600">No se encontraron usuarios que coincidan con la búsqueda.</p>
            </div>
        </div>
        <!-- Paginador Footer -->
        <div class="px-6 py-4 bg-slate-50/80 border-t border-slate-200/80 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-xs text-slate-500 font-medium" id="pagination-info"> Mostrando registros... </div>
            <div class="flex items-center gap-1.5" id="pagination-buttons">
                <!-- Los botones se generan dinámicamente con JS -->
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    
        const searchInput = document.getElementById('search-table');
        const rowsPerPageSelect = document.getElementById('rows-per-page');
        const allRows = Array.from(document.querySelectorAll('.usuario-row'));
        const noResultsDiv = document.getElementById('no-results');
        const paginationInfo = document.getElementById('pagination-info');
        const paginationButtons = document.getElementById('pagination-buttons');
    
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);
        let filteredRows = [...allRows];
    
        function renderTable() {
            allRows.forEach((row) => (row.style.display = 'none'));
    
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
    
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
    
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const currentRows = filteredRows.slice(start, end);
    
            currentRows.forEach((row) => (row.style.display = ''));
    
            if (totalRows === 0) {
                noResultsDiv.classList.remove('hidden');
            } else {
                noResultsDiv.classList.add('hidden');
            }
    
            const startText = totalRows > 0 ? start + 1 : 0;
            const endText = Math.min(end, totalRows);
            paginationInfo.textContent = `Mostrando ${startText} a ${endText} de ${totalRows} usuarios`;
    
            renderPaginationControls(totalPages);
        }
    
        function renderPaginationControls(totalPages) {
            paginationButtons.innerHTML = '';
    
            // Botón Anterior
            const prevBtn = document.createElement('button');
            prevBtn.innerHTML = '<i data-lucide="chevron-left" class="w-4 h-4"></i>';
            prevBtn.className = `p-2 rounded-xl border text-xs font-bold transition flex items-center justify-center ${currentPage === 1 ? 'bg-slate-100 text-slate-300 border-slate-200 cursor-not-allowed' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-50 shadow-2xs'}`;
            prevBtn.disabled = currentPage === 1;
            prevBtn.addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
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
                    renderTable();
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
                    renderTable();
                }
            });
            paginationButtons.appendChild(nextBtn);
    
            lucide.createIcons();
        }
    
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            filteredRows = allRows.filter((row) => {
                const searchData = row.getAttribute('data-search');
                return searchData.includes(query);
            });
            currentPage = 1;
            renderTable();
        });
    
        rowsPerPageSelect.addEventListener('change', (e) => {
            rowsPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });
    
        renderTable();
    });
</script>