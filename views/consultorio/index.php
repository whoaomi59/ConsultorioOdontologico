<div class="max-w-5xl mx-auto space-y-6 pb-12 font-sans">

    <!-- Header y Acción Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-7 rounded-3xl shadow-xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="p-3.5 bg-indigo-500/20 text-indigo-300 rounded-2xl border border-indigo-500/30 backdrop-blur-md shadow-inner">
                <i data-lucide="building-2" class="w-7 h-7"></i>
            </div>
            <div>
                <h1 class="text-2xl font-black tracking-tight">Configuración del Consultorio</h1>
                <p class="text-xs text-slate-300 mt-1">Administra la información institucional y la paleta de convenciones clínicas.</p>
            </div>
        </div>

    </div>

    <!-- Alertas -->
    <?php if (isset($_GET['success'])): ?>
        <div class="bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3 shadow-xs">
            <div class="bg-emerald-500 text-white p-1.5 rounded-full flex items-center justify-center">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <span>¡Configuración y convenciones actualizadas correctamente!</span>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="bg-rose-50 border border-rose-200/80 text-rose-800 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3 shadow-xs">
            <div class="bg-rose-500 text-white p-1.5 rounded-full flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </div>
            <span>Ocurrió un error al guardar los cambios. Inténtalo de nuevo.</span>
        </div>
    <?php endif; ?>

    <!-- Formulario Unificado -->
    <form id="form-configuracion" action="<?= BASE_URL ?>/consultorio/guardar" method="POST" enctype="multipart/form-data" class="space-y-6">

        <?php
        $logoActual        = $consultorio['Logo'] ?? ($consultorio['logo'] ?? '');
        $nombreConsultorio = $consultorio['Nombre'] ?? ($consultorio['nombre'] ?? '');$direccionConsultorio = $consultorio['direccion'] ?? ($consultorio['Direccion'] ?? '');
        ?>
        <input type="hidden" name="logo_actual" value="<?= htmlspecialchars($logoActual) ?>">

        <!-- SECCIÓN 1: DATOS GENERALES -->
        <div class="bg-white p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <i data-lucide="stethoscope" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide">Información Institucional</h2>
                    <p class="text-[11px] text-slate-400">Datos principales que aparecerán en los reportes y recetas.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Nombre del Consultorio / Doctor <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($nombreConsultorio) ?>" required maxlength="60" placeholder="Ej. Clínica Odontológica Sonrisas"
                    class="w-full bg-slate-50/60 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Dirección Física <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="direccion" value="<?= htmlspecialchars($direccionConsultorio) ?>" required maxlength="60" placeholder="Ej. Calle Principal # 45 - 12"
                    class="w-full bg-slate-50/60 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>
            </div>

            <div class="space-y-2 pt-3 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Logotipo Institucional</label>
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 mt-2 bg-slate-50/60 p-5 rounded-2xl border border-dashed border-slate-300">
                    <?php if (!empty($logoActual)): ?>
                        <div class="w-24 h-24 bg-white border border-slate-200 rounded-2xl flex items-center justify-center p-2.5 shadow-xs shrink-0">
                            <img src="<?= BASE_URL ?>/<?= htmlspecialchars($logoActual) ?>" alt="Logo" class="max-h-full max-w-full object-contain">
                        </div>
                    <?php else: ?>
                        <div class="w-24 h-24 bg-slate-100 border border-slate-200 rounded-2xl flex flex-col items-center justify-center p-2 text-slate-400 shrink-0">
                            <i data-lucide="image-off" class="w-6 h-6 mb-1"></i>
                            <span class="text-[10px] font-medium">Sin logo</span>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1 w-full space-y-2">
                        <input type="file" name="logo" accept="image/png, image/jpeg, image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                        <p class="text-[11px] text-slate-400">Formatos recomendados: <strong>PNG, JPG o WEBP</strong>.</p>
                    </div>
                </div>
            </div>
            <div class="relative z-10">
                <button type="submit" form="form-configuracion" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-2xl text-xs shadow-lg shadow-indigo-600/30 transition-all duration-300 hover:scale-105 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </div>

        <!-- SECCIÓN 2: GESTIÓN DE CONVENCIONES -->
        <div class="bg-white p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-2xl">
                        <i data-lucide="palette" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide">Tabla de Convenciones Clínicas</h2>
                        <p class="text-[11px] text-slate-400">Define los códigos, colores y descripciones para el odontograma.</p>
                    </div>
                </div>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-3">Nombre</th>
                            <th class="py-3 px-3">Código</th>
                            <th class="py-3 px-3">Color</th>
                            <th class="py-3 px-3">Descripción</th>
                            <th class="py-3 px-3 text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-convenciones-body" class="divide-y divide-slate-100">
                        <?php if (!empty($convenciones)): ?>
                            <?php foreach ($convenciones as $index =>$conv): ?>
                                <tr class="convencion-row group hover:bg-slate-50/60 transition-colors">
                                    <input type="hidden" name="convenciones[<?= $index ?>][id]" value="<?= $conv['id'] ?>">

                                    <td class="py-3 px-3">
                                        <input type="text" name="convenciones[<?= $index ?>][nombre]" value="<?= htmlspecialchars($conv['nombre']) ?>" required placeholder="Ej. Caries"
                                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                    </td>

                                    <td class="py-3 px-3 w-32">
                                        <input type="text" name="convenciones[<?= $index ?>][codigo]" value="<?= htmlspecialchars($conv['codigo']) ?>" required placeholder="Ej. CAR"
                                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 font-mono uppercase">
                                    </td>

                                    <td class="py-3 px-3 w-36">
                                        <div class="flex items-center gap-2 bg-slate-50/50 border border-slate-200 rounded-xl px-2 py-1.5">
                                            <input type="color" name="convenciones[<?= $index ?>][color]" value="<?= htmlspecialchars($conv['color'] ?: '#3b82f6') ?>"
                                            class="w-7 h-7 rounded-lg border-0 cursor-pointer bg-transparent p-0">
                                            <input type="text" name="convenciones[<?= $index ?>][color_text]" value="<?= htmlspecialchars($conv['color']) ?>" placeholder="#3B82F6"
                                            class="w-full bg-transparent text-xs text-slate-800 focus:outline-none font-mono uppercase">
                                        </div>
                                    </td>

                                    <td class="py-3 px-3">
                                        <input type="text" name="convenciones[<?= $index ?>][descripcion]" value="<?= htmlspecialchars($conv['descripcion']) ?>" placeholder="Opcional..."
                                        class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                    </td>

                                    <td class="py-3 px-3 text-center w-16">
                                        <button type="button" class="btn-eliminar p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer" title="Eliminar">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr id="fila-vacia">
                                <td colspan="5" class="text-center py-8 text-slate-400 text-xs font-medium">
                                    <i data-lucide="palette" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                    No hay convenciones registradas. Haz clic en "Nueva Convención" para agregar una.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="button" id="btn-agregar-convencion" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-2xl transition-all shadow-xs cursor-pointer">
                    <i data-lucide="plus" class="w-4 h-4"></i> Nueva Convención
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    lucide.createIcons();

    let contadorConvenciones = <?= isset($convenciones) ? count($convenciones) : 0 ?>;

    document.getElementById('btn-agregar-convencion').addEventListener('click', function () {
        const filaVacia = document.getElementById('fila-vacia');
        if (filaVacia) filaVacia.remove();

        const tbody = document.getElementById('tabla-convenciones-body');
        const tr    = document.createElement('tr');
        tr.className = 'convencion-row group hover:bg-slate-50/60 transition-colors animate-fade-in';
        tr.innerHTML = `
        <input type="hidden" name="convenciones[${contadorConvenciones}][id]" value="">

        <td class="py-3 px-3">
            <input type="text" name="convenciones[${contadorConvenciones}][nombre]" required placeholder="Ej. Caries"
            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
        </td>

        <td class="py-3 px-3 w-32">
            <input type="text" name="convenciones[${contadorConvenciones}][codigo]" required placeholder="Ej. CAR"
            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 font-mono uppercase">
        </td>

        <td class="py-3 px-3 w-36">
            <div class="flex items-center gap-2 bg-slate-50/50 border border-slate-200 rounded-xl px-2 py-1.5">
                <input type="color" name="convenciones[${contadorConvenciones}][color]" value="#3b82f6"
                class="w-7 h-7 rounded-lg border-0 cursor-pointer bg-transparent p-0">
                <input type="text" name="convenciones[${contadorConvenciones}][color_text]" value="#3b82f6" placeholder="#3B82F6"
                class="w-full bg-transparent text-xs text-slate-800 focus:outline-none font-mono uppercase">
            </div>
        </td>

        <td class="py-3 px-3">
            <input type="text" name="convenciones[${contadorConvenciones}][descripcion]" placeholder="Opcional..."
            class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
        </td>

        <td class="py-3 px-3 text-center w-16">
            <button type="button" class="btn-eliminar p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors cursor-pointer" title="Eliminar">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
        </td>
        `;
        tbody.appendChild(tr);
        contadorConvenciones++;
        lucide.createIcons();
    });

    // Sincronizar selector nativo de color con el campo de texto hexadecimal
    document.addEventListener('input', function(e) {
        if (e.target.type === 'color') {
            const textInput = e.target.closest('.flex').querySelector('input[type="text"]');
            if (textInput) textInput.value = e.target.value.toUpperCase();
        }
    });

    // Permitir guardar presionando ENTER dentro de cualquier input de texto
    document.getElementById('form-configuracion').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.target.tagName === 'INPUT' && e.target.type === 'text') {
            e.preventDefault(); // Evita comportamientos extraños de recarga
            this.submit(); // Envía el formulario automáticamente
        }
    });

    // Eliminar fila de la tabla de forma limpia
    document.addEventListener('click', function (e) {
        const btnEliminar = e.target.closest('.btn-eliminar');
        if (btnEliminar) {
            const row = btnEliminar.closest('.convencion-row');
            if (row) row.remove();
        }
    });
</script>