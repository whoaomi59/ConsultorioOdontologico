<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600"></i> Registrar Nuevo Usuario
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">Ingresa los datos personales, captura la foto e indica permisos.</p>
        </div>
        <a href="<?= BASE_URL ?>/usuarios/index" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 px-4 py-2.5 rounded-xl border border-slate-200 transition"><i data-lucide="arrow-left" class="w-4 h-4"></i>
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
                    <option value="recepcionista">Recepcionista</option>
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
                    <div class="w-28 h-28 mx-auto rounded-full border-2 border-dashed border-slate-300 flex items-center justify-center overflow-hidden bg-white shadow-sm" id="preview_container">
                        <i data-lucide="user" class="w-10 h-10 text-slate-300" id="default_icon"></i>
                        <img id="img_preview" class="w-full h-full object-cover hidden">
                    </div>
                    <span class="text-[10px] text-slate-400 block" id="preview_label">Sin foto seleccionada</span>
                </div>
            </div>
        </div>

        <div class="border-t pt-4 space-y-3">
            <h3 class="text-xs font-bold text-slate-800">Permisos y Módulos de Acceso</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" name="modulos[]" value="pacientes" checked class="rounded border-slate-300 text-indigo-600">
                    <span>Pacientes</span>
                </label>
                <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" name="modulos[]" value="citas" checked class="rounded border-slate-300 text-indigo-600">
                    <span>Citas Odontológicas</span>
                </label>
                <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" name="modulos[]" value="historias" checked class="rounded border-slate-300 text-indigo-600">
                    <span>Historias Clínicas</span>
                </label>
                <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" name="modulos[]" value="usuarios" class="rounded border-slate-300 text-indigo-600">
                    <span>Usuarios / Doctores</span>
                </label>
                <label class="flex items-center gap-2.5 p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs font-medium text-slate-700 cursor-pointer">
                    <input type="checkbox" name="modulos[]" value="reportes" class="rounded border-slate-300 text-indigo-600">
                    <span>Reportes</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t pt-4">
            <a href="<?= BASE_URL ?>/usuarios/index" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-xs font-medium">Cancelar</a>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold transition">Guardar Usuario</button>
        </div>
    </form>
</div>

<canvas id="canvas" class="hidden"></canvas>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();

    let streamVideo = null;

    // 1. Activar Cámara Web
    async function startCamera() {
        try {
            const constraints = { video: { width: 400, height: 400, facingMode: "user" } };
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
        const video  = document.getElementById('webcam_video');
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
            streamVideo.getTracks().forEach(track => track.stop());
        }
        document.getElementById('webcam_container').classList.add('hidden');
        document.getElementById('btn_snap').classList.add('hidden');
    }

    // 4. Vista previa cuando selecciona un archivo tradicional
    function previewFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result, input.files[0].name);
                document.getElementById('foto_base64').value = ''; // Limpiar Base64 de la cámara
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Helper para actualizar la imagen mostrada
    function showPreview(src, label) {
        const img       = document.getElementById('img_preview');
        const icon      = document.getElementById('default_icon');
        const textLabel = document.getElementById('preview_label');

        img.src = src;
        img.classList.remove('hidden');
        icon.classList.add('hidden');
        textLabel.textContent = label;
    }
</script>