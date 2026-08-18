<?php
// Agrupar citas por fecha (YYYY-MM-DD) para construir los calendarios dinámicamente
$citasPorFecha = [];
if (!empty($citas)) {
    foreach ($citas as $c) {
        $fechaKey                   = date('Y-m-d', strtotime($c['fecha']));
        $citasPorFecha[$fechaKey][] = $c;
    }
}

// Configuración de la semana actual
$hoy          = date('Y-m-d');
$inicioSemana = date('Y-m-d', strtotime('monday this week'));
?>

<div class="max-w-6xl mx-auto space-y-6 font-sans">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100/80 shadow-inner">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-900 tracking-tight">Agenda de Citas</h1>
                <p class="text-xs text-slate-500 mt-0.5">Gestión e historial de citas médicas del sistema.</p>
            </div>
        </div>
        <button id="btn-nueva-cita" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-xs transition-all cursor-pointer">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span>Agendar Cita</span>
        </button>
    </div>

    <!-- Barra de Control: Navegación de Fechas y Cambiador de Vista -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200/80 shadow-xs flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-start">
            <div class="inline-flex items-center gap-1 bg-slate-50 p-1 rounded-xl border border-slate-200/80">
                <button type="button" id="btn-prev-date" class="p-1.5 hover:bg-white hover:shadow-xs rounded-lg text-slate-600 transition-all cursor-pointer" title="Anterior">
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button type="button" id="btn-today" class="px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-white hover:shadow-xs rounded-lg transition-all cursor-pointer">
                    Hoy
                </button>
                <button type="button" id="btn-next-date" class="p-1.5 hover:bg-white hover:shadow-xs rounded-lg text-slate-600 transition-all cursor-pointer" title="Siguiente">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
            <span id="period-label" class="text-sm font-bold text-slate-800 tracking-tight">
                Semana del <?= date('d/m/Y', strtotime($inicioSemana)) ?>
            </span>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
            <div class="inline-flex bg-slate-100 p-1 rounded-xl text-xs font-semibold">
                <button type="button" class="tab-btn active px-3 py-1.5 rounded-lg text-indigo-600 bg-white shadow-xs transition-all cursor-pointer" data-view="semana">
                    <i data-lucide="calendar-days" class="w-3.5 h-3.5 inline mr-1"></i> Semana
                </button>
                <button type="button" class="tab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all cursor-pointer" data-view="mes">
                    <i data-lucide="calendar-range" class="w-3.5 h-3.5 inline mr-1"></i> Mes
                </button>
                <button type="button" class="tab-btn px-3 py-1.5 rounded-lg text-slate-600 hover:text-slate-900 transition-all cursor-pointer" data-view="lista">
                    <i data-lucide="list" class="w-3.5 h-3.5 inline mr-1"></i> Lista
                </button>
            </div>
        </div>
    </div>

    <!-- VISTA 1: CALENDARIO SEMANAL -->
    <div id="view-semana" class="view-content bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="grid grid-cols-7 border-b border-slate-200/80 bg-slate-50/80 text-center text-xs font-bold text-slate-600">
            <?php
            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
            for ($i = 0; $i < 7; $i++):
            $fechaDia = date('Y-m-d', strtotime("$inicioSemana +$i days"));
            $esHoy    = ($fechaDia === $hoy);
            ?>
            <div class="p-3 border-r border-slate-100 border-b-2 <?= $esHoy ? 'border-b-indigo-600 bg-indigo-50/30 text-indigo-700' : 'border-b-transparent' ?>">
                <div><?= $diasSemana[$i] ?></div>
                <div class="text-[10px] font-normal <?= $esHoy ? 'text-indigo-600 font-bold' : 'text-slate-400' ?>"><?= date('d/m', strtotime($fechaDia)) ?></div>
            </div>
            <?php endfor; ?>
        </div>

        <div class="grid grid-cols-7 divide-x divide-slate-100 min-h-[420px] bg-slate-50/30 text-xs">
            <?php for ($i = 0; $i < 7; $i++):
            $fechaDia    = date('Y-m-d', strtotime("$inicioSemana +$i days"));
            $citasDelDia = $citasPorFecha[$fechaDia] ?? [];
            $esHoy       = ($fechaDia === $hoy);
            ?>
            <div class="p-2 space-y-2 <?= $esHoy ? 'bg-indigo-50/10' : '' ?>">
                <?php if (!empty($citasDelDia)): ?>
                    <?php foreach ($citasDelDia as $c): ?>
                        <?php
                        $cardBg = match($c['estado']) {
                            'atendida'  => 'bg-emerald-50/90 border-emerald-200/80 text-emerald-800',
                            'cancelada' => 'bg-rose-50/90 border-rose-200/80 text-rose-800 opacity-75',
                            default     => 'bg-amber-50/90 border-amber-200/80 text-amber-800'
                        };
                        $dotColor = match($c['estado']) {
                            'atendida'  => 'bg-emerald-500',
                            'cancelada' => 'bg-rose-500',
                            default     => 'bg-amber-500'
                        };
                        ?>
                        <div class="card-cita p-2.5 border rounded-xl shadow-2xs hover:shadow-xs hover:scale-[1.02] transition-all cursor-pointer <?= $cardBg ?>"
                        data-id="<?= $c['id'] ?>"
                        data-paciente="<?= htmlspecialchars($c['paciente_nombre'] . ' ' . $c['paciente_apellido']) ?>"
                        data-telefono="<?= htmlspecialchars($c['paciente_telefono'] ?? 'Sin teléfono') ?>"
                        data-fecha="<?= date('d/m/Y', strtotime($c['fecha'])) ?>"
                        data-hora="<?= date('h:i A', strtotime($c['hora'])) ?>"
                        data-motivo="<?= htmlspecialchars($c['motivo']) ?>"
                        data-estado="<?= $c['estado'] ?>">
                        <div class="flex items-center justify-between text-[11px] font-extrabold">
                            <span><?= date('h:i A', strtotime($c['hora'])) ?></span>
                            <span class="w-2 h-2 rounded-full <?= $dotColor ?>"></span>
                        </div>
                        <div class="font-bold text-slate-900 mt-1 truncate <?= $c['estado'] === 'cancelada' ? 'line-through' : '' ?>">
                            <?= htmlspecialchars($c['paciente_nombre'] . ' ' . $c['paciente_apellido']) ?>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate mt-0.5"><?= htmlspecialchars($c['motivo']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>
