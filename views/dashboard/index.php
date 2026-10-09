<?php
$nombreUsuario = $_SESSION['usuario_nombre'] ?? 'Usuario';
$rolUsuario = $_SESSION['usuario_rol'] ?? 'Invitado';
$fechaActual = date('d/m/Y');
$stats = is_array($stats ?? null) ? $stats : [];
$citasHoy = is_array($citasHoy ?? null) ? $citasHoy : [];
?>
<style>
    .dashboard-shell {
        color: #172033;
    }
    .dashboard-card {
        border: 1px solid #e6edf4;
        border-radius: 1.35rem;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 5px 18px rgba(15, 23, 42, 0.035);
        transition:
            transform 0.22s ease,
            box-shadow 0.22s ease,
            border-color 0.22s ease;
    }
    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.075);
        border-color: #d7e4f0;
    }
    .dashboard-stat::after {
        content: '';
        position: absolute;
        width: 112px;
        height: 112px;
        right: -32px;
        top: -38px;
        border-radius: 999px;
        background: var(--stat-glow, #eff6ff);
        opacity: 0.78;
        pointer-events: none;
        transition: transform 0.3s ease;
    }
    .dashboard-stat:hover::after {
        transform: scale(1.18);
    }
    .dashboard-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        border-radius: 14px;
    }
    .dashboard-shortcut {
        min-height: 132px;
        border: 1px solid #e7edf4;
        border-radius: 1.15rem;
        background: linear-gradient(145deg, #fff 0%, #f8fafc 100%);
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease,
            background 0.2s ease;
    }
    .dashboard-shortcut:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(30, 64, 175, 0.09);
        border-color: #cbdcf0;
        background: #fff;
    }
    .dashboard-table th {
        white-space: nowrap;
    }
    .dashboard-table td {
        vertical-align: middle;
    }
    .dashboard-table tbody tr {
        transition: background 0.18s ease;
    }
    .dashboard-table tbody tr:hover {
        background: #f8fbff;
    }
    .dashboard-section-title {
        letter-spacing: -0.025em;
    }
    @media (prefers-reduced-motion: reduce) {
        .dashboard-card,
        .dashboard-stat::after,
        .dashboard-shortcut,
        .dashboard-table tbody tr {
            transition: none !important;
        }
        .dashboard-card:hover,
        .dashboard-shortcut:hover {
            transform: none;
        }
    }
    @media (max-width: 640px) {
        .dashboard-hero {
            padding: 1.25rem !important;
            border-radius: 1.25rem !important;
        }
        .dashboard-stat {
            padding: 1rem !important;
        }
        .dashboard-shortcut {
            min-height: 112px;
            padding: 0.9rem !important;
        }
        .dashboard-table th,
        .dashboard-table td {
            padding: 0.8rem 0.7rem !important;
        }
    }
    
    /* EDICIÓN ULTRA PREMIUM: identidad clínica azul noche + turquesa */
    .dashboard-shell {
        --clinic-night: #101d35;
        --clinic-blue: #2457a7;
        --clinic-teal: #0b938b;
        --clinic-mint: #b9fff0;
        position: relative;
        isolation: isolate;
    }
    .dashboard-hero {
        background: linear-gradient(118deg, #101b32 0%, #183e68 48%, #087f7b 100%) !important;
        border: 1px solid rgba(180, 246, 237, 0.25) !important;
        box-shadow:
            0 24px 60px rgba(16, 37, 65, 0.22),
            inset 0 1px 0 rgba(255, 255, 255, 0.12) !important;
    }
    .dashboard-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;
        opacity: 0.22;
        background-image: linear-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.08) 1px, transparent 1px);
        background-size: 34px 34px;
        mask-image: linear-gradient(110deg, #000, transparent 78%);
    }
    .dashboard-hero::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        right: -90px;
        bottom: -205px;
        border: 1px solid rgba(185, 255, 240, 0.25);
        border-radius: 50%;
        box-shadow:
            0 0 0 28px rgba(185, 255, 240, 0.035),
            0 0 0 58px rgba(185, 255, 240, 0.025);
        pointer-events: none;
    }
    .dashboard-hero h1 {
        text-wrap: balance;
        text-shadow: 0 3px 22px rgba(0, 0, 0, 0.16);
    }
    .dashboard-hero .relative {
        z-index: 1;
    }
    .dashboard-hero .rounded-full {
        box-shadow: 0 8px 26px rgba(0, 0, 0, 0.08);
    }
    .dashboard-card {
        border-color: #e2eaf1;
        border-radius: 1.45rem;
        box-shadow:
            0 8px 28px rgba(20, 39, 66, 0.045),
            0 1px 2px rgba(20, 39, 66, 0.025);
        backdrop-filter: blur(8px);
    }
    .dashboard-card:hover {
        border-color: #c6dedf;
        box-shadow:
            0 18px 42px rgba(20, 50, 76, 0.09),
            0 3px 8px rgba(20, 50, 76, 0.035);
    }
    .dashboard-stat {
        min-height: 158px;
        background: linear-gradient(145deg, #fff 0%, #fff 56%, #f7fbfc 100%);
    }
    .dashboard-stat::before {
        content: '';
        position: absolute;
        inset: 0 22% auto 0;
        height: 3px;
        background: linear-gradient(90deg, #2d5ed7, #19b7ad, transparent);
        opacity: 0.9;
    }
    .dashboard-stat::after {
        opacity: 0.65;
        filter: blur(1px);
    }
    .dashboard-stat .dashboard-icon {
        border-radius: 16px;
        box-shadow: 0 7px 16px rgba(20, 50, 76, 0.055);
        transition: transform 0.25s ease;
    }
    .dashboard-stat:hover .dashboard-icon {
        transform: rotate(-4deg) scale(1.06);
    }
    .dashboard-stat p.text-3xl {
        letter-spacing: -0.055em;
    }
    .dashboard-shortcut {
        position: relative;
        overflow: hidden;
        min-height: 138px;
        border-color: #e2eaf1;
        background: linear-gradient(145deg, #fff 0%, #f5f9fc 100%);
        box-shadow: 0 3px 10px rgba(17, 39, 67, 0.025);
    }
    .dashboard-shortcut::after {
        content: '';
        position: absolute;
        width: 85px;
        height: 85px;
        right: -42px;
        bottom: -48px;
        border-radius: 50%;
        background: rgba(13, 148, 136, 0.08);
        transition: transform 0.25s ease;
        pointer-events: none;
    }
    .dashboard-shortcut:hover {
        border-color: #a9dcd5;
        background: linear-gradient(145deg, #fff 0%, #f0fbf9 100%);
        box-shadow: 0 16px 30px rgba(12, 91, 105, 0.1);
    }
    .dashboard-shortcut:hover::after {
        transform: scale(1.55);
    }
    .dashboard-shortcut .dashboard-icon {
        border-radius: 16px;
        box-shadow: 0 6px 15px rgba(22, 45, 74, 0.055);
    }
    .dashboard-section-title {
        color: #14243b;
    }
    .dashboard-table thead tr {
        background: linear-gradient(90deg, #f2f7fb, #f7fbfb) !important;
    }
    .dashboard-table tbody tr:hover {
        background: #f1faf9;
    }
    .dashboard-table tbody tr td:first-child {
        position: relative;
    }
    .dashboard-table tbody tr:hover td:first-child::before {
        content: '';
        position: absolute;
        left: 0;
        top: 18%;
        bottom: 18%;
        width: 3px;
        border-radius: 0 4px 4px 0;
        background: #0b938b;
    }
    .dashboard-shell aside .rounded-2xl {
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.8);
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }
    .dashboard-shell aside .rounded-2xl:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 18px rgba(22, 45, 74, 0.055);
    }
    .dashboard-shell a:focus-visible {
        outline: 3px solid rgba(11, 147, 139, 0.42);
        outline-offset: 3px;
        border-radius: 12px;
    }
    @media (max-width: 640px) {
        .dashboard-hero::after {
            width: 210px;
            height: 210px;
            right: -100px;
            bottom: -145px;
        }
        .dashboard-stat {
            min-height: 135px;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .dashboard-stat .dashboard-icon,
        .dashboard-shortcut::after,
        .dashboard-shell aside .rounded-2xl {
            transition: none !important;
        }
        .dashboard-shell aside .rounded-2xl:hover {
            transform: none;
        }
    }
</style>
<div class="dashboard-shell mx-auto w-full max-w-7xl space-y-6 pb-8 font-sans">
    <!-- Bienvenida -->
    <section class="dashboard-hero relative isolate overflow-hidden rounded-[1.75rem] border border-slate-800 bg-gradient-to-br from-slate-950 via-blue-950 to-teal-950 px-7 py-7 text-white shadow-xl sm:px-8">
        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full bg-cyan-400/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 right-1/3 h-56 w-56 rounded-full bg-indigo-500/15 blur-3xl"></div>
        <div class="relative flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <div class="mb-3 inline-flex items-center gap-2 rounded-full border border-cyan-300/20 bg-white/10 px-3 py-1.5 text-[11px] font-bold uppercase tracking-[.16em] text-cyan-100 backdrop-blur">
                    <i data-lucide="sparkles" class="h-3.5 w-3.5"></i>
                    Panel de control
                </div>
                <h1 class="text-2xl font-black tracking-tight sm:text-3xl"> ¡Hola, <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?>! </h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-blue-100/80"> Aquí tienes el resumen de actividad de tu clínica y los accesos que necesitas para comenzar. </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-xl border border-white/15 bg-white/10 px-3.5 py-2.5 text-xs font-semibold text-white shadow-sm backdrop-blur">
                    <i data-lucide="calendar-days" class="h-4 w-4 text-cyan-200"></i>
                    <?= htmlspecialchars($fechaActual, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span class="inline-flex items-center gap-2 rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-3.5 py-2.5 text-xs font-bold capitalize text-emerald-100"><span class="h-2 w-2 rounded-full bg-emerald-300 shadow-[0_0_0_4px_rgba(110,231,183,.12)]"></span><?= htmlspecialchars($rolUsuario, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        </div>
    </section>
    <!-- Indicadores -->
    <section aria-label="Resumen de estadísticas" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="dashboard-card dashboard-stat relative isolate overflow-hidden p-5 sm:p-6" style="--stat-glow:#e0e7ff">
            <div class="relative z-10 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-extrabold uppercase tracking-[.13em] text-slate-500">Total de pacientes</p>
                    <p class="mt-3 text-3xl font-black tracking-tight text-slate-900"><?= htmlspecialchars((string)($stats['pacientes'] ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-700">
                        <i data-lucide="users" class="h-3.5 w-3.5"></i>
                        Pacientes registrados
                    </p>
                </div>
                <span class="dashboard-icon bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-100">
                    <i data-lucide="users-round" class="h-5 w-5"></i>
                </span>
            </div>
        </article>
        <article class="dashboard-card dashboard-stat relative isolate overflow-hidden p-5 sm:p-6" style="--stat-glow:#cffafe">
            <div class="relative z-10 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-extrabold uppercase tracking-[.13em] text-slate-500">Citas de hoy</p>
                    <p class="mt-3 text-3xl font-black tracking-tight text-slate-900"><?= htmlspecialchars((string)($stats['citas_hoy'] ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-cyan-800">
                        <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i>
                        Agenda del día
                    </p>
                </div>
                <span class="dashboard-icon bg-cyan-50 text-cyan-700 ring-1 ring-inset ring-cyan-100">
                    <i data-lucide="calendar-check-2" class="h-5 w-5"></i>
                </span>
            </div>
        </article>
        <article class="dashboard-card dashboard-stat relative isolate overflow-hidden p-5 sm:p-6" style="--stat-glow:#ffe4e6">
            <div class="relative z-10 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-extrabold uppercase tracking-[.13em] text-slate-500">Historias clínicas</p>
                    <p class="mt-3 text-3xl font-black tracking-tight text-slate-900"><?= htmlspecialchars((string)($stats['historias'] ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-rose-700">
                        <i data-lucide="file-check-2" class="h-3.5 w-3.5"></i>
                        Expedientes registrados
                    </p>
                </div>
                <span class="dashboard-icon bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-100">
                    <i data-lucide="folder-heart" class="h-5 w-5"></i>
                </span>
            </div>
        </article>
        <article class="dashboard-card dashboard-stat relative isolate overflow-hidden p-5 sm:p-6" style="--stat-glow:#fef3c7">
            <div class="relative z-10 flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-[11px] font-extrabold uppercase tracking-[.13em] text-slate-500">Personal activo</p>
                    <p class="mt-3 text-3xl font-black tracking-tight text-slate-900"><?= htmlspecialchars((string)($stats['doctores'] ?? 0), ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-amber-700">
                        <i data-lucide="user-check" class="h-3.5 w-3.5"></i>
                        Doctores
                    </p>
                </div>
                <span class="dashboard-icon bg-amber-50 text-amber-700 ring-1 ring-inset ring-amber-100">
                    <i data-lucide="stethoscope" class="h-5 w-5"></i>
                </span>
            </div>
        </article>
    </section>
    <!-- Accesos rápidos -->
    <section class="dashboard-card p-5 sm:p-6">
        <div class="mb-5 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-[.18em] text-teal-700">Navegación</p>
                <h2 class="dashboard-section-title mt-1 text-lg font-extrabold text-slate-900">Accesos rápidos</h2>
                <p class="mt-1 text-sm text-slate-500">Entra directamente a los módulos disponibles para tu cuenta.</p>
            </div>
            <span class="hidden items-center gap-1.5 text-xs font-semibold text-slate-400 sm:inline-flex">
                <i data-lucide="mouse-pointer-click" class="h-4 w-4"></i>
                Selecciona un módulo
            </span>
        </div>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
            <?php if (function_exists('hasPermission') && hasPermission('pacientes')): ?>
                <a href="<?= BASE_URL ?>/paciente/index" class="dashboard-shortcut group flex flex-col items-center justify-center gap-3 p-4 text-center focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-2">
                    <span class="dashboard-icon bg-indigo-50 text-indigo-700 ring-1 ring-indigo-100 transition group-hover:bg-indigo-600 group-hover:text-white">
                        <i data-lucide="users-round" class="h-5 w-5"></i>
                    </span>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-indigo-700 sm:text-sm">Pacientes</span>
                </a>
            <?php endif; ?>
            <?php if (function_exists('hasPermission') && hasPermission('citas')): ?>
                <a href="<?= BASE_URL ?>/cita/index" class="dashboard-shortcut group flex flex-col items-center justify-center gap-3 p-4 text-center focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2">
                    <span class="dashboard-icon bg-cyan-50 text-cyan-700 ring-1 ring-cyan-100 transition group-hover:bg-cyan-600 group-hover:text-white">
                        <i data-lucide="calendar-days" class="h-5 w-5"></i>
                    </span>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-cyan-700 sm:text-sm">Citas</span>
                </a>
            <?php endif; ?>
            <?php if (function_exists('hasPermission') && (hasPermission('historias') || hasPermission('historias_odontologia'))): ?>
                <a href="<?= BASE_URL ?>/historias/odontologia" class="dashboard-shortcut group flex flex-col items-center justify-center gap-3 p-4 text-center focus:outline-none focus:ring-2 focus:ring-rose-400 focus:ring-offset-2">
                    <span class="dashboard-icon bg-rose-50 text-rose-700 ring-1 ring-rose-100 transition group-hover:bg-rose-600 group-hover:text-white">
                        <i data-lucide="clipboard-plus" class="h-5 w-5"></i>
                    </span>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-rose-700 sm:text-sm">Odontología</span>
                </a>
            <?php endif; ?>
            <?php if (function_exists('hasPermission') && hasPermission('usuarios')): ?>
                <a href="<?= BASE_URL ?>/usuarios/index" class="dashboard-shortcut group flex flex-col items-center justify-center gap-3 p-4 text-center focus:outline-none focus:ring-2 focus:ring-amber-400 focus:ring-offset-2">
                    <span class="dashboard-icon bg-amber-50 text-amber-700 ring-1 ring-amber-100 transition group-hover:bg-amber-500 group-hover:text-white">
                        <i data-lucide="user-cog" class="h-5 w-5"></i>
                    </span>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-amber-700 sm:text-sm">Usuarios</span>
                </a>
            <?php endif; ?>
            <?php if (function_exists('hasPermission') && hasPermission('reportes')): ?>
                <a href="<?= BASE_URL ?>/reporte/index" class="dashboard-shortcut group flex flex-col items-center justify-center gap-3 p-4 text-center focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2">
                    <span class="dashboard-icon bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100 transition group-hover:bg-emerald-600 group-hover:text-white">
                        <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                    </span>
                    <span class="text-xs font-bold text-slate-700 group-hover:text-emerald-700 sm:text-sm">Reportes</span>
                </a>
            <?php endif; ?>
        </div>
    </section>
    <!-- Agenda y avisos -->
    <section class="grid grid-cols-1 items-start gap-5 xl:grid-cols-3">
        <div class="dashboard-card min-w-0 overflow-hidden xl:col-span-2">
            <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <div class="flex items-center gap-3">
                    <span class="dashboard-icon bg-blue-50 text-blue-700 ring-1 ring-blue-100">
                        <i data-lucide="calendar-clock" class="h-5 w-5"></i>
                    </span>
                    <div>
                        <h2 class="dashboard-section-title text-base font-extrabold text-slate-900">Citas programadas para hoy</h2>
                        <p class="mt-1 text-xs text-slate-500">Vista rápida de la agenda diaria</p>
                    </div>
                </div>
                <?php if (function_exists('hasPermission') && hasPermission('citas')): ?>
                    <a href="<?= defined('BASE_URL') ? BASE_URL : '#' ?>/cita/index" class="inline-flex items-center justify-center gap-2 self-start rounded-xl bg-blue-50 px-3.5 py-2.5 text-xs font-bold text-blue-800 transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 sm:self-auto">
                        Ver agenda completa
                        <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="overflow-x-auto">
                <table class="dashboard-table w-full min-w-[600px] border-collapse text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 text-[10px] font-extrabold uppercase tracking-[.13em] text-slate-500">
                            <th class="px-5 py-3.5 sm:px-6">Paciente</th>
                            <th class="px-5 py-3.5">Hora</th>
                            <th class="px-5 py-3.5">Doctor</th>
                            <th class="px-5 py-3.5">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($citasHoy)): ?>
                            <?php foreach ($citasHoy as $cita): ?>
                                <?php
                                $estado = strtolower(trim((string) ($cita['estado'] ?? 'pendiente')));
                                $estadoConfig = match ($estado) {
                                    'atendida', 'completada' => ['bg' => 'bg-emerald-50 text-emerald-800 border-emerald-200', 'dot' => 'bg-emerald-500'],
                                    'cancelada' => ['bg' => 'bg-rose-50 text-rose-800 border-rose-200', 'dot' => 'bg-rose-500'],
                                    default => ['bg' => 'bg-amber-50 text-amber-800 border-amber-200', 'dot' => 'bg-amber-500'],
                                };
                                $horaCita = !empty($cita['hora']) ? date('h:i A', strtotime($cita['hora'])) : 'Por confirmar';
                                ?>
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                                <i data-lucide="user-round" class="h-4 w-4"></i>
                                            </span>
                                            <span class="font-bold text-slate-800"><?= htmlspecialchars((string)($cita['paciente_nombre'] ?? $cita['paciente'] ?? 'Sin nombre'), ENT_QUOTES, 'UTF-8') ?></span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1.5 rounded-lg border border-blue-100 bg-blue-50 px-2.5 py-1.5 text-xs font-bold text-blue-800">
                                            <i data-lucide="clock-3" class="h-3.5 w-3.5"></i>
                                            <?= htmlspecialchars($horaCita, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-slate-600"><?= htmlspecialchars((string)($cita['doctor_nombre'] ?? $cita['doctor'] ?? 'Doctor asignado'), ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-2 rounded-full border px-2.5 py-1.5 text-[11px] font-bold capitalize <?= $estadoConfig['bg'] ?>"><span class="h-1.5 w-1.5 rounded-full <?= $estadoConfig['dot'] ?>"></span><?= htmlspecialchars($estado !== '' ? $estado : 'pendiente', ENT_QUOTES, 'UTF-8') ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center sm:px-6">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="calendar-search" class="h-7 w-7"></i>
                                    </div>
                                    <p class="mt-4 text-sm font-bold text-slate-800">No hay citas programadas para hoy</p>
                                    <p class="mx-auto mt-1 max-w-sm text-xs leading-5 text-slate-500">Cuando se registren citas para esta fecha, aparecerán aquí.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="flex items-center gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-3.5 text-xs text-slate-500 sm:px-6">
                <i data-lucide="info" class="h-4 w-4 shrink-0 text-blue-600"></i>
                Los datos mostrados corresponden a las citas disponibles para tu usuario.
            </div>
        </div>
        <aside class="dashboard-card p-5 sm:p-6">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <span class="dashboard-icon bg-amber-50 text-amber-700 ring-1 ring-amber-100">
                    <i data-lucide="bell-ring" class="h-5 w-5"></i>
                </span>
                <div>
                    <h2 class="dashboard-section-title text-base font-extrabold text-slate-900">Avisos del sistema</h2>
                    <p class="mt-1 text-xs text-slate-500">Información importante</p>
                </div>
            </div>
            <div class="mt-4 space-y-3">
                <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-4">
                    <div class="flex items-center gap-2 text-sm font-extrabold text-indigo-950">
                        <i data-lucide="shield-check" class="h-4 w-4 text-indigo-600"></i>
                        Acceso seguro
                    </div>
                    <p class="mt-2 text-xs leading-5 text-indigo-900/75">Tu cuenta muestra los módulos habilitados según los permisos asignados por el administrador.</p>
                </div>
                <div class="rounded-2xl border border-teal-100 bg-gradient-to-br from-teal-50 to-white p-4">
                    <div class="flex items-center gap-2 text-sm font-extrabold text-teal-950">
                        <i data-lucide="database" class="h-4 w-4 text-teal-700"></i>
                        Entorno del sistema
                    </div>
                    <p class="mt-2 text-xs leading-5 text-teal-900/75">Trabaja con cuidado y verifica los datos clínicos antes de guardar cambios en los expedientes.</p>
                </div>
                <div class="rounded-2xl border border-amber-100 bg-amber-50/70 p-4">
                    <div class="flex items-start gap-2">
                        <i data-lucide="lightbulb" class="mt-0.5 h-4 w-4 shrink-0 text-amber-700"></i>
                        <p class="text-xs leading-5 text-amber-950">
                            <strong>Consejo:</strong>
                            mantén actualizada la información de pacientes y citas para facilitar el seguimiento clínico.
                        </p>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</div>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }
    });
</script>
