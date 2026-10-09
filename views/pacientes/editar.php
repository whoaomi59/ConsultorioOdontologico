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
<div class="pacientes-ui pacientes-edit">
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Encabezado -->
        <div class="p-hero flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 p-6 rounded-2xl border shadow-xs">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-xl border border-amber-100">
                    <i data-lucide="pencil" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800">Editar Paciente</h1>
                    <p class="text-xs text-slate-500 mt-0.5">Actualiza la información general del paciente.</p>
                </div>
            </div>
            <a href="<?= BASE_URL ?>/paciente/index" class="p-backlink inline-flex items-center gap-2 text-xs font-semibold px-4 py-2.5 rounded-xl border transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Volver al listado</span>
            </a>
        </div>
        <!-- Formulario de Edición -->
        <form action="<?= BASE_URL ?>/paciente/editar/<?= $paciente['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Ficha 1: Fotografía del Paciente -->
            <div class="p-photo-card bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i data-lucide="camera" class="w-4 h-4 text-indigo-600"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Fotografía del Paciente</h2>
                </div>
                <!-- Campo oculto para guardar la imagen Base64 de la cámara -->
                <input type="hidden" name="foto_base64" id="foto_base64">
                <div class="flex flex-col sm:flex-row items-center gap-6 pt-2">
                    <div class="relative shrink-0">
                        <div id="avatar-preview-container" class="w-28 h-28 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 shadow-2xs overflow-hidden flex items-center justify-center text-slate-400">
                            <?php if (!empty($paciente['foto']) && file_exists(rtrim(ROOT_PATH, '/\\') . '/public/uploads/pacientes/' . $paciente['foto'])): ?>
                                <img id="avatar-preview" src="<?= BASE_URL ?>/public/uploads/pacientes/<?= htmlspecialchars($paciente['foto']) ?>" class="w-full h-full object-cover" alt="Foto Paciente">
                                <i data-lucide="user" id="avatar-icon" class="w-10 h-10 hidden"></i>
                            <?php else: ?>
                                <i data-lucide="user" id="avatar-icon" class="w-10 h-10"></i>
                                <img id="avatar-preview" class="w-full h-full object-cover hidden" alt="Vista previa">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="space-y-3 text-center sm:text-left">
                        <p class="text-xs font-medium text-slate-700">Selecciona un archivo o toma una foto desde la webcam</p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <!-- Botón de subir archivo -->
                            <label for="foto-input" class="inline-flex items-center gap-2 bg-slate-50 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 font-semibold text-xs px-3.5 py-2 rounded-xl border border-slate-200 hover:border-indigo-200 cursor-pointer transition">
                                <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                                <span>Examinar Archivo</span>
                            </label>
                            <input type="file" name="foto" id="foto-input" accept="image/png, image/jpeg, image/webp" class="hidden">
                            <!-- Botón de tomar foto -->
                            <button type="button" id="btn-abrir-camara" class="inline-flex items-center gap-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold text-xs px-3.5 py-2 rounded-xl border border-indigo-200 transition">
                                <i data-lucide="camera" class="w-4 h-4"></i>
                                <span>Tomar Foto</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal para la Cámara Web -->
            <div id="modal-camara" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 flex items-center justify-center hidden p-4">
                <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-2xl">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <i data-lucide="camera" class="w-4 h-4 text-indigo-600"></i>
                            Capturar Foto del Paciente
                        </h3>
                        <button type="button" id="btn-cerrar-camara" class="text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="relative bg-slate-900 rounded-xl overflow-hidden aspect-video flex items-center justify-center">
                        <video id="video-camara" autoplay playsinline class="w-full h-full object-cover"></video>
                        <canvas id="canvas-camara" class="hidden"></canvas>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" id="btn-cerrar-camara-alt" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"> Cancelar </button>
                        <button type="button" id="btn-capturar-foto" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl text-xs shadow-sm transition">
                            <i data-lucide="aperture" class="w-4 h-4"></i>
                            <span>Capturar</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Ficha 2: Identificación del Paciente -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i data-lucide="id-card" class="w-4 h-4 text-indigo-600"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Datos de Identificación</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Nombre
                            <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($paciente['nombre']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Apellido
                            <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="apellido" value="<?= htmlspecialchars($paciente['apellido']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <!-- Tipo de Documento -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Tipo Doc.
                            <span class="text-rose-500">*</span>
                        </label>
                        <select name="tipo_documento" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                            <?php $td = $paciente['tipo_documento'] ?? 'CC'; ?>
                            <option value="CC" <?= $td === 'CC' ? 'selected' : '' ?>>Cédula de Ciudadanía (CC)</option>
                            <option value="TI" <?= $td === 'TI' ? 'selected' : '' ?>>Tarjeta de Identidad (TI)</option>
                            <option value="CE" <?= $td === 'CE' ? 'selected' : '' ?>>Cédula de Extranjería (CE)</option>
                            <option value="PAS" <?= $td === 'PAS' ? 'selected' : '' ?>>Pasaporte (PAS)</option>
                            <option value="RC" <?= $td === 'RC' ? 'selected' : '' ?>>Registro Civil (RC)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Nº Documento
                            <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="documento" value="<?= htmlspecialchars($paciente['documento']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-mono focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                            Fecha de Nacimiento
                            <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($paciente['fecha_nacimiento']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>
            <!-- Ficha 3: Contacto -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i data-lucide="phone-call" class="w-4 h-4 text-indigo-600"></i>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Información de Contacto</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Teléfono / Celular</label>
                        <input type="tel" name="telefono" value="<?= htmlspecialchars($paciente['telefono']) ?>" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Correo Electrónico</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($paciente['email']) ?>" class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>
            <!-- Botones de Acción -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="<?= BASE_URL ?>/paciente/index" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition"> Cancelar </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-xs shadow-sm hover:shadow transition">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Actualizar Paciente</span>
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest">
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    
        const fotoInput = document.getElementById('foto-input');
        const fotoBase64 = document.getElementById('foto_base64');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarIcon = document.getElementById('avatar-icon');
    
        // Elementos del Modal y Cámara
        const modalCamara = document.getElementById('modal-camara');
        const btnAbrirCamara = document.getElementById('btn-abrir-camara');
        const btnCerrarCamara = document.getElementById('btn-cerrar-camara');
        const btnCerrarAlt = document.getElementById('btn-cerrar-camara-alt');
        const btnCapturarFoto = document.getElementById('btn-capturar-foto');
        const video = document.getElementById('video-camara');
        const canvas = document.getElementById('canvas-camara');
        let streamCamara = null;
    
        // 1. Cargar vista previa cuando se sube archivo manual
        if (fotoInput) {
            fotoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    fotoBase64.value = ''; // Limpiar foto de cámara previa
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        avatarPreview.src = event.target.result;
                        avatarPreview.classList.remove('hidden');
                        if (avatarIcon) avatarIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    
        // 2. Encender cámara web
        async function apagarCamara() {
            if (streamCamara) {
                streamCamara.getTracks().forEach((track) => track.stop());
                streamCamara = null;
            }
            modalCamara.classList.add('hidden');
        }
    
        if (btnAbrirCamara) {
            btnAbrirCamara.addEventListener('click', async () => {
                try {
                    streamCamara = await navigator.mediaDevices.getUserMedia({
                        video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: 'user' },
                        audio: false,
                    });
                    video.srcObject = streamCamara;
                    modalCamara.classList.remove('hidden');
                } catch (err) {
                    alert('No se pudo acceder a la cámara. Asegúrate de otorgar permisos.');
                    console.error(err);
                }
            });
        }
    
        if (btnCerrarCamara) btnCerrarCamara.addEventListener('click', apagarCamara);
        if (btnCerrarAlt) btnCerrarAlt.addEventListener('click', apagarCamara);
    
        // 3. Capturar imagen desde el stream de video
        if (btnCapturarFoto) {
            btnCapturarFoto.addEventListener('click', () => {
                canvas.width = video.videoWidth || 640;
                canvas.height = video.videoHeight || 480;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
    
                // Exportar como imagen JPEG en Base64
                const dataURL = canvas.toDataURL('image/jpeg', 0.9);
                fotoBase64.value = dataURL;
    
                // Limpiar input file si existía algo seleccionado
                if (fotoInput) fotoInput.value = '';
    
                // Mostrar en la vista previa
                avatarPreview.src = dataURL;
                avatarPreview.classList.remove('hidden');
                if (avatarIcon) avatarIcon.classList.add('hidden');
    
                apagarCamara();
            });
        }
    });
</script>