</div>

<!-- VISTA 2: CALENDARIO MENSUAL -->
<div id="view-mes" class="view-content hidden bg-white rounded-2xl border border-slate-200/80 shadow-xs p-6">
    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-slate-500 mb-3">
        <div>Dom</div>
        <div>Lun</div>
        <div>Mar</div>
        <div>Mié</div>
        <div>Jue</div>
        <div>Vie</div>
        <div>Sáb</div>
    </div>
    <div class="grid grid-cols-7 gap-2 text-xs">
        <?php
        $primerDiaMes = date('Y-m-01');
        $diasEnMes    = date('t');
        $offset       = date('w', strtotime($primerDiaMes));

        for ($blank = 0; $blank < $offset; $blank++): ?>
        <div class="min-h-[70px] p-2 border border-slate-50 rounded-xl bg-slate-50/30 opacity-40"></div>
        <?php endfor; ?>

        <?php for ($dia = 1; $dia <= $diasEnMes; $dia++):
        $fechaFormato = date('Y-m-' . sprintf('%02d', $dia));
        $countCitas   = count($citasPorFecha[$fechaFormato] ?? []);
        $esHoyMes     = ($fechaFormato === $hoy);
        ?>
        <div class="min-h-[70px] p-2 border <?= $esHoyMes ? 'border-indigo-400 bg-indigo-50/20' : 'border-slate-100 bg-slate-50/50' ?> rounded-xl flex flex-col justify-between hover:border-indigo-200 transition-all">
            <span class="font-bold <?= $esHoyMes ? 'text-indigo-600' : 'text-slate-700' ?>"><?= $dia ?></span>
            <?php if ($countCitas > 0): ?>
                <div class="bg-indigo-100 text-indigo-700 text-[10px] font-extrabold px-1.5 py-0.5 rounded-md text-center">
                    <?= $countCitas ?> <?= $countCitas === 1 ? 'Cita' : 'Citas' ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endfor; ?>
    </div>
</div>

