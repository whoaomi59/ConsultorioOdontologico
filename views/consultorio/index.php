<div class="max-w-3xl mx-auto space-y-6 pb-12">

    <!-- Encabezado de la Sección -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
        <div class="flex items-center gap-4 pl-2">
            <div class="bg-indigo-50 p-3.5 rounded-2xl text-indigo-600 shadow-inner">
                <i data-lucide="building-2" class="w-7 h-7"></i>
            </div>
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">Configuración del Consultorio</h1>
                <p class="text-xs text-slate-500 mt-0.5 font-medium">Administra la información institucional que aparecerá en los encabezados e impresiones.</p>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3.5 rounded-2xl text-xs font-bold flex items-center gap-3 shadow-xs animate-fade-in">
            <div class="bg-emerald-500 text-white p-1 rounded-full flex items-center justify-center">
                <i data-lucide="check" class="w-3.5 h-3.5"></i>
            </div>
            <span>¡Datos del consultorio actualizados correctamente!</span>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form action="<?= BASE_URL ?>/consultorio/guardar" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">

        <input type="hidden" name="logo_actual" value="<?= htmlspecialchars($consultorio['Logo'] ?? '') ?>">

        <!-- Campo Nombre -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                <i data-lucide="stethoscope" class="w-4 h-4 text-indigo-600"></i> Nombre del Consultorio / Doctor
            </label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($consultorio['Nombre'] ?? '') ?>" required maxlength="40"
            placeholder="Ej. Clínica Odontológica Sonrisas"
            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
        </div>

        <!-- Campo Dirección -->
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                <i data-lucide="map-pin" class="w-4 h-4 text-indigo-600"></i> Dirección Física
            </label>
            <input type="text" name="direccion" value="<?= htmlspecialchars($consultorio['direccion'] ?? '') ?>" required maxlength="40"
            placeholder="Ej. Calle Principal # 45 - 12"
            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
        </div>

        <!-- Sección de Logotipo -->
        <div class="space-y-2 pt-2 border-t border-slate-100">
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide flex items-center gap-1.5">
                <i data-lucide="image" class="w-4 h-4 text-indigo-600"></i> Logotipo Institucional
            </label>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 mt-3 bg-slate-50/60 p-4 rounded-2xl border border-dashed border-slate-300">
                <?php if (!empty($consultorio['Logo'])): ?>
                    <div class="w-24 h-24 bg-white border border-slate-200 rounded-xl flex items-center justify-center p-2.5 shadow-xs shrink-0">
                        <img src="<?= BASE_URL ?>/<?= htmlspecialchars($consultorio['Logo']) ?>" alt="Logo actual" class="max-h-full max-w-full object-contain">
                    </div>
                <?php else: ?>
                    <div class="w-24 h-24 bg-slate-100 border border-slate-200 rounded-xl flex flex-col items-center justify-center p-2 text-slate-400 shrink-0">
                        <i data-lucide="image-off" class="w-6 h-6 mb-1"></i>
                        <span class="text-[10px] font-medium">Sin logo</span>
                    </div>
                <?php endif; ?>

                <div class="flex-1 w-full space-y-2">
                    <input type="file" name="logo" accept="image/png, image/jpeg, image/webp"
                    class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 file:transition-all cursor-pointer">
                    <p class="text-[11px] text-slate-400">Sube una imagen clara en formato <strong>PNG, JPG o WEBP</strong>. Se recomienda fondo transparente o blanco.</p>
                </div>
            </div>
        </div>

        <!-- Botón de Guardar -->
        <div class="pt-5 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-6 py-3.5 rounded-xl transition-all shadow-md shadow-indigo-600/20 hover:shadow-lg hover:shadow-indigo-600/30 flex items-center gap-2 cursor-pointer">
                <i data-lucide="save" class="w-4 h-4"></i> Guardar Cambios
            </button>
        </div>

    </form>
</div>

<script>
    lucide.createIcons();
</script>