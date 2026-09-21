<div class="max-w-7xl mx-auto space-y-6 font-sans pb-12">

    <!-- Encabezado Principal Premium -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-7 rounded-3xl shadow-xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 space-y-1">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/25 text-indigo-300 text-xs font-semibold mb-1 border border-indigo-500/30">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Panel General
            </div>
            <h1 class="text-2xl font-black tracking-tight">
                ¡Bienvenid@, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario') ?>! 👋
            </h1>
            <p class="text-xs text-slate-300">
                Panel de control general de la clínica odontológica. Resumen diario de actividades y métricas en tiempo real.
            </p>
        </div>
        <div class="relative z-10 flex items-center gap-3">
            <span class="inline-flex items-center gap-2 px-3.5 py-2 bg-white/10 text-white rounded-2xl border border-white/15 text-xs font-bold backdrop-blur-md shadow-inner">
                <i data-lucide="calendar" class="w-4 h-4 text-indigo-400"></i>
                <?= date('d/m/Y') ?>
            </span>
            <span class="inline-flex items-center gap-2 px-3.5 py-2 bg-emerald-500/20 text-emerald-300 rounded-2xl border border-emerald-500/35 text-xs font-extrabold capitalize backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <?= htmlspecialchars($_SESSION['usuario_rol'] ?? 'Invitado') ?>
            </span>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas Rediseñadas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Total Pacientes -->
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 flex items-center justify-between relative overflow-hidden group hover:border-indigo-200 hover:shadow-md transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50/50 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110"></div>
            <div class="space-y-1.5 relative z-10">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Total Pacientes</span>
                <p class="text-3xl font-black text-slate-900"><?= $stats['pacientes'] ?? '0' ?></p>
                <span class="inline-flex items-center gap-1 text-[11px] text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-100">
                    <i data-lucide="trending-up" class="w-3 h-3"></i> Registrados
                </span>
            </div>
            <div class="p-4 bg-indigo-50 text-indigo-600 rounded-2xl border border-indigo-100 shadow-xs relative z-10">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Citas para Hoy -->
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 flex items-center justify-between relative overflow-hidden group hover:border-blue-200 hover:shadow-md transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50/50 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110"></div>
            <div class="space-y-1.5 relative z-10">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Citas para Hoy</span>
                <p class="text-3xl font-black text-slate-900"><?= $stats['citas_hoy'] ?? '0' ?></p>
                <span class="inline-flex items-center gap-1 text-[11px] text-blue-700 font-bold bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">
                    <i data-lucide="clock" class="w-3 h-3"></i> Agendadas
                </span>
            </div>
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 shadow-xs relative z-10">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Historias Odontológicas -->
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 flex items-center justify-between relative overflow-hidden group hover:border-rose-200 hover:shadow-md transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-rose-50/50 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110"></div>
            <div class="space-y-1.5 relative z-10">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Historias Odontológicas</span>
                <p class="text-3xl font-black text-slate-900"><?= $stats['historias'] ?? '0' ?></p>
                <span class="inline-flex items-center gap-1 text-[11px] text-rose-700 font-bold bg-rose-50 px-2 py-0.5 rounded-full border border-rose-100">
                    <i data-lucide="file-check" class="w-3 h-3"></i> Expedientes
                </span>
            </div>
            <div class="p-4 bg-rose-50 text-rose-600 rounded-2xl border border-rose-100 shadow-xs relative z-10">
                <i data-lucide="folder-heart" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Doctores / Usuarios -->
        <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 flex items-center justify-between relative overflow-hidden group hover:border-amber-200 hover:shadow-md transition-all">
            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50/50 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110"></div>
            <div class="space-y-1.5 relative z-10">
                <span class="text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Personal Activo</span>
                <p class="text-3xl font-black text-slate-900"><?= $stats['doctores'] ?? '0' ?></p>
                <span class="inline-flex items-center gap-1 text-[11px] text-amber-700 font-bold bg-amber-50 px-2 py-0.5 rounded-full border border-amber-100">
                    <i data-lucide="user-check" class="w-3 h-3"></i> Doctores
                </span>
            </div>
            <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl border border-amber-100 shadow-xs relative z-10">
                <i data-lucide="user-cog" class="w-6 h-6"></i>
            </div>
        </div>

    </div>

    <!-- Sección de Acceso Rápido -->
    <div class="bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4">
        <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest px-1">Acceso Rápido a Módulos</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">

            <?php if (hasPermission('pacientes')): ?>
                <a href="<?= BASE_URL ?>/paciente/index" class="p-5 bg-slate-50/80 hover:bg-indigo-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-3 group transition-all hover:scale-[1.02] hover:shadow-sm text-center">
                    <div class="p-3 bg-white group-hover:bg-indigo-600 text-indigo-600 group-hover:text-white rounded-2xl shadow-xs transition-all border border-indigo-100">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-indigo-700">Pacientes</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('citas')): ?>
                <a href="<?= BASE_URL ?>/cita/index" class="p-5 bg-slate-50/80 hover:bg-blue-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-3 group transition-all hover:scale-[1.02] hover:shadow-sm text-center">
                    <div class="p-3 bg-white group-hover:bg-blue-600 text-blue-600 group-hover:text-white rounded-2xl shadow-xs transition-all border border-blue-100">
                        <i data-lucide="calendar" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-blue-700">Citas</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('historias') || hasPermission('historias_odontologia')): ?>
                <a href="<?= BASE_URL ?>/historias/odontologia" class="p-5 bg-slate-50/80 hover:bg-rose-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-3 group transition-all hover:scale-[1.02] hover:shadow-sm text-center">
                    <div class="p-3 bg-white group-hover:bg-rose-600 text-rose-600 group-hover:text-white rounded-2xl shadow-xs transition-all border border-rose-100">
                        <i data-lucide="folder-heart" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-rose-700">Odontología</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('usuarios')): ?>
                <a href="<?= BASE_URL ?>/usuarios/index" class="p-5 bg-slate-50/80 hover:bg-amber-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-3 group transition-all hover:scale-[1.02] hover:shadow-sm text-center">
                    <div class="p-3 bg-white group-hover:bg-amber-600 text-amber-600 group-hover:text-white rounded-2xl shadow-xs transition-all border border-amber-100">
                        <i data-lucide="user-cog" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-amber-700">Usuarios</span>
                </a>
            <?php endif; ?>

            <?php if (hasPermission('reportes')): ?>
                <a href="<?= BASE_URL ?>/reporte/index" class="p-5 bg-slate-50/80 hover:bg-emerald-50/60 rounded-2xl border border-slate-200/80 flex flex-col items-center justify-center gap-3 group transition-all hover:scale-[1.02] hover:shadow-sm text-center">
                    <div class="p-3 bg-white group-hover:bg-emerald-600 text-emerald-600 group-hover:text-white rounded-2xl shadow-xs transition-all border border-emerald-100">
                        <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700">Reportes</span>
                </a>
            <?php endif; ?>

        </div>
    </div>

    <!-- Contenido Inferior: Citas de Hoy + Avisos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Citas Programadas para Hoy -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                    <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                        <i data-lucide="clock" class="w-4 h-4"></i>
                    </div>
                    Citas Programadas para Hoy
                </h2>
                <?php if (function_exists('hasPermission') && hasPermission('citas')): ?>
                    <a href="<?= defined('BASE_URL') ? BASE_URL : '#' ?>/cita/index" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 hover:underline inline-flex items-center gap-1">
                        Ver todas <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    </a>
                <?php endif; ?>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="font-bold uppercase text-slate-400 bg-slate-50/60 border-b border-slate-100 tracking-wider">
                            <th class="p-4 rounded-l-2xl">Paciente</th>
                            <th class="p-4">Hora</th>
                            <th class="p-4">Doctor</th>
                            <th class="p-4 rounded-r-2xl">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        <?php if (!empty($citasHoy) && is_array($citasHoy)): ?>
                            <?php foreach ($citasHoy as $cita): ?>
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="p-4 font-bold text-slate-900">
                                        <?= htmlspecialchars($cita['paciente_nombre'] ?? $cita['paciente'] ?? 'N/A') ?>
                                    </td>
                                    <td class="p-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-800 rounded-xl font-bold border border-amber-200/60 shadow-2xs">
                                            <i data-lucide="clock" class="w-3 h-3 text-amber-600"></i>
                                            <?= htmlspecialchars(isset($cita['hora']) ? date('h:i A', strtotime($cita['hora'])) : '10:00 AM') ?>
                                        </span>
                                    </td>
                                    <td class="p-4 text-slate-600">
                                        <?= htmlspecialchars($cita['doctor_nombre'] ?? $cita['doctor'] ?? 'Dr. Asignado') ?>
                                    </td>
                                    <td class="p-4">
                                        <?php
                                        $estado  = strtolower($cita['estado'] ?? 'pendiente');
                                        $bgClass = match($estado) {
                                            'atendida', 'completada' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
                                            'cancelada' => 'bg-rose-50 text-rose-700 border-rose-200/60',
                                            default => 'bg-amber-50 text-amber-700 border-amber-200/60'
                                        };
                                        $dotColor = match($estado) {
                                            'atendida', 'completada' => 'bg-emerald-500',
                                            'cancelada' => 'bg-rose-500',
                                            default => 'bg-amber-500'
                                        };
                                        ?>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold border <?= $bgClass ?> capitalize shadow-2xs">
                                            <span class="w-2 h-2 rounded-full <?= $dotColor ?>"></span>
                                            <?= htmlspecialchars($estado) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="p-12 text-center text-slate-400">
                                    <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-inner">
                                        <i data-lucide="calendar-x" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-600">No hay citas programadas</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Todo se encuentra tranquilo por el día de hoy.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Avisos del Sistema -->
        <div class="bg-white rounded-3xl shadow-xs border border-slate-200/80 p-6 space-y-4">
            <h2 class="text-sm font-extrabold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-4">
                <div class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                    <i data-lucide="bell" class="w-4 h-4"></i>
                </div>
                Avisos del Sistema
            </h2>

            <div class="space-y-3.5 text-xs">
                <div class="p-4 bg-indigo-50/60 border border-indigo-100 rounded-2xl space-y-1.5 shadow-2xs">
                    <span class="font-extrabold text-indigo-900 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600"></i> Permisos Asignados
                    </span>
                    <p class="text-indigo-700 font-medium leading-relaxed">Tu cuenta tiene acceso seguro a los módulos habilitados por el administrador del sistema.</p>
                </div>

                <div class="p-4 bg-emerald-50/60 border border-emerald-100 rounded-2xl space-y-1.5 shadow-2xs">
                    <span class="font-extrabold text-emerald-900 flex items-center gap-2">
                        <i data-lucide="database" class="w-4 h-4 text-emerald-600"></i> Respaldo Automático
                    </span>
                    <p class="text-emerald-700 font-medium leading-relaxed">Base de datos optimizada y sincronizada de manera correcta en el entorno local.</p>
                </div>
            </div>
        </div>

    </div>

</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();
    });
</script>