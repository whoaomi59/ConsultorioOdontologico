<?php
// Agrupación de módulos por categorías/secciones
$seccionesPermisos = [
    'Usuarios' => [
        'icon' => 'users',
        'modulos' => [
            'usuarios' => 'usuarios',
            'usuarios_crear' => 'usuarios_crear',
            'usuarios_ver' => 'usuarios_ver',
            'usuarios_editar' => 'usuarios_editar',
            'usuarios_eliminar' => 'usuarios_eliminar',
        ],
    ],
    'Pacientes' => [
        'icon' => 'calendar',
        'modulos' => [
            'pacientes' => 'pacientes',
            'pacientes_crear' => 'pacientes_crear',
            'pacientes_perfil' => 'pacientes_perfil',
            'pacientes_editar' => 'pacientes_editar',
            'pacientes_eliminar' => 'pacientes_eliminar',
        ],
    ],
    'Historias Clínicas' => [
        'icon' => 'folder-heart',
        'modulos' => [
            'historia' => 'Historias Clínicas',
            'historia_ver' => 'historia_ver',
            'historia_odontologia' => 'historia_odontologia',
            'historia_ortodoncia' => 'historia_ortodoncia',
        ],
    ],
    'Citas' => [
        'icon' => 'folder-heart',
        'modulos' => [
            'citas' => 'Citas',
            'citas_total' => 'citas_total',
            'citas_ver' => 'citas_ver',
            'citas_editar' => 'citas_editar',
            'citas_eliminar' => 'citas_eliminar',
        ],
    ],
    'Configuraciones' => [
        'icon' => 'folder-heart',
        'modulos' => [
            'configuracion' => 'Configuraciones',
        ],
    ],
];
?>
<style>
    /* Sistema visual unificado para Gestión de Usuarios */
    .usuarios-ui {
        --ui-ink: #142238;
        --ui-muted: #64748b;
        --ui-line: #e2eaf2;
        --ui-blue: #315ee8;
        --ui-teal: #0f9f9a;
        color: var(--ui-ink);
        width: 100%;
        min-width: 0;
    }
    .usuarios-ui > * {
        min-width: 0;
    }
    .usuarios-ui a,
    .usuarios-ui button,
    .usuarios-ui input,
    .usuarios-ui select {
        -webkit-tap-highlight-color: transparent;
    }
    .usuarios-ui a:focus-visible,
    .usuarios-ui button:focus-visible,
    .usuarios-ui input:focus-visible,
    .usuarios-ui select:focus-visible,
    .usuarios-ui textarea:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.24);
        outline-offset: 2px;
    }
    .usuarios-ui input:not([type='checkbox']):not([type='radio']):not([type='file']):not([type='hidden']),
    .usuarios-ui select,
    .usuarios-ui textarea {
        min-height: 44px;
        border-radius: 12px;
        border-color: #d8e2ee;
        background-color: #f8fafc;
        color: #17253b;
        transition:
            border-color 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }
    .usuarios-ui input:not([type='checkbox']):not([type='radio']):not([type='file']):not([type='hidden']):focus,
    .usuarios-ui select:focus,
    .usuarios-ui textarea:focus {
        border-color: #6487f4 !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.1);
    }
    .usuarios-ui input[type='checkbox'] {
        width: 17px;
        height: 17px;
        accent-color: #315ee8;
        flex: 0 0 auto;
    }
    .usuarios-ui form,
    .usuarios-ui .usuario-form-card {
        border-color: var(--ui-line) !important;
        border-radius: 22px !important;
        box-shadow: 0 8px 28px rgba(15, 35, 65, 0.055) !important;
    }
    .usuarios-ui .usuarios-section {
        border-radius: 18px;
    }
    .usuarios-ui .ui-elevate {
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            border-color 0.2s ease;
    }
    .usuarios-ui .ui-elevate:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(15, 35, 65, 0.08);
    }
    .usuarios-ui button[type='submit'] {
        min-height: 44px;
        border-radius: 12px !important;
        box-shadow: 0 7px 16px rgba(49, 94, 232, 0.18);
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease,
            filter 0.18s ease;
    }
    .usuarios-ui button[type='submit']:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(49, 94, 232, 0.24);
        filter: saturate(1.08);
    }
    .usuarios-ui .usuarios-hero {
        position: relative;
        isolation: isolate;
        overflow: hidden;
        border: 1px solid #1e3760;
        border-radius: 26px;
        background: linear-gradient(120deg, #101c35 0%, #1b3470 58%, #087e8b 100%);
        color: #fff;
        box-shadow: 0 16px 35px rgba(15, 35, 65, 0.16);
    }
    .usuarios-ui .usuarios-hero:after {
        content: '';
        position: absolute;
        z-index: -1;
        width: 240px;
        height: 240px;
        right: -65px;
        top: -110px;
        border-radius: 50%;
        background: rgba(125, 211, 252, 0.13);
        box-shadow:
            0 0 0 32px rgba(255, 255, 255, 0.025),
            0 0 0 66px rgba(255, 255, 255, 0.02);
    }
    .usuarios-ui .usuarios-panel {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid var(--ui-line);
        border-radius: 20px;
        box-shadow: 0 7px 24px rgba(15, 35, 65, 0.045);
    }
    .usuarios-ui .usuario-row {
        transition: background 0.18s ease;
    }
    .usuarios-ui .usuario-row:hover {
        background: #f4f8ff;
    }
    .usuarios-ui .usuarios-index table {
        border-collapse: separate;
        border-spacing: 0;
    }
    .usuarios-ui .usuarios-index thead th {
        background: #f5f8fc;
    }
    .usuarios-ui .usuarios-index tbody td {
        vertical-align: middle;
    }
    .usuarios-ui .usuarios-index tbody tr:last-child td {
        border-bottom: 0;
    }
    .usuarios-ui .usuarios-index #search-table {
        background: #f7f9fc;
    }
    .usuarios-ui .usuarios-index #pagination-buttons button {
        min-width: 38px;
        min-height: 38px;
    }
    .usuarios-ui .usuarios-create .tab-button,
    .usuarios-ui .usuarios-edit-page .tab-button {
        min-height: 42px;
        border-radius: 12px 12px 0 0;
    }
    .usuarios-ui .tab-panel label:has(input.chk-permiso) {
        min-height: 48px;
        border-radius: 13px;
        transition:
            border-color 0.18s ease,
            background 0.18s ease,
            transform 0.18s ease;
    }
    .usuarios-ui .tab-panel label:has(input.chk-permiso):hover {
        border-color: #bdcdfa;
        background: #f5f8ff;
        transform: translateY(-1px);
    }
    .usuarios-ui #preview_container {
        width: 132px;
        height: 132px;
        border-radius: 24px !important;
        border: 4px solid #fff !important;
        box-shadow:
            0 0 0 1px #dbe5f0,
            0 10px 24px rgba(15, 35, 65, 0.1) !important;
    }
    .usuarios-ui #webcam_container {
        width: min(100%, 260px);
        height: 220px;
        border-radius: 18px;
        box-shadow: 0 10px 24px rgba(15, 35, 65, 0.14);
    }
    .usuarios-ui #user-signature-pad {
        touch-action: none;
        display: block;
    }
    .usuarios-ui .usuarios-view .profile-banner {
        min-height: 156px;
        background: linear-gradient(120deg, #14264a, #315ee8 58%, #0d9488) !important;
    }
    .usuarios-ui .usuarios-view .profile-avatar {
        border: 5px solid white;
        box-shadow: 0 12px 30px rgba(15, 35, 65, 0.18);
    }
    @media (max-width: 640px) {
        .usuarios-ui {
            font-size: 14px;
        }
        .usuarios-ui .usuarios-hero {
            border-radius: 20px;
            padding: 20px !important;
        }
        .usuarios-ui form {
            padding: 18px !important;
        }
        .usuarios-ui .usuarios-index .overflow-x-auto {
            max-width: 100%;
        }
        .usuarios-ui .usuarios-index table {
            min-width: 720px;
        }
        .usuarios-ui .usuarios-index .pagination-footer {
            padding: 14px !important;
        }
        .usuarios-ui #tabs-header {
            padding-bottom: 4px;
            scrollbar-width: thin;
        }
        .usuarios-ui .tab-panel {
            padding: 12px !important;
        }
        .usuarios-ui #preview_container {
            width: 116px;
            height: 116px;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .usuarios-ui *,
        .usuarios-ui *:before,
        .usuarios-ui *:after {
            transition-duration: 0.01ms !important;
            animation-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }
</style>
<div class="usuarios-ui usuarios-create max-w-5xl mx-auto space-y-6">
    <div class="usuarios-hero flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-6 sm:p-7">
        <div>
            <h1 class="text-xl font-bold flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600"></i>
                Registrar Nuevo Usuario
            </h1>
            <p class="text-xs text-slate-300 mt-0.5">Ingresa los datos personales, captura la foto e indica permisos.</p>
        </div>
        <a href="<?= BASE_URL ?>/usuarios/index" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-5 py-2.5 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition-all duration-300 hover:scale-105">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Volver al listado</span>
        </a>
    </div>
    <form action="<?= BASE_URL ?>/usuarios/guardar" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" name="nombre" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico *</label>
                <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Contraseña *</label>
                <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Rol *</label>
                <select name="rol" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
                    <option value="doctor">Doctor</option>
                    <option value="auxiliar">Auxiliar</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
        </div>
        <div class="border-t pt-4 space-y-3">
            <label class="block text-xs font-bold text-slate-800">Foto de Perfil (Tomar con Cámara o Cargar)</label>
            <input type="hidden" name="foto_base64" id="foto_base64">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div class="space-y-2">
                    <span class="block text-[11px] text-slate-500">Opción A: Subir o Tomar con Cámara Nativa</span>
                    <input type="file" id="input_file" name="foto" accept="image/*" capture="user" onchange="previewFile(this)" class="w-full text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-xl p-2">
                </div>
                <div class="space-y-2">
                    <span class="block text-[11px] text-slate-500">Opción B: Usar WebCam (PC / Tablet)</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="startCamera()" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs flex items-center gap-1.5 hover:bg-slate-900 transition">
                            <i data-lucide="camera" class="w-4 h-4"></i>
                            Activar Cámara
                        </button>
                        <button type="button" id="btn_snap" onclick="takeSnapshot()" class="hidden px-3 py-2 bg-indigo-600 text-white rounded-xl text-xs flex items-center gap-1.5 hover:bg-indigo-700 transition">
                            <i data-lucide="aperture" class="w-4 h-4"></i>
                            Capturar
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-center bg-slate-50 p-4 rounded-2xl border border-slate-200/80">
                <div id="webcam_container" class="hidden relative w-44 h-44 rounded-2xl overflow-hidden border border-slate-300 bg-black">
                    <video id="webcam_video" autoplay playsinline class="w-full h-full object-cover"></video>
                </div>
                <div class="text-center space-y-1">
                    <div class="w-28 h-28 mx-auto rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-white shadow-sm" id="preview_container">
                        <i data-lucide="user" class="w-10 h-10 text-slate-300" id="default_icon"></i>
                        <img id="img_preview" class="w-full h-full object-cover hidden">
                    </div>
                    <span class="text-[10px] text-slate-400 block" id="preview_label">Sin foto seleccionada</span>
                </div>
            </div>
        </div>
        <div class="border-t border-slate-100 pt-5 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="text-xs font-bold text-slate-800">Permisos y Módulos de Acceso</h3>
                    <p class="text-[11px] text-slate-500">Navega entre pestañas para asignar accesos por categoría.</p>
                </div>
                <div class="flex gap-2 text-[11px]">
                    <button type="button" onclick="toggleTodosPermisos(true)" class="text-indigo-600 hover:underline font-semibold">Seleccionar todos</button>
                    <span class="text-slate-300">|</span>
                    <button type="button" onclick="toggleTodosPermisos(false)" class="text-slate-500 hover:underline">Desmarcar todos</button>
                </div>
            </div>
            <div class="flex border-b border-slate-200 gap-1 overflow-x-auto" id="tabs-header">
                <?php $index = 0; foreach ($seccionesPermisos as $tituloSeccion => $seccion): $index++; ?>
                <?php
                $modulosKeys = array_keys($seccion['modulos']);
                $seleccionadosEnSeccion = array_intersect($modulosKeys, $permisos ?? []);
                $esActivo = $index === 1;
                ?>
                <button type="button" onclick="switchTab(<?= $index ?>)" id="tab-btn-<?= $index ?>" class="tab-button flex items-center gap-2 px-4 py-2.5 text-xs font-bold rounded-t-xl transition border-b-2 -mb-px whitespace-nowrap focus:outline-none <?= $esActivo ? 'border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' ?>">
                    <i data-lucide="<?= $seccion['icon'] ?>" class="w-4 h-4"></i>
                    <span><?= $tituloSeccion ?></span>
                    <span id="badge-tab-<?= $index ?>" class="ml-1 text-[10px] px-2 py-0.5 rounded-full font-semibold <?= count($seleccionadosEnSeccion)> 0 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-600' ?>"><?= count($seleccionadosEnSeccion) ?> / <?= count($seccion['modulos']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
            <div class="bg-slate-50/40 border border-slate-200/80 rounded-b-2xl rounded-tr-2xl p-4 shadow-sm">
                <?php $index    = 0; foreach ($seccionesPermisos as $tituloSeccion => $seccion): $index++; ?>
                <?php $esActivo = $index === 1; ?>
                <div id="tab-content-<?= $index ?>" class="tab-panel <?= $esActivo ? '' : 'hidden' ?> space-y-3">
                    <div class="flex justify-between items-center pb-2 border-b border-slate-200/60">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Módulos de <?= $tituloSeccion ?></span>
                        <div class="flex gap-2 text-[10px]">
                            <button type="button" onclick="toggleGrupo('tab-content-<?= $index ?>', true)" class="text-indigo-600 hover:underline font-semibold">Marcar grupo</button>
                            <span class="text-slate-300">|</span>
                            <button type="button" onclick="toggleGrupo('tab-content-<?= $index ?>', false)" class="text-slate-400 hover:underline">Desmarcar grupo</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        <?php foreach ($seccion['modulos'] as $key => $label): ?>
                            <?php $isChecked = in_array($key, $permisos ?? []); ?>
                            <label class="flex items-center gap-2.5 p-3 bg-white hover:bg-indigo-50/40 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer transition shadow-sm">
                                <input type="checkbox" name="modulos[]" value="<?= $key ?>" <?= $isChecked ? 'checked' : '' ?> onchange="actualizarBadgesTabs()" class="chk-permiso rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-end gap-3 border-t pt-4">
                <a href="<?= BASE_URL ?>/usuarios/index" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-medium">Cancelar</a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition">Guardar Usuario</button>
            </div>
    </form>
</div>
</div>
<canvas id="canvas" class="hidden"></canvas>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    lucide.createIcons();
    
    let streamVideo = null;
    
    // 1. Activar Cámara Web
    async function startCamera() {
        try {
            const constraints = { video: { width: 400, height: 400, facingMode: 'user' } };
            streamVideo = await navigator.mediaDevices.getUserMedia(constraints);
            const video = document.getElementById('webcam_video');
            video.srcObject = streamVideo;
    
            document.getElementById('webcam_container').classList.remove('hidden');
            document.getElementById('btn_snap').classList.remove('hidden');
        } catch (err) {
            alert('No se pudo acceder a la cámara. Asegúrate de dar los permisos correspondientes.');
        }
    }
    
    // 2. Tomar captura desde el video
    function takeSnapshot() {
        const video = document.getElementById('webcam_video');
        const canvas = document.getElementById('canvas');
        canvas.width = 300;
        canvas.height = 300;
    
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    
        // Convertir a Base64 JPEG
        const dataURL = canvas.toDataURL('image/jpeg', 0.85);
        document.getElementById('foto_base64').value = dataURL;
    
        // Mostrar en vista previa
        showPreview(dataURL, 'Captura de cámara');
    
        // Limpiar archivo subido si existía
        document.getElementById('input_file').value = '';
    
        // Detener la cámara
        stopCamera();
    }
    
    // 3. Detener Stream de la Cámara
    function stopCamera() {
        if (streamVideo) {
            streamVideo.getTracks().forEach((track) => track.stop());
        }
        document.getElementById('webcam_container').classList.add('hidden');
        document.getElementById('btn_snap').classList.add('hidden');
    }
    
    // 4. Vista previa cuando selecciona un archivo tradicional
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                showPreview(e.target.result, input.files[0].name);
                document.getElementById('foto_base64').value = ''; // Limpiar Base64 de la cámara
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Helper para actualizar la imagen mostrada
    function showPreview(src, label) {
        const img = document.getElementById('img_preview');
        const icon = document.getElementById('default_icon');
        const textLabel = document.getElementById('preview_label');
    
        img.src = src;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
        textLabel.textContent = label;
    }
    
    // --- MANEJO DE TABS DE PERMISOS ---
    function switchTab(tabIndex) {
        document.querySelectorAll('.tab-panel').forEach((panel) => panel.classList.add('hidden'));
        document.querySelectorAll('.tab-button').forEach((btn) => {
            btn.classList.remove('border-indigo-600', 'text-indigo-600', 'bg-indigo-50/50');
            btn.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
        });
    
        const targetPanel = document.getElementById('tab-content-' + tabIndex);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }
    
        const targetBtn = document.getElementById('tab-btn-' + tabIndex);
        if (targetBtn) {
            targetBtn.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-50');
            targetBtn.classList.add('border-indigo-600', 'text-indigo-600', 'bg-indigo-50/50');
        }
    }
    
    function toggleGrupo(containerId, estado) {
        const checkboxes = document.querySelectorAll(`#${containerId} .chk-permiso`);
        checkboxes.forEach((chk) => (chk.checked = estado));
        actualizarBadgesTabs();
    }
    
    function toggleTodosPermisos(estado) {
        const checkboxes = document.querySelectorAll('.chk-permiso');
        checkboxes.forEach((chk) => (chk.checked = estado));
        actualizarBadgesTabs();
    }
    
    function actualizarBadgesTabs() {
        const paneles = document.querySelectorAll('.tab-panel');
        paneles.forEach((panel) => {
            const idNumber = panel.id.replace('tab-content-', '');
            const total = panel.querySelectorAll('.chk-permiso').length;
            const marcados = panel.querySelectorAll('.chk-permiso:checked').length;
    
            const badge = document.getElementById('badge-tab-' + idNumber);
            if (badge && total > 0) {
                badge.textContent = `${marcados} / ${total}`;
                if (marcados > 0) {
                    badge.className = 'ml-1 text-[10px] px-2 py-0.5 rounded-full font-semibold bg-indigo-100 text-indigo-700';
                } else {
                    badge.className = 'ml-1 text-[10px] px-2 py-0.5 rounded-full font-semibold bg-slate-200 text-slate-600';
                }
            }
        });
    }
</script>
