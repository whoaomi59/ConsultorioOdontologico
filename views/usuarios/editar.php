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
        ]
    ],
    'Pacientes' => [
        'icon' => 'calendar',
        'modulos' => [
            'pacientes' => 'pacientes',
            'pacientes_crear' => 'pacientes_crear',
            'pacientes_perfil' => 'pacientes_perfil',
            'pacientes_editar' => 'pacientes_editar',
            'pacientes_eliminar' => 'pacientes_eliminar',
        ]
    ],
    'Historias Clínicas' => [
        'icon' => 'folder-heart',
        'modulos' => [
            'historia' => 'Historias Clínicas',
            'historia_ver' => 'historia_ver',
            'historia_odontologia' => 'historia_odontologia',
            'historia_ortodoncia' => 'historia_ortodoncia'
        ]
    ],
    'Citas' => [
        'icon' => 'folder-heart',
        'modulos' => [
            'citas' => 'Citas',
            'citas_ver' => 'citas_ver',
            'citas_editar' => 'citas_editar',
            'citas_eliminar' => 'citas_eliminar',
        ]
    ]
];
?>

<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <div class="max-w-3xl mx-auto space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
                        <div>
                            <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <i data-lucide="pencil" class="w-5 h-5 text-indigo-600"></i> Editar Usuario #<?= $usuario['id'] ?>
                            </h1>
                            <p class="text-xs text-slate-500 mt-0.5">Modifica los datos personales, actualiza la foto o gestiona los módulos asignados.</p>
                        </div>
                        <a href="<?= BASE_URL ?>/usuarios/index" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 px-4 py-2.5 rounded-xl border border-slate-200/80 transition shadow-sm self-start sm:self-auto">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i>
                            <span>Volver al listado</span>
                        </a>
                    </div>

                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Registrado El</span>
                                <span class="font-bold text-slate-700">
                                    <?= !empty($usuario['creado_en']) ? date('d/m/Y h:i A', strtotime($usuario['creado_en'])) : 'N/A' ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-amber-50 text-amber-600 rounded-xl">
                                <i data-lucide="clock" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Última Modificación</span>
                                <span class="font-bold text-slate-700">
                                    <?= !empty($usuario['actualizado_en']) ? date('d/m/Y h:i A', strtotime($usuario['actualizado_en'])) : 'Sin cambios' ?>
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl">
                                <i data-lucide="log-in" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block">Último Acceso</span>
                                <span class="font-bold text-slate-700">
                                    <?= !empty($usuario['ultimo_acceso']) ? date('d/m/Y h:i A', strtotime($usuario['ultimo_acceso'])) : 'Nunca registrado' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="<?= BASE_URL ?>/usuarios/actualizar/<?= $usuario['id'] ?>" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nombre Completo *</label>
                                <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Correo Electrónico *</label>
                                <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Nueva Contraseña (Opcional)</label>
                                <input type="password" name="password" placeholder="Dejar en blanco para mantener actual" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1.5">Rol *</label>
                                <select name="rol" required class="w-full bg-slate-50/50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                                    <option value="doctor" <?= $usuario['rol'] === 'doctor' ? 'selected' : '' ?>>Doctor</option>
                                    <option value="recepcionista" <?= $usuario['rol'] === 'recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                                    <option value="admin" <?= $usuario['rol'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2 flex items-center justify-between bg-slate-50/80 p-3.5 rounded-xl border border-slate-200/80">
                                <span class="text-xs font-bold text-slate-700">Estado de la cuenta</span>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="estado" value="1" <?= $usuario['estado'] ? 'checked' : '' ?> class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-xs font-medium text-slate-600">Usuario Activo</span>
                                </label>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-5 space-y-4">
                            <div>
                                <h3 class="text-xs font-bold text-slate-800">Foto de Perfil</h3>
                                <p class="text-[11px] text-slate-500">Selecciona un archivo o realiza una toma en vivo con la cámara web.</p>
                            </div>

                            <input type="hidden" name="foto_base64" id="foto_base64">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-end">
                                <div class="space-y-1.5">
                                    <span class="block text-[11px] font-medium text-slate-600">Opción A: Subir archivo de imagen</span>
                                    <input type="file" id="input_file" name="foto" accept="image/*" capture="user" onchange="previewFile(this)" class="w-full text-xs text-slate-500 bg-slate-50/50 border border-slate-200 rounded-xl p-2 focus:outline-none">
                                </div>

                                <div class="space-y-1.5">
                                    <span class="block text-[11px] font-medium text-slate-600">Opción B: Capturar con Webcam</span>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="startCamera()" class="px-3.5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-medium flex items-center gap-1.5 transition">
                                            <i data-lucide="camera" class="w-4 h-4"></i> Activar Cámara
                                        </button>
                                        <button type="button" id="btn_snap" onclick="takeSnapshot()" class="hidden px-3.5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-medium flex items-center gap-1.5 transition shadow-sm">
                                            <i data-lucide="aperture" class="w-4 h-4"></i> Capturar
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-6 items-center justify-center bg-slate-50/60 p-4 rounded-2xl border border-slate-200/80">
                                <div id="webcam_container" class="hidden relative w-40 h-40 rounded-2xl overflow-hidden border border-slate-300 bg-black shadow-inner">
                                    <video id="webcam_video" autoplay playsinline class="w-full h-full object-cover"></video>
                                </div>

                                <div class="text-center space-y-2">
                                    <div class="w-28 h-28 mx-auto rounded-full border-2 border-slate-200 flex items-center justify-center overflow-hidden bg-white shadow-sm" id="preview_container">
                                        <?php if (!empty($usuario['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' . $usuario['foto'])): ?>
                                            <img id="img_preview" src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i data-lucide="user" class="w-10 h-10 text-slate-300" id="default_icon"></i>
                                            <img id="img_preview" class="w-full h-full object-cover hidden">
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-[10px] font-medium text-slate-400 block" id="preview_label">
                                        <?= !empty($usuario['foto']) ? 'Foto actual cargada' : 'Sin foto cargada' ?>
                                    </span>
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
                                $modulosKeys            = array_keys($seccion['modulos']);
                                $seleccionadosEnSeccion = array_intersect($modulosKeys, $permisos ?? []);
                                $esActivo               = ($index === 1);
                                ?>
                                <button type="button"
                                onclick="switchTab(<?= $index ?>)"
                                id="tab-btn-<?= $index ?>"
                                class="tab-button flex items-center gap-2 px-4 py-2.5 text-xs font-bold rounded-t-xl transition border-b-2 -mb-px whitespace-nowrap focus:outline-none <?= $esActivo ? 'border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'border-transparent text-slate-500 hover:text-slate-700 hover:bg-slate-50' ?>">
                                <i data-lucide="<?= $seccion['icon'] ?>" class="w-4 h-4"></i>
                                <span><?= $tituloSeccion ?></span>
                                <span id="badge-tab-<?= $index ?>" class="ml-1 text-[10px] px-2 py-0.5 rounded-full font-semibold <?= count($seleccionadosEnSeccion) > 0 ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-200 text-slate-600' ?>">
                                    <?= count($seleccionadosEnSeccion) ?> / <?= count($seccion['modulos']) ?>
                                </span>
                            </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="bg-slate-50/40 border border-slate-200/80 rounded-b-2xl rounded-tr-2xl p-4 shadow-sm">
                            <?php $index    = 0; foreach ($seccionesPermisos as $tituloSeccion => $seccion): $index++; ?>
                            <?php $esActivo = ($index === 1); ?>

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
                                            <input type="checkbox"
                                            name="modulos[]"
                                            value="<?= $key ?>"
                                            <?= $isChecked ? 'checked' : '' ?>
                                            onchange="actualizarBadgesTabs()"
                                            class="chk-permiso rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                            <span><?= $label ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="border-t pt-4 space-y-3">
                        <label class="block text-xs font-bold text-slate-800">Firma Digital del Doctor / Usuario</label>
                        <div class="relative bg-white border-2 border-dashed border-slate-300 rounded-2xl overflow-hidden shadow-2xs">
                            <canvas id="user-signature-pad" class="w-full h-36 touch-none cursor-crosshair"></canvas>
                            <button type="button" id="clear-user-signature" class="absolute top-2 right-2 text-[10px] bg-slate-100 hover:bg-slate-200 px-2 py-1 rounded">Limpiar</button>
                        </div>
                        <input type="hidden" name="firma_base64" id="user_firma_base64" value="<?= htmlspecialchars($usuario['firma_base64'] ?? '') ?>">
                    </div>
                    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-5">
                        <a href="<?= BASE_URL ?>/usuarios/index" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">Cancelar</a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-sm transition">Guardar Cambios</button>
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

                // --- MANEJO DE TABS DE PERMISOS ---
                function switchTab(tabIndex) {
                    document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.add('hidden'));
                    document.querySelectorAll('.tab-button').forEach(btn => {
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
                    checkboxes.forEach(chk => chk.checked = estado);
                    actualizarBadgesTabs();
                }

                function toggleTodosPermisos(estado) {
                    const checkboxes = document.querySelectorAll('.chk-permiso');
                    checkboxes.forEach(chk => chk.checked = estado);
                    actualizarBadgesTabs();
                }

                function actualizarBadgesTabs() {
                    const paneles = document.querySelectorAll('.tab-panel');
                    paneles.forEach((panel) => {
                        const idNumber = panel.id.replace('tab-content-', '');
                        const total    = panel.querySelectorAll('.chk-permiso').length;
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




            <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    const canvas = document.getElementById('user-signature-pad');
                    if (canvas) {
                        canvas.width = canvas.parentElement.clientWidth;
                        canvas.height = 120;
                        const userPad = new SignaturePad(canvas, { backgroundColor: 'rgb(255, 255, 255)' });

                        const firmaExistente = "<?= $usuario['firma_base64'] ?? '' ?>";
                        if (firmaExistente) {
                            userPad.fromDataURL(firmaExistente);
                        }

                        document.getElementById('clear-user-signature').addEventListener('click', () => {
                            userPad.clear();
                            document.getElementById('user_firma_base64').value = '';
                        });

                        canvas.closest('form').addEventListener('submit', () => {
                            if (!userPad.isEmpty()) {
                                document.getElementById('user_firma_base64').value = userPad.toDataURL('image/png');
                            }
                        });
                    }
                });
            </script>