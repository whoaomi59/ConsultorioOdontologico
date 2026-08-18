<div class="max-w-4xl mx-auto space-y-6">

    <!-- Encabezado -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl border border-amber-100">
                <i data-lucide="pencil" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800">Editar Paciente</h1>
                <p class="text-xs text-slate-500 mt-0.5">Actualiza la información general del paciente.</p>
            </div>
        </div>
        <a href="<?= BASE_URL ?>/paciente/index" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 px-4 py-2.5 rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Volver al listado</span>
        </a>
    </div>

    <!-- Formulario de Edición -->
    <form action="<?= BASE_URL ?>/paciente/editar/<?= $paciente['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-6">


        <!-- Ficha 1: Fotografía del Paciente -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
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
                    <button type="button" id="btn-cerrar-camara-alt" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                        Cancelar
                    </button>
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nombre <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($paciente['nombre']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Apellido <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="apellido" value="<?= htmlspecialchars($paciente['apellido']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Tipo de Documento -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Tipo Doc. <span class="text-rose-500">*</span>
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nº Documento <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="documento" value="<?= htmlspecialchars($paciente['documento']) ?>" required class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-mono focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Fecha de Nacimiento <span class="text-rose-500">*</span>
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
            <a href="<?= BASE_URL ?>/paciente/index" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-xs shadow-sm hover:shadow transition">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Actualizar Paciente</span>
            </button>
        </div>
    </form>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        const fotoInput     = document.getElementById('foto-input');
        const fotoBase64    = document.getElementById('foto_base64');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarIcon    = document.getElementById('avatar-icon');

        // Elementos del Modal y Cámara
        const modalCamara     = document.getElementById('modal-camara');
        const btnAbrirCamara  = document.getElementById('btn-abrir-camara');
        const btnCerrarCamara = document.getElementById('btn-cerrar-camara');
        const btnCerrarAlt    = document.getElementById('btn-cerrar-camara-alt');
        const btnCapturarFoto = document.getElementById('btn-capturar-foto');
        const video           = document.getElementById('video-camara');
        const canvas          = document.getElementById('canvas-camara');
        let streamCamara       = null;

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
                streamCamara.getTracks().forEach(track => track.stop());
                streamCamara = null;
            }
            modalCamara.classList.add('hidden');
        }

        if (btnAbrirCamara) {
            btnAbrirCamara.addEventListener('click', async () => {
                try {
                    streamCamara = await navigator.mediaDevices.getUserMedia({
                        video: { width: { ideal: 640 }, height: { ideal: 480 }, facingMode: "user" },
                        audio: false
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