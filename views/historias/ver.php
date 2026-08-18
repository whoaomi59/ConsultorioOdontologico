<?php
// Cálculo de edad para validación
$nacimiento  = new DateTime($paciente['fecha_nacimiento']);
$hoy         = new DateTime();
$edad        = $hoy->diff($nacimiento)->y;
$esMenorEdad = $edad < 18;

// La firma del doctor ahora se recibe desde el controlador ($firmaPreviaDoctor)
$firmaPreviaDoctor = $firmaPreviaDoctor ?? '';
?>

<div class="space-y-6">

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
        <div class="text-right text-xs bg-slate-50 p-3 rounded-xl border border-slate-200">
            <span class="block text-slate-400 font-semibold uppercase text-[10px]">Atendido por</span>
            <span class="font-bold text-slate-700 flex items-center gap-1">
                <i data-lucide="user-check" class="w-4 h-4 text-indigo-600"></i>
                <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Doctor General') ?>
            </span>
        </div>
    </div>

    <form action="<?= BASE_URL ?>/historias/guardar/<?= $paciente['id'] ?>" method="POST" id="form-historia" class="space-y-6">

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

            <?php require_once ROOT_PATH . '/views/historias/odontograma.php'; ?>

            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-6">
                <div class="border-b border-slate-200 pb-3 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="file-signature" class="w-5 h-5 text-indigo-600"></i>
                        Firmas y Consentimiento de Conformidad
                    </h3>
                </div>

                <?php if ($esMenorEdad): ?>
                    <div class="bg-amber-50/70 border border-amber-200 p-4 rounded-xl space-y-3">
                        <div class="flex items-center gap-2 text-amber-800 font-bold text-xs">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>El paciente es menor de edad (<?= $edad ?> años). Se requieren los datos del acudiente:</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nombre Completo del Acudiente <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="acudiente_nombre" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Documento del Acudiente <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="acudiente_documento" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs font-mono focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Parentesco <span class="text-rose-500">*</span>
                                </label>
                                <select name="acudiente_parentesco" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs focus:outline-none focus:border-indigo-500">
                                    <option value="" disabled selected>Seleccione...</option>
                                    <option value="Padre">Padre</option>
                                    <option value="Madre">Madre</option>
                                    <option value="Hermano / Hermana">Hermano / Hermana</option>
                                    <option value="Tio / Tia">Tio / Tia</option>
                                    <option value="Abuelo / Abuela">Abuelo / Abuela</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-700">
                            Firma <?= $esMenorEdad ? 'del Acudiente' : 'del Paciente' ?> <span class = "text-rose-500">*</span>
                        </label>
                        <div class="relative bg-white border-2 border-dashed border-slate-300 rounded-2xl overflow-hidden shadow-2xs">
                            <canvas id="signature-pad-paciente" class="w-full h-36 touch-none cursor-crosshair"></canvas>
                            <button type="button" id="clear-signature-paciente" class="absolute top-2 right-2 inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-600 px-2 py-1 rounded-lg text-[10px] font-semibold transition">
                                <i data-lucide="eraser" class="w-3 h-3"></i> Limpiar
                            </button>
                        </div>
                        <input type="hidden" name="firma_base64" id="firma_base64">
                    </div>



                </div>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-3 rounded-xl transition text-sm shadow-sm">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Guardar Consulta y Estado del Odontograma</span>
                </button>
            </div>
        </div>
    </form>

    <div class="space-y-4 pt-4">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-indigo-600"></i>
            Historial de Consultas Registradas
        </h2>

        <?php if (!empty($historias)): ?>
            <?php foreach ($historias as $h): ?>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-100 pb-3 gap-2">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-indigo-600 flex items-center gap-1.5 bg-indigo-50 px-3 py-1 rounded-lg">
                                <i data-lucide="calendar" class="w-4 h-4"></i>
                                <?= date('d/m/Y H:i', strtotime($h['fecha_consulta'])) ?>
                            </span>
                            <span class="text-xs text-slate-600 font-semibold flex items-center gap-1">
                                <i data-lucide="user-check" class="w-3.5 h-3.5 text-slate-400"></i>
                                Atendido por: <strong class="text-slate-800"><?= htmlspecialchars($h['doctor_nombre'] ?? 'Doctor No Especificado') ?></strong>
                            </span>
                        </div>

                        <button type="button"
                        onclick='cargarConsultaCompleta(<?= json_encode($h) ?>);'
                        class="inline-flex items-center space-x-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        <span>Ver Odontograma</span>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-xl border border-slate-100 text-xs">
                        <?php if (!empty($h['firma_base64'])): ?>
                            <div class="border bg-white rounded-lg p-1 shrink-0">
                                <img src="<?= $h['firma_base64'] ?>" class="h-10 object-contain" alt="Firma Paciente">
                            </div>
                        <?php endif; ?>
                        <div>
                            <p class="font-bold text-slate-700">Firma del Paciente/Acudiente</p>
                            <p class="text-[10px] text-slate-500">
                                <?= !empty($h['acudiente_nombre']) ? 'Acudiente: ' . htmlspecialchars($h['acudiente_nombre']) : 'Firmado por el paciente' ?>
                            </p>
                        </div>
                    </div>
                </div>

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
    let padPaciente, padDoctor;
    const firmaGuardadaDoctor = "<?= $firmaPreviaDoctor ?>";

    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        // 1. Inicializar Firma Paciente
        const canvasPac = document.getElementById('signature-pad-paciente');
        if (canvasPac) {
            canvasPac.width = canvasPac.parentElement.clientWidth;
            canvasPac.height = 140;
            padPaciente = new SignaturePad(canvasPac, { backgroundColor: 'rgb(255, 255, 255)' });

            document.getElementById('clear-signature-paciente').addEventListener('click', () => {
                padPaciente.clear();
                document.getElementById('firma_base64').value = '';
            });
        }


        // Validaciones al Enviar Formulario
        const formHistoria = document.getElementById('form-historia');
        formHistoria.addEventListener('submit', (e) => {
            if (padPaciente.isEmpty()) {
                e.preventDefault();
                alert('La firma del Paciente o Acudiente es obligatoria.');
                return false;
            }

            document.getElementById('firma_base64').value = padPaciente.toDataURL('image/png');
        });
    });

    function cargarConsultaCompleta(historia) {
        if (historia.odontograma) {
            loadOdontogramaState(historia.odontograma);
        }
        window.scrollTo({ top: 0, behavior: "smooth" });
    }
</script>