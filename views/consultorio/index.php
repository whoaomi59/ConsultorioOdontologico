<style>
    /* Identidad premium del consultorio: azul profundo, índigo y turquesa */
    .consultorio-config-premium {
        --cc-ink: #17243b;
        --cc-muted: #718096;
        --cc-line: #e4ebf4;
        --cc-blue: #315ee8;
        --cc-teal: #0e9488;
        color: var(--cc-ink);
        isolation: isolate;
    }
    .consultorio-config-premium .config-hero {
        background: linear-gradient(118deg, #111d38 0%, #2549a5 55%, #087f86 100%);
        border: 1px solid rgba(255, 255, 255, 0.14);
        box-shadow: 0 24px 55px rgba(23, 36, 59, 0.2);
    }
    .consultorio-config-premium .config-hero:after {
        content: '';
        position: absolute;
        width: 270px;
        height: 270px;
        right: -78px;
        top: -115px;
        border: 1px solid rgba(255, 255, 255, 0.16);
        border-radius: 50%;
        box-shadow:
            0 0 0 28px rgba(255, 255, 255, 0.035),
            0 0 0 58px rgba(255, 255, 255, 0.025);
        pointer-events: none;
    }
    .consultorio-config-premium .config-hero-icon {
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.06));
        border: 1px solid rgba(255, 255, 255, 0.23);
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.16);
    }
    .consultorio-config-premium .config-section {
        border: 1px solid var(--cc-line);
        border-radius: 24px;
        background: linear-gradient(145deg, #fff 0%, #fff 68%, #f8fbff 100%);
        box-shadow: 0 10px 28px rgba(23, 36, 59, 0.055);
        transition:
            box-shadow 0.25s ease,
            border-color 0.25s ease;
    }
    .consultorio-config-premium .config-section:hover {
        box-shadow: 0 16px 38px rgba(23, 36, 59, 0.085);
        border-color: #d5e1f0;
    }
    .consultorio-config-premium .config-section-head {
        border-bottom: 1px solid #eaf0f7;
        padding-bottom: 18px;
    }
    .consultorio-config-premium .config-section-icon {
        background: linear-gradient(145deg, #eaf0ff, #e5fbf8);
        color: #315ee8;
        box-shadow: inset 0 0 0 1px rgba(49, 94, 232, 0.07);
    }
    .consultorio-config-premium label {
        letter-spacing: 0.055em;
    }
    .consultorio-config-premium input:not([type='color']):not([type='file']) {
        min-height: 42px;
        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }
    .consultorio-config-premium input:not([type='color']):not([type='file']):focus {
        border-color: #6b8af0 !important;
        box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.11);
        background: #fff;
    }
    .consultorio-config-premium .logo-dropzone {
        background: linear-gradient(120deg, #f7f9ff, #f0fbfa);
        border: 1px dashed #bdcce0;
        transition:
            border-color 0.2s ease,
            background 0.2s ease;
    }
    .consultorio-config-premium .logo-dropzone:hover {
        border-color: #0e9488;
        background: linear-gradient(120deg, #f3f6ff, #eafbf8);
    }
    .consultorio-config-premium .logo-preview {
        box-shadow: 0 8px 22px rgba(23, 36, 59, 0.08);
        border: 1px solid #e4ebf4;
    }
    .consultorio-config-premium .config-primary-btn {
        background: linear-gradient(110deg, #315ee8, #2549a5 58%, #0e9488);
        box-shadow: 0 9px 20px rgba(49, 94, 232, 0.22);
        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease;
    }
    .consultorio-config-premium .config-primary-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 13px 25px rgba(49, 94, 232, 0.3);
    }
    .consultorio-config-premium .config-add-btn {
        background: linear-gradient(110deg, #17243b, #2549a5);
        box-shadow: 0 7px 16px rgba(23, 36, 59, 0.16);
    }
    .consultorio-config-premium .config-table-wrap {
        border: 1px solid #e6edf6;
        border-radius: 18px;
        overflow-x: auto;
        background: #fff;
    }
    .consultorio-config-premium .config-table {
        min-width: 780px;
    }
    .consultorio-config-premium .config-table thead {
        background: linear-gradient(90deg, #f4f7ff, #effaf9);
    }
    .consultorio-config-premium .config-table thead th {
        color: #53647d;
        font-size: 10px;
        letter-spacing: 0.11em;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .consultorio-config-premium .config-table tbody tr:nth-child(even) {
        background: #fbfcff;
    }
    .consultorio-config-premium .config-table tbody tr:hover {
        background: #f1f7ff;
    }
    .consultorio-config-premium .config-table td {
        padding-top: 11px;
        padding-bottom: 11px;
    }
    .consultorio-config-premium .config-table input:not([type='color']) {
        background: #f8faff;
        border-color: #e1e8f2;
        border-radius: 11px;
    }
    .consultorio-config-premium .config-table input:not([type='color']):focus {
        background: #fff;
    }
    .consultorio-config-premium .config-color-control {
        border-color: #e1e8f2;
        background: #f8faff;
    }
    .consultorio-config-premium .config-color-control input[type='color'] {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .consultorio-config-premium .btn-eliminar {
        border: 1px solid transparent;
    }
    .consultorio-config-premium .btn-eliminar:hover {
        border-color: #fecdd3;
    }
    .consultorio-config-premium .config-alert {
        box-shadow: 0 8px 24px rgba(23, 36, 59, 0.06);
    }
    @media (max-width: 640px) {
        .consultorio-config-premium .config-section {
            padding: 20px !important;
            border-radius: 20px;
        }
        .consultorio-config-premium .config-hero {
            padding: 23px !important;
            border-radius: 22px;
        }
        .consultorio-config-premium .config-hero h1 {
            font-size: 22px;
            line-height: 1.2;
        }
        .consultorio-config-premium .config-primary-btn {
            width: 100%;
            justify-content: center;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .consultorio-config-premium * {
            transition: none !important;
            animation: none !important;
        }
    }
</style>
<div class="consultorio-config-premium max-w-5xl mx-auto space-y-6 pb-12 font-sans">
    <!-- Header y Acción Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 config-hero bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-7 rounded-3xl shadow-xl border border-slate-800 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="config-hero-icon p-3.5 bg-indigo-500/20 text-indigo-300 rounded-2xl border border-indigo-500/30 backdrop-blur-md shadow-inner">
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
        <div class="config-alert bg-emerald-50 border border-emerald-200/80 text-emerald-800 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3 shadow-xs">
            <div class="bg-emerald-500 text-white p-1.5 rounded-full flex items-center justify-center">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <span>¡Configuración y convenciones actualizadas correctamente!</span>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="config-alert bg-rose-50 border border-rose-200/80 text-rose-800 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3 shadow-xs">
            <div class="bg-rose-500 text-white p-1.5 rounded-full flex items-center justify-center">
                <i data-lucide="x" class="w-4 h-4"></i>
            </div>
            <span>Ocurrió un error al guardar los cambios. Inténtalo de nuevo.</span>
        </div>
    <?php endif; ?>
    <!-- Formulario Unificado -->
    <form id="form-configuracion" action="<?= BASE_URL ?>/consultorio/guardar" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php
        $logoActual = $consultorio['Logo'] ?? ($consultorio['logo'] ?? '');
        $nombreConsultorio = $consultorio['Nombre'] ?? ($consultorio['nombre'] ?? '');
        $direccionConsultorio = $consultorio['direccion'] ?? ($consultorio['Direccion'] ?? '');
        ?>
        <input type="hidden" name="logo_actual" value="<?= htmlspecialchars($logoActual) ?>">
        <!-- SECCIÓN 1: DATOS GENERALES -->
        <div class="config-section bg-white p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="config-section-head flex items-center gap-3 border-b border-slate-100 pb-4">
                <div class="config-section-icon p-2.5 bg-indigo-50 text-indigo-600 rounded-2xl">
                    <i data-lucide="stethoscope" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 uppercase tracking-wide">Información Institucional</h2>
                    <p class="text-[11px] text-slate-400">Datos principales que aparecerán en los reportes y recetas.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">
                        Nombre del Consultorio / Doctor
                        <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nombre" value="<?= htmlspecialchars($nombreConsultorio) ?>" required maxlength="60" placeholder="Ej. Clínica Odontológica Sonrisas" class="w-full bg-slate-50/60 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">
                        Dirección Física
                        <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="direccion" value="<?= htmlspecialchars($direccionConsultorio) ?>" required maxlength="60" placeholder="Ej. Calle Principal # 45 - 12" class="w-full bg-slate-50/60 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs text-slate-800 font-medium focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition-all">
                </div>
            </div>
            <div class="space-y-2 pt-3 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Logotipo Institucional</label>
                <div class="logo-dropzone flex flex-col sm:flex-row items-start sm:items-center gap-5 mt-2 bg-slate-50/60 p-5 rounded-2xl border border-dashed border-slate-300">
                    <?php if (!empty($logoActual)): ?>
                        <div class="logo-preview w-24 h-24 bg-white border border-slate-200 rounded-2xl flex items-center justify-center p-2.5 shadow-xs shrink-0">
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
                        <p class="text-[11px] text-slate-400">
                            Formatos recomendados:
                            <strong>PNG, JPG o WEBP</strong>
                            .
                        </p>
                    </div>
                </div>
            </div>
            <div class="relative z-10">
                <button type="submit" form="form-configuracion" class="config-primary-btn inline-flex items-center gap-2 text-white font-bold px-6 py-3 rounded-2xl text-xs transition-all duration-300 cursor-pointer">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Guardar Cambios</span>
                </button>
            </div>
        </div>
        <!-- SECCIÓN 2: GESTIÓN DE CONVENCIONES -->
        <div class="config-section bg-white p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6">
            <div class="config-section-head flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                <div class="flex items-center gap-3">
                    <div class="config-section-icon p-2.5 bg-blue-50 text-blue-600 rounded-2xl">
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
                                        <input type="text" name="convenciones[<?= $index ?>][nombre]" value="<?= htmlspecialchars($conv['nombre']) ?>" required placeholder="Ej. Caries" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                                    </td>
                                    <td class="py-3 px-3 w-32">
                                        <input type="text" name="convenciones[<?= $index ?>][codigo]" value="<?= htmlspecialchars($conv['codigo']) ?>" required placeholder="Ej. CAR" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 font-mono uppercase">
                                    </td>
                                    <td class="py-3 px-3 w-36">
                                        <div class="config-color-control flex items-center gap-2 bg-slate-50/50 border border-slate-200 rounded-xl px-2 py-1.5">
                                            <input type="color" name="convenciones[<?= $index ?>][color]" value="<?= htmlspecialchars($conv['color'] ?: '#3b82f6') ?>" class="w-7 h-7 rounded-lg border-0 cursor-pointer bg-transparent p-0">
                                            <input type="text" name="convenciones[<?= $index ?>][color_text]" value="<?= htmlspecialchars($conv['color']) ?>" placeholder="#3B82F6" class="w-full bg-transparent text-xs text-slate-800 focus:outline-none font-mono uppercase">
                                        </div>
                                    </td>
                                    <td class="py-3 px-3">
                                        <input type="text" name="convenciones[<?= $index ?>][descripcion]" value="<?= htmlspecialchars($conv['descripcion']) ?>" placeholder="Opcional..." class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
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
                <button type="button" id="btn-agregar-convencion" class="config-add-btn inline-flex items-center gap-2 text-white text-xs font-bold px-4 py-2.5 rounded-2xl transition-all shadow-xs cursor-pointer mt-4 hover:-translate-y-0.5">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nueva Convención
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
        const tr = document.createElement('tr');
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
                <div class="config-color-control flex items-center gap-2 bg-slate-50/50 border border-slate-200 rounded-xl px-2 py-1.5">
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
    document.addEventListener('input', function (e) {
        if (e.target.type === 'color') {
            const textInput = e.target.closest('.flex').querySelector('input[type="text"]');
            if (textInput) textInput.value = e.target.value.toUpperCase();
        }
    });
    
    // Permitir guardar presionando ENTER dentro de cualquier input de texto
    document.getElementById('form-configuracion').addEventListener('keydown', function (e) {
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