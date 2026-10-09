<?php
// Agrupar citas por fecha (YYYY-MM-DD) para pasarlas de forma limpia a JavaScript
$citasPorFecha = [];
if (!empty($citas)) {
    foreach ($citas as $c) {
        $fechaKey = date('Y-m-d', strtotime($c['fecha']));
        $citasPorFecha[$fechaKey][] = $c;
    }
}

// Configuración inicial
$hoy = date('Y-m-d');
$inicioSemana = date('Y-m-d', strtotime('monday this week'));

/*
|--------------------------------------------------------------------------
| FECHAS PERMITIDAS PARA EL USUARIO
|--------------------------------------------------------------------------
*/

$fechasPermitidas = [];
$horasInicioPorFecha = [];

if (!empty($fechasAtencion)) {
    foreach ($fechasAtencion as $fa) {
        $fechaKey = date('Y-m-d', strtotime($fa['fecha']));
        $fechasPermitidas[] = $fechaKey;
        $horasInicioPorFecha[$fechaKey] = substr($fa['hora_inicio'], 0, 5);
    }
}

$agendaDisponible = !empty($tieneCitasTotal) || !empty($fechasPermitidas);
$fechasBloqueadas = $fechasBloqueadas ?? [];

?>
<div class="max-w-7xl mx-auto space-y-6 font-sans pb-12 px-3 sm:px-6">
    <!-- Encabezado Principal Estilizado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-5 sm:p-7 rounded-3xl shadow-xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 w-full sm:w-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-semibold mb-2 border border-indigo-500/30">
                <i data-lucide="calendar-days" class="w-3.5 h-3.5"></i>
                Módulo de Gestión
            </div>
            <h1 class="text-xl sm:text-2xl font-black tracking-tight"> Agenda de Citas </h1>
            <p class="text-xs text-slate-300 mt-1"> Gestión, control e historial de citas médicas del sistema clínico en tiempo real. </p>
        </div>
        <?php if ($agendaDisponible): ?>
            <button id="btn-nueva-cita" class="relative z-10 w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white text-xs font-semibold px-5 py-3 rounded-2xl shadow-sm hover:shadow-md transition-all cursor-pointer">
                <i data-lucide="plus" class="w-4 h-4"></i>
                <span>Agendar Nueva Cita</span>
            </button>
        <?php endif; ?>
    </div>
    <?php if (!$agendaDisponible): ?>
        <div class="bg-amber-50 border border-amber-200 rounded-3xl p-8 text-center">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i data-lucide="calendar-off" class="w-7 h-7"></i>
            </div>
            <h2 class="text-lg font-black text-slate-800"> No tienes días de atención programados </h2>
            <p class="text-sm text-slate-500 mt-2 max-w-xl mx-auto"> Actualmente no tienes ninguna fecha asignada para atender pacientes. Cuando se programe un día de atención, aparecerá aquí tu agenda. </p>
        </div>
    <?php else: ?>
        <!-- Barra de Control: Navegación de Fechas y Cambiador de Vista -->
        <div class="bg-white p-4 rounded-3xl border border-slate-200/60 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto justify-between md:justify-start">
                <div class="inline-flex items-center gap-1 bg-slate-50/80 p-1.5 rounded-2xl border border-slate-200/60 w-full sm:w-auto justify-center">
                    <button type="button" id="btn-prev-date" class="p-2 hover:bg-white hover:shadow-xs rounded-xl text-slate-600 transition-all cursor-pointer" title="Anterior">
                        <i data-lucide="chevron-left" class="w-4 h-4"></i>
                    </button>
                    <button type="button" id="btn-today" class="px-3.5 py-1.5 text-xs font-bold text-slate-700 hover:bg-white hover:shadow-xs rounded-xl transition-all cursor-pointer"> Hoy </button>
                    <button type="button" id="btn-next-date" class="p-2 hover:bg-white hover:shadow-xs rounded-xl text-slate-600 transition-all cursor-pointer" title="Siguiente">
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                    </button>
                </div>
                <span id="period-label" class="text-xs sm:text-sm font-bold text-slate-800 tracking-tight px-2 text-center sm:text-left"> Semana actual </span>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto justify-center md:justify-end overflow-x-auto pb-1 md:pb-0">
                <div class="inline-flex bg-slate-100/80 p-1.5 rounded-2xl text-xs font-semibold border border-slate-200/40 shrink-0">
                    <button type="button" class="tab-btn active px-3 sm:px-4 py-2 rounded-xl text-indigo-600 bg-white shadow-xs transition-all cursor-pointer" data-view="semana">
                        <i data-lucide="calendar-days" class="w-3.5 h-3.5 inline mr-1.5"></i>
                        Semana
                    </button>
                    <button type="button" class="tab-btn px-3 sm:px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer" data-view="mes">
                        <i data-lucide="calendar-range" class="w-3.5 h-3.5 inline mr-1.5"></i>
                        Mes
                    </button>
                    <button type="button" class="tab-btn px-3 sm:px-4 py-2 rounded-xl text-slate-600 hover:text-slate-900 transition-all cursor-pointer" data-view="lista">
                        <i data-lucide="list" class="w-3.5 h-3.5 inline mr-1.5"></i>
                        Lista
                    </button>
                </div>
            </div>
        </div>
        <!-- VISTA 1: CALENDARIO SEMANAL DINÁMICO -->
        <div id="view-semana" class="view-content bg-white rounded-3xl border border-slate-200/60 shadow-xs overflow-hidden"><div class="overflow-x-auto"><div class="min-w-[768px]"><div id="semana-headers" class="grid grid-cols-7 border-b border-slate-200/60 bg-slate-50/50 text-center text-xs font-bold text-slate-600"></div><div id="semana-grid" class="grid grid-cols-7 divide-x divide-slate-100 min-h-[500px] bg-slate-50/10 text-xs"></div></div></div></div>
        <!-- VISTA 2: CALENDARIO MENSUAL DINÁMICO -->
        <div id="view-mes" class="view-content hidden bg-white rounded-3xl border border-slate-200/60 shadow-xs p-4 sm:p-6 overflow-x-auto"><div class="min-w-[650px]"><div class="grid grid-cols-7 gap-2 sm:gap-3 text-center text-[10px] sm:text-xs font-bold text-slate-400 mb-3 uppercase tracking-wider"><div>Domingo</div><div>Lunes</div><div>Martes</div><div>Miércoles</div><div>Jueves</div><div>Viernes</div><div>Sábado</div></div><div id="mes-grid" class="grid grid-cols-7 gap-2 sm:gap-3 text-xs"></div></div></div>
        <!-- VISTA 3: TABLA LISTA -->
        <div id="view-lista" class="view-content hidden bg-white rounded-3xl border border-slate-200/60 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse min-w-[700px]">
                    <thead class="bg-slate-50/60 border-b border-slate-200/60 text-slate-500 font-bold uppercase tracking-wider">
                        <tr>
                            <th class="p-4 sm:p-5">Horario</th>
                            <th class="p-4 sm:p-5">Paciente</th>
                            <th class="p-4 sm:p-5">Motivo</th>
                            <th class="p-4 sm:p-5">Estado</th>
                            <th class="p-4 sm:p-5 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <?php if (!empty($citas)): ?>
                            <?php foreach ($citas as $c): ?>
                                <?php
                                $horaFinText = !empty($c['hora_final']) ? date('h:i A', strtotime($c['hora_final'])) : 'N/A';
                                $esAtendida = $c['estado'] === 'atendida';
                                ?>
                                <tr class="hover:bg-slate-50/55 transition-colors">
                                    <td class="p-3.5 sm:p-4.5">
                                        <div class="inline-flex items-center gap-2.5 bg-amber-50/50 border border-amber-200/40 rounded-2xl p-2.5 pr-3.5 shadow-2xs">
                                            <div class="bg-amber-500/10 text-amber-700 p-2 rounded-xl">
                                                <i data-lucide="clock" class="w-4 h-4"></i>
                                            </div>
                                            <div><div class="font-bold text-slate-900 text-xs"><?= date('d/m/Y', strtotime($c['fecha'])) ?></div><div class="text-[11px] font-extrabold text-amber-700 tracking-wide mt-0.5"><?= date('h:i A', strtotime($c['hora'])) ?> - <?= $horaFinText ?></div></div>
                                        </div>
                                    </td>
                                    <td class="p-3.5 sm:p-4.5">
                                        <div class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($c['paciente_nombre'] . ' ' . $c['paciente_apellido']) ?></div>
                                        <span class="inline-block text-[11px] font-medium text-slate-400 mt-0.5"> Tel: <?= htmlspecialchars($c['paciente_telefono'] ?? 'No registrado') ?></span>
                                    </td>
                                    <td class="p-3.5 sm:p-4.5 text-slate-600 max-w-xs truncate font-medium"><?= htmlspecialchars($c['motivo']) ?></td>
                                    <td class="p-3.5 sm:p-4.5">
                                        <?php
                                        $badge = match ($c['estado']) {
                                            'atendida' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'cancelada' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                            default => 'bg-amber-50 text-amber-700 border-amber-200/60',
                                        };
                                        $dot = match ($c['estado']) {
                                            'atendida' => 'bg-emerald-500',
                                            'cancelada' => 'bg-rose-500',
                                            default => 'bg-amber-500',
                                        };
                                        ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border text-[11px] font-bold tracking-wide capitalize shadow-2xs <?= $badge ?>"><span class="w-2 h-2 rounded-full <?= $dot ?>"></span><?= $c['estado'] ?></span>
                                    </td>
                                    <td class="p-3.5 sm:p-4.5 text-right">
                                        <div class="inline-flex items-center justify-end gap-1.5 flex-wrap">
                                            <button type="button" class="px-3 py-1.5 text-indigo-700 hover:bg-indigo-50 bg-indigo-50/40 border border-indigo-100/80 rounded-xl font-bold text-xs transition-all btn-editar-cita cursor-pointer shadow-2xs" data-id="<?= $c['id'] ?>" data-paciente-id="<?= $c['paciente_id'] ?>" data-paciente-nombre="<?= htmlspecialchars($c['paciente_nombre'] . ' ' .$c['paciente_apellido'], ENT_QUOTES) ?>" data-fecha="<?= $c['fecha'] ?>" data-hora="<?= $c['hora'] ?>" data-hora-fin="<?= $c['hora_final'] ?? '' ?>" data-motivo="<?= htmlspecialchars($c['motivo'], ENT_QUOTES) ?>" data-estado="<?= $c['estado'] ?>"><?= $esAtendida ? 'Ver Detalles' : 'Editar' ?></button>
                                            <?php if (!$esAtendida): ?>
                                                <a href="<?= BASE_URL ?>/cita/cambiarEstado/<?= $c['id'] ?>?estado=atendida" class="px-3 py-1.5 text-emerald-700 hover:bg-emerald-50 bg-emerald-50/40 border border-emerald-100/80 rounded-xl font-bold text-xs transition-all shadow-2xs">Atendida</a>
                                                <a href="<?= BASE_URL ?>/cita/cambiarEstado/<?= $c['id'] ?>?estado=cancelada" class="px-3 py-1.5 text-rose-700 hover:bg-rose-50 bg-rose-50/40 border border-rose-100/80 rounded-xl font-bold text-xs transition-all shadow-2xs">Cancelar</a>
                                            <?php else: ?>
                                                <span class="px-3 py-1.5 text-slate-400 bg-slate-100 border border-slate-200 rounded-xl font-bold text-xs cursor-not-allowed" title="Cita finalizada, no se puede modificar">Finalizada</span>
                                            <?php endif; ?>
                                            <a href="<?= BASE_URL ?>/cita/eliminar/<?= $c['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta cita?')" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all ml-1" title="Eliminar Cita">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-16 text-center text-slate-400">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                                        <i data-lucide="calendar-x" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-600">No hay citas registradas</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Comienza agendando una nueva cita médica en el botón superior.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>
