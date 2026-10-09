<?php
/**
 * ============================================================
 * HEADER PRINCIPAL
 * CONSULTORIO ODONTOLÓGICO
 * ============================================================
 */

require_once ROOT_PATH . '/models/Consultorio.php';

/* ============================================================
   CONEXIÓN
============================================================ */

if (!isset($db) && isset($GLOBALS['db'])) {
    $db = $GLOBALS['db'];
}

/* ============================================================
   INFORMACIÓN DEL CONSULTORIO
============================================================ */

$consultorioModel = new Consultorio($db ?? null);

$infoConsultorio = [];

if (method_exists($consultorioModel, 'getInfo') && isset($db)) {
    $infoConsultorio = $consultorioModel->getInfo();
}

$logoNavbar = $infoConsultorio['Logo'] ?? ($infoConsultorio['logo'] ?? '');

$nombreConsultorio = $infoConsultorio['Nombre'] ?? ($infoConsultorio['nombre'] ?? 'DentalControl');

/* ============================================================
   URL ACTUAL
============================================================ */

$currentUrl = isset($_GET['url']) ? (string) $_GET['url'] : '';

$currentUrl = trim($currentUrl, '/');

/* ============================================================
   USUARIO ACTUAL
============================================================ */

$usuarioNombre = (string) ($_SESSION['usuario_nombre'] ?? 'Usuario');

$usuarioRol = (string) ($_SESSION['usuario_rol'] ?? 'Usuario');

$usuarioFoto = (string) ($_SESSION['usuario_foto'] ?? '');

/* ============================================================
   INICIALES
============================================================ */

$nombrePartes = preg_split('/\s+/', trim($usuarioNombre));

$iniciales = '';

if (is_array($nombrePartes) && count($nombrePartes) >= 2) {
    $iniciales = mb_substr($nombrePartes[0], 0, 1) . mb_substr($nombrePartes[1], 0, 1);
} else {
    $iniciales = mb_substr($usuarioNombre, 0, 2);
}

$iniciales = strtoupper($iniciales);

/* ============================================================
   FUNCIÓN DE RUTA ACTIVA
============================================================ */

if (!function_exists('menuActivo')) {
    function menuActivo(string $ruta): bool
    {
        $url = isset($_GET['url']) ? (string) $_GET['url'] : '';

        $url = trim($url, '/');
        $ruta = trim($ruta, '/');

        if ($url === '') {
            return $ruta === 'dashboard';
        }

        return $url === $ruta || str_starts_with($url, $ruta . '/');
    }
}

/* ============================================================
   HISTORIAS ACTIVAS
============================================================ */

