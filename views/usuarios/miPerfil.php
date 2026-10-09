<?php

$fotoExiste = !empty($usuario['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' . $usuario['foto']);

$nombre = $usuario['nombre'] ?? 'Usuario';

$iniciales = mb_strtoupper(mb_substr($nombre, 0, 2));

$rol = $usuario['rol'] ?? 'usuario';

$esDoctor = $rol === 'doctor';

$hoy = date('Y-m-d');

$mensajeExito = $_SESSION['exito_perfil'] ?? null;

$mensajeError = $_SESSION['error_perfil'] ?? null;

unset($_SESSION['exito_perfil'], $_SESSION['error_perfil']);

?>
<style>
    /* Mi perfil · sistema visual de clínica */
    .profile-shell {
        --mp-ink: #17243b;
        --mp-muted: #718096;
        --mp-line: #e4ebf3;
        --mp-blue: #365fe8;
        --mp-teal: #0e9488;
        width: 100%;
        max-width: 1440px;
        margin-inline: auto;
        padding: 8px 0 34px;
        color: var(--mp-ink);
    }
    .profile-shell,
    .profile-shell *,
    #modalCamara,
    #modalCamara * {
        box-sizing: border-box;
    }
    .profile-shell > div,
    .profile-shell > section {
        min-width: 0;
        transition:
            box-shadow 0.2s ease,
            border-color 0.2s ease,
            transform 0.2s ease;
    }
    .profile-shell > div:first-of-type {
        position: relative;
        isolation: isolate;
        overflow: visible !important;
        border: 1px solid #dce6f0 !important;
        border-radius: 28px !important;
        background: #fff;
        box-shadow: 0 18px 48px rgba(17, 36, 68, 0.09) !important;
    }
    .profile-shell > div:first-of-type > div:first-child {
        position: relative;
        z-index: 0;
        height: 164px !important;
        overflow: hidden;
        border-radius: 27px 27px 0 0 !important;
        background:
            radial-gradient(circle at 82% 28%, rgba(94, 234, 212, 0.28), transparent 20%),
            radial-gradient(circle at 67% 115%, rgba(96, 165, 250, 0.28), transparent 35%), linear-gradient(118deg, #111d38 0%, #214a8d 52%, #087e82 100%) !important;
    }
    .profile-shell > div:first-of-type > div:first-child::before,
    .profile-shell > div:first-of-type > div:first-child::after {
        content: '';
        position: absolute;
        right: 8%;
        top: -195px;
        width: 320px;
        height: 320px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        pointer-events: none;
    }
    .profile-shell > div:first-of-type > div:first-child::after {
        right: 2%;
        top: -235px;
        width: 410px;
        height: 410px;
        border-color: rgba(255, 255, 255, 0.09);
    }
    .profile-shell > div:first-of-type > div:nth-child(2) {
        position: relative;
        z-index: 1;
        padding-top: 0 !important;
        background: #fff;
        border-radius: 0 0 28px 28px;
    }
    .profile-shell > div:first-of-type > div:nth-child(2) > div:first-child {
        position: relative;
        z-index: 2;
        align-items: flex-end !important;
        gap: 20px !important;
        margin-top: -78px !important;
    }
    .profile-shell #fotoPerfilPrincipal {
        position: relative !important;
        z-index: 3 !important;
        display: flex;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        width: 126px !important;
        height: 126px !important;
        overflow: hidden;
        border: 6px solid #fff !important;
        border-radius: 28px !important;
        background: linear-gradient(145deg, #e8eeff, #d9f7f0);
        color: #3156c5;
        box-shadow: 0 12px 28px rgba(15, 35, 65, 0.22) !important;
        object-fit: cover !important;
    }
    .profile-shell > div:first-of-type h1 {
        font-size: clamp(24px, 3vw, 31px) !important;
        line-height: 1.15;
        letter-spacing: -0.045em;
        overflow-wrap: anywhere;
    }
    .profile-shell > div:first-of-type .pt-5 {
        padding-top: 12px !important;
    }
    .profile-shell > div:first-of-type .px-6.pb-6 {
        padding-bottom: 26px !important;
    }
    .profile-shell a[href*='/cita/index'] {
        min-height: 45px;
        padding-inline: 18px !important;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 13px !important;
        background: linear-gradient(110deg, #172a49, #25446a) !important;
        box-shadow: 0 7px 17px rgba(23, 42, 73, 0.17);
    }
    .profile-shell a[href*='/cita/index']:hover {
        transform: translateY(-2px);
        box-shadow: 0 11px 22px rgba(23, 42, 73, 0.23);
    }
    .profile-shell > div:nth-of-type(2),
    .profile-shell > div:nth-of-type(3) {
        border-radius: 16px !important;
    }
    .profile-shell > .grid.grid-cols-2.md\:grid-cols-3.xl\:grid-cols-6 {
        grid-template-columns: repeat(6, minmax(0, 1fr)) !important;
        gap: 13px !important;
    }
    .profile-shell .profile-stat-card {
        position: relative;
        isolation: isolate;
        min-width: 0;
        min-height: 126px;
        overflow: hidden;
        padding: 19px !important;
        border: 1px solid #e2eaf3 !important;
        border-top: 3px solid currentColor !important;
        border-radius: 19px !important;
        background: linear-gradient(145deg, #fff 0%, #f8fbff 100%) !important;
        box-shadow: 0 7px 20px rgba(15, 35, 65, 0.045) !important;
    }
    .profile-shell .profile-stat-card::after {
        content: '';
        position: absolute;
        z-index: -1;
        top: -29px;
        right: -25px;
        width: 92px;
        height: 92px;
        border-radius: 50%;
        background: currentColor;
        opacity: 0.055;
    }
    .profile-shell .profile-stat-card:hover {
        transform: translateY(-3px);
        border-color: #cbd9ea !important;
        box-shadow: 0 14px 28px rgba(15, 35, 65, 0.09) !important;
    }
    .profile-shell .profile-stat-card p:first-child {
        min-height: 28px;
        color: #7b899d !important;
        font-size: 9px !important;
        line-height: 1.5;
        letter-spacing: 0.11em;
    }
    .profile-shell .profile-stat-card p.text-3xl {
        margin-top: 7px !important;
        font-size: clamp(24px, 2.2vw, 31px) !important;
        line-height: 1.1;
        letter-spacing: -0.04em;
    }
    .profile-shell > .grid.grid-cols-1.xl\:grid-cols-3 > div,
    .profile-shell > div.rounded-3xl.border.border-slate-200.shadow-sm.p-6 {
        min-width: 0;
        border: 1px solid #e2eaf2 !important;
        border-radius: 23px !important;
        background: #fff;
        box-shadow: 0 9px 28px rgba(15, 35, 65, 0.05) !important;
    }
    .profile-shell h2 {
        color: #1c2c45;
        letter-spacing: -0.025em;
    }
    .profile-shell form label {
        display: block;
        margin-bottom: 7px;
        color: #526176;
        font-size: 11px !important;
        font-weight: 800 !important;
    }
    .profile-shell form input:not([type='file']):not([type='hidden']),
    .profile-shell form select,
    .profile-shell form textarea {
        width: 100%;
        min-height: 45px;
        padding: 11px 13px !important;
        border: 1px solid #dce5ef !important;
        border-radius: 12px !important;
        background: #f8fafc !important;
        color: #1d2b42;
        outline: none;
        transition:
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }
    .profile-shell form input:focus,
    .profile-shell form select:focus,
    .profile-shell form textarea:focus {
        border-color: #4c77eb !important;
        background: #fff !important;
        box-shadow: 0 0 0 4px rgba(54, 95, 232, 0.11) !important;
    }
    .profile-shell input[type='file'] {
        max-width: 100%;
    }
    .profile-shell form button[type='submit'] {
        min-height: 46px;
        border-radius: 13px !important;
        background: linear-gradient(110deg, #315ee8, #3154ce) !important;
        box-shadow: 0 7px 17px rgba(49, 94, 232, 0.19);
    }
    .profile-shell form button[type='submit']:hover {
        transform: translateY(-1px);
        box-shadow: 0 11px 22px rgba(49, 94, 232, 0.25);
    }
    .profile-shell form[action*='guardarFechaAtencion'] {
        border-radius: 17px !important;
        background: linear-gradient(145deg, #f8fbff, #f2f8f8) !important;
    }
    .profile-shell a[title='Eliminar fecha'] {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        min-height: 38px;
        border: 1px solid #ffe0e4;
        border-radius: 11px !important;
    }
    .profile-shell .space-y-3 > div.flex.flex-col.sm\:flex-row {
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease;
    }
    .profile-shell .space-y-3 > div.flex.flex-col.sm\:flex-row:hover {
        transform: translateY(-1px);
        box-shadow: 0 7px 18px rgba(15, 35, 65, 0.055);
    }
    .profile-shell > div.rounded-3xl.border.border-slate-200.shadow-sm.p-6:last-of-type .grid > div {
        border: 1px solid rgba(148, 163, 184, 0.13);
        border-radius: 17px !important;
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease;
    }
    .profile-shell > div.rounded-3xl.border.border-slate-200.shadow-sm.p-6:last-of-type .grid > div:hover {
        transform: translateY(-2px);
        box-shadow: 0 9px 20px rgba(15, 35, 65, 0.06);
    }
    .profile-shell button,
    .profile-shell a,
    #modalCamara button {
        -webkit-tap-highlight-color: transparent;
    }
    .profile-shell a:focus-visible,
    .profile-shell button:focus-visible,
    #modalCamara button:focus-visible {
        outline: 3px solid rgba(54, 95, 232, 0.35);
        outline-offset: 3px;
    }
    #modalCamara {
        z-index: 1000 !important;
    }
    #modalCamara > div {
        max-height: calc(100dvh - 32px);
        overflow-y: auto;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 24px !important;
        box-shadow: 0 28px 80px rgba(0, 0, 0, 0.28);
    }
    #videoCamara {
        display: block;
        width: 100%;
        max-height: 60vh;
        min-height: 180px;
    }
    @media (max-width: 1279px) {
        .profile-shell > .grid.grid-cols-2.md\:grid-cols-3.xl\:grid-cols-6 {
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
        }
    }
    @media (max-width: 767px) {
        .profile-shell {
            padding: 0 0 22px;
        }
        .profile-shell > div:first-of-type {
            border-radius: 21px !important;
        }
        .profile-shell > div:first-of-type > div:first-child {
            height: 132px !important;
            border-radius: 20px 20px 0 0 !important;
        }
        .profile-shell > div:first-of-type > div:nth-child(2) {
            border-radius: 0 0 21px 21px;
        }
        .profile-shell > div:first-of-type > div:nth-child(2) > div:first-child {
            margin-top: -62px !important;
            gap: 13px !important;
        }
        .profile-shell #fotoPerfilPrincipal {
            width: 100px !important;
            height: 100px !important;
            border-radius: 22px !important;
        }
        .profile-shell .px-6 {
            padding-left: 17px !important;
            padding-right: 17px !important;
        }
        .profile-shell .p-6 {
            padding: 17px !important;
        }
        .profile-shell .profile-stat-card {
            min-height: 108px;
            padding: 14px !important;
        }
        .profile-shell .profile-stat-card p.text-3xl {
            font-size: 25px !important;
        }
        .profile-shell > .grid.grid-cols-1.xl\:grid-cols-3 {
            gap: 15px !important;
        }
    }
    @media (max-width: 480px) {
        .profile-shell > .grid.grid-cols-2.md\:grid-cols-3.xl\:grid-cols-6 {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 9px !important;
        }
        .profile-shell .profile-stat-card {
            padding: 12px !important;
            border-radius: 15px !important;
        }
        .profile-shell .profile-stat-card p:first-child {
            font-size: 8px !important;
            letter-spacing: 0.07em;
        }
        .profile-shell .profile-stat-card p.text-3xl {
            font-size: 23px !important;
        }
        .profile-shell > div:first-of-type > div:nth-child(2) > div:first-child {
            flex-direction: column !important;
            align-items: flex-start !important;
            margin-top: -57px !important;
        }
        .profile-shell > div:first-of-type > div:nth-child(2) > div:first-child > div {
            padding-bottom: 0 !important;
        }
        .profile-shell > div:first-of-type h1 {
            font-size: 24px !important;
        }
        .profile-shell a[href*='/cita/index'] {
            width: 100%;
        }
        .profile-shell .flex.gap-2 > label,
        .profile-shell .flex.gap-2 > button {
            min-width: 0;
        }
        .profile-shell .flex.gap-2 > label > div,
        .profile-shell .flex.gap-2 > button {
            padding: 10px 7px !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .profile-shell *,
        .profile-shell *::before,
        .profile-shell *::after,
        #modalCamara * {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            scroll-behavior: auto !important;
        }
    }
