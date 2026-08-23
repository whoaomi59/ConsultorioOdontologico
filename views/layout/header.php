<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema Clínico Odontológico</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
        <link rel="stylesheet" href="./public/css/style.css">
    </head>
    <body class="bg-slate-100 text-slate-800 font-sans min-h-screen flex">

        <aside class="w-64 bg-indigo-900 text-white flex flex-col min-h-screen shadow-lg shrink-0">
            <div class="p-5 border-b border-indigo-800/60 flex items-center space-x-3">
                <div class="p-2 bg-indigo-800/80 rounded-xl">
                    <i data-lucide="activity" class="w-6 h-6 text-indigo-300"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-none tracking-wide">DentalControl</h1>
                    <span class="text-xs text-indigo-300 font-normal">Gestión Odontológica</span>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1.5">
                <a href="<?= BASE_URL ?>/dashboard" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-indigo-300"></i>
                    <span>dashboard</span>
                </a>

                <?php if (hasPermission('pacientes')): ?>
                    <a href="<?= BASE_URL ?>/paciente/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                        <i data-lucide="users" class="w-5 h-5 text-indigo-300"></i>
                        <span>Pacientes</span>
                    </a>
                <?php endif; ?>

                <?php if (hasPermission('citas')): ?>
                    <a href="<?= BASE_URL ?>/cita/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                        <i data-lucide="calendar" class="w-5 h-5 text-indigo-300"></i>
                        <span>Citas Odontológicas</span>
                    </a>
                <?php endif; ?>

                <?php if (hasPermission('historia')): ?>
                    <div class="space-y-1">
                        <button type="button" onclick="toggleDropdown('historias-dropdown', 'historias-arrow')" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm focus:outline-none">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="folder-heart" class="w-5 h-5 text-indigo-300"></i>
                                <span>Historias Clínicas</span>
                            </div>
                            <i id="historias-arrow" data-lucide="chevron-down" class="w-4 h-4 text-indigo-300 transition-transform duration-200"></i>
                        </button>

                        <div id="historias-dropdown" class="hidden pl-11 pr-2 py-1 space-y-1">
                            <?php if (hasPermission('historia_odontologia')): ?>
                                <a href="<?= BASE_URL ?>/historias/odontologia" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                                    <i data-lucide="file-text" class="w-5 h-5 text-indigo-400"></i>
                                    <span>Odontología</span>
                                </a>
                            <?php endif; ?>
                            <?php if (hasPermission('historia_ortodoncia')): ?>
                                <a href="<?= BASE_URL ?>/historia/ortodoncia" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                                    <i data-lucide="smile" class="w-5 h-5 text-indigo-400"></i>
                                    <span>Ortodoncias</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (hasPermission('usuarios')): ?>
                    <a href="<?= BASE_URL ?>/usuarios/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                        <i data-lucide="user-cog" class="w-5 h-5 text-indigo-300"></i>
                        <span>Usuarios / Doctores</span>
                    </a>
                <?php endif; ?>

                <?php if (hasPermission('reportes')): ?>
                    <a href="<?= BASE_URL ?>/reporte/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-300"></i>
                        <span>Reportes</span>
                    </a>
                <?php endif; ?>
                <?php if (hasPermission('configuracion')): ?>
                    <a href="<?= BASE_URL ?>/consultorio/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                        <i data-lucide="cog" class="w-5 h-5 text-indigo-300"></i>
                        <span>Configuración</span>
                    </a>
                <?php endif; ?>

            </nav>

            <div class="p-4 border-t border-indigo-800/60 flex items-center justify-between">
                <div class="flex items-center space-x-3 text-xs text-indigo-300 overflow-hidden">
                    <div class="p-2 bg-indigo-800/60 rounded-lg shrink-0">
                        <i data-lucide="user" class="w-4 h-4 text-indigo-300"></i>
                    </div>
                    <div class="truncate">
                        <span class="block text-[10px] text-indigo-400 uppercase tracking-wider">Sesión actual</span>
                        <strong class="text-white text-xs truncate block">
                            <?= $_SESSION['usuario_nombre'] ?? 'Usuario' ?>
                        </strong>
                    </div>
                </div>

                <a href="<?= BASE_URL ?>/logout" title="Cerrar Sesión" class="p-2 text-indigo-300 hover:text-rose-400 hover:bg-indigo-800/80 rounded-lg transition shrink-0">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-slate-700">Módulo Odontológico</h2>

                <div class="flex items-center space-x-4">
                    <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full flex items-center space-x-1.5">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span>
                            <?= $_SESSION['usuario_nombre'] ?? 'Usuario' ?>
                        </span>
                    </span>

                    <a href="<?= BASE_URL ?>/logout" class="flex items-center space-x-1.5 text-xs text-rose-600 hover:text-rose-700 font-medium hover:bg-rose-50 px-2.5 py-1.5 rounded-lg transition">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                        <span>Salir</span>
                    </a>
                </div>
            </header>

            <main class="p-8 max-w-7xl mx-auto w-full flex-grow">
                <?php if (!empty($_SESSION['error_acceso'])): ?>
                    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-alert" class="w-4 h-4 text-rose-600"></i>
                            <span><?= htmlspecialchars($_SESSION['error_acceso']) ?></span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-600">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <?php unset($_SESSION['error_acceso']); ?>
                <?php endif; ?>

                <script>
                    // Inicializar íconos Lucide
                    lucide.createIcons();

                    // Función para abrir/cerrar desplegables
                    function toggleDropdown(menuId, arrowId) {
                        const menu  = document.getElementById(menuId);
                        const arrow = document.getElementById(arrowId);

                        menu.classList.toggle('hidden');
                        arrow.classList.toggle('rotate-180');
                    }
                </script>