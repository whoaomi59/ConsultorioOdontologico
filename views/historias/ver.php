<?php
// Cálculo de edad para validación
$nacimiento  = new DateTime($paciente['fecha_nacimiento']);
$hoy         = new DateTime();
$edad        = $hoy->diff($nacimiento)->y;
$esMenorEdad = $edad < 18;
?>

<div class="space-y-6">

    <!-- Header Paciente -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="<?= BASE_URL ?>/historias/odontologia" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 mb-2 gap-1 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>Volver a la búsqueda
            </a>
            <h1 class="text-2xl font-bold text-slate-800">
                Historia Clínica y Odontograma
            </h1>
            <p class="text-sm font-medium text-slate-600 mt-0.5">
                Paciente: <span class="text-indigo-600 font-semibold"><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></span>
                <span class="text-slate-400 mx-1">|</span> Doc: <?= htmlspecialchars($paciente['documento']) ?>
                <span class="text-slate-400 mx-1">|</span> Edad: <?= $edad ?> años
                <?php if ($esMenorEdad): ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200 ml-1">Menor de edad</span>
                <?php else: ?>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 ml-1">Mayor de edad</span>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <!-- Formulario Principal -->
    <form action="<?= BASE_URL ?>/historias/guardar/<?= $paciente['id'] ?>" method="POST" id="form-historia" class="space-y-6">

        <!-- Formulario Campos Clínicos -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">
            <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i data-lucide="clipboard-edit" class="w-5 h-5 text-indigo-600"></i>
                Detalles de la Consulta
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Motivo de Consulta <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="motivo_consulta" required rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Diagnóstico <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="diagnostico" required rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tratamiento <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="tratamiento" required rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Evolución</label>
                    <textarea name="observaciones" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
            </div>

            <!-- Componente Odontograma Incluido -->
            <?php require_once ROOT_PATH . '/views/historias/odontograma.php'; ?>

            <!-- Sección de Firma y Consentimiento Informado -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div class="flex items-center gap-2">
                        <i data-lucide="file-signature" class="w-5 h-5 text-indigo-600"></i>
                        <h3 class="text-sm font-bold text-slate-800">Firma del Consentimiento Informado</h3>
                    </div>
                    <span class="text-xs font-semibold text-slate-500">
                        Firmante: <strong class="text-slate-700"><?= $esMenorEdad ? 'Acudiente / Tutor Legal' : 'Paciente Directo' ?></strong>
                    </span>
                </div>

                <!-- Campos obligatorios para Acudiente únicamente si el Paciente es Menor de Edad -->
                <?php if ($esMenorEdad): ?>
                    <div class="bg-amber-50/70 border border-amber-200 p-4 rounded-xl space-y-3">
                        <div class="flex items-center gap-2 text-amber-800 font-bold text-xs">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>El paciente es menor de edad (<?= $edad ?> años). Se requieren los datos del acudiente o responsable legal:</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nombre Completo del Acudiente <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="acudiente_nombre" id="input_acudiente_nombre" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Documento del Acudiente <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="acudiente_documento" id="input_acudiente_documento" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs font-mono focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">
                                    Parentesco / Relación <span class="text-rose-500">*</span>
                                </label>
                                <select
                                name="acudiente_parentesco"
                                id="input_acudiente_parentesco"
                                required
                                class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs focus:outline-none focus:border-indigo-500 text-slate-700 font-medium"
                                >
                                <option value="" disabled selected>Seleccione el parentesco...</option>
                                <option value="Padre">Padre</option>
                                <option value="Madre">Madre</option>
                                <option value="Hermano / Hermana">Hermano / Hermana</option>
                                <option value="Tio / Tia">Tio   / Tia
                                </option>
                                <option value="Abuelo / Abuela">Abuelo / Abuela</option>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Panel Pad de Firma Digital -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700">Firma Digital <?= $esMenorEdad ? 'del Acudiente' : 'del Paciente' ?> <span class="text-rose-500">*</span>
                </label>
                <div class="relative bg-white border-2 border-dashed border-slate-300 rounded-2xl overflow-hidden shadow-2xs">
                    <canvas id="signature-pad" class="w-full h-40 touch-none cursor-crosshair"></canvas>
                    <button type="button" id="clear-signature" class="absolute top-2 right-2 inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-600 px-2.5 py-1 rounded-lg text-[11px] font-semibold border border-slate-200 transition">
                        <i data-lucide="eraser" class="w-3.5 h-3.5"></i> Limpiar Firma
                    </button>
                </div>
                <input type="hidden" name="firma_base64" id="firma_base64">
            </div>
        </div>

        <!-- Botón Guardar -->
        <div class="pt-2">
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-3 rounded-xl transition text-sm shadow-sm">
                <i data-lucide="save" class="w-4 h-4"></i>
                <span>Guardar Consulta y Estado del Odontograma</span>
            </button>
        </div>
    </div>