<!-- VISTA 3: TABLA LISTA -->
<div id="view-lista" class="view-content hidden bg-white rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead class="bg-slate-50/80 border-b border-slate-200/80 text-slate-500 font-semibold uppercase tracking-wider">
                <tr>
                    <th class="p-4">Fecha y Hora</th>
                    <th class="p-4">Paciente</th>
                    <th class="p-4">Motivo</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700">
                <?php if (!empty($citas)): ?>
                    <?php foreach ($citas as $c): ?>
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 cursor-pointer card-cita"
                            data-id="<?= $c['id'] ?>"
                            data-paciente="<?= htmlspecialchars($c['paciente_nombre'] . ' ' . $c['paciente_apellido']) ?>"
                            data-telefono="<?= htmlspecialchars($c['paciente_telefono'] ?? 'Sin teléfono') ?>"
                            data-fecha="<?= date('d/m/Y', strtotime($c['fecha'])) ?>"
                            data-hora="<?= date('h:i A', strtotime($c['hora'])) ?>"
                            data-motivo="<?= htmlspecialchars($c['motivo']) ?>"
                            data-estado="<?= $c['estado'] ?>">
                            <div class="inline-flex items-center gap-2 bg-amber-50/80 border border-amber-200/70 rounded-xl p-2 pr-3">
                                <div class="bg-amber-500/10 text-amber-700 p-1.5 rounded-lg">
                                    <i data-lucide="clock" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-xs">
                                        <?= date('d/m/Y', strtotime($c['fecha'])) ?>
                                    </div>
                                    <div class="text-[11px] font-extrabold text-amber-700 tracking-wide mt-0.5">
                                        <?= date('h:i A', strtotime($c['hora'])) ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="font-semibold text-slate-900">
                                <?= htmlspecialchars($c['paciente_nombre'] . ' ' . $c['paciente_apellido']) ?>
                            </div>
                            <span class="inline-block text-[11px] font-normal text-slate-400 mt-0.5">
                                <?= htmlspecialchars($c['paciente_telefono'] ?? '') ?>
                            </span>
                        </td>
                        <td class="p-4 text-slate-600 max-w-xs truncate">
                            <?= htmlspecialchars($c['motivo']) ?>
                        </td>
                        <td class="p-4">
                            <?php
                            $badge = match($c['estado']) {
                                'atendida'  => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                'cancelada' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                default     => 'bg-amber-50 text-amber-700 border-amber-200/60'
                            };
                            $dot = match($c['estado']) {
                                'atendida'  => 'bg-emerald-500',
                                'cancelada' => 'bg-rose-500',
                                default     => 'bg-amber-500'
                            };
                            ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] font-semibold tracking-wide capitalize <?= $badge ?>">
                                <span class="w-1.5 h-1.5 rounded-full <?= $dot ?>"></span>
                                <?= $c['estado'] ?>
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1">
                                <a href="<?= BASE_URL ?>/cita/cambiarEstado/<?= $c['id'] ?>?estado=atendida" class="px-2.5 py-1 text-emerald-700 hover:bg-emerald-50 border border-transparent hover:border-emerald-200/60 rounded-lg font-medium text-[11px] transition-all">Atendida</a>
                                <a href="<?= BASE_URL ?>/cita/cambiarEstado/<?= $c['id'] ?>?estado=cancelada" class="px-2.5 py-1 text-rose-700 hover:bg-rose-50 border border-transparent hover:border-rose-200/60 rounded-lg font-medium text-[11px] transition-all">Cancelar</a>
                                <a href="<?= BASE_URL ?>/cita/eliminar/<?= $c['id'] ?>" onclick="return confirm('¿Eliminar cita?')" class="p-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-all ml-1" title="Eliminar Cita">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="p-12 text-center text-slate-400">
                        <i data-lucide="calendar-x" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        No hay citas registradas en el sistema.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>
</div>

<!-- Modal 1: Registrar Cita -->
<div id="modal-cita" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4 transition-all">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 space-y-5 shadow-xl border border-slate-100">
        <div class="flex justify-between items-center border-b border-slate-100 pb-3.5">
            <div>
                <h3 class="text-base font-bold text-slate-900">Agendar Nueva Cita</h3>
                <p class="text-xs text-slate-500 mt-0.5">Completa la información requerida.</p>
            </div>
            <button type="button" id="btn-cerrar-modal" class="text-slate-400 hover:text-slate-600 p-1 hover:bg-slate-100 rounded-lg transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <form action="<?= BASE_URL ?>/cita/guardar" method="POST" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1.5">Paciente <span class="text-rose-500">*</span>
                </label>
                <select name="paciente_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                    <option value="">-- Seleccionar Paciente --</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido'] . ' (' . ($p['documento'] ?? '') . ')') ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Fecha <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="fecha" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Hora <span class="text-rose-500">*</span>
                    </label>
                    <input type="time" name="hora" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1.5">Motivo de Consulta</label>
                <textarea name="motivo" rows="3" placeholder="Ej. Valoración odontológica" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-800 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all"></textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" id="btn-cancelar-modal" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 rounded-xl font-semibold text-slate-600 transition-all cursor-pointer">Cancelar</button>
                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-semibold rounded-xl shadow-xs transition-all cursor-pointer">Guardar Cita</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal 2: Detalle y Cambio de Estado de la Cita -->