$historiasActivas = str_contains($currentUrl, 'historia') || str_contains($currentUrl, 'historias') || str_contains($currentUrl, 'ortodoncia');

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($nombreConsultorio) ?> | Sistema Odontológico </title>
        <!-- Tailwind -->
        <script src="https://cdn.tailwindcss.com">
        </script>
        <!-- Lucide -->
        <script src="https://unpkg.com/lucide@latest">
        </script>
        <!-- Favicon -->
        <link rel="icon" href="<?= BASE_URL ?>/public/img/diente.jpg" type="image/x-icon">
        <!-- CSS DEL SISTEMA -->
        <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
        <style>
            /* =====================================================
                                                                                                           VARIABLES
                                                                                                        ===================================================== */
            
            :root {
                --menu-width: 260px;
            }
            
            /* =====================================================
                                                                                                           BODY
                                                                                                        ===================================================== */
            
            html,
            body {
                margin: 0;
                padding: 0;
                min-height: 100%;
            }
            
            /* =====================================================
                                                                                                           SIDEBAR
                                                                                                        ===================================================== */
            
            #sidebar {
                width: var(--menu-width);
            }
            
            /* =====================================================
                                                                                                           SCROLL DEL MENÚ
                                                                                                        ===================================================== */
            
            #sidebar-nav {
                scrollbar-width: thin;
                scrollbar-color: rgba(148, 163, 184, 0.25) transparent;
            }
            
            #sidebar-nav::-webkit-scrollbar {
                width: 5px;
            }
            
            #sidebar-nav::-webkit-scrollbar-track {
                background: transparent;
            }
            
            #sidebar-nav::-webkit-scrollbar-thumb {
                background: rgba(148, 163, 184, 0.25);
                border-radius: 10px;
            }
            
            /* =====================================================
                                                                                                           OVERLAY
                                                                                                        ===================================================== */
            
            #sidebar-overlay {
                transition:
                    opacity 0.25s ease,
                    visibility 0.25s ease;
            }
            
            /* =====================================================
                                                                                                           TRANSICIONES
                                                                                                        ===================================================== */
            
            .menu-item {
                transition:
                    background-color 0.18s ease,
                    color 0.18s ease,
                    transform 0.18s ease;
            }
            
            .menu-item:hover {
                transform: translateX(2px);
            }
            
            /* =====================================================
                                                                                                           MÓVIL
                                                                                                        ===================================================== */
            
            @media (max-width: 1023px) {
                #sidebar {
                    position: fixed;
                    top: 0;
                    bottom: 0;
                    left: 0;
                    height: 100dvh;
                    z-index: 60;
                }
            
                #sidebar.sidebar-hidden {
                    transform: translateX(-100%);
                }
            
                #sidebar.sidebar-visible {
                    transform: translateX(0);
                }
            
                #sidebar-overlay.overlay-visible {
                    opacity: 1;
                    visibility: visible;
                }
            }
            
            /* =====================================================
                                                                                                           DESKTOP
                                                                                                        ===================================================== */
            
            @media (min-width: 1024px) {
                #sidebar {
                    position: sticky;
                    top: 0;
                    height: 100vh;
                    flex-shrink: 0;
                }
            
                #mobile-menu-button {
                    display: none;
                }
            }
            
            /* =====================================================
                                                                                                           PANTALLAS PEQUEÑAS
                                                                                                        ===================================================== */
            
            @media (max-width: 480px) {
                #sidebar {
                    width: min(88vw, 300px);
                }
            
                #topbar-title {
                    display: none;
                }
            
                #topbar-user-name {
                    display: none;
                }
            
                #topbar-status {
                    display: none;
                }
            
                main {
                    padding: 1rem !important;
                }
            }
        </style>
        <style>
            /* DentalControl · acabado premium para navegación global */
            :root {
                --dc-ink: #17243b;
                --dc-blue: #315ee8;
                --dc-teal: #0e9488;
                --dc-line: #e4ebf4;
            }
            body {
                background: radial-gradient(ellipse at 90% 0%, rgba(14, 148, 136, 0.045), transparent 28%), #f4f7fb !important;
            }
            #sidebar {
                background: linear-gradient(180deg, #101b33 0%, #111e38 58%, #0d2637 100%) !important;
                border-right: 1px solid rgba(255, 255, 255, 0.07) !important;
                box-shadow: 14px 0 38px rgba(15, 27, 51, 0.1) !important;
            }
            #sidebar > div:first-child {
                min-height: 82px;
                border-bottom-color: rgba(255, 255, 255, 0.09) !important;
                background: linear-gradient(110deg, rgba(255, 255, 255, 0.035), transparent);
            }
            #sidebar > div:first-child img,
            #sidebar > div:first-child div:has(> i[data-lucide='tooth']) {
                border-radius: 15px !important;
            }
            #sidebar nav > p {
                color: #7185a5 !important;
                font-size: 9px !important;
                letter-spacing: 0.19em !important;
            }
            #sidebar .menu-item {
                position: relative;
                min-height: 42px;
                border: 1px solid transparent;
                border-radius: 12px !important;
                transition:
                    background 0.18s ease,
                    color 0.18s ease,
                    border-color 0.18s ease,
                    transform 0.18s ease,
                    box-shadow 0.18s ease;
            }
            #sidebar .menu-item:hover {
                transform: translateX(3px);
                color: #fff !important;
                border-color: rgba(255, 255, 255, 0.075);
                background: rgba(255, 255, 255, 0.065) !important;
            }
            #sidebar .menu-item[class*='bg-indigo-600'] {
                color: #fff !important;
                border-color: rgba(130, 166, 255, 0.25) !important;
                background: linear-gradient(105deg, #315ee8, #2849b8 65%, #087f86) !important;
                box-shadow:
                    0 8px 18px rgba(28, 76, 184, 0.24),
                    inset 0 1px 0 rgba(255, 255, 255, 0.12);
            }
            #sidebar .menu-item[class*='bg-indigo-600']::before {
                content: '';
                position: absolute;
                left: -13px;
                top: 10px;
                bottom: 10px;
                width: 3px;
                border-radius: 0 4px 4px 0;
                background: #77e6d6;
            }
            #historias-dropdown {
                border-left-color: rgba(137, 164, 206, 0.25) !important;
            }
            #sidebar > div:last-child {
                border-top-color: rgba(255, 255, 255, 0.09) !important;
                background: rgba(0, 0, 0, 0.1);
            }
            #sidebar > div:last-child a:hover {
                background: rgba(244, 63, 94, 0.11) !important;
            }
            body > div.flex-1 > header,
            body .min-h-screen.flex.flex-col > header {
                background: rgba(255, 255, 255, 0.91) !important;
                border-bottom-color: rgba(220, 230, 242, 0.9) !important;
                box-shadow: 0 5px 22px rgba(23, 36, 59, 0.035);
                backdrop-filter: blur(16px);
            }
            #topbar-title p {
                color: #0e9488 !important;
                font-weight: 800 !important;
            }
            #topbar-title h2 {
                letter-spacing: -0.025em;
            }
            #topbar-status {
                border-radius: 999px !important;
                padding: 8px 12px !important;
            }
            #topbar-status span:first-child {
                box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.11);
            }
            header a[href*='usuarios/miPerfil'] {
                border: 1px solid transparent;
                border-radius: 13px !important;
                transition:
                    background 0.18s ease,
                    border-color 0.18s ease;
            }
            header a[href*='usuarios/miPerfil']:hover {
                border-color: #e3eaf4;
                background: #f5f8fc !important;
            }
            header a[href$='/logout'] {
                border-radius: 12px !important;
            }
            main {
                scroll-margin-top: 80px;
            }
            main > div[class*='border-red-200'] {
                border-radius: 15px !important;
                box-shadow: 0 8px 24px rgba(190, 18, 60, 0.055);
            }
            #mobile-menu-button {
                border: 1px solid #e3eaf4;
                border-radius: 12px !important;
                background: #fff !important;
                box-shadow: 0 3px 9px rgba(23, 36, 59, 0.04);
            }
            #mobile-menu-button:hover {
                background: #edf3ff !important;
            }
            #sidebar-overlay {
                background: rgba(8, 18, 37, 0.64) !important;
                backdrop-filter: blur(5px);
            }
            #sidebar a:focus-visible,
            #sidebar button:focus-visible,
            header a:focus-visible,
            header button:focus-visible {
                outline: 3px solid rgba(105, 145, 255, 0.75);
                outline-offset: 3px;
            }
            @media (max-width: 1023px) {
                #sidebar {
                    box-shadow: 22px 0 55px rgba(5, 14, 31, 0.28) !important;
                }
            }
            @media (prefers-reduced-motion: reduce) {
                #sidebar *,
                #sidebar *::before,
                #sidebar *::after,
                header *,
                header *::before,
                header *::after {
                    transition-duration: 0.01ms !important;
                    animation-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }
            }
        </style>
    </head>
    <body class="
    bg-slate-100
    text-slate-800
    font-sans
    min-h-screen
    flex
    flex-col
    lg:flex-row
    ">
        <!-- ============================================================
        OVERLAY MÓVIL
        ============================================================ -->
        <div id="sidebar-overlay" class="
        fixed
        inset-0
        bg-slate-950/60
        backdrop-blur-sm
        opacity-0
        invisible
        lg:hidden
        z-50
        " onclick="toggleSidebar()"></div>
        <!-- ============================================================
        SIDEBAR
        ============================================================ -->
        <aside id="sidebar" class="
        sidebar-hidden
        bg-slate-950
        text-white
        flex
        flex-col
        shadow-2xl
        border-r
        border-slate-800
        ">
            <!-- ========================================================
            LOGO
            ========================================================= -->
            <div class="
            h-20
            px-4
            border-b
            border-slate-800
            flex
            items-center
            justify-between
            shrink-0
            ">
                <div class="
                flex
                items-center
                gap-3
                min-w-0
                ">
                    <?php if (!empty($logoNavbar)): ?>
                        <div class="
                        w-11
                        h-11
                        rounded-xl
                        bg-white
                        p-1
                        flex
                        items-center
                        justify-center
                        overflow-hidden
                        shrink-0
                        ">
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($logoNavbar) ?>" alt="Logo" class="
                            max-w-full
                            max-h-full
                            object-contain
                            ">
                        </div>
                    <?php else: ?>
                        <div class="
                        w-11
                        h-11
                        rounded-xl
                        bg-indigo-600
                        flex
                        items-center
                        justify-center
                        shrink-0
                        ">
                            <i data-lucide="tooth" class="w-6 h-6"></i>
                        </div>
                    <?php endif; ?>
                    <div class="min-w-0">
                        <h1 class="
                        text-sm
                        font-bold
                        text-white
                        truncate
                        " title="<?= htmlspecialchars($nombreConsultorio) ?>"><?= htmlspecialchars($nombreConsultorio) ?></h1>
                        <p class="
                        text-[10px]
                        text-slate-400
                        mt-0.5
                        "> Gestión odontológica </p>
                    </div>
                </div>
                <!-- CERRAR EN MÓVIL -->
                <button type="button" onclick="toggleSidebar()" class="
                lg:hidden
                p-2
                rounded-lg
                text-slate-400
                hover:text-white
                hover:bg-slate-800
                ">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            <!-- ========================================================
            NAVEGACIÓN
            ========================================================= -->
            <nav id="sidebar-nav" class="
            flex-1
            overflow-y-auto
            px-3
            pb-4
            ">
                <!-- ====================================================
                PRINCIPAL
                ==================================================== -->
                <p class="
                px-3
                pt-2
                pb-2
                text-[10px]
                uppercase
                tracking-widest
                font-bold
                text-slate-500
                "> Principal </p>
                <!-- DASHBOARD -->
                <a href="<?= BASE_URL ?>/dashboard" class="
                menu-item
                flex
                items-center
                gap-3
                px-3
                py-2.5
                rounded-lg
                mb-1
                <?= menuActivo('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                ">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 shrink-0"></i>
                    <span class="text-sm font-medium"> Dashboard </span>
                </a>
                <!-- MI PERFIL -->
                <a href="<?= BASE_URL ?>/usuarios/miPerfil" class="
                menu-item
                flex
                items-center
                gap-3
                px-3
                py-2.5
                rounded-lg
                mb-1
                <?= menuActivo('usuarios/miPerfil') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                ">
                    <i data-lucide="user-round" class="w-5 h-5 shrink-0"></i>
                    <div class="min-w-0">
                        <span class="block text-sm font-medium"> Mi Perfil </span>
                    </div>
                </a>
                <!-- ====================================================
                ATENCIÓN
                ==================================================== -->
                <p class="
                px-3
                pt-6
                pb-2
                text-[10px]
                uppercase
                tracking-widest
                font-bold
                text-slate-500
                "> Atención </p>
                <!-- PACIENTES -->
                <?php if (hasPermission('pacientes')): ?>
                    <a href="<?= BASE_URL ?>/paciente/index" class="
                    menu-item
                    flex
                    items-center
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    mb-1
                    <?= menuActivo('paciente') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                    ">
                        <i data-lucide="users" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm font-medium"> Pacientes </span>
                    </a>
                <?php endif; ?>
                <!-- CITAS -->
                <?php if (hasPermission('citas')): ?>
                    <a href="<?= BASE_URL ?>/cita" class="
                    menu-item
                    flex
                    items-center
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    mb-1
                    <?= menuActivo('cita') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                    ">
                        <i data-lucide="calendar-days" class="w-5 h-5 shrink-0"></i>
                        <div class="min-w-0">
                            <span class="block text-sm font-medium"> Citas </span>
                        </div>
                    </a>
                <?php endif; ?>
                <!-- HISTORIAS -->
                <?php if (hasPermission('historia')): ?>
                    <button type="button" onclick="toggleDropdown(
                    'historias-dropdown',
                    'historias-arrow'
                    )" class="
                    menu-item
                    w-full
                    flex
                    items-center
                    justify-between
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    text-slate-300
                    hover:bg-slate-800
                    hover:text-white
                    ">
                        <div class="flex items-center gap-3 min-w-0">
                            <i data-lucide="folder-heart" class="
                            w-5
                            h-5
                            shrink-0
                            "></i>
                            <span class="text-sm font-medium truncate"> Historias Clínicas </span>
                        </div>
                        <i id="historias-arrow" data-lucide="chevron-down" class="
                        w-4
                        h-4
                        shrink-0
                        transition-transform
                        <?= $historiasActivas ? 'rotate-180' : '' ?>
                        "></i>
                    </button>
                    <div id="historias-dropdown" class="
                    <?= $historiasActivas ? '' : 'hidden' ?>
                    ml-4
                    pl-4
                    border-l
                    border-slate-800
                    mt-1
                    space-y-1
                    ">
                        <?php if (hasPermission('historia_odontologia')): ?>
                            <a href="<?= BASE_URL ?>/historias/odontologia" class="
                            menu-item
                            flex
                            items-center
                            gap-3
                            px-3
                            py-2.5
                            rounded-lg
                            text-slate-400
                            hover:bg-slate-800
                            hover:text-white
                            ">
                                <i data-lucide="file-text" class="w-4 h-4"></i>
                                <span class="text-sm"> Odontología </span>
                            </a>
                        <?php endif; ?>
                        <?php if (hasPermission('historia_ortodoncia')): ?>
                            <a href="<?= BASE_URL ?>/ortodoncia/ortodoncia" class="
                            menu-item
                            flex
                            items-center
                            gap-3
                            px-3
                            py-2.5
                            rounded-lg
                            text-slate-400
                            hover:bg-slate-800
                            hover:text-white
                            ">
                                <i data-lucide="smile" class="w-4 h-4"></i>
                                <span class="text-sm"> Ortodoncias </span>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <!-- ====================================================
                ADMINISTRACIÓN
                ==================================================== -->
                <!-- USUARIOS -->
                <?php if (hasPermission('usuarios')): ?>
                    <a href="<?= BASE_URL ?>/usuarios/index" class="
                    menu-item
                    flex
                    items-center
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    mb-1
                    <?= menuActivo('usuarios/index') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                    ">
                        <i data-lucide="user-cog" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm font-medium"> Usuarios / Doctores </span>
                    </a>
                <?php endif; ?>
                <!-- REPORTES -->
                <?php if (hasPermission('reportes')): ?>
                    <a href="<?= BASE_URL ?>/reporte/index" class="
                    menu-item
                    flex
                    items-center
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    mb-1
                    <?= menuActivo('reporte') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                    ">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm font-medium"> Reportes </span>
                    </a>
                <?php endif; ?>
                <!-- CONFIGURACIÓN -->
                <?php if (hasPermission('configuracion')): ?>
                    <a href="<?= BASE_URL ?>/consultorio/index" class="
                    menu-item
                    flex
                    items-center
                    gap-3
                    px-3
                    py-2.5
                    rounded-lg
                    mb-1
                    <?= menuActivo('consultorio') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' ?>
                    ">
                        <i data-lucide="settings" class="w-5 h-5 shrink-0"></i>
                        <span class="text-sm font-medium"> Configuración </span>
                    </a>
                <?php endif; ?>
            </nav>
            <!-- ========================================================
            PIE
            ========================================================= -->
            <div class="
            shrink-0
            border-t
            border-slate-800
            p-3
            ">
                <a href="<?= BASE_URL ?>/logout" class="
                menu-item
                flex
                items-center
                gap-3
                px-3
                py-2.5
                rounded-lg
                text-slate-400
                hover:bg-red-500/10
                hover:text-red-300
                ">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="text-sm font-medium"> Cerrar sesión </span>
                </a>
            </div>
        </aside>
        <!-- ============================================================
        CONTENIDO PRINCIPAL
        ============================================================ -->
        <div class="
        flex-1
        min-w-0
        min-h-screen
        flex
        flex-col
        ">
            <!-- ========================================================
            TOPBAR
            ========================================================= -->
            <header class="
            sticky
            top-0
            z-40
            bg-white
            border-b
            border-slate-200
            h-16
            px-4
            sm:px-6
            flex
            items-center
            justify-between
            ">
                <!-- IZQUIERDA -->
                <div class="flex items-center gap-3 min-w-0">
                    <!-- BOTÓN MÓVIL -->
                    <button id="mobile-menu-button" type="button" onclick="toggleSidebar()" class="
                    lg:hidden
                    w-10
                    h-10
                    rounded-lg
                    bg-slate-100
                    text-slate-600
                    flex
                    items-center
                    justify-center
                    hover:bg-indigo-50
                    hover:text-indigo-600
                    transition
                    shrink-0
                    ">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div id="topbar-title" class="min-w-0">
                        <p class="
                        text-[10px]
                        uppercase
                        tracking-wider
                        text-slate-400
                        font-semibold
                        "> Sistema Clínico </p>
                        <h2 class="
                        text-sm
                        sm:text-base
                        font-bold
                        text-slate-800
                        truncate
                        "> Módulo Odontológico </h2>
                    </div>
                </div>
                <!-- DERECHA -->
                <div class="
                flex
                items-center
                gap-2
                sm:gap-3
                ">
                    <!-- ESTADO -->
                    <div id="topbar-status" class="
                    hidden
                    sm:flex
                    items-center
                    gap-2
                    px-3
                    py-2
                    rounded-lg
                    bg-emerald-50
                    border
                    border-emerald-100
                    ">
                        <span class="
                        w-2
                        h-2
                        rounded-full
                        bg-emerald-500
                        "></span>
                        <span class="
                        text-[10px]
                        font-semibold
                        text-emerald-700
                        "> En línea </span>
                    </div>
                    <!-- PERFIL -->
                    <a href="<?= BASE_URL ?>/usuarios/miPerfil" class="
                    flex
                    items-center
                    gap-2
                    rounded-lg
                    p-1.5
                    sm:pr-2.5
                    hover:bg-slate-100
                    transition
                    min-w-0
                    " title="Mi Perfil">
                        <?php if (!empty($usuarioFoto)): ?>
                            <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuarioFoto) ?>" alt="Perfil" class="
                            w-9
                            h-9
                            rounded-lg
                            object-cover
                            shrink-0
                            ">
                        <?php else: ?>
                            <div class="
                            w-9
                            h-9
                            rounded-lg
                            bg-indigo-600
                            text-white
                            flex
                            items-center
                            justify-center
                            text-xs
                            font-bold
                            shrink-0
                            "><?= htmlspecialchars($iniciales) ?></div>
                        <?php endif; ?>
                        <div id="topbar-user-name" class="hidden sm:block min-w-0">
                            <p class="
                            text-xs
                            font-semibold
                            text-slate-700
                            truncate
                            max-w-[140px]
                            "><?= htmlspecialchars($usuarioNombre) ?></p>
                            <p class="
                            text-[10px]
                            text-slate-400
                            truncate
                            "><?= htmlspecialchars(ucfirst($usuarioRol)) ?></p>
                        </div>
                        <i data-lucide="chevron-down" class="
                        hidden
                        sm:block
                        w-4
                        h-4
                        text-slate-400
                        "></i>
                    </a>
                    <!-- SALIR -->
                    <a href="<?= BASE_URL ?>/logout" title="Cerrar sesión" class="
                    w-9
                    h-9
                    rounded-lg
                    flex
                    items-center
                    justify-center
                    text-slate-400
                    hover:bg-red-50
                    hover:text-red-600
                    transition
                    ">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                    </a>
                </div>
            </header>
            <!-- ========================================================
            CONTENIDO DE LA VISTA
            ========================================================= -->
            <main class="
            flex-1
            w-full
            max-w-7xl
            mx-auto
            p-4
            sm:p-6
            lg:p-8
            ">
                <!-- ERROR DE ACCESO -->
                <?php if (!empty($_SESSION['error_acceso'])): ?>
                    <div class="
                    mb-5
                    rounded-xl
                    border
                    border-red-200
                    bg-red-50
                    p-4
                    flex
                    items-start
                    gap-3
                    text-red-700
                    ">
                        <i data-lucide="shield-alert" class="
                        w-5
                        h-5
                        shrink-0
                        mt-0.5
                        "></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium"> Acceso restringido </p>
                            <p class="text-xs mt-1"><?= htmlspecialchars(
                            $_SESSION['error_acceso']
                            ) ?></p>
                        </div>
                        <button type="button" onclick="this.parentElement.remove()" class="
                        text-red-400
                        hover:text-red-600
                        ">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    <?php unset($_SESSION['error_acceso']); ?>
                <?php endif; ?>
                <!-- AQUÍ CONTINÚA EL CONTENIDO DE CADA VISTA -->
                <script>
                    /* ============================================================
                                                                                                                                                                   ICONOS
                                                                                                                                                                ============================================================ */
                    
                    function cargarIconos() {
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    }
                    
                    /* ============================================================
                                                                                                                                                                   SIDEBAR
                                                                                                                                                                ============================================================ */
                    
                    function toggleSidebar() {
                        const sidebar = document.getElementById('sidebar');
                    
                        const overlay = document.getElementById('sidebar-overlay');
                    
                        if (!sidebar || !overlay) {
                            return;
                        }
                    
                        const abierto = sidebar.classList.contains('sidebar-visible');
                    
                        if (abierto) {
                            sidebar.classList.remove('sidebar-visible');
                    
                            sidebar.classList.add('sidebar-hidden');
                    
                            overlay.classList.remove('overlay-visible');
                        } else {
                            sidebar.classList.remove('sidebar-hidden');
                    
                            sidebar.classList.add('sidebar-visible');
                    
                            overlay.classList.add('overlay-visible');
                        }
                    }
                    
                    /* ============================================================
                                                                                                                                                                   DROPDOWN HISTORIAS
                                                                                                                                                                ============================================================ */
                    
                    function toggleDropdown(menuId, arrowId) {
                        const menu = document.getElementById(menuId);
                    
                        const arrow = document.getElementById(arrowId);
                    
                        if (!menu) {
                            return;
                        }
                    
                        menu.classList.toggle('hidden');
                    
                        if (arrow) {
                            arrow.classList.toggle('rotate-180');
                        }
                    }
                    
                    /* ============================================================
                                                                                                                                                                   CERRAR SIDEBAR
                                                                                                                                                                ============================================================ */
                    
                    function cerrarSidebarMovil() {
                        if (window.innerWidth >= 1024) {
                            return;
                        }
                    
                        const sidebar = document.getElementById('sidebar');
                    
                        const overlay = document.getElementById('sidebar-overlay');
                    
                        if (sidebar) {
                            sidebar.classList.remove('sidebar-visible');
                    
                            sidebar.classList.add('sidebar-hidden');
                        }
                    
                        if (overlay) {
                            overlay.classList.remove('overlay-visible');
                        }
                    }
                    
                    /* ============================================================
                                                                                                                                                                   CERRAR AL CAMBIAR DE PÁGINA
                                                                                                                                                                ============================================================ */
                    
                    document.addEventListener('DOMContentLoaded', function () {
                        cargarIconos();
                    
                        const sidebarLinks = document.querySelectorAll('#sidebar a');
                    
                        sidebarLinks.forEach(function (link) {
                            link.addEventListener('click', function () {
                                cerrarSidebarMovil();
                            });
                        });
                    });
                    
                    /* ============================================================
                                                                                                                                                                   ESC
                                                                                                                                                                ============================================================ */
                    
                    document.addEventListener('keydown', function (event) {
                        if (event.key === 'Escape') {
                            cerrarSidebarMovil();
                        }
                    });
                    
                    /* ============================================================
                                                                                                                                                                   AL CAMBIAR TAMAÑO
                                                                                                                                                                ============================================================ */
                    
                    window.addEventListener('resize', function () {
                        if (window.innerWidth >= 1024) {
                            const sidebar = document.getElementById('sidebar');
                    
                            const overlay = document.getElementById('sidebar-overlay');
                    
                            if (sidebar) {
                                sidebar.classList.remove('sidebar-hidden', 'sidebar-visible');
                            }
                    
                            if (overlay) {
                                overlay.classList.remove('overlay-visible');
                            }
                        } else {
                            const sidebar = document.getElementById('sidebar');
                    
                            if (sidebar && !sidebar.classList.contains('sidebar-visible')) {
                                sidebar.classList.add('sidebar-hidden');
                            }
                        }
                    });
                </script>