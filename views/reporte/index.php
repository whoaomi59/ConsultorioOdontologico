<div id="reporte-print-area" class="space-y-8 pb-12">
    <!-- Encabezado Principal -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-8 rounded-3xl shadow-xl border border-slate-800 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold mb-3 border border-indigo-500/30 shadow-inner">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Dashboard Analítico Global
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Panel General del Consultorio</h1>
            <p class="text-xs md:text-sm text-slate-300 mt-1 max-w-xl leading-relaxed">
                Métricas absolutas, rendimiento histórico y análisis financiero consolidados de odontología y ortodoncia en tiempo real.
            </p>
        </div>
        <div class="relative z-10 flex items-center gap-3 no-print">
            <button onclick="window.location.reload();" class="px-4 py-2.5 bg-slate-800/80 hover:bg-slate-800 text-slate-200 text-xs font-semibold rounded-xl border border-slate-700 transition flex items-center gap-2 shadow-sm backdrop-blur">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i> Actualizar
            </button>
            <button onclick="window.print();" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-600/30 transition flex items-center gap-2">
                <i data-lucide="printer" class="w-4 h-4"></i> Imprimir Reporte
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
                <h3 class="text-3xl md:text-4xl font-black mt-4 tracking-tight text-white">
                    $<?= number_format($reporteGeneral['ortodoncia_evoluciones_stats']['valor_recaudado_total'] ?? 0, 2, ',', '.') ?>
                </h3>
            </div>
            <div class="mt-6 pt-4 border-t border-indigo-800/60 flex items-center justify-between text-xs text-indigo-200 font-medium">
                <span>Acumulado histórico global</span>
                <span class="text-emerald-400 font-bold flex items-center gap-1 bg-emerald-500/10 px-2.5 py-1 rounded-lg border border-emerald-500/20">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5"></i> Verificado
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
                <h3 class="text-3xl md:text-4xl font-black text-slate-800 mt-4 tracking-tight">
                    $<?= number_format($reporteGeneral['ortodoncia_evoluciones_stats']['valor_promedio_evolucion'] ?? 0, 2, ',', '.') ?>
                </h3>
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
                    $totalCitas    = $reporteGeneral['citas']['total'] > 0 ? $reporteGeneral['citas']['total'] : 1;
                    $atendidasPct  = round((($reporteGeneral['citas']['atendidas'] ?? 0) / $totalCitas) * 100);
                    $pendientesPct = round((($reporteGeneral['citas']['pendientes'] ?? 0) / $totalCitas) * 100);
                    $canceladasPct = round((($reporteGeneral['citas']['canceladas'] ?? 0) / $totalCitas) * 100);
                    ?>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                                Atendidas
                            </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['atendidas'] ?? 0) ?> <span class="text-slate-400 font-normal">(<?= $atendidasPct ?>%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                            <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: <?= $atendidasPct ?>%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/50"></span>
                                Pendientes
                            </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['pendientes'] ?? 0) ?> <span class="text-slate-400 font-normal">(<?= $pendientesPct ?>%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                            <div class="bg-amber-500 h-full rounded-full transition-all duration-500" style="width: <?= $pendientesPct ?>%;"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1.5">
                            <span class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span>
                                Canceladas
                            </span>
                            <span class="text-slate-900 font-extrabold"><?= number_format($reporteGeneral['citas']['canceladas'] ?? 0) ?> <span class="text-slate-400 font-normal">(<?= $canceladasPct ?>%)</span>
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 border border-slate-200/60">
                            <div class="bg-rose-500 h-full rounded-full transition-all duration-500" style="width: <?= $canceladasPct ?>%;"></div>
                        </div>
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
            <span class="text-xs bg-indigo-50 text-indigo-700 px-3.5 py-2 rounded-xl font-bold border border-indigo-100 shadow-sm">
                Histórico Consolidado
            </span>
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
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-indigo-500/20">
                                        <?= strtoupper(substr($doc['doctor_nombre'] ?? 'D', 0, 1)) ?>
                                    </div>
                                    <div>
                                        <span class="block text-slate-900 font-extrabold text-sm"><?= htmlspecialchars($doc['doctor_nombre'] ?? 'Sin asignar') ?></span>
                                        <span class="block text-[11px] text-indigo-600 font-semibold">Especialista en Ortodoncia</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-slate-500 font-medium">
                                    <?= htmlspecialchars($doc['doctor_email'] ?? 'No registrado') ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3 py-1.5 bg-blue-50 text-blue-700 rounded-xl font-extrabold text-xs border border-blue-100 shadow-sm">
                                        <?= number_format($doc['total_consultas']) ?> consultas
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right font-black text-emerald-600 text-sm">
                                    $<?= number_format($doc['valor_total'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-400 text-sm font-medium">
                                No hay registros financieros o de consultas de ortodoncia disponibles.
                            </td>
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
                                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center font-black text-xs shadow-md shadow-emerald-500/20">
                                        <?= strtoupper(substr($odonto['doctor_nombre'] ?? 'D', 0, 1)) ?>
                                    </div>
                                    <?= htmlspecialchars($odonto['doctor_nombre'] ?? 'Desconocido') ?>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="px-3.5 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl font-extrabold text-xs border border-emerald-100 shadow-sm">
                                        <?= number_format($odonto['total_consultas_odontologia']) ?> registros
                                    </span>
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
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
        body, html {
            visibility: visible !important;
            background: white !important;
            color: black !important;
        }

        #reporte-print-area, #reporte-print-area * {
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
</style>