<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistema Clínico Odontológico</title>
        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="bg-slate-100 text-slate-800 font-sans min-h-screen flex">

        <!-- Menú Lateral Fijo (Sidebar) -->
        <aside class="w-64 bg-indigo-900 text-white flex flex-col min-h-screen shadow-lg shrink-0">
            <!-- Logo Header -->
            <div class="p-5 border-b border-indigo-800/60 flex items-center space-x-3">
                <div class="p-2 bg-indigo-800/80 rounded-xl">
                    <i data-lucide="activity" class="w-6 h-6 text-indigo-300"></i>
                </div>
                <div>
                    <h1 class="font-bold text-lg leading-none tracking-wide">DentalControl</h1>
                    <span class="text-xs text-indigo-300 font-normal">Gestión Odontológica</span>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 p-4 space-y-1.5">
                <!-- Pacientes -->
                <a href="<?= BASE_URL ?>/paciente/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                    <i data-lucide="users" class="w-5 h-5 text-indigo-300"></i>
                    <span>Pacientes</span>
                </a>

                <!-- Citas Odontológicas -->
                <a href="<?= BASE_URL ?>/cita/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                    <i data-lucide="calendar" class="w-5 h-5 text-indigo-300"></i>
                    <span>Citas Odontológicas</span>
                </a>

                <!-- Desplegable: Historias Clínicas -->
                <div class="space-y-1">
                    <button type="button" onclick="toggleDropdown('historias-dropdown', 'historias-arrow')" class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm focus:outline-none">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="folder-heart" class="w-5 h-5 text-indigo-300"></i>
                            <span>Historias Clínicas</span>
                        </div>
                        <i id="historias-arrow" data-lucide="chevron-down" class="w-4 h-4 text-indigo-300 transition-transform duration-200"></i>
                    </button>

                    <!-- Submenú -->
                    <div id="historias-dropdown" class="hidden pl-11 pr-2 py-1 space-y-1">
                        <a href="<?= BASE_URL ?>/historias/odontologia" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                            <i data-lucide="file-text" class="w-5 h-5 text-indigo-400"></i>
                            <span>Odontología</span>
                        </a>
                        <a href="<?= BASE_URL ?>/historia/ortodoncia" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                            <i data-lucide="smile" class="w-5 h-5 text-indigo-400"></i>
                            <span>Ortodoncias</span>
                        </a>
                    </div>
                </div>

                <!-- Usuarios / Doctores -->
                <a href="<?= BASE_URL ?>/usuarios/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                    <i data-lucide="user-cog" class="w-5 h-5 text-indigo-300"></i>
                    <span>Usuarios / Doctores</span>
                </a>

                <!-- Reportes -->
                <a href="<?= BASE_URL ?>/reporte/index" class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-indigo-800/70 text-indigo-100 font-medium transition text-sm">
                    <i data-lucide="bar-chart-3" class="w-5 h-5 text-indigo-300"></i>
                    <span>Reportes</span>
                </a>
            </nav>

            <!-- Footer Sidebar -->
            <div class="p-4 border-t border-indigo-800/60 flex items-center space-x-3 text-xs text-indigo-300">
                <i data-lucide="user" class="w-4 h-4 text-indigo-300"></i>
                <div>
                    <span class="block text-[10px] text-indigo-400 uppercase tracking-wider">Sesión actual</span>
                    <strong class="text-white text-xs">Dr. Administrador</strong>
                </div>
            </div>
        </aside>

        <!-- Área Principal -->
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <header class="bg-white shadow-sm border-b px-8 py-4 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-slate-700">Módulo Odontológico</h2>
                <span class="text-xs bg-emerald-100 text-emerald-800 font-bold px-2.5 py-1 rounded-full flex items-center space-x-1.5">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    <span>Sistema Activo</span>
                </span>
            </header>

            <main class="p-8 max-w-7xl mx-auto w-full flex-grow">

                <!-- Scripts de Interactividad e Íconos -->
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