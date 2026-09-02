<?php
// Cálculo de edad para validación
$nacimiento  = new DateTime($paciente['fecha_nacimiento']);
$hoy         = new DateTime();
$edad        = $hoy->diff($nacimiento)->y;
$esMenorEdad = $edad < 18;

// Verificar si ya existe historia base para rellenar los campos y determinar si se oculta
$base      = $historiaBase ?? [];
$estomData = !empty($base['examen_estomatologico']) ? json_decode($base['examen_estomatologico'], true) : [];
$tieneBase = !empty($base); // Bandera para saber si ya fue diligenciada


?>

<div class="space-y-6">

    <!-- CABECERA -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="<?= BASE_URL ?>/historias/odontologia" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 mb-2 gap-1 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>Volver a la búsqueda
            </a>
            <h1 class="text-2xl font-bold text-slate-800">
                Historia Clínica y Controles Odontológicos
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

    <!-- SECCIÓN 1: HISTORIA CLÍNICA BASE (Colapsable / Ocultable si ya está llena) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

        <!-- Barra de estado y botón colapsable -->
        <div class="p-4 bg-slate-50 border-b border-slate-200/80 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i data-lucide="file-text" class="w-5 h-5 text-indigo-600"></i>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">1. Historia Clínica Base (Antecedentes e Higiene Oral)</h2>
                    <p class="text-[11px] text-slate-500">
                        <?php if ($tieneBase): ?>
                            <span class="text-emerald-600 font-semibold">● Ya diligenciada.</span> Oculta por defecto para agilizar la consulta.
                        <?php else: ?>
                            <span class="text-amber-600 font-semibold">● Pendiente de llenado.</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
            <button type="button" id="btn-toggle-base" class="inline-flex items-center gap-1.5 bg-white hover:bg-slate-100 text-slate-700 border border-slate-200 px-3 py-1.5 rounded-xl text-xs font-semibold transition shadow-2xs">
                <i data-lucide="<?= $tieneBase ? 'eye' : 'eye-off' ?>" id="icon-toggle-base" class="w-4 h-4 text-indigo-600"></i>
                <span id="text-toggle-base"><?= $tieneBase ? 'Ver Historia Base' : 'Ocultar Historia Base' ?></span>
            </button>
        </div>

        <!-- Contenedor del Formulario Base -->
        <div id="contenedor-historia-base" class="p-6 space-y-6 <?= $tieneBase ? 'hidden' : '' ?>">
            <form action="<?= BASE_URL ?>/historias/guardarBase/<?= $paciente['id'] ?>" method="POST" class="space-y-6">

                <!-- Alerta Médica -->
                <div>
                    <label class="block text-xs font-semibold text-rose-600 mb-1">
                        <i data-lucide="alert-triangle" class="w-3 h-3 inline"></i> Alerta Médica General
                    </label>
                    <input type="text" name="alerta_medica" value="<?= htmlspecialchars($base['alerta_medica'] ?? '') ?>" placeholder="Especifique si existe alguna alerta médica importante..." class="w-full bg-rose-50/50 border border-rose-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-rose-500 transition">
                </div>

                <!-- Antecedentes Médicos -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-indigo-600"></i>
                        Datos básicos de antecedentes médicos
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-slate-700 border border-slate-200 rounded-xl bg-white">
                            <thead class="bg-slate-100 text-slate-700 uppercase text-[10px]">
                                <tr>
                                    <th class="p-2 border-b">Refiere</th>
                                    <th class="p-2 border-b text-center">Sí / No</th>
                                    <th class="p-2 border-b">Refiere</th>
                                    <th class="p-2 border-b text-center">Sí / No</th>
                                    <th class="p-2 border-b">Refiere</th>
                                    <th class="p-2 border-b text-center">Sí / No</th>
                                    <th class="p-2 border-b">Cual / Observación</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $camposAnt = [
    ['ant_hipertension', 'Hipertensión', 'ant_traumas', 'Traumas', 'ant_cirugias', 'Cirugías'],
    ['ant_hepatitis', 'Hepatitis', 'ant_convulsiones', 'Convulsiones', 'ant_alergias', 'Alergias'],
    ['ant_hipoglicemia_diabetes', 'Hipoglicemia / Diabetes', 'ant_gastritis_resp', 'Gastritis / Resp.', 'ant_t_mentales', 'T. Mentales'],
    ['ant_enf_cardiovascular', 'Enfermedad Cardiovasc.', 'ant_cancer', 'Cáncer', 'ant_embarazo', 'Embarazo'],
    ['ant_fiebre_reumatica', 'Fiebre reumática', 'ant_sida', 'Sida / VIH', '', '']
];
                                foreach($camposAnt as $row):
                                    ?>
                                    <tr>
                                        <td class="p-2 font-medium"><?= $row[1] ?></td>
                                        <td class="p-2 text-center">
                                            <?php if($row[0]): ?>
                                                <select name="<?= $row[0] ?>" class="border rounded p-1">
                                                    <option value="">-</option>
                                                    <option value="Si" <?= ($base[$row[0]] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                                    <option value="No" <?= ($base[$row[0]] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-2 font-medium"><?= $row[3] ?></td>
                                        <td class="p-2 text-center">
                                            <?php if($row[2]): ?>
                                                <select name="<?= $row[2] ?>" class="border rounded p-1">
                                                    <option value="">-</option>
                                                    <option value="Si" <?= ($base[$row[2]] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                                    <option value="No" <?= ($base[$row[2]] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-2 font-medium"><?= $row[5] ?></td>
                                        <td class="p-2 text-center">
                                            <?php if($row[4]): ?>
                                                <select name="<?= $row[4] ?>" class="border rounded p-1">
                                                    <option value="">-</option>
                                                    <option value="Si" <?= ($base[$row[4]] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                                    <option value="No" <?= ($base[$row[4]] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                                </select>
                                            <?php endif; ?>
                                        </td>
                                        <?php if($row[1] === 'Hipertensión'): ?>
                                            <td class="p-2" rowspan="5">
                                                <textarea name="ant_otras" placeholder="Especifique alergias u otras..." rows="8" class="w-full border rounded p-2 text-[11px]"><?= htmlspecialchars($base['ant_otras'] ?? '') ?></textarea>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Antecedentes de Higiene -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-indigo-600"></i>
                        Antecedentes de Higiene Oral
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                        <div class="bg-white p-3 rounded-xl border border-slate-200">
                            <span class="font-bold block mb-1">Cepillado dental</span>
                            <div class="flex gap-2">
                                <select name="higiene_cepillado" class="w-1/2 border rounded p-1">
                                    <option value="">Sí/No</option>
                                    <option value="Si" <?= ($base['higiene_cepillado'] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                    <option value="No" <?= ($base['higiene_cepillado'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                                <input type="text" name="higiene_cepillado_cant" value="<?= htmlspecialchars($base['higiene_cepillado_cant'] ?? '') ?>" placeholder="Cantidad" class="w-1/2 border rounded p-1">
                            </div>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-200">
                            <span class="font-bold block mb-1">Seda dental</span>
                            <div class="flex gap-2">
                                <select name="higiene_seda" class="w-1/2 border rounded p-1">
                                    <option value="">Sí/No</option>
                                    <option value="Si" <?= ($base['higiene_seda'] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                    <option value="No" <?= ($base['higiene_seda'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                                <input type="text" name="higiene_seda_cant" value="<?= htmlspecialchars($base['higiene_seda_cant'] ?? '') ?>" placeholder="Cantidad" class="w-1/2 border rounded p-1">
                            </div>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-200">
                            <span class="font-bold block mb-1">Enjuague</span>
                            <div class="flex gap-2">
                                <select name="higiene_enjuague" class="w-1/2 border rounded p-1">
                                    <option value="">Sí/No</option>
                                    <option value="Si" <?= ($base['higiene_enjuague'] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                    <option value="No" <?= ($base['higiene_enjuague'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                                <input type="text" name="higiene_enjuague_cant" value="<?= htmlspecialchars($base['higiene_enjuague_cant'] ?? '') ?>" placeholder="Cantidad" class="w-1/2 border rounded p-1">
                            </div>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-slate-200">
                            <span class="font-bold block mb-1">Otro / Cual</span>
                            <div class="flex gap-2">
                                <select name="higiene_otro" class="w-1/3 border rounded p-1">
                                    <option value="">Sí/No</option>
                                    <option value="Si" <?= ($base['higiene_otro'] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                    <option value="No" <?= ($base['higiene_otro'] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                                <input type="text" name="higiene_otro_cual" value="<?= htmlspecialchars($base['higiene_otro_cual'] ?? '') ?>" placeholder="¿Cuál?" class="w-2/3 border rounded p-1">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Examen Estomatológico -->
                <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <i data-lucide="scan-face" class="w-4 h-4 text-indigo-600"></i>
                        Examen Estomatológico
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 overflow-hidden border border-slate-200 rounded-xl bg-white text-xs">
                        <?php
                        $examenes = [
    ['Labios', 'Maxilares', 'Carrillos', 'Glándulas salivales', 'Frenillos', 'Gingival', 'Trauma', 'Patología pulpar'],
    ['Músculos', 'Orofaringe', 'Piso de boca', 'Mucosa oral', 'ATM', 'Ganglios', 'Hábitos', 'Otros'],
    ['Color dental', 'Esmalte dental', 'Desgaste dental', 'Movilidad', 'Cantidad dientes', 'Oclusión', 'Posición dental']
];
                        foreach($examenes as $columna): ?>
                        <div class="border-r last:border-r-0 border-slate-200 flex flex-col">
                            <?php foreach($columna as $item): $key = strtolower(str_replace(' ', '_', $item)); ?>
                            <div class="flex justify-between items-center p-2 border-b last:border-b-0 border-slate-100 hover:bg-slate-50">
                                <span class="font-medium text-slate-700"><?= $item ?></span>
                                <select name="estomatologico[<?= $key ?>]" class="border border-slate-200 rounded p-1 text-[11px] bg-white">
                                    <option value="">-</option>
                                    <option value="Si" <?= ($estomData[$key] ?? '') === 'Si' ? 'selected' : '' ?>>Sí</option>
                                    <option value="No" <?= ($estomData[$key] ?? '') === 'No' ? 'selected' : '' ?>>No</option>
                                </select>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Datos de Acudiente si es menor -->
                <?php if ($esMenorEdad): ?>
                    <div class="bg-amber-50/70 border border-amber-200 p-4 rounded-xl space-y-3">
                        <div class="flex items-center gap-2 text-amber-800 font-bold text-xs">
                            <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            <span>Datos del acudiente (Menor de edad):</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nombre Completo <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="acudiente_nombre" value="<?= htmlspecialchars($base['acudiente_nombre'] ?? '') ?>" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Documento <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="acudiente_documento" value="<?= htmlspecialchars($base['acudiente_documento'] ?? '') ?>" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs font-mono">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Parentesco <span class="text-rose-500">*</span>
                                </label>
                                <select name="acudiente_parentesco" required class="w-full bg-white border border-slate-200 rounded-lg p-2 text-xs">
                                    <option value="">Seleccione...</option>
                                    <option value="Padre" <?= ($base['acudiente_parentesco'] ?? '') === 'Padre' ? 'selected' : '' ?>>Padre</option>
                                    <option value="Madre" <?= ($base['acudiente_parentesco'] ?? '') === 'Madre' ? 'selected' : '' ?>>Madre</option>
                                    <option value="Tio / Tia" <?= ($base['acudiente_parentesco'] ?? '') === 'Tio / Tia' ? 'selected' : '' ?>>Tio / Tia</option>
                                    <option value="Abuelo / Abuela" <?= ($base['acudiente_parentesco'] ?? '') === 'Abuelo / Abuela' ? 'selected' : '' ?>>Abuelo / Abuela</option>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <button type="submit" class="inline-flex items-center space-x-2 bg-slate-800 hover:bg-slate-900 text-white font-medium px-6 py-2.5 rounded-xl transition text-xs shadow-sm">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Guardar / Actualizar Historia Base</span>
                </button>
            </form>
        </div>
    </div>

    <!-- SECCIÓN 2: NUEVA CONSULTA / EVOLUCIÓN Y ODONTOGRAMA -->
    <form action="<?= BASE_URL ?>/historias/guardar/<?= $paciente['id'] ?>" method="POST" id="form-historia" class="space-y-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-6">

            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                    <i data-lucide="clipboard-edit" class="w-5 h-5 text-indigo-600"></i>
                    2. Registrar Nueva Consulta / Evolución y Odontograma Actual
                </h2>
                <span class="text-[11px] bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-lg font-bold">Nuevo Control</span>
            </div>

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
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Evolución / Observaciones</label>
                    <textarea name="observaciones" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"></textarea>
                </div>
            </div>

            <!-- ODONTOGRAMA DE LA CONSULTA -->
            <?php require_once ROOT_PATH . '/views/historias/odontograma.php'; ?>

            <!-- FIRMA DE CONFORMIDAD -->
            <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200/80 space-y-4">
                <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="file-signature" class="w-4 h-4 text-indigo-600"></i>
                    Firma de Conformidad de esta Consulta
                </h3>
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

            <!-- BOTÓN GUARDAR CONSULTA -->
            <div class="pt-2">
                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-8 py-3 rounded-xl transition text-sm shadow-sm">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    <span>Guardar Nueva Evolución y Odontograma</span>
                </button>
            </div>
        </div>
    </form>

    <!-- SECCIÓN 3: HISTORIAL DE CONSULTAS ANTERIORES -->
    <div class="space-y-4 pt-4">
        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="history" class="w-5 h-5 text-indigo-600"></i>
            Historial de Consultas y Evoluciones Previas
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
                        <button type="button" onclick='cargarConsultaCompleta(<?= json_encode($h) ?>);' class="inline-flex items-center space-x-1.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 text-slate-700 px-3 py-1.5 rounded-lg text-xs font-medium transition">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            <span>Ver Odontograma de esta Fecha</span>
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
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-white p-12 text-center rounded-2xl border border-slate-200/80 text-slate-400">
                <i data-lucide="folder-x" class="w-10 h-10 mx-auto mb-2 text-slate-300"></i>
                <p class="text-sm font-medium text-slate-600">No hay controles ni evoluciones registradas para este paciente.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    let padPaciente;

    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        // Control para mostrar/ocultar la Historia Base
        const btnToggleBase  = document.getElementById('btn-toggle-base');
        const contenedorBase = document.getElementById('contenedor-historia-base');
        const iconToggleBase = document.getElementById('icon-toggle-base');
        const textToggleBase = document.getElementById('text-toggle-base');

        if (btnToggleBase) {
            btnToggleBase.addEventListener('click', () => {
                contenedorBase.classList.toggle('hidden');
                const estaOculto = contenedorBase.classList.contains('hidden');

                if (estaOculto) {
                    textToggleBase.textContent = 'Ver Historia Base';
                    iconToggleBase.setAttribute('data-lucide', 'eye');
                } else {
                    textToggleBase.textContent = 'Ocultar Historia Base';
                    iconToggleBase.setAttribute('data-lucide', 'eye-off');
                }
                lucide.createIcons();
            });
        }

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

        const formHistoria = document.getElementById('form-historia');
        formHistoria.addEventListener('submit', (e) => {
            if (padPaciente.isEmpty()) {
                e.preventDefault();
                alert('La firma de conformidad es obligatoria para registrar la consulta.');
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