</form>

<!-- Visor de Detalles al Dar Clic en una Consulta del Historial -->
<div id="historial-detalle-container" class="hidden bg-indigo-900 text-white p-6 rounded-2xl shadow-lg border border-indigo-700 space-y-4">
    <div class="flex justify-between items-center border-b border-indigo-800 pb-3">
        <h3 class="font-bold text-base flex items-center gap-2">
            <i data-lucide="file-check" class="w-5 h-5 text-indigo-300"></i>
            Consulta Seleccionada del Historial
        </h3>
        <button type="button" onclick="document.getElementById('historial-detalle-container').classList.add('hidden')" class="text-xs bg-indigo-800 hover:bg-indigo-700 px-2.5 py-1 rounded-lg text-indigo-200">Cerrar Visor</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
        <div id="visor-acudiente-box" class="bg-indigo-950/60 p-4 rounded-xl border border-indigo-800/80 space-y-2 hidden">
            <span class="text-indigo-400 font-bold uppercase tracking-wider text-[10px]">Información del Acudiente / Tutor Legal</span>
            <p>
                <strong>Nombre:</strong>
                <span id="v-acudiente-nombre">-</span>
            </p>
            <p>
                <strong>Documento:</strong>
                <span id="v-acudiente-doc">-</span>
            </p>
            <p>
                <strong>Parentesco:</strong>
                <span id="v-acudiente-parentesco">-</span>
            </p>
        </div>

        <div id="visor-firma-box" class="bg-indigo-950/60 p-4 rounded-xl border border-indigo-800/80 space-y-2 hidden">
            <span class="text-indigo-400 font-bold uppercase tracking-wider text-[10px]">Firma de Conformidad</span>
            <div class="bg-white p-2 rounded-lg border border-slate-200 max-w-[250px]">
                <img id="v-firma-img" src="" class="h-16 object-contain mx-auto" alt="Firma registrada">
            </div>
        </div>
    </div>
</div>

