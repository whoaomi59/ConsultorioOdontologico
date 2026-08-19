<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                👋 Bienvenid@, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?>
            </h1>
            <p class="text-xs text-slate-500">
                Panel de control general de la clínica odontológica. Resumen diario de actividades.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-slate-50 text-slate-600 rounded-xl border border-slate-200/80 text-xs font-medium">
                <i data-lucide="calendar" class="w-4 h-4 text-indigo-600"></i>
                <?= date('d/m/Y') ?>
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 text-xs font-bold capitalize">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'Invitado') ?>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Pacientes</span>
                <p class="text-2xl font-extrabold text-slate-800"><?= $stats['pacientes'] ?? '0' ?></p>
                <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> Registrados en sistema
                </span>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Citas para Hoy</span>
                <p class="text-2xl font-extrabold text-slate-800"><?= $stats['citas_hoy'] ?? '0' ?></p>
                <span class="text-[10px] text-amber-600 font-semibold flex items-center gap-1">
                    <i data-lucide="clock" class="w-3 h-3"></i> Agendadas
                </span>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Historias Odontológicas</span>
                <p class="text-2xl font-extrabold text-slate-800"><?= $stats['historias'] ?? '0' ?></p>
                <span class="text-[10px] text-indigo-600 font-semibold flex items-center gap-1">
                    <i data-lucide="file-check" class="w-3 h-3"></i> Expedientes
                </span>
            </div>
            <div class="p-3 bg-rose-50 text-rose-600 rounded-2xl">
                <i data-lucide="folder-heart" class="w-6 h-6"></i>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Doctores / Usuarios</span>
                <p class="text-2xl font-extrabold text-slate-800"><?= $stats['doctores'] ?? '0' ?></p>
                <span class="text-[10px] text-emerald-600 font-semibold flex items-center gap-1">
                    <i data-lucide="user-check" class="w-3 h-3"></i> Personal Activo
                </span>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                <i data-lucide="user-cog" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-4">
        <h2 class="text-xs font-bold text-slate-800 uppercase tracking-wider text-slate-400">Acceso Rápido a Módulos</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">

            <?php if (hasPermission('pacientes')): ?>
                <a href="<?= BASE_URL ?>/paciente/index" class="p-4 bg-slate-50 hover:bg-indigo-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-2 group transition text-center">
                    <div class="p-2.5 bg-white group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white rounded-xl shadow-sm transition">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-indigo-600">Pacientes</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('citas')): ?>
                <a href="<?= BASE_URL ?>/cita/index" class="p-4 bg-slate-50 hover:bg-blue-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-2 group transition text-center">
                    <div class="p-2.5 bg-white group-hover:bg-blue-600 text-blue-600 group-hover:text-white rounded-xl shadow-sm transition">
                        <i data-lucide="calendar" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-blue-600">Citas</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('historias') || hasPermission('historias_odontologia')): ?>
                <a href="<?= BASE_URL ?>/historias/odontologia" class="p-4 bg-slate-50 hover:bg-rose-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-2 group transition text-center">
                    <div class="p-2.5 bg-white group-hover:bg-rose-600 text-rose-600 group-hover:text-white rounded-xl shadow-sm transition">
                        <i data-lucide="folder-heart" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-rose-600">Odontología</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('usuarios')): ?>
                <a href="<?= BASE_URL ?>/usuarios/index" class="p-4 bg-slate-50 hover:bg-amber-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-2 group transition text-center">
                    <div class="p-2.5 bg-white group-hover:bg-amber-600 text-amber-600 group-hover:text-white rounded-xl shadow-sm transition">
                        <i data-lucide="user-cog" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-amber-600">Usuarios</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('reportes')): ?>
                <a href="<?= BASE_URL ?>/reporte/index" class="p-4 bg-slate-50 hover:bg-emerald-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-2 group transition text-center">
                    <div class="p-2.5 bg-white group-hover:bg-emerald-600 text-emerald-600 group-hover:text-white rounded-xl shadow-sm transition">
                        <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-600">Reportes</span>
                </a>
            <?php endif; ?>

        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Citas Programadas para Hoy -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="clock" class="w-4 h-4 text-indigo-600"></i> Citas Programadas para Hoy
                </h2>
                <?php if (function_exists('hasPermission') && hasPermission('citas')): ?>
                    <a href="<?= defined('BASE_URL') ? BASE_URL : '#' ?>/cita/index" class="text-xs font-semibold text-indigo-600 hover:underline">Ver todas</a>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-[10px] font-bold uppercase text-slate-400 bg-slate-50 border-b border-slate-100">
                            <th class="p-3">Paciente</th>
                            <th class="p-3">Hora</th>
                            <th class="p-3">Doctor</th>
                            <th class="p-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        <?php if (!empty($citasHoy) && is_array($citasHoy)): ?>
                            <?php foreach ($citasHoy as $cita): ?>
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="p-3 font-semibold text-slate-800">
                                        <?= htmlspecialchars($cita['paciente_nombre'] ?? $cita['paciente'] ?? 'N/A') ?>
                                    </td>
                                    <td class="p-3 text-slate-600 font-medium">
                                        <?= htmlspecialchars(isset($cita['hora']) ? date('h:i A', strtotime($cita['hora'])) : '10:00 AM') ?>
                                    </td>
                                    <td class="p-3 text-slate-600">
                                        <?= htmlspecialchars($cita['doctor_nombre'] ?? $cita['doctor'] ?? 'Dr. Asignado') ?>
                                    </td>
                                    <td class="p-3">
                                        <?php
                                        $estado  = strtolower($cita['estado'] ?? 'pendiente');
                                        $bgClass = match($estado) {
                                            'atendida', 'completada' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                            'cancelada' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            default => 'bg-amber-50 text-amber-700 border-amber-200'
                                        };
                                        ?>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $bgClass ?> capitalize">
                                            <?= htmlspecialchars($estado) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-6 text-center text-slate-400">
                                    <i data-lucide="calendar-x" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                    No hay citas programadas para el día de hoy.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Avisos del Sistema -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 space-y-4">
            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i data-lucide="bell" class="w-4 h-4 text-amber-500"></i> Avisos del Sistema
            </h2>

            <div class="space-y-3">
                <div class="p-3 bg-indigo-50/70 border border-indigo-100 rounded-xl space-y-1">
                    <span class="text-xs font-bold text-indigo-800 flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Permisos Asignados
                    </span>
                    <p class="text-[11px] text-indigo-700">Tu cuenta tiene acceso a los módulos habilitados por el administrador.</p>
                </div>

                <div class="p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl space-y-1">
                    <span class="text-xs font-bold text-emerald-800 flex items-center gap-1.5">
                        <i data-lucide="database" class="w-3.5 h-3.5"></i> Respaldo Automático
                    </span>
                    <p class="text-[11px] text-emerald-700">Base de datos optimizada y sincronizada correctamente.</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>