<!-- Modal: Registrar o Editar Cita -->
<div id="modal-cita" class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4 transition-all opacity-0 pointer-events-none duration-200">
    <div id="modal-contenido" class="bg-white rounded-3xl max-w-lg w-full p-5 sm:p-7 space-y-6 shadow-2xl border border-slate-100 transform scale-95 transition-all duration-200 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center border-b border-slate-100 pb-4">
            <div>
                <h3 id="modal-titulo" class="text-base sm:text-lg font-bold text-slate-900">Agendar Nueva Cita</h3>
                <p id="modal-subtitulo" class="text-xs text-slate-500 mt-0.5">Complete los detalles para programar la atención médica.</p>
            </div>
            <button type="button" id="btn-cerrar-modal" class="text-slate-400 hover:text-slate-600 p-2 hover:bg-slate-100 rounded-xl transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>
        <form action="<?= BASE_URL ?>/cita/guardar" method="POST" class="space-y-4 text-xs">
            <input type="hidden" name="id" id="cita_id_hidden">
            <input type="hidden" id="estado_original_hidden" value="">
            <!-- Autocompletado Paciente -->
            <div class="relative">
                <label class="block font-bold text-slate-700 mb-2">
                    Paciente
                    <span class="text-rose-500">*</span>
                </label>
                <input type="hidden" name="paciente_id" id="paciente_id_hidden" required>
                <div class="relative">
                    <input type="text" id="buscador-paciente-input" placeholder="Escribe el nombre o documento del paciente..." autocomplete="off" class="w-full px-3.5 py-3 pl-10 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs" required>
                    <i data-lucide="search" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5"></i>
                </div>
                <div id="sugerencias-box" class="absolute left-0 right-0 mt-1 bg-white border border-slate-200 rounded-2xl shadow-xl max-h-48 overflow-y-auto z-50 hidden divide-y divide-slate-100"></div>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-2">
                    Fecha
                    <span class="text-rose-500">*</span>
                </label>
                <input type="date" name="fecha" id="input_fecha" required class="w-full px-3.5 py-3 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs">
            </div>
            <!-- Horas: Inicio y Fin -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div class="col-span-2 transition-all duration-300" id="contenedor-hora-inicio">
                    <label class="block font-bold text-slate-700 mb-2">
                        Hora de Inicio
                        <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" name="hora" id="input_hora" required class="w-full px-3.5 py-3 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs">
                </div>
                <!-- Hora Final: Oculta al crear, visible solo al editar -->
                <div class="col-span-2 hidden transition-all duration-300" id="grupo-hora-final">
                    <label class="block font-bold text-slate-700 mb-2">Hora Final</label>
                    <input type="time" name="hora_final" id="input_hora_fin" class="w-full px-3.5 py-3 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs">
                </div>
            </div>
            <!-- Selector de Estado de la Cita -->
            <div id="contenedor-estado-cita" class="hidden">
                <label class="block font-bold text-slate-700 mb-2"> Estado de la Cita </label>
                <select name="estado" id="input_estado" class="w-full px-3.5 py-3 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs">
                    <option value="pendiente">Pendiente</option>
                    <option value="atendida">Atendida</option>
                    <option value="cancelada">Cancelada</option>
                </select>
                <p id="alerta-estado-atendida" class="text-[11px] text-emerald-600 font-bold mt-1.5 hidden flex items-center gap-1">
                    <i data-lucide="lock" class="w-3.5 h-3.5 inline"></i>
                    Esta cita ya fue atendida. Sus datos están bloqueados y no se pueden modificar.
                </p>
            </div>
            <div>
                <label class="block font-bold text-slate-700 mb-2">Motivo de Consulta</label>
                <textarea name="motivo" id="input_motivo" rows="3" placeholder="Ej. Procedimiento largo, control u ortodoncia avanzada" class="w-full px-3.5 py-3 bg-slate-50/80 border border-slate-200/80 rounded-2xl text-slate-800 font-medium focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-2xs resize-none"></textarea>
            </div>
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 pt-4 border-t border-slate-100" id="contenedor-botones-modal">
                <button type="button" id="btn-cancelar-modal" class="w-full sm:w-auto px-5 py-2.5 border border-slate-200 hover:bg-slate-50 rounded-2xl font-bold text-slate-600 transition-all cursor-pointer text-center">Cancelar</button>
                <button type="submit" id="btn-guardar-cambios" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold rounded-2xl shadow-sm transition-all cursor-pointer text-center">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
        const BASE_URL = '<?= BASE_URL ?>';
    
        const citasData = <?= json_encode(
            $citasPorFecha,
            JSON_UNESCAPED_UNICODE
            ) ?>;
    
        const tieneCitasTotal = <?= !empty($tieneCitasTotal) ? 'true' : 'false' ?>;
    
        const fechasPermitidas = <?= json_encode(array_values($fechasPermitidas)) ?>;
    
        const fechasBloqueadas = <?= json_encode(array_values($fechasBloqueadas)) ?>;
    
        const horasInicioPorFecha = <?= json_encode($horasInicioPorFecha) ?>;
    
        let fechaActual = new Date();
    
        if (!tieneCitasTotal && fechasPermitidas.length > 0) {
            fechaActual = new Date(fechasPermitidas[0] + 'T00:00:00');
        }
        function fechaEstaPermitida(fecha) {
            if (tieneCitasTotal) {
                return !fechasBloqueadas.includes(fecha);
            }
            return fechasPermitidas.includes(fecha);
        }
        ///
    
        const periodLabel = document.getElementById('period-label');
        const semanaHeaders = document.getElementById('semana-headers');
        const semanaGrid = document.getElementById('semana-grid');
        const mesGrid = document.getElementById('mes-grid');
    
        function getMonday(d) {
            d = new Date(d);
            let day = d.getDay();
            let diff = d.getDate() - day + (day === 0 ? -6 : 1);
            return new Date(d.setDate(diff));
        }
    
        function formatDateKey(date) {
            let d = new Date(date);
            let month = '' + (d.getMonth() + 1);
            let day = '' + d.getDate();
            let year = d.getFullYear();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;
            return [year, month, day].join('-');
        }
    
        const modalCita = document.getElementById('modal-cita');
        const modalContenido = document.getElementById('modal-contenido');
        const modalTitulo = document.getElementById('modal-titulo');
        const modalSubtitulo = document.getElementById('modal-subtitulo');
    
        function abrirModal() {
            modalCita.classList.remove('hidden');
            setTimeout(() => {
                modalCita.classList.remove('opacity-0', 'pointer-events-none');
                modalContenido.classList.remove('scale-95');
                modalContenido.classList.add('scale-100');
            }, 10);
        }
    
        function cerrarModal() {
            modalCita.classList.add('opacity-0', 'pointer-events-none');
            modalContenido.classList.remove('scale-100');
            modalContenido.classList.add('scale-95');
            setTimeout(() => {
                modalCita.classList.add('hidden');
            }, 200);
        }
    
        function renderSemana() {
            semanaHeaders.innerHTML = '';
            semanaGrid.innerHTML = '';
    
            let lunes = getMonday(fechaActual);
            let diasNombres = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            let hoyStr = formatDateKey(new Date());
    
            let inicioLabel = '';
            let finLabel = '';
    
            for (let i = 0; i < 7; i++) {
                let d = new Date(lunes);
    
                d.setDate(lunes.getDate() + i);
    
                let fechaStr = formatDateKey(d);
    
                // Los usuarios sin citas_total solamente pueden
                // visualizar sus fechas programadas.
                if (!fechaEstaPermitida(fechaStr)) {
                    continue;
                }
    
                let esHoy = fechaStr === hoyStr;
    
                if (i === 0) inicioLabel = d.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
                if (i === 6) finLabel = d.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    
                let headerDiv = document.createElement('div');
                headerDiv.className = `p-3.5 border-r border-slate-100 border-b-2 ${esHoy ? 'border-b-indigo-600 bg-indigo-50/40 text-indigo-700 font-bold' : 'border-b-transparent text-slate-500'}`;
                headerDiv.innerHTML = `<div class="uppercase tracking-wider text-[11px]">${diasNombres[i]}</div>
                    <div class="text-xs ${esHoy ? 'text-indigo-600 font-bold bg-white inline-block px-2 py-0.5 rounded-full shadow-2xs mt-1' : 'text-slate-400 font-semibold'} mt-0.5">${d.getDate()}/${d.getMonth() + 1}</div>`;
                semanaHeaders.appendChild(headerDiv);
    
                let colDiv = document.createElement('div');
                colDiv.className = `p-2.5 space-y-3 ${esHoy ? 'bg-indigo-50/10' : ''}`;
    
                let citasDia = citasData[fechaStr] || [];
                citasDia.forEach((c) => {
                    let cardBg =
                        c.estado === 'atendida'
                            ? 'bg-emerald-50/80 border-emerald-200/60 text-emerald-900 hover:bg-emerald-100/60'
                            : c.estado === 'cancelada'
                              ? 'bg-rose-50/80 border-rose-200/60 text-rose-900 opacity-60 hover:bg-rose-100/60'
                              : 'bg-amber-50/80 border-amber-200/60 text-amber-900 hover:bg-amber-100/60';
                    let dotColor = c.estado === 'atendida' ? 'bg-emerald-500' : c.estado === 'cancelada' ? 'bg-rose-500' : 'bg-amber-500';
    
                    let horaFinStr = c.hora_final ? c.hora_final : '';
    
                    let card = document.createElement('div');
                    card.className = `p-3.5 border rounded-2xl shadow-2xs hover:shadow-md transition-all cursor-pointer btn-editar-cita ${cardBg}`;
    
                    card.dataset.id = c.id;
                    card.dataset.pacienteId = c.paciente_id;
                    card.dataset.pacienteNombre = `${c.paciente_nombre} ${c.paciente_apellido}`;
                    card.dataset.fecha = c.fecha;
                    card.dataset.hora = c.hora;
                    card.dataset.horaFin = c.hora_final || '';
                    card.dataset.motivo = c.motivo;
                    card.dataset.estado = c.estado;
    
                    card.innerHTML = `
                        <div class="flex items-center justify-between text-[11px] font-bold pb-1.5 border-b border-black/5">
                            <span class="flex items-center gap-1">
                                <i data-lucide="clock" class="w-3 h-3"></i>
                                ${c.hora}${horaFinStr ? ' - ' + horaFinStr : ''}
                            </span>
                            <span class="w-2 h-2 rounded-full ${dotColor} shadow-xs"></span>
                        </div>
                        <div class="font-bold text-slate-900 mt-2 truncate text-xs ${c.estado === 'cancelada' ? 'line-through' : ''}">${c.paciente_nombre} ${c.paciente_apellido}</div>
                        <p class="text-[10px] text-slate-500 truncate mt-1 font-medium bg-white/60 p-1.5 rounded-xl border border-black/5">${c.motivo || 'Sin motivo especificado'}</p>
                        `;
    
                    colDiv.appendChild(card);
                });
                semanaGrid.appendChild(colDiv);
            }
            periodLabel.textContent = `Semana del ${inicioLabel} al ${finLabel}`;
            lucide.createIcons();
        }
    
        function renderMes() {
            mesGrid.innerHTML = '';
            let year = fechaActual.getFullYear();
            let month = fechaActual.getMonth();
    
            let primerDiaMes = new Date(year, month, 1);
            let ultimoDiaMes = new Date(year, month + 1, 0);
            let offset = primerDiaMes.getDay();
            let diasEnMes = ultimoDiaMes.getDate();
            let hoyStr = formatDateKey(new Date());
    
            periodLabel.textContent = primerDiaMes.toLocaleDateString('es-ES', { month: 'long', year: 'numeric' }).toUpperCase();
    
            for (let i = 0; i < offset; i++) {
                let blank = document.createElement('div');
                blank.className = 'min-h-[80px] sm:min-h-[95px] p-2 sm:p-2.5 border border-slate-100 rounded-2xl bg-slate-50/10 opacity-20';
                mesGrid.appendChild(blank);
            }
    
            for (let dia = 1; dia <= diasEnMes; dia++) {
                let fechaFormato = `${year}-${String(month + 1).padStart(2, '0')}-${String(dia).padStart(2, '0')}`;
    
                // Los usuarios sin citas_total solamente pueden
                // visualizar sus fechas programadas.
                if (!fechaEstaPermitida(fechaFormato)) {
                    continue;
                }
    
                let countCitas = (citasData[fechaFormato] || []).length;
                let esHoyMes = fechaFormato === hoyStr;
    
                let cell = document.createElement('div');
                cell.className = `min-h-[80px] sm:min-h-[95px] p-2 sm:p-3 border ${esHoyMes ? 'border-indigo-400 bg-indigo-50/20 shadow-xs' : 'border-slate-100 bg-slate-50/30'} rounded-2xl flex flex-col justify-between hover:border-indigo-300 transition-all`;
    
                let badgeHtml =
                    countCitas > 0
                        ? `<div class="bg-indigo-600 text-white text-[9px] sm:text-[10px] font-bold px-1.5 sm:px-2 py-1 rounded-xl text-center shadow-xs flex items-center justify-center gap-1">
                        <i data-lucide="calendar" class="w-3 h-3 hidden sm:inline"></i>
                        ${countCitas} ${countCitas === 1 ? 'Cita' : 'Citas'}
                    </div>`
                        : '';
                cell.innerHTML = `<span class="font-bold text-xs ${esHoyMes ? 'text-indigo-600 bg-white w-6 h-6 sm:w-7 sm:h-7 rounded-full flex items-center justify-center shadow-2xs' : 'text-slate-700'}">${dia}</span>${badgeHtml}`;
                mesGrid.appendChild(cell);
            }
            lucide.createIcons();
        }
    
        document.getElementById('btn-prev-date').addEventListener('click', () => {
            let activeTab = document.querySelector('.tab-btn.active').dataset.view;
            if (activeTab === 'semana') {
                fechaActual.setDate(fechaActual.getDate() - 7);
                renderSemana();
            } else if (activeTab === 'mes') {
                fechaActual.setMonth(fechaActual.getMonth() - 1);
                renderMes();
            }
        });
    
        document.getElementById('btn-next-date').addEventListener('click', () => {
            let activeTab = document.querySelector('.tab-btn.active').dataset.view;
            if (activeTab === 'semana') {
                fechaActual.setDate(fechaActual.getDate() + 7);
                renderSemana();
            } else if (activeTab === 'mes') {
                fechaActual.setMonth(fechaActual.getMonth() + 1);
                renderMes();
            }
        });
    
        document.getElementById('btn-today').addEventListener('click', () => {
            fechaActual = new Date();
            let activeTab = document.querySelector('.tab-btn.active').dataset.view;
            if (activeTab === 'semana') renderSemana();
            else if (activeTab === 'mes') renderMes();
        });
    
        const tabs = document.querySelectorAll('.tab-btn');
        const viewContents = document.querySelectorAll('.view-content');
    
        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const targetView = tab.dataset.view;
                tabs.forEach((t) => {
                    t.classList.remove('active', 'bg-white', 'text-indigo-600', 'shadow-xs');
                    t.classList.add('text-slate-600');
                });
                tab.classList.add('active', 'bg-white', 'text-indigo-600', 'shadow-xs');
                tab.classList.remove('text-slate-600');
    
                viewContents.forEach((view) => {
                    if (view.id === `view-${targetView}`) {
                        view.classList.remove('hidden');
                    } else {
                        view.classList.add('hidden');
                    }
                });
    
                if (targetView === 'semana') renderSemana();
                if (targetView === 'mes') renderMes();
            });
        });
    
        document.getElementById('btn-nueva-cita')?.addEventListener('click', () => {
            modalTitulo.textContent = 'Agendar Nueva Cita';
            modalSubtitulo.textContent = 'Complete los detalles para programar la atención médica.';
    
            document.getElementById('cita_id_hidden').value = '';
    
            // Nueva cita: estado original vacío
            document.getElementById('estado_original_hidden').value = '';
    
            document.getElementById('paciente_id_hidden').value = '';
            document.getElementById('buscador-paciente-input').value = '';
            document.getElementById('buscador-paciente-input').disabled = false;
    
            document.getElementById('input_fecha').value = '';
            document.getElementById('input_fecha').disabled = false;
    
            document.getElementById('input_hora').value = '';
            document.getElementById('input_hora').disabled = false;
    
            document.getElementById('input_hora_fin').value = '';
            document.getElementById('input_hora_fin').disabled = false;
    
            document.getElementById('grupo-hora-final').classList.add('hidden');
            document.getElementById('contenedor-hora-inicio').className = 'col-span-4';
    
            // Estado oculto al crear
            const contenedorEstado = document.getElementById('contenedor-estado-cita');
    
            const selectEstado = document.getElementById('input_estado');
    
            selectEstado.value = 'pendiente';
            selectEstado.disabled = false;
    
            contenedorEstado.classList.add('hidden');
    
            selectEstado.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-500');
    
            document.getElementById('alerta-estado-atendida').classList.add('hidden');
    
            document.getElementById('input_motivo').value = '';
            document.getElementById('input_motivo').disabled = false;
    
            document.getElementById('btn-guardar-cambios').classList.remove('hidden');
    
            abrirModal();
        });
    
        document.addEventListener('click', (e) => {
            const btnEditar = e.target.closest('.btn-editar-cita');
            if (!btnEditar) return;
    
            e.stopPropagation();
    
            const estadoActual = btnEditar.dataset.estado || 'pendiente';
            const esAtendida = estadoActual === 'atendida';
    
            // Guardamos el estado ORIGINAL de la cita
            document.getElementById('estado_original_hidden').value = estadoActual;
    
            // Al editar sí mostramos el selector de estado
            document.getElementById('contenedor-estado-cita').classList.remove('hidden');
    
            if (esAtendida) {
                modalTitulo.textContent = 'Detalles de Cita Atendida';
                modalSubtitulo.textContent = 'Esta cita se encuentra finalizada y sus datos están protegidos contra modificaciones.';
            } else {
                modalTitulo.textContent = 'Editar Cita y Horarios';
                modalSubtitulo.textContent = 'Modifique los detalles de la cita seleccionada.';
            }
    
            document.getElementById('cita_id_hidden').value = btnEditar.dataset.id || '';
            document.getElementById('paciente_id_hidden').value = btnEditar.dataset.pacienteId || '';
    
            const inputBuscador = document.getElementById('buscador-paciente-input');
            inputBuscador.value = btnEditar.dataset.pacienteNombre || '';
    
            const inputFecha = document.getElementById('input_fecha');
            inputFecha.value = btnEditar.dataset.fecha || '';
    
            const inputHora = document.getElementById('input_hora');
            inputHora.value = btnEditar.dataset.hora || '';
    
            const inputHoraFin = document.getElementById('input_hora_fin');
            const grupoHoraFinal = document.getElementById('grupo-hora-final');
            const contenedorHoraInicio = document.getElementById('contenedor-hora-inicio');
    
            inputHoraFin.value = btnEditar.dataset.horaFin || '';
            grupoHoraFinal.classList.remove('hidden');
            contenedorHoraInicio.className = 'col-span-2';
    
            const selectEstado = document.getElementById('input_estado');
            const alertaAtendida = document.getElementById('alerta-estado-atendida');
            const btnGuardar = document.getElementById('btn-guardar-cambios');
            const inputMotivo = document.getElementById('input_motivo');
    
            selectEstado.value = estadoActual;
            inputMotivo.value = btnEditar.dataset.motivo || '';
    
            // Bloquear o desbloquear formulario completo según estado
            if (esAtendida) {
                inputBuscador.disabled = true;
                inputFecha.disabled = true;
                inputHora.disabled = true;
                inputHoraFin.disabled = true;
                inputMotivo.disabled = true;
                selectEstado.disabled = true;
    
                // Estilos visuales de bloqueo total
                [inputBuscador, inputFecha, inputHora, inputHoraFin, inputMotivo, selectEstado].forEach((el) => {
                    el.classList.add('bg-slate-100', 'cursor-not-allowed', 'text-slate-500');
                });
    
                alertaAtendida.classList.remove('hidden');
                btnGuardar.classList.add('hidden'); // Ocultar botón guardar porque no hay nada que actualizar
            } else {
                inputBuscador.disabled = false;
                inputFecha.disabled = false;
                inputHora.disabled = false;
                inputHoraFin.disabled = false;
                inputMotivo.disabled = false;
                selectEstado.disabled = false;
    
                [inputBuscador, inputFecha, inputHora, inputHoraFin, inputMotivo, selectEstado].forEach((el) => {
                    el.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-500');
                });
    
                alertaAtendida.classList.add('hidden');
                btnGuardar.classList.remove('hidden');
            }
    
            abrirModal();
        });
    
        // Asegurar campos habilitados antes de enviar (por si acaso el navegador bloquea disabled al enviar)
        // Validaciones antes de guardar
        document.querySelector('#modal-cita form').addEventListener('submit', function (e) {
            const pacienteId = document.getElementById('paciente_id_hidden').value.trim();
    
            const estadoOriginal = document.getElementById('estado_original_hidden').value;
    
            // Validar paciente
            if (!pacienteId || !/^\d+$/.test(pacienteId) || parseInt(pacienteId, 10) <= 0) {
                e.preventDefault();
    
                alert('Debes seleccionar un paciente válido de la lista antes de guardar la cita.');
    
                document.getElementById('buscador-paciente-input').focus();
    
                return;
            }
    
            /*
             * IMPORTANTE:
             *
             * Solo bloqueamos si la cita YA estaba atendida.
             *
             * Si estaba pendiente y ahora pasa a atendida,
             * sí permitimos guardar.
             */
            if (estadoOriginal === 'atendida') {
                e.preventDefault();
    
                alert('Esta cita ya fue atendida y no puede modificarse.');
    
                cerrarModal();
    
                return;
            }
    
            // Si llegamos aquí:
            // pendiente -> atendida     ✅
            // pendiente -> cancelada    ✅
            // pendiente -> pendiente    ✅
            // nueva cita                ✅
    
            // Aseguramos que el estado viaje al servidor
            document.getElementById('input_estado').disabled = false;
        });
    
        document.getElementById('btn-cerrar-modal')?.addEventListener('click', cerrarModal);
        document.getElementById('btn-cancelar-modal')?.addEventListener('click', cerrarModal);
    
        const inputBuscador = document.getElementById('buscador-paciente-input');
        const hiddenPacienteId = document.getElementById('paciente_id_hidden');
        const sugerenciasBox = document.getElementById('sugerencias-box');
    
        const pacientesLista = [
            <?php foreach ($pacientes as$p): ?> {
                id: '<?= $p['id'] ?>',
                nombre: '<?= htmlspecialchars($p['nombre'] . ' ' .$p['apellido'], ENT_QUOTES) ?>',
                documento: '<?= htmlspecialchars($p['documento'] ?? 'Sin documento', ENT_QUOTES) ?>',
            },
            <?php endforeach; ?>
        ];
    
        if (inputBuscador && sugerenciasBox) {
            inputBuscador.addEventListener('input', (e) => {
                if (inputBuscador.disabled) return;
                const query = e.target.value.toLowerCase().trim();
                hiddenPacienteId.value = '';
    
                if (query.length === 0) {
                    sugerenciasBox.classList.add('hidden');
                    sugerenciasBox.innerHTML = '';
                    return;
                }
    
                const filtrados = pacientesLista.filter((p) => p.nombre.toLowerCase().includes(query) || p.documento.toLowerCase().includes(query));
    
                if (filtrados.length > 0) {
                    sugerenciasBox.innerHTML = '';
                    filtrados.forEach((p) => {
                        const div = document.createElement('div');
                        div.className = 'p-3 hover:bg-indigo-50 cursor-pointer transition-colors';
                        div.innerHTML = `<div class="font-bold text-slate-800">${p.nombre}</div>
                            <div class="text-[10px] text-slate-500 font-medium">Doc: ${p.documento}</div>`;
    
                        div.addEventListener('click', () => {
                            inputBuscador.value = `${p.nombre} (${p.documento})`;
                            hiddenPacienteId.value = p.id;
                            sugerenciasBox.classList.add('hidden');
                        });
                        sugerenciasBox.appendChild(div);
                    });
                    sugerenciasBox.classList.remove('hidden');
                } else {
                    sugerenciasBox.innerHTML = '<div class="p-4 text-slate-400 text-center font-medium">No se encontraron pacientes</div>';
                    sugerenciasBox.classList.remove('hidden');
                }
            });
    
            document.addEventListener('click', (e) => {
                if (!inputBuscador.contains(e.target) && !sugerenciasBox.contains(e.target)) {
                    sugerenciasBox.classList.add('hidden');
                }
            });
        }
    
        renderSemana();
    });
</script>