<!-- Historial de Consultas Registradas -->
<div class="space-y-4 pt-4">
    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
        <i data-lucide="history" class="w-5 h-5 text-indigo-600"></i>
        Historial de Consultas Registradas
    </h2>

    <?php if (!empty($historias)): ?>
        <?php foreach ($historias as $h): ?>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-3 gap-2">
                    <span class="text-xs font-bold text-indigo-600 flex items-center gap-1.5">
                        <i data-lucide="calendar" class="w-4 h-4"></i>
                        <?= date('d/m/Y H:i', strtotime($h['fecha_consulta'])) ?>
                    </span>

                    <button type="button"
                    onclick='cargarConsultaCompleta(<?= json_encode($h) ?>);'
                    class="inline-flex items-center space-x-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                    <span>Cargar Odontograma y Ver Firma</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                <div>
                    <strong class="text-slate-500 uppercase tracking-wider text-[10px] block mb-1">Motivo</strong>
                    <p class="text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100"><?= nl2br(htmlspecialchars($h['motivo_consulta'])) ?></p>
                </div>
                <div>
                    <strong class="text-slate-500 uppercase tracking-wider text-[10px] block mb-1">Diagnóstico</strong>
                    <p class="text-slate-800 font-medium bg-slate-50 p-3 rounded-xl border border-slate-100"><?= nl2br(htmlspecialchars($h['diagnostico'])) ?></p>
                </div>
                <div>
                    <strong class="text-slate-500 uppercase tracking-wider text-[10px] block mb-1">Tratamiento</strong>
                    <p class="text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100"><?= nl2br(htmlspecialchars($h['tratamiento'])) ?></p>
                </div>
            </div>

            <?php if (!empty($h['observaciones'])): ?>
                <div class="text-xs">
                    <strong class="text-slate-500 uppercase tracking-wider text-[10px] block mb-1">Evolución</strong>
                    <p class="text-slate-600 bg-slate-50 p-3 rounded-xl border border-slate-100"><?= nl2br(htmlspecialchars($h['observaciones'])) ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($h['firma_base64']) || !empty($h['acudiente_nombre'])): ?>
                <div class="flex flex-wrap items-center gap-4 bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs">
                    <?php if (!empty($h['firma_base64'])): ?>
                        <div class="border bg-white rounded-lg p-1 shrink-0">
                            <img src="<?= $h['firma_base64'] ?>" class="h-10 object-contain" alt="Firma Registrada">
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="font-bold text-slate-700">Firma Registrada</p>
                        <p class="text-[11px] text-slate-500">
                            <?= !empty($h['acudiente_nombre']) ? 'Acudiente: ' . htmlspecialchars($h['acudiente_nombre']) . ' (' . htmlspecialchars($h['acudiente_parentesco']) . ' - Doc: ' . htmlspecialchars($h['acudiente_documento']) . ')' : 'Firmado por el Paciente' ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="bg-white p-12 text-center rounded-2xl border border-slate-200/80 text-slate-400">
        <i data-lucide="folder-x" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
        <p class="text-sm font-medium text-slate-600">No hay consultas ni odontogramas guardados para este paciente.</p>
    </div>
<?php endif; ?>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    let signaturePad;

    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        const canvas = document.getElementById('signature-pad');
        if (canvas) {
            canvas.width = canvas.parentElement.clientWidth;
            canvas.height = 160;

            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(15, 23, 42)'
            });

            // Actualizar el campo oculto en cada finalización de trazo
            signaturePad.addEventListener("afterUpdateStroke", () => {
                document.getElementById('firma_base64').value = signaturePad.toDataURL('image/png');
            });

            document.getElementById('clear-signature').addEventListener('click', () => {
                signaturePad.clear();
                document.getElementById('firma_base64').value = '';
            });

            const formHistoria = document.getElementById('form-historia');
            formHistoria.addEventListener('submit', (e) => {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    alert('Atención: La firma digital es obligatoria para guardar la historia clínica.');
                    return false;
                }
                document.getElementById('firma_base64').value = signaturePad.toDataURL('image/png');
            });
        }
    });

    function cargarConsultaCompleta(historia) {
        if (historia.odontograma) {
            loadOdontogramaState(historia.odontograma);
        }

        const visor = document.getElementById('historial-detalle-container');
        visor.classList.remove('hidden');

        const acudienteBox = document.getElementById('visor-acudiente-box');
        if (historia.acudiente_nombre) {
            document.getElementById('v-acudiente-nombre').textContent = historia.acudiente_nombre;
            document.getElementById('v-acudiente-doc').textContent = historia.acudiente_documento || 'N/A';
            document.getElementById('v-acudiente-parentesco').textContent = historia.acudiente_parentesco || 'N/A';
            acudienteBox.classList.remove('hidden');
        } else {
            acudienteBox.classList.add('hidden');
        }

        const firmaBox = document.getElementById('visor-firma-box');
        if (historia.firma_base64) {
            document.getElementById('v-firma-img').src = historia.firma_base64;
            firmaBox.classList.remove('hidden');
        } else {
            firmaBox.classList.add('hidden');
        }

        window.scrollTo({ top: 0, behavior: "smooth" });
    }
</script>