</style>
<div class="profile-shell max-w-7xl mx-auto space-y-6 pb-8">
    <!-- =====================================================
    ENCABEZADO
    ====================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="h-32 bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500"></div>
        <div class="px-6 pb-6">
            <div class="-mt-14 flex flex-col md:flex-row md:items-end md:justify-between gap-5">
                <div class="flex items-end gap-4">
                    <?php if ($fotoExiste): ?>
                        <img id="fotoPerfilPrincipal" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" class="w-32 h-34 rounded-3xl object-cover border-4 border-white shadow-xl">
                    <?php else: ?>
                        <div id="fotoPerfilPrincipal" class="w-28 h-28 rounded-3xl bg-indigo-100 text-indigo-700 border-4 border-white shadow-xl flex items-center justify-center text-3xl font-black"><?= htmlspecialchars($iniciales) ?></div>
                    <?php endif; ?>
                    <div class="pt-5">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="text-2xl font-black text-slate-900"><?= htmlspecialchars($nombre) ?></h1>
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase"><?= htmlspecialchars($rol) ?></span>
                        </div>
                        <p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($usuario['email'] ?? '') ?></p>
                    </div>
                </div>
                <a href="<?= BASE_URL ?>/cita/index" class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition">
                    <i data-lucide="calendar-days" class="w-4 h-4"></i>
                    Ir a mi agenda
                </a>
            </div>
        </div>
    </div>
    <!-- =====================================================
    MENSAJES
    ====================================================== -->
    <?php if ($mensajeExito): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="text-sm font-semibold"><?= htmlspecialchars($mensajeExito) ?></span>
        </div>
    <?php endif; ?>
    <?php if ($mensajeError): ?>
        <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-4 flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="text-sm font-semibold"><?= htmlspecialchars($mensajeError) ?></span>
        </div>
    <?php endif; ?>
    <!-- =====================================================
    ESTADÍSTICAS
    ====================================================== -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-indigo-600">
            <p class="text-[10px] font-black uppercase text-slate-400"> Días programados </p>
            <p class="text-3xl font-black text-indigo-600 mt-2"><?= (int) $estadisticas['dias_programados'] ?></p>
        </div>
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-violet-600">
            <p class="text-[10px] font-black uppercase text-slate-400"> Días realizados </p>
            <p class="text-3xl font-black text-violet-600 mt-2"><?= (int) $estadisticas['dias_realizados'] ?></p>
        </div>
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-slate-700">
            <p class="text-[10px] font-black uppercase text-slate-400"> Total citas </p>
            <p class="text-3xl font-black text-slate-800 mt-2"><?= (int) $estadisticas['total_citas'] ?></p>
        </div>
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-amber-500">
            <p class="text-[10px] font-black uppercase text-slate-400"> Pendientes </p>
            <p class="text-3xl font-black text-amber-500 mt-2"><?= (int) $estadisticas['pendientes'] ?></p>
        </div>
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-emerald-600">
            <p class="text-[10px] font-black uppercase text-slate-400"> Atendidas </p>
            <p class="text-3xl font-black text-emerald-600 mt-2"><?= (int) $estadisticas['atendidas'] ?></p>
        </div>
        <div class="profile-stat-card bg-white rounded-2xl border border-slate-200 p-5 shadow-sm text-rose-600">
            <p class="text-[10px] font-black uppercase text-slate-400"> Canceladas </p>
            <p class="text-3xl font-black text-rose-600 mt-2"><?= (int) $estadisticas['canceladas'] ?></p>
        </div>
    </div>
    <!-- =====================================================
    PERFIL + AGENDA
    ====================================================== -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <!-- =================================================
        DATOS PERSONALES
        ================================================== -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="user-round" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="font-black text-slate-800"> Mi información </h2>
                    <p class="text-xs text-slate-400"> Actualiza tus datos personales </p>
                </div>
            </div>
            <form action="<?= BASE_URL ?>/usuarios/actualizarMiPerfil" method="POST" enctype="multipart/form-data" class="space-y-4">
                <!-- FOTO -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-2"> Fotografía </label>
                    <div class="flex gap-2">
                        <label class="flex-1 cursor-pointer">
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-center hover:bg-slate-100 transition">
                                <i data-lucide="upload" class="w-4 h-4 mx-auto mb-1 text-indigo-600"></i>
                                <span class="text-[10px] font-bold text-slate-600"> Subir foto </span>
                            </div>
                            <input type="file" name="foto" id="fotoArchivo" accept="image/jpeg,image/png,image/webp" class="hidden">
                        </label>
                        <button type="button" id="btnAbrirCamara" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-3 text-center hover:bg-slate-100 transition">
                            <i data-lucide="camera" class="w-4 h-4 mx-auto mb-1 text-indigo-600"></i>
                            <span class="text-[10px] font-bold text-slate-600"> Cámara </span>
                        </button>
                    </div>
                    <input type="hidden" name="foto_base64" id="foto_base64">
                </div>
                <!-- NOMBRE -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1"> Nombre completo </label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <!-- EMAIL -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1"> Correo electrónico </label>
                    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <!-- PASSWORD -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1"> Nueva contraseña </label>
                    <input type="password" name="password" placeholder="Dejar vacío para conservarla" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-3 text-xs font-black transition">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
        <!-- =================================================
        AGENDA
        ================================================== -->
        <div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="calendar-plus" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-slate-800"> Mi agenda de atención </h2>
                        <p class="text-xs text-slate-400"> Programa los días y horarios en los que atenderás. </p>
                    </div>
                </div>
            </div>
            <?php if ($esDoctor): ?>
                <!-- FORMULARIO -->
                <form action="<?= BASE_URL ?>/usuarios/guardarFechaAtencion" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1"> Fecha de atención </label>
                        <input type="date" name="fecha" min="<?= $hoy ?>" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1"> Hora de inicio </label>
                        <input type="time" name="hora_inicio" required class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 text-xs font-black transition flex items-center justify-center gap-2">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            Agendar fecha
                        </button>
                    </div>
                </form>
                <!-- LISTA -->
                <div class="space-y-3">
                    <?php if (empty($fechasAtencion)): ?>
                        <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl">
                            <i data-lucide="calendar-off" class="w-10 h-10 mx-auto text-slate-300"></i>
                            <p class="text-sm font-bold text-slate-500 mt-3"> No tienes fechas programadas </p>
                            <p class="text-xs text-slate-400 mt-1"> Utiliza el formulario para agregar tu primera fecha. </p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($fechasAtencion as $fecha): ?>
                            <?php

                            $esPasada = $fecha['fecha'] < $hoy;

                            $fechaFormateada = date('d/m/Y', strtotime($fecha['fecha']));

                            $horaFormateada = date('h:i A', strtotime($fecha['hora_inicio']));

                            ?>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl border <?= $esPasada ? 'border-slate-200 bg-slate-50' : 'border-emerald-100 bg-emerald-50/40' ?>">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl <?= $esPasada ? 'bg-slate-200 text-slate-500' : 'bg-emerald-100 text-emerald-700' ?> flex flex-col items-center justify-center">
                                        <span class="text-[9px] font-black uppercase"><?= date('M', strtotime($fecha['fecha'])) ?></span>
                                        <span class="text-lg font-black leading-none"><?= date('d', strtotime($fecha['fecha'])) ?></span>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-800"><?= htmlspecialchars($fechaFormateada) ?></p>
                                        <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">
                                            <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            <?= htmlspecialchars($horaFormateada) ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <?php if ($esPasada): ?>
                                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-black uppercase"> Realizada </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase"> Programada </span>
                                        <a href="<?= BASE_URL ?>/usuarios/eliminarFechaAtencion/<?= (int) $fecha['id'] ?>" onclick="return confirm('¿Deseas eliminar esta fecha de atención?');" class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition" title="Eliminar fecha">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                    <div class="flex gap-3">
                        <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0"></i>
                        <div>
                            <p class="text-sm font-black text-amber-800"> Agenda personal disponible para doctores </p>
                            <p class="text-xs text-amber-700 mt-1">
                                Actualmente tu usuario tiene el rol
                                <strong><?= htmlspecialchars($rol) ?></strong>
                                .
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- =====================================================
    TRAYECTORIA
    ====================================================== -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                <i data-lucide="chart-no-axes-combined" class="w-5 h-5"></i>
            </div>
            <div>
                <h2 class="font-black text-slate-800"> Mi trayectoria en el sistema </h2>
                <p class="text-xs text-slate-400"> Resumen de tu actividad y atención registrada. </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-2xl bg-indigo-50 p-5">
                <i data-lucide="calendar-check" class="w-5 h-5 text-indigo-600"></i>
                <p class="text-xs text-indigo-700 font-bold mt-3"> Fechas programadas </p>
                <p class="text-2xl font-black text-indigo-800 mt-1"><?= (int) $estadisticas['dias_programados'] ?></p>
            </div>
            <div class="rounded-2xl bg-emerald-50 p-5">
                <i data-lucide="user-check" class="w-5 h-5 text-emerald-600"></i>
                <p class="text-xs text-emerald-700 font-bold mt-3"> Citas atendidas </p>
                <p class="text-2xl font-black text-emerald-800 mt-1"><?= (int) $estadisticas['atendidas'] ?></p>
            </div>
            <div class="rounded-2xl bg-amber-50 p-5">
                <i data-lucide="clock-3" class="w-5 h-5 text-amber-600"></i>
                <p class="text-xs text-amber-700 font-bold mt-3"> Citas pendientes </p>
                <p class="text-2xl font-black text-amber-800 mt-1"><?= (int) $estadisticas['pendientes'] ?></p>
            </div>
            <div class="rounded-2xl bg-rose-50 p-5">
                <i data-lucide="calendar-x-2" class="w-5 h-5 text-rose-600"></i>
                <p class="text-xs text-rose-700 font-bold mt-3"> Citas canceladas </p>
                <p class="text-2xl font-black text-rose-800 mt-1"><?= (int) $estadisticas['canceladas'] ?></p>
            </div>
        </div>
    </div>
