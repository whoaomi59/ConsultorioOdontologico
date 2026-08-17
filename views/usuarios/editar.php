<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="pencil" class="w-5 h-5 text-indigo-600"></i> Editar Usuario #<?= $usuario['id'] ?>
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Modifica los datos personales, actualiza la foto o gestiona los módulos asignados.</p>
        </div>
        <a href="<?= BASE_URL ?>/usuarios/index" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 px-4 py-2.5 rounded-xl border border-slate-200 transition"><i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Volver al listado</span>
        </a>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-xl">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Registrado El</span>
                <span class="font-bold text-slate-700">
                    <?= !empty($usuario['creado_en']) ? date('d/m/Y h:i A', strtotime($usuario['creado_en'])) : 'N/A' ?>
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="p-2 bg-amber-50 text-amber-600 rounded-xl">
                <i data-lucide="clock" class="w-4 h-4"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Última Modificación</span>
                <span class="font-bold text-slate-700">
                    <?= !empty($usuario['actualizado_en']) ? date('d/m/Y h:i A', strtotime($usuario['actualizado_en'])) : 'Sin cambios' ?>
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="p-2 bg-emerald-50 text-emerald-600 rounded-xl">
                <i data-lucide="log-in" class="w-4 h-4"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Último Acceso</span>
                <span class="font-bold text-slate-700">
                    <?= !empty($usuario['ultimo_acceso']) ? date('d/m/Y h:i A', strtotime($usuario['ultimo_acceso'])) : 'Nunca registrado' ?>
                </span>
            </div>
        </div>
    </div>

    <form action="<?= BASE_URL ?>/usuarios/actualizar/<?= $usuario['id'] ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo *</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico *</label>
                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nueva Contraseña (Opcional)</label>
                <input type="password" name="password" placeholder="Dejar en blanco para mantener actual" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Rol *</label>
                <select name="rol" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
                    <option value="doctor" <?= $usuario['rol'] === 'doctor' ? 'selected' : '' ?>>Doctor</option>
                    <option value="recepcionista" <?= $usuario['rol'] === 'recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                    <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>
            <div class="sm:col-span-2 flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-200">
                <span class="text-xs font-bold text-slate-700">Estado de la cuenta</span>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="estado" value="1" <?= $usuario['estado'] ? 'checked' : '' ?> class="rounded border-slate-300 text-indigo-600">
                    <span class="text-xs font-medium text-slate-600">Usuario Activo</span>
                </label>
            </div>
        </div>

        <div class="border-t pt-4 space-y-3">
            <label class="block text-xs font-bold text-slate-800">Actualizar Foto de Perfil (Tomar nueva foto o seleccionar)</label>

            <input type="hidden" name="foto_base64" id="foto_base64">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                <div class="space-y-2">
                    <span class="block text-[11px] text-slate-500">Opción A: Subir archivo o cámara del dispositivo</span>
                    <input type="file" id="input_file" name="foto" accept="image/*" capture="user" onchange="previewFile(this)" class="w-full text-xs text-slate-500 bg-slate-50 border border-slate-200 rounded-xl p-2">
                </div>

                <div class="space-y-2">
                    <span class="block text-[11px] text-slate-500">Opción B: Capturar con Cámara Web</span>
                    <div class="flex gap-2">
                        <button type="button" onclick="startCamera()" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs flex items-center gap-1.5 hover:bg-slate-900 transition">
                            <i data-lucide="camera" class="w-4 h-4"></i> Activar Cámara
                        </button>
                        <button type="button" id="btn_snap" onclick="takeSnapshot()" class="hidden px-3 py-2 bg-indigo-600 text-white rounded-xl text-xs flex items-center gap-1.5 hover:bg-indigo-700 transition">
                            <i data-lucide="aperture" class="w-4 h-4"></i> Capturar
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-center justify-center bg-slate-50 p-4 rounded-2xl border border-slate-200/80">

                <div id="webcam_container" class="hidden relative w-44 h-44 rounded-2xl overflow-hidden border border-slate-300 bg-black">
                    <video id="webcam_video" autoplay playsinline class="w-full h-full object-cover"></video>
                </div>

                <div class="text-center space-y-1">
                    <div class="w-28 h-28 mx-auto rounded-full border-2 border-slate-200 flex items-center justify-center overflow-hidden bg-white shadow-sm" id="preview_container">
                        <?php if (!empty($usuario['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' . $usuario['foto'])): ?>
                            <img id="img_preview" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                            <i data-lucide="user" class="w-10 h-10 text-slate-300" id="default_icon"></i>
                            <img id="img_preview" class="w-full h-full object-cover hidden">
                        <?php endif; ?>
                    </div>
                    <span class="text-[10px] text-slate-400 block" id="preview_label">
                        <?= !empty($usuario['foto']) ? 'Foto actual cargada' : 'Sin foto cargada' ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="border-t pt-4 space-y-3">
            <h3 class="text-xs font-bold text-slate-800">Permisos y Módulos de Acceso</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <?php $modulosDisponibles = ['pacientes', 'citas', 'historias', 'usuarios', 'reportes']; ?>
                <?php foreach ($modulosDisponibles as $m): ?>
                    <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer hover:bg-slate-100 transition">
                        <input type="checkbox" name="modulos[]" value="<?= $m ?>" <?= in_array($m, $permisos) ? 'checked' : '' ?> class="rounded border-slate-300 text-indigo-600">
                        <span class="capitalize"><?= $m ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t pt-4">
            <a href="<?= BASE_URL ?>/usuarios/index" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-medium">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition">Guardar Cambios</button>
        </div>
    </form>
</div>

<canvas id="canvas" class="hidden"></canvas>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    let streamVideo = null;

    async function startCamera() {
        try {
            const constraints = { video: { width: 400, height: 400, facingMode: "user" } };
            streamVideo = await navigator.mediaDevices.getUserMedia(constraints);
            const video = document.getElementById('webcam_video');
            video.srcObject = streamVideo;

            document.getElementById('webcam_container').classList.remove('hidden');
            document.getElementById('btn_snap').classList.remove('hidden');
        } catch (err) {
            alert('No se pudo acceder a la cámara. Revisa los permisos de tu navegador.');
        }
    }

    function takeSnapshot() {
        const video  = document.getElementById('webcam_video');
        const canvas = document.getElementById('canvas');
        canvas.width = 300;
        canvas.height = 300;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataURL = canvas.toDataURL('image/jpeg', 0.85);
        document.getElementById('foto_base64').value = dataURL;

        showPreview(dataURL, 'Captura de cámara lista');
        document.getElementById('input_file').value = '';
        stopCamera();
    }

    function stopCamera() {
        if (streamVideo) {
            streamVideo.getTracks().forEach(track => track.stop());
        }
        document.getElementById('webcam_container').classList.add('hidden');
        document.getElementById('btn_snap').classList.add('hidden');
    }

    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result, input.files[0].name);
                document.getElementById('foto_base64').value = '';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function showPreview(src, label) {
        const img       = document.getElementById('img_preview');
        const icon      = document.getElementById('default_icon');
        const textLabel = document.getElementById('preview_label');

        img.src = src;
        img.classList.remove('hidden');
        if (icon) icon.classList.add('hidden');
        textLabel.textContent = label;
    }
</script>