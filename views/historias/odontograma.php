<?php
// Si la variable no viene desde el controlador, se consulta mediante la variable global de BD
if (!isset($convenciones)) {
    try {
        global $db;
        if ($db) {
            $stmtConv = $db->query('SELECT * FROM convenciones WHERE activo = 1 ORDER BY id ASC');
            $convenciones = $stmtConv->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $convenciones = [];
        }
    } catch (Exception $e) {
        $convenciones = [];
    }
}
?>
<style>
    /* Identidad premium del consultorio odontológico: azul profundo y turquesa */
    .odontologia-premium,
    .historia-premium,
    .odontograma-premium {
        --clinic-navy: #10233f;
        --clinic-blue: #176b87;
        --clinic-teal: #0f9b91;
        --clinic-teal-dark: #087f78;
        --clinic-ink: #172b45;
        --clinic-muted: #64758b;
        color: var(--clinic-ink);
    }
    .odontologia-premium > div:first-child,
    .historia-premium > div:first-child {
        border-radius: 1.5rem;
    }
    .odontologia-premium > div:first-child {
        background-image: linear-gradient(120deg, #10233f 0%, #123c59 58%, #087f78 100%) !important;
        border-color: rgba(148, 210, 205, 0.28) !important;
        box-shadow: 0 20px 45px rgba(16, 35, 63, 0.16) !important;
    }
    .odontologia-premium .bg-indigo-500\/20,
    .historia-premium .bg-indigo-500\/20 {
        background: rgba(15, 155, 145, 0.18) !important;
        border-color: rgba(113, 214, 203, 0.28) !important;
    }
    .odontologia-premium .text-indigo-300,
    .historia-premium .text-indigo-300 {
        color: #8de3da !important;
    }
    .odontologia-premium .bg-indigo-600,
    .historia-premium .bg-indigo-600,
    .odontograma-premium .bg-indigo-600 {
        background-color: var(--clinic-teal) !important;
    }
    .odontologia-premium .hover\:bg-indigo-600:hover,
    .historia-premium .hover\:bg-indigo-600:hover,
    .odontograma-premium .hover\:bg-indigo-600:hover {
        background-color: var(--clinic-teal-dark) !important;
    }
    .odontologia-premium .text-indigo-600,
    .odontologia-premium .text-indigo-700,
    .historia-premium .text-indigo-600,
    .historia-premium .text-indigo-700,
    .odontograma-premium .text-indigo-600,
    .odontograma-premium .text-indigo-700 {
        color: var(--clinic-teal-dark) !important;
    }
    .odontologia-premium .bg-indigo-50,
    .historia-premium .bg-indigo-50,
    .odontograma-premium .bg-indigo-50 {
        background-color: #eaf8f6 !important;
    }
    .odontologia-premium .border-indigo-100,
    .historia-premium .border-indigo-100,
    .odontograma-premium .border-indigo-100 {
        border-color: #bce8e2 !important;
    }
    .odontologia-premium input:focus,
    .odontologia-premium select:focus,
    .historia-premium input:focus,
    .historia-premium select:focus,
    .historia-premium textarea:focus,
    .odontograma-premium select:focus {
        border-color: var(--clinic-teal) !important;
        box-shadow: 0 0 0 4px rgba(15, 155, 145, 0.12) !important;
        outline: none;
    }
    .odontologia-premium .patient-card {
        transition:
            background-color 0.18s ease,
            border-color 0.18s ease;
    }
    .odontologia-premium .patient-card:hover {
        background-color: #f4fbfa !important;
    }
    .odontologia-premium #pagination-buttons button {
        min-width: 38px;
        min-height: 38px;
    }
    .odontologia-premium #pagination-buttons button[class*='bg-indigo-600'] {
        background-image: linear-gradient(135deg, #13a89e, #087f78) !important;
        border-color: transparent !important;
    }
    .historia-premium > div:first-child {
        border-top: 4px solid var(--clinic-teal);
        box-shadow: 0 12px 32px rgba(16, 35, 63, 0.07);
    }
    .historia-premium .bg-slate-50 {
        background-color: #f5f9fb;
    }
    .historia-premium .rounded-2xl {
        border-radius: 1.1rem;
    }
    .historia-premium .shadow-sm {
        box-shadow: 0 8px 24px rgba(16, 35, 63, 0.055);
    }
    .historia-premium .bg-rose-50\/50 {
        background-color: #fff7f7;
    }
    .historia-premium .border-slate-200,
    .historia-premium .border-slate-200\/80 {
        border-color: #dce7ed;
    }
    .historia-premium button[type='submit'] {
        background-image: linear-gradient(135deg, #13a89e, #087f78);
        box-shadow: 0 8px 18px rgba(8, 127, 120, 0.18);
    }
    .historia-premium button[type='submit']:hover {
        filter: brightness(0.95);
    }
    .historia-premium .text-slate-800 {
        color: #172b45;
    }
    .odontograma-premium {
        border-color: #dce7ed !important;
        box-shadow: 0 12px 32px rgba(16, 35, 63, 0.06) !important;
    }
    .odontograma-premium .palette-btn {
        border-radius: 0.8rem;
        min-height: 38px;
    }
    .odontograma-premium .ring-indigo-500 {
        --tw-ring-color: #0f9b91 !important;
    }
    .odontograma-premium #odontogram-scroll-container {
        background: linear-gradient(180deg, #f8fbfc, #f2f8f9) !important;
        border-color: #dce7ed !important;
    }
    .odontograma-premium [id$='-wrapper'] > span {
        color: #536b82 !important;
    }
    .odontograma-premium svg path,
    .odontograma-premium svg circle {
        transition:
            fill 0.12s ease,
            stroke 0.12s ease;
    }
    .odontologia-premium button:focus-visible,
    .odontologia-premium a:focus-visible,
    .historia-premium button:focus-visible,
    .historia-premium a:focus-visible,
    .historia-premium input:focus-visible,
    .historia-premium select:focus-visible,
    .historia-premium textarea:focus-visible,
    .odontograma-premium button:focus-visible {
        outline: 3px solid rgba(15, 155, 145, 0.32);
        outline-offset: 2px;
    }
    @media (max-width: 640px) {
        .odontologia-premium .patient-card {
            padding: 1rem !important;
        }
        .historia-premium > div:first-child {
            padding: 1rem !important;
        }
        .historia-premium .p-6 {
            padding: 1rem !important;
        }
        .odontograma-premium {
            padding: 1rem !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .odontologia-premium *,
        .historia-premium *,
        .odontograma-premium * {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
        }
    }
</style>
<div class="odontograma-premium bg-white p-4 sm:p-6 rounded-2xl shadow-sm border border-slate-200/80 mb-6 mt-6 sm:mt-10">
    <!-- Header y Paleta de colores -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 pb-4 border-b border-slate-100 gap-4">
        <div>
            <h2 class="text-lg sm:text-xl font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="activity" class="w-5 h-5 sm:w-6 sm:h-6 text-indigo-600"></i>
                Odontograma Clinico
            </h2>
            <p class="text-xs text-slate-500 mt-0.5">Selecciona una convención y toca sobre las secciones del diente para pintarlas.</p>
        </div>
        <!-- Paleta Dinámica (Desplazable en móviles) -->
        <div class="w-full lg:w-auto overflow-x-auto pb-1 sm:pb-0">
            <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200/80 min-w-max" id="palette-container">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-1 lg:hidden">Convención:</span>
                <?php if (!empty($convenciones) && is_array($convenciones)): ?>
                    <?php foreach ($convenciones as $index => $conv):
                                        $color  = is_array($conv) ? $conv['color'] : $conv->color;
                                        $nombre = is_array($conv) ? $conv['nombre'] : $conv->nombre;
                                        ?>
                    <button type="button" onclick="selectColor('<?= htmlspecialchars($color) ?>', this)" class="palette-btn <?= $index === 0 ? 'ring-2 ring-indigo-500 ring-offset-1' : '' ?> flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-700 shadow-xs border border-slate-200 hover:bg-slate-100 transition active:scale-95">
                        <span class="w-3 h-3 rounded-full border border-black/10 shrink-0" style="background-color: <?= htmlspecialchars($color) ?>;"></span>
                        <span class="whitespace-nowrap"><?= htmlspecialchars($nombre) ?></span>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <button type="button" onclick="selectColor('#ef4444', this)" class="palette-btn ring-2 ring-indigo-500 ring-offset-1 flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-700 shadow-xs border border-slate-200">
                    <span class="w-3 h-3 rounded-full bg-red-500 shrink-0"></span>
                    <span>Caries</span>
                </button>
                <button type="button" onclick="selectColor('#3b82f6', this)" class="palette-btn flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-white text-slate-700 shadow-xs border border-slate-200">
                    <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                    <span>Obturado</span>
                </button>
                <?php endif; ?>
                <button type="button" onclick="selectColor('#ffffff', this)" class="palette-btn flex items-center space-x-1.5 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 transition active:scale-95">
                    <i data-lucide="eraser" class="w-3.5 h-3.5"></i>
                    <span>Limpiar</span>
                </button>
            </div>
        </div>
    </div>
    <!-- Indicador de desplazamiento para móviles -->
    <div class="flex items-center justify-between sm:hidden mb-3 bg-indigo-50/70 border border-indigo-100 px-3 py-2 rounded-xl text-indigo-700 text-xs font-medium">
        <span class="flex items-center gap-1.5">
            <i data-lucide="move-horizontal" class="w-4 h-4 animate-pulse"></i>
            Desliza horizontalmente para examinar
        </span>
        <span class="text-[10px] bg-indigo-100 px-2 py-0.5 rounded-md font-bold">16x16</span>
    </div>
    <!-- Selector de vista rápida por cuadrante (Exclusivo para pantallas móviles) -->
    <div class="flex sm:hidden overflow-x-auto gap-1 mb-4 pb-1">
        <button type="button" onclick="scrollToQuadrant('row-adult-upper')" class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 whitespace-nowrap">Sup. Permanente</button>
        <button type="button" onclick="scrollToQuadrant('row-child-upper')" class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 whitespace-nowrap">Sup. Temporal</button>
        <button type="button" onclick="scrollToQuadrant('row-child-lower')" class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 whitespace-nowrap">Inf. Temporal</button>
        <button type="button" onclick="scrollToQuadrant('row-adult-lower')" class="text-[10px] font-bold px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 whitespace-nowrap">Inf. Permanente</button>
    </div>
    <!-- Campo Oculto para persistir estado -->
    <input type="hidden" name="odontograma_data" id="odontograma_data" value="{}">
    <!-- Odontograma Responsivo con Scroll Táctil -->
    <div class="relative w-full overflow-x-auto rounded-xl border border-slate-100 bg-slate-50/30 p-2 sm:p-4 touch-pan-x" id="odontogram-scroll-container">
        <div class="flex flex-col items-center gap-4 min-w-[920px] select-none py-2 mx-auto">
            <!-- Cuadrante Superior Permanente -->
            <div id="row-adult-upper-wrapper" class="w-full text-center">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Cuadrante Superior Permanente (18-28)</span>
                <div id="row-adult-upper" class="flex justify-center gap-1 sm:gap-1.5"></div>
            </div>
            <!-- Cuadrante Superior Temporal -->
            <div id="row-child-upper-wrapper" class="w-full bg-slate-100/60 p-2.5 rounded-2xl border border-slate-200/50 text-center">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Cuadrante Superior Temporal (55-65)</span>
                <div id="row-child-upper" class="flex justify-center gap-1 sm:gap-1.5"></div>
            </div>
            <!-- Cuadrante Inferior Temporal -->
            <div id="row-child-lower-wrapper" class="w-full bg-slate-100/60 p-2.5 rounded-2xl border border-slate-200/50 text-center">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Cuadrante Inferior Temporal (85-75)</span>
                <div id="row-child-lower" class="flex justify-center gap-1 sm:gap-1.5"></div>
            </div>
            <!-- Cuadrante Inferior Permanente -->
            <div id="row-adult-lower-wrapper" class="w-full text-center">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Cuadrante Inferior Permanente (48-38)</span>
                <div id="row-adult-lower" class="flex justify-center gap-1 sm:gap-1.5"></div>
            </div>
        </div>
    </div>
</div>
<script>
    let activeColor = '<?= !empty($convenciones[0]['color']) ? $convenciones[0]['color'] : "#ef4444" ?>';
    let odontogramaState = {};
    
    const adultUpper = [18, 17, 16, 15, 14, 13, 12, 11, 21, 22, 23, 24, 25, 26, 27, 28];
    const childUpper = [55, 54, 53, 52, 51, 61, 62, 63, 64, 65];
    const childLower = [85, 84, 83, 82, 81, 71, 72, 73, 74, 75];
    const adultLower = [48, 47, 46, 45, 44, 43, 42, 41, 31, 32, 33, 34, 35, 36, 37, 38];
    
    function selectColor(color, btnElement) {
        activeColor = color;
        document.querySelectorAll('.palette-btn').forEach((b) => {
            b.classList.remove('ring-2', 'ring-indigo-500', 'ring-offset-1');
        });
        if (btnElement) {
            btnElement.classList.add('ring-2', 'ring-indigo-500', 'ring-offset-1');
        }
    }
    
    // Renderiza un diente REDONDO con áreas táctiles optimizadas
    function renderToothSVG(number) {
        return `
            <div class="flex flex-col items-center bg-white p-1 sm:p-1.5 rounded-xl border border-slate-200/80 shadow-2xs hover:shadow-xs transition shrink-0">
                <span class="text-[10px] sm:text-[11px] font-bold text-slate-600 mb-1 font-mono">${number}</span>
                <svg width="44" height="44" viewBox="0 0 100 100" class="cursor-pointer sm:w-[48px] sm:h-[48px] touch-manipulation">
                    <!-- Arriba / Superior -->
                    <path d="M 14.64 14.64 A 50 50 0 0 1 85.36 14.64 L 67.68 32.32 A 25 25 0 0 0 32.32 32.32 Z"
                    fill="#ffffff" stroke="#475569" stroke-width="2.5" data-tooth="${number}" data-face="top" onclick="paintFace(this)"/>
    
                    <!-- Derecha -->
                    <path d="M 85.36 14.64 A 50 50 0 0 1 85.36 85.36 L 67.68 67.68 A 25 25 0 0 0 67.68 32.32 Z"
                    fill="#ffffff" stroke="#475569" stroke-width="2.5" data-tooth="${number}" data-face="right" onclick="paintFace(this)"/>
    
                    <!-- Abajo / Inferior -->
                    <path d="M 85.36 85.36 A 50 50 0 0 1 14.64 85.36 L 32.32 67.68 A 25 25 0 0 0 67.68 67.68 Z"
                    fill="#ffffff" stroke="#475569" stroke-width="2.5" data-tooth="${number}" data-face="bottom" onclick="paintFace(this)"/>
    
                    <!-- Izquierda -->
                    <path d="M 14.64 85.36 A 50 50 0 0 1 14.64 14.64 L 32.32 32.32 A 25 25 0 0 0 32.32 67.68 Z"
                    fill="#ffffff" stroke="#475569" stroke-width="2.5" data-tooth="${number}" data-face="left" onclick="paintFace(this)"/>
    
                    <!-- Centro -->
                    <circle cx="50" cy="50" r="25"
                    fill="#ffffff" stroke="#475569" stroke-width="2.5" data-tooth="${number}" data-face="center" onclick="paintFace(this)"/>
                </svg>
            </div>`;
    }
    
    function paintFace(element) {
        const tooth = element.getAttribute('data-tooth');
        const face = element.getAttribute('data-face');
        element.setAttribute('fill', activeColor);
    
        if (!odontogramaState[tooth]) odontogramaState[tooth] = {};
        odontogramaState[tooth][face] = activeColor;
        document.getElementById('odontograma_data').value = JSON.stringify(odontogramaState);
    }
    
    function loadRow(rowId, teethArray) {
        const container = document.getElementById(rowId);
        if (container) {
            container.innerHTML = teethArray.map((num) => renderToothSVG(num)).join('');
        }
    }
    
    function scrollToQuadrant(id) {
        const el = document.getElementById(id + '-wrapper');
        if (el) {
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    function loadOdontogramaState(dataJSON) {
        if (!dataJSON) return;
        try {
            odontogramaState = typeof dataJSON === 'string' ? JSON.parse(dataJSON) : dataJSON;
            document.getElementById('odontograma_data').value = JSON.stringify(odontogramaState);
    
            document.querySelectorAll('[data-tooth]').forEach((el) => el.setAttribute('fill', '#ffffff'));
    
            Object.keys(odontogramaState).forEach((tooth) => {
                Object.keys(odontogramaState[tooth]).forEach((face) => {
                    const element = document.querySelector(`[data-tooth="${tooth}"][data-face="${face}"]`);
                    if (element) element.setAttribute('fill', odontogramaState[tooth][face]);
                });
            });
        } catch (e) {
            console.error('Error al cargar estado del odontograma:', e);
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        loadRow('row-adult-upper', adultUpper);
        loadRow('row-child-upper', childUpper);
        loadRow('row-child-lower', childLower);
        loadRow('row-adult-lower', adultLower);
    });
</script>