<div id="modal-detalle-cita" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4 transition-all">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-5 shadow-xl border border-slate-100">
        <div class="flex justify-between items-start border-b border-slate-100 pb-3.5">
            <div>
                <span id="det-estado" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-[11px] font-semibold uppercase tracking-wider mb-2">
                    <!-- Estado inyectado dinámicamente -->
                </span>
                <h3 id="det-paciente" class="text-base font-bold text-slate-900">--</h3>
                <p id="det-telefono" class="text-xs text-slate-500 mt-0.5">--</p>
            </div>
            <button type="button" id="btn-cerrar-modal-det" class="text-slate-400 hover:text-slate-600 p-1 hover:bg-slate-100 rounded-lg transition-all cursor-pointer">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="space-y-3 text-xs">
            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Fecha:</span>
                    <span id="det-fecha" class="font-bold text-slate-800">--</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 font-medium">Hora:</span>
                    <span id="det-hora" class="font-bold text-slate-800">--</span>
                </div>
            </div>

            <div>
                <span class="block text-slate-500 font-medium mb-1">Motivo de consulta:</span>
                <p id="det-motivo" class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-slate-700 font-normal">--</p>
            </div>
        </div>

        <!-- Acciones directas mapeadas con tu CitaController -->
        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
            <a id="btn-eliminar-cita" href="#" onclick="return confirm('¿Eliminar cita?')" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-all" title="Eliminar cita">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </a>

            <div class="flex items-center gap-2">
                <a id="btn-marcar-cancelada" href="#" class="px-3 py-2 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl font-semibold text-xs transition-all">Cancelar Cita</a>
                <a id="btn-marcar-atendida" href="#" class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-semibold text-xs transition-all">Marcar Atendida</a>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
        const BASE_URL = "<?= BASE_URL ?>";

        // Modales
        const modalNueva   = document.getElementById('modal-cita');
        const modalDetalle = document.getElementById('modal-detalle-cita');

        document.getElementById('btn-nueva-cita')?.addEventListener('click', () => modalNueva.classList.remove('hidden'));
        document.getElementById('btn-cerrar-modal')?.addEventListener('click', () => modalNueva.classList.add('hidden'));
        document.getElementById('btn-cancelar-modal')?.addEventListener('click', () => modalNueva.classList.add('hidden'));
        document.getElementById('btn-cerrar-modal-det')?.addEventListener('click', () => modalDetalle.classList.add('hidden'));

        // Cambio de Vistas
        const tabs         = document.querySelectorAll('.tab-btn');
        const viewContents = document.querySelectorAll('.view-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const targetView = tab.dataset.view;

                tabs.forEach(t => {
                    t.classList.remove('bg-white', 'text-indigo-600', 'shadow-xs');
                    t.classList.add('text-slate-600');
                });
                tab.classList.add('bg-white', 'text-indigo-600', 'shadow-xs');
                tab.classList.remove('text-slate-600');

                viewContents.forEach(view => {
                    if (view.id === `view-${targetView}`) {
                        view.classList.remove('hidden');
                    } else {
                        view.classList.add('hidden');
                    }
                });
            });
        });

        // Evento Click para Ver Detalle de Cita
        document.querySelectorAll('.card-cita').forEach(item => {
            item.addEventListener('click', () => {
                const id       = item.dataset.id;
                const paciente = item.dataset.paciente;
                const telefono = item.dataset.telefono;
                const fecha    = item.dataset.fecha;
                const hora     = item.dataset.hora;
                const motivo   = item.dataset.motivo;
                const estado   = item.dataset.estado;

                // Inyectar datos en el Modal
                document.getElementById('det-paciente').textContent = paciente;
                document.getElementById('det-telefono').textContent = 'Teléfono: ' + telefono;
                document.getElementById('det-fecha').textContent = fecha;
                document.getElementById('det-hora').textContent = hora;
                document.getElementById('det-motivo').textContent = motivo || 'Sin motivo especificado.';

                // Configurar Badge de Estado
                const badgeElement = document.getElementById('det-estado');
                badgeElement.textContent = estado;
                if (estado === 'atendida') {
                    badgeElement.className = 'inline-flex items-center px-2.5 py-1 rounded-full border text-[11px] font-semibold uppercase bg-emerald-50 text-emerald-700 border-emerald-200';
                } else if (estado === 'cancelada') {
                    badgeElement.className = 'inline-flex items-center px-2.5 py-1 rounded-full border text-[11px] font-semibold uppercase bg-rose-50 text-rose-700 border-rose-200';
                } else {
                    badgeElement.className = 'inline-flex items-center px-2.5 py-1 rounded-full border text-[11px] font-semibold uppercase bg-amber-50 text-amber-700 border-amber-200';
                }

                // Mapear rutas exactas con el Controller
                document.getElementById('btn-marcar-atendida').href = `${BASE_URL}/cita/cambiarEstado/${id}?estado=atendida`; //
                document.getElementById('btn-marcar-cancelada').href = `${BASE_URL}/cita/cambiarEstado/${id}?estado=cancelada`; //[cite: 1]
                document.getElementById('btn-eliminar-cita').href = `${BASE_URL}/cita/eliminar/${id}`; //[cite: 1]

                // Mostrar Modal
                modalDetalle.classList.remove('hidden');
            });
        });
    });
</script>