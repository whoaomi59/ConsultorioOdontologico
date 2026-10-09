<div id="reporte-print-area" class="dashboard-premium space-y-8 pb-12">
    <!-- Encabezado Principal -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-8 rounded-3xl shadow-xl border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold mb-3 border border-indigo-500/30 shadow-inner">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                Dashboard Analítico Global
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Panel General del Consultorio</h1>
            <p class="text-xs md:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed"> Métricas absolutas, rendimiento histórico y análisis financiero consolidados de odontología y ortodoncia en tiempo real. </p>
        </div>
        <div class="relative z-10 flex items-center gap-3 no-print">
            <button onclick="window.location.reload();" class="px-4 py-2.5 bg-slate-800/80 hover:bg-slate-800 text-slate-200 text-xs font-semibold rounded-xl border border-slate-700 transition flex items-center gap-2 shadow-sm backdrop-blur">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                Actualizar
            </button>
            <button onclick="window.print();" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Imprimir Reporte
            </button>
        </div>
    </div>
    <!-- Bloque 1: Tarjetas de Resumen Principal (Globales) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Pacientes Registrados -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pacientes</p>
                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($reporteGeneral['pacientes_totales'] ?? 0) ?></h3>
                <div class="mt-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-100">
                    <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i>
                    <span><?= number_format($reporteGeneral['pacientes_con_historia'] ?? 0) ?> con historia clínica</span>
                </div>
            </div>
        </div>
        <!-- Citas Totales -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Citas Totales</p>
                <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="calendar" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($reporteGeneral['citas']['total'] ?? 0) ?></h3>
                <div class="mt-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-[11px] font-semibold border border-indigo-100">
                    <i data-lucide="activity" class="w-3.5 h-3.5"></i>
                    <span><?= number_format($reporteGeneral['citas']['atendidas'] ?? 0) ?> citas atendidas</span>
                </div>
            </div>
        </div>
        <!-- Historias Clínicas Generales -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hist. Generales</p>
                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($reporteGeneral['historias_clinicas_totales'] ?? 0) ?></h3>
                <div class="mt-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[11px] font-semibold border border-emerald-100">
                    <i data-lucide="folder-open" class="w-3.5 h-3.5"></i>
                    <span><?= number_format($reporteGeneral['historias_base_totales'] ?? 0) ?> registros base</span>
                </div>
            </div>
        </div>
        <!-- Ortodoncias Activas -->
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ortodoncias</p>
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-300">
                    <i data-lucide="smile" class="w-5 h-5"></i>
                </div>
            </div>
            <div class="mt-4">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight"><?= number_format($reporteGeneral['ortodoncias_diagnosticos'] ?? 0) ?></h3>
                <div class="mt-2.5 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 text-[11px] font-semibold border border-amber-100">
                    <i data-lucide="layers" class="w-3.5 h-3.5"></i>
                    <span><?= number_format($reporteGeneral['ortodoncia_evoluciones_stats']['total_evoluciones'] ?? 0) ?> controles total</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Bloque 2: Métricas Financieras y Estado de Citas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Recaudo Total -->
        <div class="bg-gradient-to-br from-indigo-900 via-slate-900 to-indigo-950 text-white p-7 rounded-3xl shadow-xl flex flex-col justify-between relative overflow-hidden border border-indigo-800/50">
            <div class="absolute right-0 top-0 w-48 h-48 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
            <div>
                <div class="flex justify-between items-center">
                    <p class="text-xs text-indigo-300 uppercase tracking-widest font-bold">Recaudo Total Ortodoncia</p>
                    <span class="p-2.5 bg-emerald-500/20 text-emerald-400 rounded-2xl border border-emerald-500/30 shadow-sm">
                        <i data-lucide="dollar-sign" class="w-5 h-5"></i>
                    </span>
                </div>
                <h3 class="text-3xl md:text-4xl font-black mt-4 tracking-tight text-white"> $<?= number_format($reporteGeneral['ortodoncia_evoluciones_stats']['valor_recaudado_total'] ?? 0, 2, ',', '.') ?></h3>
            </div>
            <div class="mt-6 pt-4 border-t border-indigo-800/60 flex items-center justify-between text-xs text-indigo-200 font-medium">
                <span>Acumulado histórico global</span>
                <span class="text-emerald-400 font-bold flex items-center gap-1 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                    Verificado
                </span>
            </div>
        </div>
        <!-- Promedio por Control -->
        <div class="bg-white p-7 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center">
                    <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">Valor Promedio por Control</p>
                    <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-2xl shadow-sm">
                        <i data-lucide="pie-chart" class="w-5 h-5"></i>
                    </div>
                </div>
                <h3 class="text-3xl md:text-4xl font-black text-slate-800 mt-4 tracking-tight"> $<?= number_format($reporteGeneral['ortodoncia_evoluciones_stats']['valor_promedio_evolucion'] ?? 0, 2, ',', '.') ?></h3>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                <span>Costo promedio por cita cobrada</span>
                <span class="font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg">Ortodoncia</span>
            </div>
        </div>
        <!-- Desglose de Estado de Citas -->
        <div class="bg-white p-7 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col justify-between">
            <div>
                <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-4">Estado General de Citas</p>
                <div class="space-y-3.5">
                    <?php
                    $totalCitas = $reporteGeneral['citas']['total'] > 0 ? $reporteGeneral['citas']['total'] : 1;
                    $atendidasPct = round((($reporteGeneral['citas']['atendidas'] ?? 0) / $totalCitas) * 100);
                    $pendientesPct = round((($reporteGeneral['citas']['pendientes'] ?? 0) / $totalCitas) * 100);
                    $canceladasPct = round((($reporteGeneral['citas']['canceladas'] ?? 0) / $totalCitas) * 100);
                    ?>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span> Atendidas </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['atendidas'] ?? 0) ?><span class="text-slate-400 font-normal">(<?= $atendidasPct ?>%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60"><div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: <?= $atendidasPct ?>%;"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/50"></span> Pendientes </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['pendientes'] ?? 0) ?><span class="text-slate-400 font-normal">(<?= $pendientesPct ?>%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60"><div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: <?= $pendientesPct ?>%;"></div></div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span> Canceladas </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['canceladas'] ?? 0) ?><span class="text-slate-400 font-normal">(<?= $canceladasPct ?>%)</span></span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60"><div class="bg-rose-500 h-full rounded-full transition-all duration-500" style="width: <?= $canceladasPct ?>%;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bloque 3: Rendimiento Financiero y de Consultas por Doctor de Ortodoncia -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/50">
            <div>
                <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2.5">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    Rendimiento por Doctor de Ortodoncia
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-medium">Volumen de controles realizados y recaudos financieros acumulados por especialista.</p>
            </div>
            <span class="text-xs bg-indigo-50 text-indigo-700 px-3.5 py-2 rounded-xl font-bold border border-indigo-100 shadow-sm"> Histórico Consolidado </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-100 font-bold">
                        <th class="py-4 px-6">Doctor(a) Especialista</th>
                        <th class="py-4 px-6">Correo Electrónico</th>
                        <th class="py-4 px-6 text-center">Consultas / Evoluciones</th>
                        <th class="py-4 px-6 text-right">Valor Total Acumulado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    <?php if (!empty($reporteGeneral['doctores_ortodoncia'])): ?>
                        <?php foreach ($reporteGeneral['doctores_ortodoncia'] as $doc): ?>
                            <tr class="hover:bg-indigo-50/40 transition duration-150">
                                <td class="py-4 px-6 font-bold text-slate-800 flex items-center gap-3.5">
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/20"><?= strtoupper(substr($doc['doctor_nombre'] ?? 'D', 0, 1)) ?></div>
                                    <div>
                                        <span class="block text-slate-900 font-extrabold text-sm"><?= htmlspecialchars($doc['doctor_nombre'] ?? 'Sin asignar') ?></span>
                                        <span class="block text-[11px] text-indigo-600 font-semibold">Especialista en Ortodoncia</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-medium"><?= htmlspecialchars($doc['doctor_email'] ?? 'No registrado') ?></td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl font-extrabold text-xs border border-blue-100 shadow-sm"><?= number_format($doc['total_consultas']) ?> consultas </span>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-emerald-600 text-sm"> $<?= number_format($doc['valor_total'], 2, ',', '.') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-sm font-medium"> No hay registros financieros o de consultas de ortodoncia disponibles. </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bloque 4: Rendimiento de Odontólogos Generales -->
    <?php if (!empty($reporteGeneral['doctores_odontologia'])): ?>
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2.5">
                    <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                        <i data-lucide="user-check" class="w-5 h-5"></i>
                    </div>
                    Consultas de Odontología General por Profesional
                </h2>
                <p class="text-xs text-slate-500 mt-1 font-medium">Cantidad de historias clínicas e intervenciones registradas por cada odontólogo general.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-100 font-bold">
                            <th class="py-4 px-6">Doctor(a) / Usuario</th>
                            <th class="py-4 px-6 text-center">Historias / Consultas Creadas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                        <?php foreach ($reporteGeneral['doctores_odontologia'] as $odonto): ?>
                            <tr class="hover:bg-emerald-50/30 transition duration-150">
                                <td class="py-4 px-6 font-bold text-slate-900 flex items-center gap-3.5 text-sm">
                                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-emerald-500/20"><?= strtoupper(substr($odonto['doctor_nombre'] ?? 'D', 0, 1)) ?></div>
                                    <?= htmlspecialchars($odonto['doctor_nombre'] ?? 'Desconocido') ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl font-extrabold text-xs border border-emerald-100 shadow-sm"><?= number_format($odonto['total_consultas_odontologia']) ?> registros </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- Carga correcta de iconos Lucide -->
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
<style>
    @media print {
        /* 1. Ocultar barras de navegación, sidebars, headers globales y botones de acción */
        nav,
        aside,
        header,
        footer,
        .no-print,
        button {
            display: none !important;
        }
    
        /* 2. Asegurar que el cuerpo y el contenedor principal muestren todo el contenido */
        body,
        html {
            visibility: visible !important;
            background: white !important;
            color: black !important;
        }
    
        #reporte-print-area,
        #reporte-print-area * {
            visibility: visible !important;
        }
    
        #reporte-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    }
    
    /* Dashboard premium: identidad visual del módulo de pacientes */
    .dashboard-premium {
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
    .dashboard-premium,
    .dashboard-premium * {
        box-sizing: border-box;
    }
    .dashboard-premium h1,
    .dashboard-premium h2,
    .dashboard-premium h3 {
        letter-spacing: -0.03em;
    }
    .dashboard-premium a:focus-visible,
    .dashboard-premium button:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.28);
        outline-offset: 3px;
    }
    .dashboard-premium > div:first-child {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        border: 1px solid #203960 !important;
        border-radius: 25px !important;
        background: linear-gradient(118deg, #111d38 0%, #2549a5 55%, #087f86 100%) !important;
        box-shadow: 0 18px 38px rgba(20, 40, 75, 0.17) !important;
    }
    .dashboard-premium > div:first-child::after {
        content: '';
        position: absolute;
        z-index: -1;
        right: -82px;
        top: -155px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.17);
        box-shadow:
            0 0 0 34px rgba(255, 255, 255, 0.025),
            0 0 0 72px rgba(255, 255, 255, 0.02);
        pointer-events: none;
    }
    .dashboard-premium > div:first-child h1 {
        color: #fff !important;
    }
    .dashboard-premium > div:first-child p {
        color: rgba(255, 255, 255, 0.78) !important;
    }
    .dashboard-premium > div:first-child .bg-indigo-500\/20 {
        color: #c8f5f0 !important;
        background: rgba(255, 255, 255, 0.13) !important;
        border-color: rgba(255, 255, 255, 0.22) !important;
    }
    .dashboard-premium > div:first-child button {
        min-height: 43px;
        border-radius: 13px !important;
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }
    .dashboard-premium > div:first-child button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(5, 15, 35, 0.2);
    }
    .dashboard-premium > .grid > div,
    .dashboard-premium .bg-white {
        border-color: var(--p-line) !important;
        border-radius: 22px !important;
        box-shadow: 0 8px 28px rgba(19, 38, 68, 0.055) !important;
    }
    .dashboard-premium > .grid:first-of-type > div {
        min-height: 185px;
        position: relative;
        overflow: hidden;
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease;
    }
    .dashboard-premium > .grid:first-of-type > div::after {
        content: '';
        position: absolute;
        right: -36px;
        bottom: -52px;
        width: 115px;
        height: 115px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(49, 94, 232, 0.07), rgba(14, 148, 136, 0.07));
        pointer-events: none;
    }
    .dashboard-premium > .grid:first-of-type > div:hover {
        transform: translateY(-4px);
        border-color: #cdd9f4 !important;
        box-shadow: 0 18px 36px rgba(19, 38, 68, 0.1) !important;
    }
    .dashboard-premium > .grid:first-of-type > div h3 {
        font-variant-numeric: tabular-nums;
        letter-spacing: -0.045em;
    }
    .dashboard-premium > .grid:first-of-type > div > div:first-child > div {
        border-radius: 15px !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div {
        border-radius: 22px !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:first-child {
        background: linear-gradient(135deg, #111d38 0%, #2549a5 56%, #087f86 100%) !important;
        border: 1px solid #203960 !important;
        box-shadow: 0 18px 38px rgba(20, 40, 75, 0.16) !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:first-child p {
        color: #b9c8f8 !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:first-child h3 {
        color: #fff !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:first-child .border-t {
        border-color: rgba(255, 255, 255, 0.17) !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:first-child .text-indigo-200 {
        color: rgba(255, 255, 255, 0.78) !important;
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:not(:first-child) {
        background: linear-gradient(145deg, #fff 0%, #f8fbff 100%);
    }
    .dashboard-premium > .grid:nth-of-type(2) > div:not(:first-child) h3 {
        color: #17243b !important;
        font-variant-numeric: tabular-nums;
    }
    .dashboard-premium .rounded-3xl {
        border-radius: 22px !important;
    }
    .dashboard-premium .rounded-2xl {
        border-radius: 16px !important;
    }
    .dashboard-premium .shadow-sm {
        box-shadow: 0 8px 28px rgba(19, 38, 68, 0.055) !important;
    }
    .dashboard-premium table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .dashboard-premium table thead th {
        background: #f5f8fc !important;
        color: #728096 !important;
        border-bottom: 1px solid #e4ebf4 !important;
        white-space: nowrap;
    }
    .dashboard-premium table tbody td {
        vertical-align: middle;
    }
    .dashboard-premium table tbody tr {
        transition: background 0.16s ease;
    }
    .dashboard-premium table tbody tr:hover {
        background: #f4f7ff !important;
    }
    .dashboard-premium table tbody tr:last-child td {
        border-bottom: 0;
    }
    .dashboard-premium > div.bg-white,
    .dashboard-premium .overflow-hidden.bg-white {
        overflow: hidden;
    }
    .dashboard-premium .border-slate-100,
    .dashboard-premium .border-slate-200\/80,
    .dashboard-premium .border-slate-200 {
        border-color: #e4ebf4 !important;
    }
    .dashboard-premium .text-slate-800 {
        color: #17243b;
    }
    .dashboard-premium .text-indigo-600 {
        color: #315ee8;
    }
    .dashboard-premium .bg-indigo-600 {
        background-color: #315ee8 !important;
    }
    .dashboard-premium .hover\:bg-indigo-500:hover {
        background-color: #244dcc !important;
    }
    .dashboard-premium .no-print button {
        box-shadow: 0 8px 18px rgba(5, 15, 35, 0.13);
    }
    @media (max-width: 700px) {
        .dashboard-premium > div:first-child {
            padding: 20px !important;
            border-radius: 20px !important;
        }
        .dashboard-premium > .grid:first-of-type > div {
            min-height: 165px;
        }
        .dashboard-premium > .grid > div {
            border-radius: 18px !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .dashboard-premium *,
        .dashboard-premium *::before,
        .dashboard-premium *::after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>