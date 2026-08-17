<div class="max-w-4xl mx-auto space-y-6">

    <!-- Encabezado de la Vista -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl border border-indigo-100">
                <i data-lucide="user-plus" class="w-6 h-6"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-slate-800">Registrar Nuevo Paciente</h1>
                <p class="text-xs text-slate-500 mt-0.5">Ingresa los datos del expediente e información personal.</p>
            </div>
        </div>
        <a href="<?= BASE_URL ?>/paciente/index" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-slate-100 px-4 py-2.5 rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            <span>Volver al listado</span>
        </a>
    </div>

    <!-- Alerta de Error (Documento duplicado u otros) -->
    <?php if (isset($error)): ?>
        <div class="flex items-center gap-3 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-xl text-xs font-medium">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-rose-500"></i>
            <span><?= htmlspecialchars($error) ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulario Principal -->
    <form action="<?= BASE_URL ?>/paciente/crear" method="POST" enctype="multipart/form-data" class="space-y-6">

        <!-- Ficha 1: Fotografía y Perfil -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                <i data-lucide="camera" class="w-4 h-4 text-indigo-600"></i>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Fotografía del Paciente</h2>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-6 pt-2">
                <div class="relative shrink-0">
                    <div id="avatar-preview-container" class="w-24 h-24 rounded-2xl bg-slate-100 border-2 border-dashed border-slate-300 shadow-2xs overflow-hidden flex items-center justify-center text-slate-400">
                        <i data-lucide="user" id="avatar-icon" class="w-10 h-10"></i>
                        <img id="avatar-preview" class="w-full h-full object-cover hidden" alt="Vista previa">
                    </div>
                </div>

                <div class="space-y-2 text-center sm:text-left">
                    <p class="text-xs font-medium text-slate-700">Cargar una imagen oficial o foto del expediente</p>
                    <p class="text-[11px] text-slate-400">Archivos permitidos: JPG, PNG, WEBP (Opcional, máx. 5MB).</p>

                    <label class="inline-flex items-center gap-2 bg-slate-50 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 font-semibold text-xs px-4 py-2 rounded-xl border border-slate-200 hover:border-indigo-200 cursor-pointer transition">
                        <i data-lucide="upload-cloud" class="w-4 h-4"></i>
                        <span>Examinar archivo</span>
                        <input type="file" name="foto" id="foto-input" accept="image/png, image/jpeg, image/webp" class="hidden">
                    </label>
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
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="nombre" required placeholder="Ej. Juan Carlos" class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Apellido <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="apellido" required placeholder="Ej. Gómez Pérez" class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Selector Tipo Documento -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Tipo Doc. <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="file-badge" class="w-4 h-4"></i>
                        </span>
                        <select name="tipo_documento" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition appearance-none">
                            <option value="CC" selected>Cédula de Ciudadanía (CC)</option>
                            <option value="TI">Tarjeta de Identidad (TI)</option>
                            <option value="CE">Cédula de Extranjería (CE)</option>
                            <option value="PAS">Pasaporte (PAS)</option>
                            <option value="RC">Registro Civil (RC)</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="chevron-down" class="w-4 h-4"></i>
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Nº Documento <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="binary" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="documento" required placeholder="Ej. 1098765432" class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs font-mono focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Fecha de Nacimiento <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </span>
                        <input type="date" name="fecha_nacimiento" required class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- Ficha 3: Contacto y Notificaciones -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-5">
            <div class="flex items-center gap-2 border-b border-slate-100 pb-3">
                <i data-lucide="phone-call" class="w-4 h-4 text-indigo-600"></i>
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Información de Contacto</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Teléfono / Celular</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </span>
                        <input type="tel" name="telefono" placeholder="Ej. +57 300 123 4567" class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" name="email" placeholder="ejemplo@correo.com" class="w-full pl-10 pr-4 py-2.5 bg-slate-50/50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de Envió -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="<?= BASE_URL ?>/paciente/index" class="px-5 py-3 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Cancelar
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-xs shadow-sm hover:shadow transition">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Registrar Paciente</span>
            </button>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        const fotoInput     = document.getElementById('foto-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const avatarIcon    = document.getElementById('avatar-icon');

        if (fotoInput) {
            fotoInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        avatarPreview.src = event.target.result;
                        avatarPreview.classList.remove('hidden');
                        avatarIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>