</div>
<!-- =========================================================
MODAL CÁMARA
========================================================= -->
<div id="modalCamara" class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">
        <div class="p-5 border-b border-slate-200 flex items-center justify-between">
            <div>
                <h3 class="font-black text-slate-800"> Tomar fotografía </h3>
                <p class="text-xs text-slate-400"> Centra tu rostro y toma la fotografía. </p>
            </div>
            <button type="button" id="btnCerrarCamara" class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
        <div class="p-5">
            <video id="videoCamara" autoplay playsinline class="w-full aspect-video bg-slate-950 rounded-2xl object-cover"></video>
            <canvas id="canvasCamara" class="hidden"></canvas>
        </div>
        <div class="p-5 pt-0 flex gap-3">
            <button type="button" id="btnCapturarFoto" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-3 text-xs font-black">
                <i data-lucide="camera" class="w-4 h-4 inline-block mr-1"></i>
                Capturar
            </button>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnAbrir = document.getElementById('btnAbrirCamara');
    
        const btnCerrar = document.getElementById('btnCerrarCamara');
    
        const btnCapturar = document.getElementById('btnCapturarFoto');
    
        const modal = document.getElementById('modalCamara');
    
        const video = document.getElementById('videoCamara');
    
        const canvas = document.getElementById('canvasCamara');
    
        const campoBase64 = document.getElementById('foto_base64');
    
        const archivo = document.getElementById('fotoArchivo');
    
        let stream = null;
    
        function detenerCamara() {
            if (stream) {
                stream.getTracks().forEach((track) => track.stop());
    
                stream = null;
            }
        }
    
        btnAbrir?.addEventListener('click', async function () {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
    
            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false,
                });
    
                video.srcObject = stream;
            } catch (error) {
                alert('No fue posible acceder a la cámara.');
    
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    
        btnCerrar?.addEventListener('click', function () {
            detenerCamara();
    
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    
        btnCapturar?.addEventListener('click', function () {
            if (!video.videoWidth) {
                return;
            }
    
            canvas.width = video.videoWidth;
    
            canvas.height = video.videoHeight;
    
            const ctx = canvas.getContext('2d');
    
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    
            const imagen = canvas.toDataURL('image/jpeg', 0.9);
    
            campoBase64.value = imagen;
    
            archivo.value = '';
    
            detenerCamara();
    
            modal.classList.add('hidden');
            modal.classList.remove('flex');
    
            alert('Fotografía capturada. Presiona "Guardar cambios" para almacenarla.');
        });
    
        function actualizarVistaFoto(origen) {
            const actual = document.getElementById('fotoPerfilPrincipal');
            if (!actual) return;
            let vista = actual;
            if (actual.tagName !== 'IMG') {
                vista = document.createElement('img');
                vista.id = 'fotoPerfilPrincipal';
                vista.className = actual.className;
                vista.alt = 'Vista previa de la foto de perfil';
                actual.replaceWith(vista);
            }
            vista.src = origen;
        }
    
        archivo?.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                campoBase64.value = '';
                const archivoFoto = this.files[0];
                if (archivoFoto.type.startsWith('image/')) {
                    const lector = new FileReader();
                    lector.onload = (evento) => actualizarVistaFoto(evento.target.result);
                    lector.readAsDataURL(archivoFoto);
                }
            }
        });
    
        modal?.addEventListener('click', function (evento) {
            if (evento.target === modal) {
                detenerCamara();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    
        document.addEventListener('keydown', function (evento) {
            if (evento.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                detenerCamara();
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });
</script>