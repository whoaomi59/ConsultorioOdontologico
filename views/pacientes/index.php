<style>
    /* Identidad visual premium para el módulo de pacientes */
    .pacientes-ui {
        --p-ink: #17243b;
        --p-muted: #718096;
        --p-line: #e4ebf4;
        --p-blue: #315ee8;
        --p-teal: #0e9488;
        width: 100%;
        min-width: 0;
        color: var(--p-ink);
        padding-bottom: clamp(18px, 2vw, 32px);
    }
    .pacientes-ui,
    .pacientes-ui * {
        box-sizing: border-box;
    }
    .pacientes-ui a,
    .pacientes-ui button,
    .pacientes-ui input,
    .pacientes-ui select {
        -webkit-tap-highlight-color: transparent;
    }
    .pacientes-ui a:focus-visible,
    .pacientes-ui button:focus-visible,
    .pacientes-ui input:focus-visible,
    .pacientes-ui select:focus-visible,
    .pacientes-ui textarea:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.28);
        outline-offset: 3px;
    }
    .pacientes-ui h1,
    .pacientes-ui h2,
    .pacientes-ui h3 {
        letter-spacing: -0.025em;
    }
    .pacientes-ui input:not([type='file']):not([type='hidden']):not([type='checkbox']):not([type='radio']),
    .pacientes-ui select,
    .pacientes-ui textarea {
        min-height: 45px;
        border-radius: 13px !important;
        border-color: #d8e3ef !important;
        background-color: #f8fafc;
        color: #1c2c43;
        transition:
            border-color 0.18s,
            box-shadow 0.18s,
            background 0.18s;
    }
    .pacientes-ui input:not([type='file']):not([type='hidden']):not([type='checkbox']):not([type='radio']):focus,
    .pacientes-ui select:focus,
    .pacientes-ui textarea:focus {
        background: #fff !important;
        border-color: #6b89f2 !important;
        box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.1) !important;
        outline: none;
    }
    .pacientes-ui label {
        line-height: 1.45;
    }
    .pacientes-ui form button[type='submit'] {
        min-height: 46px;
        border-radius: 13px !important;
        box-shadow: 0 8px 18px rgba(49, 94, 232, 0.18);
        transition:
            transform 0.18s,
            box-shadow 0.18s,
            filter 0.18s;
    }
    .pacientes-ui form button[type='submit']:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 23px rgba(49, 94, 232, 0.23);
        filter: saturate(1.08);
    }
    .pacientes-ui .pu-card,
    .pacientes-ui form.space-y-6 > div.bg-white,
    .pacientes-ui form.space-y-6 > section {
        border-color: var(--p-line) !important;
        border-radius: 22px !important;
        box-shadow: 0 8px 28px rgba(19, 38, 68, 0.055) !important;
    }
    .pacientes-ui .p-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 1px solid #edf1f6;
    }
    .pacientes-ui .p-section-title h2 {
        margin: 0;
    }
    .pacientes-ui .p-section-title i {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        background: #eef3ff;
        border-radius: 12px;
        padding: 9px;
    }
    .pacientes-ui .p-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        color: #fff !important;
        border: 1px solid #203960 !important;
        border-radius: 25px !important;
        background: linear-gradient(118deg, #111d38 0%, #2549a5 55%, #087f86 100%) !important;
        box-shadow: 0 18px 38px rgba(20, 40, 75, 0.17) !important;
    }
    .pacientes-ui .p-hero:after {
        content: '';
        position: absolute;
        z-index: -1;
        right: -75px;
        top: -145px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.17);
        box-shadow:
            0 0 0 32px rgba(255, 255, 255, 0.025),
            0 0 0 68px rgba(255, 255, 255, 0.02);
    }
    .pacientes-ui .p-hero h1 {
        color: #fff !important;
    }
    .pacientes-ui .p-hero p {
        color: rgba(255, 255, 255, 0.76) !important;
    }
    .pacientes-ui .p-backlink {
        background: rgba(255, 255, 255, 0.11) !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        color: #fff !important;
    }
    .pacientes-ui .p-backlink:hover {
        background: rgba(255, 255, 255, 0.2) !important;
    }
    .pacientes-ui .p-photo-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fff, #f7faff) !important;
    }
    .pacientes-ui #avatar-preview-container {
        width: 136px !important;
        height: 136px !important;
        border-radius: 25px !important;
        border: 4px solid #fff !important;
        box-shadow:
            0 0 0 1px #dbe5f0,
            0 12px 28px rgba(15, 35, 65, 0.12) !important;
    }
    .pacientes-ui #avatar-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pacientes-ui #modal-camara {
        z-index: 1000;
        background: rgba(8, 18, 37, 0.76);
        backdrop-filter: blur(9px);
    }
    .pacientes-ui #modal-camara > div {
        border: 1px solid rgba(255, 255, 255, 0.65);
        border-radius: 24px !important;
        box-shadow: 0 28px 80px rgba(0, 0, 0, 0.3) !important;
    }
    .pacientes-ui #video-camara {
        max-height: 60vh;
    }
    .pacientes-ui .p-form-note {
        color: #718096;
        font-size: 11px;
        line-height: 1.55;
    }
    .pacientes-ui .p-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .pacientes-ui .p-actions a,
    .pacientes-ui .p-actions button {
        min-height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .pacientes-ui .paciente-row {
        transition: background 0.16s ease;
    }
    .pacientes-ui .paciente-row:hover {
        background: #f4f7ff !important;
    }
    .pacientes-ui #pacientes-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .pacientes-ui #pacientes-table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #f5f8fc !important;
        color: #728096 !important;
        border-bottom: 1px solid #e4ebf4;
    }
    .pacientes-ui #pacientes-table tbody td {
        vertical-align: middle;
    }
    .pacientes-ui #pacientes-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .pacientes-ui #search-table {
        min-height: 46px;
        border-radius: 14px !important;
        background: #f8fafc;
    }
    .pacientes-ui #pagination-buttons button {
        min-width: 38px;
        min-height: 38px;
    }
    .pacientes-ui .p-toolbar {
        border-radius: 20px !important;
        box-shadow: 0 7px 24px rgba(19, 38, 68, 0.05) !important;
    }
    .pacientes-ui .p-profile-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        border-radius: 25px !important;
        background: linear-gradient(118deg, #111d38 0%, #2549a5 56%, #087f86 100%) !important;
        color: white !important;
        box-shadow: 0 17px 38px rgba(20, 40, 75, 0.15) !important;
    }
    .pacientes-ui .p-profile-hero h1 {
        color: white !important;
    }
    .pacientes-ui .p-profile-hero .text-slate-500 {
        color: rgba(255, 255, 255, 0.76) !important;
    }
    .pacientes-ui .p-profile-hero .bg-indigo-50 {
        background: rgba(255, 255, 255, 0.14) !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    .pacientes-ui .p-profile-avatar {
        border: 5px solid #fff !important;
        box-shadow: 0 12px 28px rgba(15, 35, 65, 0.18) !important;
    }
    .pacientes-ui .p-data-grid > div {
        min-width: 0;
        padding: 16px;
        border: 1px solid #e7edf5;
        border-radius: 16px;
        background: linear-gradient(145deg, #fff, #f8fbff);
    }
    .pacientes-ui .p-data-grid label {
        display: block;
        margin-bottom: 7px;
        color: #8592a5;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .pacientes-ui .p-data-grid p {
        overflow-wrap: anywhere;
    }
    .pacientes-ui .p-history-card {
        border-radius: 21px !important;
        border-color: #e4ebf4 !important;
        box-shadow: 0 8px 26px rgba(19, 38, 68, 0.05) !important;
    }
    .pacientes-ui .p-empty {
        padding: 26px 16px;
        border: 1px dashed #d7e1ed;
        border-radius: 16px;
        background: #f9fbfe;
        text-align: center;
        color: #7c8ba0;
    }
    @media (max-width: 700px) {
        .pacientes-ui .p-hero {
            border-radius: 20px !important;
            padding: 20px !important;
        }
        .pacientes-ui .p-toolbar {
            align-items: stretch !important;
            padding: 14px !important;
        }
        .pacientes-ui .p-toolbar > div {
            width: 100%;
        }
        .pacientes-ui #pacientes-table {
            min-width: 900px;
        }
        .pacientes-ui .p-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .pacientes-ui .p-actions > * {
            width: 100%;
        }
        .pacientes-ui #avatar-preview-container {
            width: 116px !important;
            height: 116px !important;
        }
        .pacientes-ui form.space-y-6 > div {
            padding: 18px !important;
        }
    }
    @media (max-width: 430px) {
        .pacientes-ui .p-actions {
            grid-template-columns: 1fr;
        }
        .pacientes-ui .p-profile-hero {
            border-radius: 20px !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .pacientes-ui *,
        .pacientes-ui *::before,
        .pacientes-ui *::after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>
<div class="pacientes-ui pacientes-index space-y-6">
    <!-- Header y Acción Principal -->
    <div class="p-hero flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-white p-7 rounded-3xl shadow-xl border relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold mb-2 border border-indigo-500/30">
                <i data-lucide="users" class="w-3.5 h-3.5"></i>
                Directorio Clínico
            </div>
            <h1 class="text-2xl font-black tracking-tight">Listado de Pacientes</h1>
            <p class="text-xs text-slate-300 mt-1">Gestión integral, historias clínicas y exportación de datos en tiempo real.</p>
        </div>
        <div class="relative z-10">
            <a href="<?= BASE_URL ?>/paciente/crear" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition-all duration-300 hover:scale-105">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Registrar Paciente</span>
            </a>
        </div>
    </div>
    <!-- Barra de Herramientas: Búsqueda, Paginación y Exportación -->
    <div class="p-toolbar bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between gap-4 items-center">
        <!-- Buscador Instantáneo -->
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input type="text" id="search-table" placeholder="Buscar por documento, nombre o teléfono..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition shadow-inner">
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto justify-end">
            <!-- Selector de Registros por Página -->
            <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                <span>Mostrar:</span>
                <select id="rows-per-page" class="bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 focus:outline-none focus:border-indigo-500 transition">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <!-- Botones de Exportación -->
            <div class="flex items-center gap-2">
                <a href="<?= BASE_URL ?>/paciente/exportar/pdf" target="_blank" class="inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-2.5 rounded-xl text-xs font-semibold border border-rose-200/80 transition shadow-sm">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>PDF</span>
                </a>
                <a href="<?= BASE_URL ?>/paciente/exportar/excel" class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3 py-2.5 rounded-xl text-xs font-semibold border border-emerald-200/80 transition shadow-sm">
                    <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                    <span>Excel</span>
                </a>
            </div>
        </div>
    </div>
    <!-- Tabla de Pacientes -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="pacientes-table">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200/80 text-[11px] font-extrabold uppercase text-slate-400 tracking-wider">
                        <th class="py-4 px-6">Paciente</th>
                        <th class="py-4 px-6">Documento</th>
                        <th class="py-4 px-6">Edad / Condición</th>
                        <th class="py-4 px-6">Teléfono</th>
                        <th class="py-4 px-6">Correo</th>
                        <th class="py-4 px-6 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs" id="table-body">
                    <?php foreach ($pacientes as$p): ?>
                        <?php
                        $tipoDoc = $p['tipo_documento'] ?? 'CC';
                        $nacimiento = new DateTime($p['fecha_nacimiento']);
                        $hoy = new DateTime();
                        $edad = $hoy->diff($nacimiento)->y;
                        $esMayor = $edad >= 18;

                        $searchContext = mb_strtolower($p['documento'] . ' ' . $p['nombre'] . ' ' . $p['apellido'] . ' ' . $p['telefono'] . ' ' . $p['email']);
                        ?>
                        <tr class="paciente-row hover:bg-indigo-50/30 transition duration-150" data-search="<?= htmlspecialchars($searchContext) ?>">
                            <td class="py-4 px-6 font-bold text-slate-900 flex items-center gap-3.5">
                                <?php
                                $fotoRutaFisica = ROOT_PATH . '/public/uploads/pacientes/' . $p['foto'];
                                $tieneFoto = !empty($p['foto']) && file_exists($fotoRutaFisica);
                                ?>
                                <?php if ($tieneFoto): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/pacientes/<?= htmlspecialchars($p['foto']) ?>" alt="Foto Paciente" class="w-10 h-10 rounded-2xl object-cover border border-slate-200 shadow-sm shrink-0">
                                <?php else: ?>
                                    <!-- Avatar con iniciales estilizado -->
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/20 shrink-0"><?= strtoupper(substr($p['nombre'] ?? 'P', 0, 1)) ?></div>
                                <?php endif; ?>
                                <div>
                                    <span class="block text-slate-900 font-extrabold text-sm"><?= htmlspecialchars($p['nombre'] . ' ' .$p['apellido']) ?></span>
                                </div>
                            </td>
                            <td class="py-4 px-6 font-mono font-semibold text-slate-600">
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md mr-1.5 font-sans font-extrabold border border-slate-200"><?= htmlspecialchars($tipoDoc) ?></span>
                                <?= htmlspecialchars($p['documento']) ?>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-slate-700"><?= $edad ?> años</span>
                                    <?php if ($esMayor): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold bg-blue-50 text-blue-700 border border-blue-100 shadow-2xs"> Mayor </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-100 shadow-2xs"> Menor </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium"><?= htmlspecialchars($p['telefono'] ?: 'N/A') ?></td>
                            <td class="py-4 px-6 text-slate-500 font-medium"><?= htmlspecialchars($p['email'] ?: 'N/A') ?></td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1 bg-slate-50 p-1 rounded-2xl border border-slate-200/80 shadow-2xs">
                                    <!-- Ver Perfil -->
                                    <a href="<?= BASE_URL ?>/paciente/perfil/<?= $p['id'] ?>" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-xl transition shadow-2xs" title="Ver Perfil">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Historia Ortodoncia -->
                                    <a href="<?= BASE_URL ?>/ortodoncia/ver/<?= $p['id'] ?>" class="p-2 text-slate-500 hover:text-amber-600 hover:bg-white rounded-xl transition shadow-2xs" title="Historia Ortodoncia">
                                        <i data-lucide="smile" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Historia Clínica General -->
                                    <a href="<?= BASE_URL ?>/historias/ver/<?= $p['id'] ?>" class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-white rounded-xl transition shadow-2xs" title="Historia Clínica">
                                        <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Editar -->
                                    <a href="<?= BASE_URL ?>/paciente/editar/<?= $p['id'] ?>" class="p-2 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-xl transition shadow-2xs" title="Editar Paciente">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    <!-- Eliminar -->
                                    <a href="<?= BASE_URL ?>/paciente/eliminar/<?= $p['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este paciente y todas sus historias clínicas?');" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-white rounded-xl transition shadow-2xs" title="Eliminar Paciente">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Mensaje Vacío (Oculto por defecto si hay datos) -->
            <div id="no-results" class="hidden py-16 text-center text-slate-400">
                <i data-lucide="search-x" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                <p class="text-sm font-semibold text-slate-600">No se encontraron pacientes que coincidan con la búsqueda.</p>
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
        const tableBody = document.getElementById('table-body');
        const allRows = Array.from(document.querySelectorAll('.paciente-row'));
        const noResultsDiv = document.getElementById('no-results');
        const paginationInfo = document.getElementById('pagination-info');
        const paginationButtons = document.getElementById('pagination-buttons');
    
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);
        let filteredRows = [...allRows];
    
        function renderTable() {
            // Ocultar todas las filas primero
            allRows.forEach((row) => (row.style.display = 'none'));
    
            const totalRows = filteredRows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage) || 1;
    
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
    
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const currentRows = filteredRows.slice(start, end);
    
            // Mostrar filas de la página actual
            currentRows.forEach((row) => (row.style.display = ''));
    
            // Mostrar u ocultar mensaje de vacío
            if (totalRows === 0) {
                noResultsDiv.classList.remove('hidden');
            } else {
                noResultsDiv.classList.add('hidden');
            }
    
            // Actualizar texto informativo
            const startText = totalRows > 0 ? start + 1 : 0;
            const endText = Math.min(end, totalRows);
            paginationInfo.textContent = `Mostrando ${startText} a ${endText} de ${totalRows} pacientes`;
    
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
    
            // Números de página compactos
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
    
        // Evento de Búsqueda instantánea
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            filteredRows = allRows.filter((row) => {
                const searchData = row.getAttribute('data-search');
                return searchData.includes(query);
            });
            currentPage = 1;
            renderTable();
        });
    
        // Evento de cambio de filas por página
        rowsPerPageSelect.addEventListener('change', (e) => {
            rowsPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });
    
        // Renderizado inicial
        renderTable();
    });
</script>