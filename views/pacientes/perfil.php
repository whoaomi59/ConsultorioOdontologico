<style>
    /* Identidad visual premium para el módulo de pacientes */
    .pacientes-ui {
        --p-ink: #17243b;
        --p-muted: #718096;
        --p-line: #e4ebf4;
        --p-blue: #315ee8;
        --p-teal: #0e9488;
        width: 100%;
        min-width: 0;
        color: var(--p-ink);
        padding-bottom: clamp(18px, 2vw, 32px);
    }
    .pacientes-ui,
    .pacientes-ui * {
        box-sizing: border-box;
    }
    .pacientes-ui a,
    .pacientes-ui button,
    .pacientes-ui input,
    .pacientes-ui select {
        -webkit-tap-highlight-color: transparent;
    }
    .pacientes-ui a:focus-visible,
    .pacientes-ui button:focus-visible,
    .pacientes-ui input:focus-visible,
    .pacientes-ui select:focus-visible,
    .pacientes-ui textarea:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.28);
        outline-offset: 3px;
    }
    .pacientes-ui h1,
    .pacientes-ui h2,
    .pacientes-ui h3 {
        letter-spacing: -0.025em;
    }
    .pacientes-ui input:not([type='file']):not([type='hidden']):not([type='checkbox']):not([type='radio']),
    .pacientes-ui select,
    .pacientes-ui textarea {
        min-height: 45px;
        border-radius: 13px !important;
        border-color: #d8e3ef !important;
        background-color: #f8fafc;
        color: #1c2c43;
        transition:
            border-color 0.18s,
            box-shadow 0.18s,
            background 0.18s;
    }
    .pacientes-ui input:not([type='file']):not([type='hidden']):not([type='checkbox']):not([type='radio']):focus,
    .pacientes-ui select:focus,
    .pacientes-ui textarea:focus {
        background: #fff !important;
        border-color: #6b89f2 !important;
        box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.1) !important;
        outline: none;
    }
    .pacientes-ui label {
        line-height: 1.45;
    }
    .pacientes-ui form button[type='submit'] {
        min-height: 46px;
        border-radius: 13px !important;
        box-shadow: 0 8px 18px rgba(49, 94, 232, 0.18);
        transition:
            transform 0.18s,
            box-shadow 0.18s,
            filter 0.18s;
    }
    .pacientes-ui form button[type='submit']:hover {
        transform: translateY(-1px);
        box-shadow: 0 12px 23px rgba(49, 94, 232, 0.23);
        filter: saturate(1.08);
    }
    .pacientes-ui .pu-card,
    .pacientes-ui form.space-y-6 > div.bg-white,
    .pacientes-ui form.space-y-6 > section {
        border-color: var(--p-line) !important;
        border-radius: 22px !important;
        box-shadow: 0 8px 28px rgba(19, 38, 68, 0.055) !important;
    }
    .pacientes-ui .p-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 14px;
        border-bottom: 1px solid #edf1f6;
    }
    .pacientes-ui .p-section-title h2 {
        margin: 0;
    }
    .pacientes-ui .p-section-title i {
        width: 36px;
        height: 36px;
        display: grid;
        place-items: center;
        background: #eef3ff;
        border-radius: 12px;
        padding: 9px;
    }
    .pacientes-ui .p-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        color: #fff !important;
        border: 1px solid #203960 !important;
        border-radius: 25px !important;
        background: linear-gradient(118deg, #111d38 0%, #2549a5 55%, #087f86 100%) !important;
        box-shadow: 0 18px 38px rgba(20, 40, 75, 0.17) !important;
    }
    .pacientes-ui .p-hero:after {
        content: '';
        position: absolute;
        z-index: -1;
        right: -75px;
        top: -145px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.17);
        box-shadow:
            0 0 0 32px rgba(255, 255, 255, 0.025),
            0 0 0 68px rgba(255, 255, 255, 0.02);
    }
    .pacientes-ui .p-hero h1 {
        color: #fff !important;
    }
    .pacientes-ui .p-hero p {
        color: rgba(255, 255, 255, 0.76) !important;
    }
    .pacientes-ui .p-backlink {
        background: rgba(255, 255, 255, 0.11) !important;
        border-color: rgba(255, 255, 255, 0.25) !important;
        color: #fff !important;
    }
    .pacientes-ui .p-backlink:hover {
        background: rgba(255, 255, 255, 0.2) !important;
    }
    .pacientes-ui .p-photo-card {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #fff, #f7faff) !important;
    }
    .pacientes-ui #avatar-preview-container {
        width: 136px !important;
        height: 136px !important;
        border-radius: 25px !important;
        border: 4px solid #fff !important;
        box-shadow:
            0 0 0 1px #dbe5f0,
            0 12px 28px rgba(15, 35, 65, 0.12) !important;
    }
    .pacientes-ui #avatar-preview-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .pacientes-ui #modal-camara {
        z-index: 1000;
        background: rgba(8, 18, 37, 0.76);
        backdrop-filter: blur(9px);
    }
    .pacientes-ui #modal-camara > div {
        border: 1px solid rgba(255, 255, 255, 0.65);
        border-radius: 24px !important;
        box-shadow: 0 28px 80px rgba(0, 0, 0, 0.3) !important;
    }
    .pacientes-ui #video-camara {
        max-height: 60vh;
    }
    .pacientes-ui .p-form-note {
        color: #718096;
        font-size: 11px;
        line-height: 1.55;
    }
    .pacientes-ui .p-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        flex-wrap: wrap;
    }
    .pacientes-ui .p-actions a,
    .pacientes-ui .p-actions button {
        min-height: 46px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .pacientes-ui .paciente-row {
        transition: background 0.16s ease;
    }
    .pacientes-ui .paciente-row:hover {
        background: #f4f7ff !important;
    }
    .pacientes-ui #pacientes-table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .pacientes-ui #pacientes-table thead th {
        position: sticky;
        top: 0;
        z-index: 1;
        background: #f5f8fc !important;
        color: #728096 !important;
        border-bottom: 1px solid #e4ebf4;
    }
    .pacientes-ui #pacientes-table tbody td {
        vertical-align: middle;
    }
    .pacientes-ui #pacientes-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .pacientes-ui #search-table {
        min-height: 46px;
        border-radius: 14px !important;
        background: #f8fafc;
    }
    .pacientes-ui #pagination-buttons button {
        min-width: 38px;
        min-height: 38px;
    }
    .pacientes-ui .p-toolbar {
        border-radius: 20px !important;
        box-shadow: 0 7px 24px rgba(19, 38, 68, 0.05) !important;
    }
    .pacientes-ui .p-profile-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        border-radius: 25px !important;
        background: linear-gradient(118deg, #111d38 0%, #2549a5 56%, #087f86 100%) !important;
        color: white !important;
        box-shadow: 0 17px 38px rgba(20, 40, 75, 0.15) !important;
    }
    .pacientes-ui .p-profile-hero h1 {
        color: white !important;
    }
    .pacientes-ui .p-profile-hero .text-slate-500 {
        color: rgba(255, 255, 255, 0.76) !important;
    }
    .pacientes-ui .p-profile-hero .bg-indigo-50 {
        background: rgba(255, 255, 255, 0.14) !important;
        color: #fff !important;
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    .pacientes-ui .p-profile-avatar {
        border: 5px solid #fff !important;
        box-shadow: 0 12px 28px rgba(15, 35, 65, 0.18) !important;
    }
    .pacientes-ui .p-data-grid > div {
        min-width: 0;
        padding: 16px;
        border: 1px solid #e7edf5;
        border-radius: 16px;
        background: linear-gradient(145deg, #fff, #f8fbff);
    }
    .pacientes-ui .p-data-grid label {
        display: block;
        margin-bottom: 7px;
        color: #8592a5;
        font-size: 10px;
        font-weight: 850;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .pacientes-ui .p-data-grid p {
        overflow-wrap: anywhere;
    }
    .pacientes-ui .p-history-card {
        border-radius: 21px !important;
        border-color: #e4ebf4 !important;
        box-shadow: 0 8px 26px rgba(19, 38, 68, 0.05) !important;
    }
    .pacientes-ui .p-empty {
        padding: 26px 16px;
        border: 1px dashed #d7e1ed;
        border-radius: 16px;
        background: #f9fbfe;
        text-align: center;
        color: #7c8ba0;
    }
    @media (max-width: 700px) {
        .pacientes-ui .p-hero {
            border-radius: 20px !important;
            padding: 20px !important;
        }
        .pacientes-ui .p-toolbar {
            align-items: stretch !important;
            padding: 14px !important;
        }
        .pacientes-ui .p-toolbar > div {
            width: 100%;
        }
        .pacientes-ui #pacientes-table {
            min-width: 900px;
        }
        .pacientes-ui .p-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .pacientes-ui .p-actions > * {
            width: 100%;
        }
        .pacientes-ui #avatar-preview-container {
            width: 116px !important;
            height: 116px !important;
        }
        .pacientes-ui form.space-y-6 > div {
            padding: 18px !important;
        }
    }
    @media (max-width: 430px) {
        .pacientes-ui .p-actions {
            grid-template-columns: 1fr;
        }
        .pacientes-ui .p-profile-hero {
            border-radius: 20px !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .pacientes-ui *,
        .pacientes-ui *::before,
        .pacientes-ui *::after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>
<?php
$nacimiento = new DateTime($paciente['fecha_nacimiento']);
$hoy = new DateTime();
$edad = $hoy->diff($nacimiento)->y;
$esMayor = $edad >= 18;
?>
<div class="pacientes-ui pacientes-profile">
    <div class="max-w-5xl mx-auto space-y-6 pb-12">
        <!-- Encabezado del Perfil -->
        <div class="p-profile-hero flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 rounded-2xl border gap-4">
            <div class="flex items-center gap-4">
                <?php if (!empty($paciente['foto'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/pacientes/<?= htmlspecialchars($paciente['foto']) ?>" class="p-profile-avatar w-16 h-16 rounded-2xl object-cover border border-slate-200 shadow-xs">
                <?php else: ?>
                    <div class="p-profile-avatar w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl border border-indigo-100"><?= strtoupper(substr($paciente['nombre'], 0, 1) . substr($paciente['apellido'], 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <h1 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></h1>
                    <p class="text-xs text-slate-500 font-mono mt-0.5"><?= htmlspecialchars($paciente['tipo_documento'] ?? 'CC') ?>: <?= htmlspecialchars($paciente['documento']) ?></p>
                </div>
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <a href="<?= BASE_URL ?>/paciente/editar/<?= $paciente['id'] ?>" class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 px-3.5 py-2 rounded-xl text-xs font-semibold border border-amber-200 transition">
                    <i data-lucide="pencil" class="w-4 h-4"></i>
                    Editar
                </a>
                <a href="<?= BASE_URL ?>/paciente/index" class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-200 transition">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Volver
                </a>
            </div>
        </div>
        <!-- Datos Personales -->
        <div class="p-data-grid bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Fecha de Nacimiento</label>
                <p class="text-sm font-semibold text-slate-800"><?= date('d/m/Y', strtotime($paciente['fecha_nacimiento'])) ?></p>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Condición Legal</label>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-bold text-slate-800"><?= $edad ?> años</span>
                    <?php if ($esMayor): ?>
                        <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-md text-[10px] font-bold">Mayor</span>
                    <?php else: ?>
                        <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-md text-[10px] font-bold">Menor</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Teléfono</label>
                <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($paciente['telefono'] ?: 'No registrado') ?></p>
            </div>
            <div>
                <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Correo Electrónico</label>
                <p class="text-sm font-semibold text-slate-800 truncate"><?= htmlspecialchars($paciente['email'] ?: 'No registrado') ?></p>
            </div>
        </div>
        <!-- SECCIÓN DE HISTORIAS MÉDICAS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- 1. Historia Clínica Base & Odontología -->
            <div class="p-history-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="file-text" class="w-4 h-4 text-indigo-600"></i>
                        Historia Clínica General
                    </h2>
                    <a href="<?= BASE_URL ?>/historias/ver/<?= $paciente['id'] ?>" class="text-xs text-indigo-600 hover:underline font-semibold">Gestionar &rarr;</a>
                </div>
                <?php if (!empty($historiaBase)): ?>
                    <div class="space-y-3 text-xs">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="font-bold text-slate-700 block mb-1">Alerta Médica / Antecedentes relevantes:</span>
                            <p class="text-slate-600"><?= !empty($historiaBase['alerta_medica']) ? htmlspecialchars($historiaBase['alerta_medica']) : 'Ninguna registrada.' ?></p>
                        </div>
                        <?php if(!empty($historiaBase['acudiente_nombre'])): ?>
                            <div>
                                <span class="text-slate-400 uppercase font-bold text-[10px]">Acudiente:</span>
                                <p class="font-medium text-slate-700"><?= htmlspecialchars($historiaBase['acudiente_nombre']) ?> (<?= htmlspecialchars($historiaBase['acudiente_parentesco']) ?>)</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-slate-400 italic py-4 text-center">No se ha registrado la historia clínica base aún.</p>
                <?php endif; ?>
                <!-- Consultas recientes -->
                <div class="pt-2 border-t border-slate-100">
                    <span class="text-xs font-bold text-slate-700 block mb-2">Evoluciones Odontológicas (<?= count($consultasOdontologia) ?>)</span>
                    <?php if (!empty($consultasOdontologia)): ?>
                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                            <?php foreach($consultasOdontologia as $c): ?>
                                <div class="p-2.5 rounded-xl bg-indigo-50/40 border border-indigo-100/60 text-xs">
                                    <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                                        <span><?= date('d/m/Y H:i', strtotime($c['fecha_consulta'])) ?></span>
                                        <span class="font-medium text-indigo-600"><?= htmlspecialchars($c['doctor_nombre'] ?? 'Dr.') ?></span>
                                    </div>
                                    <p class="font-semibold text-slate-800 truncate">Motivo: <?= htmlspecialchars($c['motivo_consulta']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-xs text-slate-400 italic">Sin consultas registradas.</p>
                    <?php endif; ?>
                </div>
            </div>
            <!-- 2. Historia de Ortodoncia -->
            <div class="p-history-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h2 class="font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="smile" class="w-4 h-4 text-emerald-600"></i>
                        Historia de Ortodoncia
                    </h2>
                    <a href="<?= BASE_URL ?>/ortodoncia/ver/<?= $paciente['id'] ?>" class="text-xs text-emerald-600 hover:underline font-semibold">Gestionar &rarr;</a>
                </div>
                <?php if (!empty($historiaOrtodoncia)): ?>
                    <div class="space-y-3 text-xs">
                        <div class="bg-emerald-50/40 p-3 rounded-xl border border-emerald-100/60">
                            <span class="font-bold text-emerald-800 block mb-1">Diagnóstico Ortodóncico Registrado</span>
                            <p class="text-slate-600">
                                Tratamiento previo:
                                <strong><?= !empty($historiaOrtodoncia['tratamiento_previo_ortodoncia']) ? 'Sí' : 'No' ?></strong>
                            </p>
                            <p class="text-slate-600 truncate">Observaciones iniciales activas.</p>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-700 block mb-2">Evoluciones de Ortodoncia (<?= count($evolucionesOrtodoncia) ?>)</span>
                            <?php if (!empty($evolucionesOrtodoncia)): ?>
                                <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                    <?php foreach($evolucionesOrtodoncia as $eo): ?>
                                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                            <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                                                <span><?= date('d/m/Y', strtotime($eo['fecha_consulta'])) ?></span>
                                                <span class="font-medium text-emerald-600">$<?= number_format($eo['valor_evolucion'], 2) ?></span>
                                            </div>
                                            <p class="text-slate-700 truncate"><?= htmlspecialchars($eo['descripcion_evolucion']) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-xs text-slate-400 italic">No hay controles de ortodoncia registrados.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="py-8 text-center space-y-2">
                        <p class="text-xs text-slate-400 italic">Este paciente no cuenta con una historia de ortodoncia abierta.</p>
                        <a href="<?= BASE_URL ?>/ortodoncia/ver/<?= $paciente['id'] ?>" class="inline-block bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">Crear Diagnóstico</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    lucide.createIcons();
</script>