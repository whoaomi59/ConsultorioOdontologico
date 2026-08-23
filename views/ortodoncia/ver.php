<?php
$nacimiento = new DateTime($paciente['fecha_nacimiento']);
$hoy        = new DateTime();
$edad       = $hoy->diff($nacimiento)->y;

// Identificación para la Hoja N° (Número de documento del paciente)
$documentoPaciente = $paciente['documento'] ?? $paciente['numero_documento'] ?? $paciente['identificacion'] ?? 'Sin Documento';

// Dientes ordenados por cuadrantes (18 a 48)
$dientes = [
    '18','17','16','15','14','13','12','11', '21','22','23','24','25','26','27','28',
    '48','47','46','45','44','43','42','41', '31','32','33','34','35','36','37','38'
];

// Comprobar si se solicita modo edición
$esEdicion = isset($_GET['modo']) && $_GET['modo'] === 'editar' && !empty($historia);
?>

<div class="space-y-6 bg-slate-50/50 p-2 md:p-4 rounded-2xl">

    <!-- Encabezado Institucional -->
    <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
        <div>
            <a href="<?= BASE_URL ?>/paciente/index" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 mb-2 gap-1 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>Volver al Directorio
            </a>
            <h1 class="text-2xl font-black text-slate-800 uppercase tracking-tight">Historia de Ortodoncia Correctiva</h1>
            <p class="text-xs text-slate-500 mt-1 font-medium flex items-center gap-2">
                <i data-lucide="building-2" class="w-3.5 h-3.5"></i> Fady J. Guatibonza Jaimes — Reg. 30391241 — UNICOC
            </p>
        </div>
        <div class="text-right">
            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Hoja Clínica N°</span>
            <span class="block text-xl font-bold text-indigo-700"><?= htmlspecialchars($documentoPaciente) ?></span>
        </div>
    </div>

    <?php if (!$historia || $esEdicion): ?>
        <!-- FORMULARIO DE HISTORIA BASE (CREACIÓN / EDICIÓN) -->
        <form action="<?= BASE_URL ?>/ortodoncia/<?= $esEdicion ? 'editarDiagnostico/' . $paciente['id'] : 'guardarDiagnostico/' . $paciente['id'] ?>" method="POST" id="form-diagnostico" class="space-y-6">

            <?php if ($esEdicion): ?>
                <input type="hidden" name="historia_id" value="<?= htmlspecialchars($historia['id']) ?>">
            <?php endif; ?>

            <input type="hidden" name="hoja_numero" value="<?= htmlspecialchars($documentoPaciente) ?>">

            <?php if ($esEdicion): ?>
                <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-xs font-medium flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                        Editando el diagnóstico principal del paciente.
                    </span>
                    <a href="?" class="text-amber-900 underline font-bold">Cancelar Edición</a>
                </div>
            <?php endif; ?>

            <!-- 1. DATOS PERSONALES DEL PACIENTE -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
                <h3 class="text-sm font-bold text-indigo-700 uppercase flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <i data-lucide="user" class="w-4 h-4"></i> 1. Información General
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-5 text-sm">
                    <div class="md:col-span-2">
                        <label class="font-semibold block text-slate-600 text-xs uppercase tracking-wide mb-1">Paciente</label>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl font-bold text-slate-800">
                            <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?>
                        </div>
                    </div>
                    <div>
                        <label class="font-semibold block text-slate-600 text-xs uppercase tracking-wide mb-1">Edad</label>
                        <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-800"><?= $edad ?> años</div>
                    </div>
                    <div>
                        <label class="font-semibold block text-slate-600 text-xs uppercase tracking-wide mb-1">Fecha Apertura</label>
                        <input type="date" name="fecha_apertura" value="<?= htmlspecialchars($historia['fecha_apertura'] ?? date('Y-m-d')) ?>" class="w-full border-slate-200 rounded-xl p-2.5 text-slate-800 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold block text-slate-600 text-xs uppercase tracking-wide mb-1">Remitido Por</label>
                        <input type="text" name="remitido_por" value="<?= htmlspecialchars($historia['remitido_por'] ?? '') ?>" placeholder="Nombre del profesional..." class="w-full border-slate-200 rounded-xl p-2.5 text-slate-800 focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-semibold block text-slate-600 text-xs uppercase tracking-wide mb-1">Motivo de Consulta</label>
                        <input type="text" name="motivo_consulta" value="<?= htmlspecialchars($historia['motivo_consulta'] ?? '') ?>" required placeholder="Describe el motivo principal..." class="w-full border-slate-200 rounded-xl p-2.5 text-slate-800 focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-6 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100/50">
                    <div>
                        <label class="font-bold text-slate-800 block text-xs uppercase mb-2">Tratamiento de ortodoncia previo</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tratamiento_previo_ortodoncia" value="1" <?= ($historia['tratamiento_previo_ortodoncia'] ?? '') == '1' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm font-medium">SÍ</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tratamiento_previo_ortodoncia" value="0" <?= ($historia['tratamiento_previo_ortodoncia'] ?? '0') == '0' ? 'checked' : '' ?> class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm font-medium">NO</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="font-bold text-slate-800 block text-xs uppercase mb-2">Tipo de Tratamiento</label>
                        <div class="flex flex-wrap gap-4">
                            <?php $tt = $historia['tipo_tratamiento'] ?? 'CORRECTIVO'; ?>
                            <label class="flex items-center gap-1.5 cursor-pointer text-sm">
                                <input type="radio" name="tipo_tratamiento" value="PREVENTIVO" <?= $tt === 'PREVENTIVO' ? 'checked' : '' ?> class="text-indigo-600"> Preventivo
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-sm">
                                <input type="radio" name="tipo_tratamiento" value="CORRECTIVO" <?= $tt === 'CORRECTIVO' ? 'checked' : '' ?> class="text-indigo-600"> Correctivo
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-sm">
                                <input type="radio" name="tipo_tratamiento" value="INTERCEPTIVO" <?= $tt === 'INTERCEPTIVO' ? 'checked' : '' ?> class="text-indigo-600"> Interceptivo
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-sm">
                                <input type="radio" name="tipo_tratamiento" value="ORTOPEDICOS" <?= $tt === 'ORTOPEDICOS' ? 'checked' : '' ?> class="text-indigo-600"> Ortopédicos
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-sm">
                                <input type="radio" name="tipo_tratamiento" value="REMOVIBLE" <?= $tt === 'REMOVIBLE' ? 'checked' : '' ?> class="text-indigo-600"> Removible
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1.1 ANÁLISIS FACIAL -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
                <h3 class="text-sm font-bold text-indigo-700 uppercase flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <i data-lucide="scan-face" class="w-4 h-4"></i> 1.1 Análisis Facial
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div class="space-y-4">
                        <h4 class="font-bold text-slate-800 text-xs bg-slate-100 py-1.5 px-3 rounded uppercase">Examen de Frente</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <span class="block text-xs font-semibold text-slate-500 uppercase">Tipo de Cara</span>
                                <?php $tc = $historia['tipo_cara'] ?? ''; ?>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_cara" value="MESOPROSOPO" <?= $tc === 'MESOPROSOPO' ? 'checked' : '' ?>> Mesoprosopo
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_cara" value="EURIPROSOPO" <?= $tc === 'EURIPROSOPO' ? 'checked' : '' ?>> Euriprosopo
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_cara" value="LEPTOPROSOPO" <?= $tc === 'LEPTOPROSOPO' ? 'checked' : '' ?>> Leptoprosopo
                                </label>
                            </div>
                            <div class="space-y-2">
                                <span class="block text-xs font-semibold text-slate-500 uppercase">Tipo de Sonrisa</span>
                                <?php $ts = $historia['tipo_sonrisa'] ?? ''; ?>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_sonrisa" value="PAPILAR" <?= $ts === 'PAPILAR' ? 'checked' : '' ?>> Papilar
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_sonrisa" value="GINGIVAL" <?= $ts === 'GINGIVAL' ? 'checked' : '' ?>> Gingival
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tipo_sonrisa" value="CORONAL" <?= $ts === 'CORONAL' ? 'checked' : '' ?>> Coronal
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h4 class="font-bold text-slate-800 text-xs bg-slate-100 py-1.5 px-3 rounded uppercase">Examen de Perfil</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <span class="block text-xs font-semibold text-slate-500 uppercase">Perfil</span>
                                <?php $pf = $historia['perfil_facial'] ?? ''; ?>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="perfil_facial" value="RECTO" <?= $pf === 'RECTO' ? 'checked' : '' ?>> Recto
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="perfil_facial" value="CONCAVO" <?= $pf === 'CONCAVO' ? 'checked' : '' ?>> Cóncavo
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="perfil_facial" value="CONVEXO" <?= $pf === 'CONVEXO' ? 'checked' : '' ?>> Convexo
                                </label>
                            </div>
                            <div class="space-y-2">
                                <span class="block text-xs font-semibold text-slate-500 uppercase">Hipertonía Labial</span>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tonicidad_labial_sup" value="HIPERTONIA_SUP" <?= !empty($historia['tonicidad_labial_sup']) ? 'checked' : '' ?>> Superior
                                </label>
                                <label class="flex items-center gap-2 text-sm">
                                    <input type="radio" name="tonicidad_labial_inf" value="HIPERTONIA_INF" <?= !empty($historia['tonicidad_labial_inf']) ? 'checked' : '' ?>> Inferior
                                </label>
                            </div>
                        </div>

                        <div class="pt-2">
                            <span class="block text-xs font-semibold text-slate-500 uppercase mb-2">Posición Labial</span>
                            <div class="grid grid-cols-3 gap-2 text-xs font-medium text-center bg-slate-50 p-2 rounded-xl border border-slate-200">
                                <div class="text-slate-400">Posición</div>
                                <div>Sup</div>
                                <div>Inf</div>
                                <?php
                                $pls = $historia['posicion_labial_sup'] ?? '';
                                $pli = $historia['posicion_labial_inf'] ?? '';
                                ?>
                                <div class="text-left pl-2">Normal</div>
                                <div>
                                    <input type="radio" name="posicion_labial_sup" value="NORMAL" <?= $pls === 'NORMAL' ? 'checked' : '' ?>>
                                </div>
                                <div>
                                    <input type="radio" name="posicion_labial_inf" value="NORMAL" <?= $pli === 'NORMAL' ? 'checked' : '' ?>>
                                </div>

                                <div class="text-left pl-2">Protrusión</div>
                                <div>
                                    <input type="radio" name="posicion_labial_sup" value="PROTRUSION" <?= $pls === 'PROTRUSION' ? 'checked' : '' ?>>
                                </div>
                                <div>
                                    <input type="radio" name="posicion_labial_inf" value="PROTRUSION" <?= $pli === 'PROTRUSION' ? 'checked' : '' ?>>
                                </div>

                                <div class="text-left pl-2">Retrusión</div>
                                <div>
                                    <input type="radio" name="posicion_labial_sup" value="RETRUSION" <?= $pls === 'RETRUSION' ? 'checked' : '' ?>>
                                </div>
                                <div>
                                    <input type="radio" name="posicion_labial_inf" value="RETRUSION" <?= $pli === 'RETRUSION' ? 'checked' : '' ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2 pt-2 border-t border-slate-100">
                        <span class="block text-xs font-bold text-slate-800 uppercase mb-2">Frenillo Sobreinsertado</span>
                        <div class="flex flex-wrap gap-6 text-sm">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="frenillo_sobreinsertado_sup" value="1" <?= !empty($historia['frenillo_sobreinsertado_sup']) ? 'checked' : '' ?> class="rounded text-indigo-600"> Superior
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="frenillo_sobreinsertado_inf" value="1" <?= !empty($historia['frenillo_sobreinsertado_inf']) ? 'checked' : '' ?> class="rounded text-indigo-600"> Inferior
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="frenillo_sobreinsertado_lat" value="1" <?= !empty($historia['frenillo_sobreinsertado_lat']) ? 'checked' : '' ?> class="rounded text-indigo-600"> Lateral
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="frenillo_sobreinsertado_lin" value="1" <?= !empty($historia['frenillo_sobreinsertado_lin']) ? 'checked' : '' ?> class="rounded text-indigo-600"> Lingual
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. ANÁLISIS FUNCIONAL -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
                <h3 class="text-sm font-bold text-indigo-700 uppercase flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <i data-lucide="activity" class="w-4 h-4"></i> 2. Análisis Funcional
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-slate-800 text-xs uppercase mb-3 text-center border-b pb-2">2.1 Hábitos</h4>
                        <div class="space-y-2 text-sm">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_onicofagia" value="1" <?= !empty($historia['habito_onicofagia']) ? 'checked' : '' ?> class="rounded"> Onicofagia
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_respiracion_oral" value="1" <?= !empty($historia['habito_respiracion_oral']) ? 'checked' : '' ?> class="rounded"> Respiración Oral
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_succion_digital" value="1" <?= !empty($historia['habito_succion_digital']) ? 'checked' : '' ?> class="rounded"> Succión Digital
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_succion_labial" value="1" <?= !empty($historia['habito_succion_labial']) ? 'checked' : '' ?> class="rounded"> Succión Labial
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_presion" value="1" <?= !empty($historia['habito_presion']) ? 'checked' : '' ?> class="rounded"> Presión
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="habito_alternacion_foniatricas" value="1" <?= !empty($historia['habito_alternacion_foniatricas']) ? 'checked' : '' ?> class="rounded"> Foniátricas
                            </label>

                            <div class="pt-2 mt-2 border-t border-slate-200">
                                <span class="block font-semibold text-xs text-slate-500 uppercase mb-1">Deglución Atípica</span>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="deglucion_empuje_lingual_simple" value="1" <?= !empty($historia['deglucion_empuje_lingual_simple']) ? 'checked' : '' ?> class="rounded"> Empuje Simple
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="deglucion_empuje_lingual_complejo" value="1" <?= !empty($historia['deglucion_empuje_lingual_complejo']) ? 'checked' : '' ?> class="rounded"> Empuje Complejo
                                </label>
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="deglucion_infantil" value="1" <?= !empty($historia['deglucion_infantil']) ? 'checked' : '' ?> class="rounded"> Infantil
                                </label>
                            </div>
                            <div class="pt-2 mt-2 border-t border-slate-200">
                                <span class="block font-semibold text-xs text-slate-500 uppercase mb-1">Bruxismo</span>
                                <div class="flex gap-4">
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" name="bruxismo_diurno" value="1" <?= !empty($historia['bruxismo_diurno']) ? 'checked' : '' ?> class="rounded"> Diurno
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" name="bruxismo_nocturno" value="1" <?= !empty($historia['bruxismo_nocturno']) ? 'checked' : '' ?> class="rounded"> Nocturno
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-slate-800 text-xs uppercase mb-3 text-center border-b pb-2">2.2 Examen de ATM</h4>
                        <div class="flex gap-4 mb-3">
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="ruido_cliking" value="1" <?= !empty($historia['ruido_cliking']) ? 'checked' : '' ?> class="rounded"> Cliking
                            </label>
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="ruido_crepitacion" value="1" <?= !empty($historia['ruido_crepitacion']) ? 'checked' : '' ?> class="rounded"> Crepitación
                            </label>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <span class="block font-semibold text-[11px] text-slate-500 uppercase">Ruidos Articulares</span>
                                <?php $ral = $historia['ruidos_articulares_lado'] ?? ''; ?>
                                <div class="flex gap-3 text-sm mt-1">
                                    <label>
                                        <input type="radio" name="ruidos_articulares_lado" value="DERECHO" <?= $ral === 'DERECHO' ? 'checked' : '' ?>> Der
                                    </label>
                                    <label>
                                        <input type="radio" name="ruidos_articulares_lado" value="IZQUIERDO" <?= $ral === 'IZQUIERDO' ? 'checked' : '' ?>> Izq
                                    </label>
                                    <label>
                                        <input type="radio" name="ruidos_articulares_lado" value="BILATERAL" <?= $ral === 'BILATERAL' ? 'checked' : '' ?>> Bilat
                                    </label>
                                </div>
                            </div>
                            <div>
                                <span class="block font-semibold text-[11px] text-slate-500 uppercase">Localización</span>
                                <?php $rl = $historia['ruidos_localizacion'] ?? ''; ?>
                                <div class="flex gap-3 text-sm mt-1">
                                    <label>
                                        <input type="radio" name="ruidos_localizacion" value="INICIAL" <?= $rl === 'INICIAL' ? 'checked' : '' ?>> Inicial
                                    </label>
                                    <label>
                                        <input type="radio" name="ruidos_localizacion" value="INTERMEDIO" <?= $rl === 'INTERMEDIO' ? 'checked' : '' ?>> Medio
                                    </label>
                                    <label>
                                        <input type="radio" name="ruidos_localizacion" value="FINAL" <?= $rl === 'FINAL' ? 'checked' : '' ?>> Final
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-2 pt-2 border-t border-slate-200">
                                <input type="number" step="0.1" name="medida_apertura_maxima_mm" value="<?= htmlspecialchars($historia['medida_apertura_maxima_mm'] ?? '') ?>" placeholder="Apertura Máx (mm)" class="w-full border-slate-200 rounded text-sm p-1.5 focus:ring-1">
                                <input type="number" step="0.1" name="medida_lateralidad_derecha_mm" value="<?= htmlspecialchars($historia['medida_lateralidad_derecha_mm'] ?? '') ?>" placeholder="Lat. Derecha (mm)" class="w-full border-slate-200 rounded text-sm p-1.5 focus:ring-1">
                                <input type="number" step="0.1" name="medida_lateralidad_izquierda_mm" value="<?= htmlspecialchars($historia['medida_lateralidad_izquierda_mm'] ?? '') ?>" placeholder="Lat. Izquierda (mm)" class="w-full border-slate-200 rounded text-sm p-1.5 focus:ring-1">
                                <input type="number" step="0.1" name="desviacion_mandibular_mm" value="<?= htmlspecialchars($historia['desviacion_mandibular_mm'] ?? '') ?>" placeholder="Desviación Mand (mm)" class="w-full border-slate-200 rounded text-sm p-1.5 focus:ring-1">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <h4 class="font-bold text-slate-800 text-xs uppercase mb-3 text-center border-b pb-2">2.3 Palpación Articular</h4>
                        <div class="space-y-4">
                            <div>
                                <span class="block font-semibold text-[11px] text-slate-500 uppercase">Dolor Articular Lado</span>
                                <?php $dal = $historia['dolor_articular_lado'] ?? ''; ?>
                                <div class="flex gap-3 text-sm mt-1">
                                    <label>
                                        <input type="radio" name="dolor_articular_lado" value="DERECHO" <?= $dal === 'DERECHO' ? 'checked' : '' ?>> Der
                                    </label>
                                    <label>
                                        <input type="radio" name="dolor_articular_lado" value="IZQUIERDO" <?= $dal === 'IZQUIERDO' ? 'checked' : '' ?>> Izq
                                    </label>
                                    <label>
                                        <input type="radio" name="dolor_articular_lado" value="BILATERAL" <?= $dal === 'BILATERAL' ? 'checked' : '' ?>> Bilat
                                    </label>
                                </div>
                            </div>
                            <div>
                                <span class="block font-semibold text-[11px] text-slate-500 uppercase">Fase del Dolor</span>
                                <?php $daf = $historia['dolor_articular_fase'] ?? ''; ?>
                                <div class="space-y-1 text-sm mt-1">
                                    <label class="block">
                                        <input type="radio" name="dolor_articular_fase" value="EN REPOSO" <?= $daf === 'EN REPOSO' ? 'checked' : '' ?>> En Reposo
                                    </label>
                                    <label class="block">
                                        <input type="radio" name="dolor_articular_fase" value="EN APERTURA" <?= $daf === 'EN APERTURA' ? 'checked' : '' ?>> En Apertura
                                    </label>
                                    <label class="block">
                                        <input type="radio" name="dolor_articular_fase" value="EN MOVIMIENTO DE LATERALIDAD" <?= $daf === 'EN MOVIMIENTO DE LATERALIDAD' ? 'checked' : '' ?>> Mov. Lateralidad
                                    </label>
                                </div>
                            </div>
                            <div class="pt-3 border-t border-slate-200">
                                <label class="flex items-center gap-2 font-bold text-slate-800 text-sm mb-2">
                                    <input type="checkbox" name="dolor_muscular_presente" value="1" <?= !empty($historia['dolor_muscular_presente']) ? 'checked' : '' ?> class="rounded text-rose-500"> Dolor Muscular Presente
                                </label>
                                <input type="text" name="dolor_muscular_detalle" value="<?= htmlspecialchars($historia['dolor_muscular_detalle'] ?? '') ?>" placeholder="Especifique el músculo..." class="w-full border-slate-200 rounded text-sm p-2 focus:ring-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. ANÁLISIS RADIOGRÁFICO -->
            <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
                <h3 class="text-sm font-bold text-indigo-700 uppercase flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                    <i data-lucide="bone" class="w-4 h-4"></i> 3. Análisis Radiográfico (Localizaciones)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php
                    function renderDentograma($nameTitle, $inputPrefix, $dientesArr, $valoresGuardados = []) {
                        if (is_string($valoresGuardados)) {
                            $valoresGuardados = array_filter(explode(',', $valoresGuardados));
                        } elseif (!is_array($valoresGuardados)) {
                            $valoresGuardados = [];
                        }
                        echo "<div class='bg-slate-50 p-3 rounded-xl border border-slate-200'>";
                            echo "<span class='font-bold text-slate-800 text-xs uppercase block mb-2'>{$nameTitle}</span>";
                            echo "<div class='flex flex-wrap gap-1.5'>";
                                foreach($dientesArr as $d) {
                                    $checked = in_array($d, $valoresGuardados) ? 'checked' : '';
                                    echo "<label class='cursor-pointer text-center relative'>";
                                        echo "<input type='checkbox' name='{$inputPrefix}[]' value='{$d}' {$checked} class='peer sr-only'>";
                                        echo "<div class='w-7 h-7 flex items-center justify-center rounded-lg border border-slate-300 bg-white text-[11px] font-semibold text-slate-600 peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-all shadow-xs'>{$d}</div>";
                                        echo "
                                            </label>";
                                    }
                                    echo "
                                        </div>";
                                    echo "
                                        </div>";
                                }
                                ?>

                                <?= renderDentograma("Periodonto Disminuido", "periodonto_dientes", $dientes, $historia['periodonto_disminuido_dientes'] ?? []) ?>
                                <?= renderDentograma("Dientes Retenidos/Impactados", "retenidos_dientes", $dientes, $historia['dientes_retenidos_dientes'] ?? []) ?>
                                <?= renderDentograma("Dientes Supernumerarios", "supernumerarios_dientes", $dientes, $historia['dientes_supernumerarios_dientes'] ?? []) ?>
                                <?= renderDentograma("Longitud Radicular Disminuida", "longitud_dientes", $dientes, $historia['longitud_radicular_disminuida_dientes'] ?? []) ?>
                            </div>
                        </div>

                        <!-- 4. ANÁLISIS CEFALOMÉTRICO -->
                        <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200">
                            <h3 class="text-sm font-bold text-indigo-700 uppercase flex items-center gap-2 mb-4 border-b border-slate-100 pb-2">
                                <i data-lucide="ruler" class="w-4 h-4"></i> 4. Análisis Cefalométrico
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <p class="font-bold text-slate-800 text-xs uppercase mb-3 border-b pb-1 text-center">Esquelético</p>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Perfil Esquelético</span>
                                            <?php $pe = $historia['perfil_esqueletico'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="perfil_esqueletico" value="CLI" <?= $pe === 'CLI' ? 'checked' : '' ?>> CLI
                                                </label>
                                                <label>
                                                    <input type="radio" name="perfil_esqueletico" value="CLII" <?= $pe === 'CLII' ? 'checked' : '' ?>> CLII
                                                </label>
                                                <label>
                                                    <input type="radio" name="perfil_esqueletico" value="CLIII" <?= $pe === 'CLIII' ? 'checked' : '' ?>> CLIII
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Prognatismo Total</span>
                                            <?php $pt = $historia['prognatismo_total'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="prognatismo_total" value="MAXILAR" <?= $pt === 'MAXILAR' ? 'checked' : '' ?>> Max
                                                </label>
                                                <label>
                                                    <input type="radio" name="prognatismo_total" value="MANDIBULAR" <?= $pt === 'MANDIBULAR' ? 'checked' : '' ?>> Mand
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Retrognatismo Total</span>
                                            <?php $rt = $historia['retrognatismo_total'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="retrognatismo_total" value="MAXILAR" <?= $rt === 'MAXILAR' ? 'checked' : '' ?>> Max
                                                </label>
                                                <label>
                                                    <input type="radio" name="retrognatismo_total" value="MANDIBULAR" <?= $rt === 'MANDIBULAR' ? 'checked' : '' ?>> Mand
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Crecimiento</span>
                                            <?php $tc = $historia['tipo_crecimiento'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="tipo_crecimiento" value="VERTICAL" <?= $tc === 'VERTICAL' ? 'checked' : '' ?>> Vert
                                                </label>
                                                <label>
                                                    <input type="radio" name="tipo_crecimiento" value="HORIZONTAL" <?= $tc === 'HORIZONTAL' ? 'checked' : '' ?>> Horiz
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <p class="font-bold text-slate-800 text-xs uppercase mb-3 border-b pb-1 text-center">Radiográfico Dentario</p>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Protrusión Alveolar</span>
                                            <?php $pa = $historia['protrusion_alveolar'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="protrusion_alveolar" value="SUPERIOR" <?= $pa === 'SUPERIOR' ? 'checked' : '' ?>> Sup
                                                </label>
                                                <label>
                                                    <input type="radio" name="protrusion_alveolar" value="INFERIOR" <?= $pa === 'INFERIOR' ? 'checked' : '' ?>> Inf
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Retrusión Alveolar</span>
                                            <?php $ra = $historia['retrusion_alveolar'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="retrusion_alveolar" value="SUPERIOR" <?= $ra === 'SUPERIOR' ? 'checked' : '' ?>> Sup
                                                </label>
                                                <label>
                                                    <input type="radio" name="retrusion_alveolar" value="INFERIOR" <?= $ra === 'INFERIOR' ? 'checked' : '' ?>> Inf
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Macrognatismo</span>
                                            <?php $mac = $historia['macrognatismo'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="macrognatismo" value="MAXILAR" <?= $mac === 'MAXILAR' ? 'checked' : '' ?>> Max
                                                </label>
                                                <label>
                                                    <input type="radio" name="macrognatismo" value="MANDIBULAR" <?= $mac === 'MANDIBULAR' ? 'checked' : '' ?>> Mand
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Micrognatismo</span>
                                            <?php $mic = $historia['micrognatismo'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="micrognatismo" value="MAXILAR" <?= $mic === 'MAXILAR' ? 'checked' : '' ?>> Max
                                                </label>
                                                <label>
                                                    <input type="radio" name="micrognatismo" value="MANDIBULAR" <?= $mic === 'MANDIBULAR' ? 'checked' : '' ?>> Mand
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <p class="font-bold text-slate-800 text-xs uppercase mb-3 border-b pb-1 text-center">Tejidos Blandos</p>
                                    <div class="space-y-3">
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Perfil Facial</span>
                                            <?php $cpf = $historia['cefalometrico_perfil_facial'] ?? ''; ?>
                                            <div class="flex flex-col gap-1">
                                                <label>
                                                    <input type="radio" name="cefalometrico_perfil_facial" value="RECTO" <?= $cpf === 'RECTO' ? 'checked' : '' ?>> Recto
                                                </label>
                                                <label>
                                                    <input type="radio" name="cefalometrico_perfil_facial" value="CONCAVO" <?= $cpf === 'CONCAVO' ? 'checked' : '' ?>> Cóncavo
                                                </label>
                                                <label>
                                                    <input type="radio" name="cefalometrico_perfil_facial" value="CONVEXO" <?= $cpf === 'CONVEXO' ? 'checked' : '' ?>> Convexo
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Proquelia</span>
                                            <?php $pr = $historia['proquelia'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="proquelia" value="SUPERIOR" <?= $pr === 'SUPERIOR' ? 'checked' : '' ?>> Superior
                                                </label>
                                                <label>
                                                    <input type="radio" name="proquelia" value="INFERIOR" <?= $pr === 'INFERIOR' ? 'checked' : '' ?>> Inferior
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="block text-[11px] text-slate-500 font-bold uppercase mb-1">Retroquelia</span>
                                            <?php $rq = $historia['retroquelia'] ?? ''; ?>
                                            <div class="flex gap-3">
                                                <label>
                                                    <input type="radio" name="retroquelia" value="SUPERIOR" <?= $rq === 'SUPERIOR' ? 'checked' : '' ?>> Superior
                                                </label>
                                                <label>
                                                    <input type="radio" name="retroquelia" value="INFERIOR" <?= $rq === 'INFERIOR' ? 'checked' : '' ?>> Inferior
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- SECCIÓN DE FIRMAS DEL DOCTOR Y PACIENTE EN LA HISTORIA GUARDADA -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div class="text-center border-t border-slate-200 pt-4">
                                <?php if (!empty($historia['doctor_firma_base64'])): ?>
                                    <img src="<?= $historia['doctor_firma_base64'] ?>" class="h-16 mx-auto mb-2 object-contain">
                                <?php else: ?>
                                    <p class="text-xs text-slate-400 italic h-16 flex items-center justify-center">Sin firma registrada en el usuario del doctor</p>
                                <?php endif; ?>
                                <p class="text-xs font-bold text-slate-800 uppercase"><?= htmlspecialchars($historia['doctor_nombre'] ?? 'Doctor Asignado') ?></p>
                                <span class="text-[10px] text-slate-500 uppercase font-semibold">Firma del Profesional</span>
                            </div>
                            <!-- FIRMA DEL PACIENTE (REQUERIDA AL GUARDAR/EDITAR) -->

                            <div class="text-center border-t border-slate-200 pt-4">
                                <?php if (!empty($historia['firma_paciente_base64'])): ?>
                                    <img src="<?= $historia['firma_paciente_base64'] ?>" class="h-16 mx-auto mb-2 object-contain">
                                <?php else: ?>
                                    <div class="bg-white p-6 rounded-2xl shadow-xs border border-slate-200 space-y-3">
                                        <label class="block text-xs font-bold text-slate-700 uppercase">
                                            Firma del Paciente <span class="text-rose-500">* (Requerida)</span>
                                        </label>
                                        <div class="relative bg-slate-50 border border-slate-300 rounded-xl overflow-hidden max-w-md w-full">
                                            <canvas id="canvas-firma-paciente" class="w-full h-32 block touch-none cursor-crosshair"></canvas>
                                            <button type="button" id="clear-firma-paciente" class="absolute top-2 right-2 bg-slate-200 hover:bg-slate-300 text-slate-700 px-2 py-1 rounded text-[10px] font-bold uppercase">
                                                Limpiar
                                            </button>
                                        </div>
                                        <input type="hidden" name="firma_paciente_base64" id="firma_paciente_base64">
                                    </div>
                                <?php endif; ?>
                                <p class="text-xs font-bold text-slate-800 uppercase"><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></p>
                                <span class="text-[10px] text-slate-500 uppercase font-semibold">Firma del Paciente / Acudiente</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 text-white font-black text-sm uppercase tracking-widest py-4 rounded-2xl hover:bg-indigo-700 shadow-md hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-2">
                            <i data-lucide="save" class="w-5 h-5"></i>
                            <?= $esEdicion ? 'Actualizar Diagnóstico Base' : 'Guardar Diagnóstico Base Definitivo' ?>
                        </button>
                    </form>

                <?php else: ?>

                    <!-- VISTA RESUMEN Y EVOLUCIONES CONTINUAS -->
                    <div class="bg-white p-5 rounded-2xl shadow-xs border border-emerald-100 flex items-center justify-between flex-wrap gap-4">
                        <div class="flex items-center gap-3">
                            <div class="bg-emerald-100 p-2 rounded-full text-emerald-600">
                                <i data-lucide="check-circle" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 class="text-sm font-bold text-slate-800 uppercase">Diagnóstico Ortodóntico Registrado</h2>
                                <p class="text-xs text-slate-500">Fecha de Apertura: <span class="font-semibold text-slate-700"><?= date('d/m/Y', strtotime($historia['fecha_registro'] ?? $historia['fecha_apertura'])) ?></span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="?modo=editar" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-4 py-2 rounded-xl transition-all shadow-xs flex items-center gap-1.5">
                                <i data-lucide="edit-3" class="w-4 h-4"></i> Editar Diagnóstico
                            </a>
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-2 rounded-xl border border-indigo-200">Hoja N° <?= htmlspecialchars($historia['hoja_numero']) ?></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        <div class="lg:col-span-1 bg-white p-5 rounded-2xl shadow-xs border border-slate-200 h-fit sticky top-6">
                            <h3 class="text-sm font-bold text-slate-800 uppercase flex items-center gap-2 border-b border-slate-100 pb-3 mb-4">
                                <i data-lucide="activity" class="w-4 h-4 text-indigo-600"></i> Registrar Control
                            </h3>
                            <form action="<?= BASE_URL ?>/ortodoncia/guardarEvolucion/<?= $paciente['id'] ?>" method="POST" id="form-evolucion" class="space-y-4">
                                <input type="hidden" name="historia_id" value="<?= $historia['id'] ?>">

                                <div>
                                    <label class="block text-xs font-bold text-slate-600 uppercase mb-2">Procedimiento Realizado <span class="text-rose-500">*</span>
                                    </label>
                                    <textarea name="descripcion_evolucion" required rows="5" placeholder="Describa el progreso, cambios de arco, elásticos..." class="w-full border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-indigo-500 bg-slate-50"></textarea>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-slate-600 uppercase">Firma del Paciente</label>
                                    <div class="relative bg-white border border-slate-200 rounded-xl overflow-hidden shadow-inner">
                                        <canvas id="canvas-evo" class="w-full h-28 touch-none cursor-crosshair"></canvas>
                                        <button type="button" id="clear-evo" class="absolute top-2 right-2 bg-slate-100 hover:bg-slate-200 text-slate-600 px-2 py-1 rounded text-[10px] font-bold uppercase transition">Limpiar</button>
                                    </div>
                                    <input type="hidden" name="firma_paciente_base64" id="firma_evo_base64">
                                </div>

                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl text-sm transition flex justify-center items-center gap-2">
                                    <i data-lucide="plus" class="w-4 h-4"></i> Guardar Control
                                </button>
                            </form>
                        </div>

                        <div class="lg:col-span-2 bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
                            <h3 class="text-sm font-bold text-slate-800 uppercase flex items-center gap-2 border-b border-slate-100 pb-3 mb-4">
                                <i data-lucide="history" class="w-4 h-4 text-indigo-600"></i> Historial Clínico de Controles
                            </h3>

                            <?php if (!empty($evoluciones)): ?>
                                <div class="space-y-3">
                                    <?php foreach ($evoluciones as $evo): ?>
                                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-2">
                                            <div class="flex justify-between items-center text-xs border-b border-slate-200 pb-1.5">
                                                <span class="font-bold text-indigo-600 flex items-center gap-1">
                                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                                    <?= date('d/m/Y - h:i A', strtotime($evo['fecha_consulta'])) ?>
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-700 whitespace-pre-line"><?= htmlspecialchars($evo['descripcion_evolucion']) ?></p>
                                            <?php if (!empty($evo['firma_paciente_base64'])): ?>
                                                <div class="pt-1 flex items-center gap-2">
                                                    <span class="text-[10px] text-slate-400 font-semibold">Firma Paciente:</span>
                                                    <img src="<?= $evo['firma_paciente_base64'] ?>" class="h-7 border bg-white rounded p-0.5">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-center text-slate-400 text-xs py-8">No hay controles o evoluciones registradas aún.</p>
                            <?php endif; ?>
                        </div>

                    </div>



                <?php endif; ?>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
            <script src="https://unpkg.com/lucide@latest"></script>
            <script>
                document.addEventListener("DOMContentLoaded", () => {
                    lucide.createIcons();

                    // Canvas para evoluciones
                    const canvasEvo = document.getElementById('canvas-evo');
                    if (canvasEvo) {
                        canvasEvo.width = canvasEvo.parentElement.clientWidth;
                        canvasEvo.height = 112;
                        const padEvo = new SignaturePad(canvasEvo, { backgroundColor: 'rgb(255, 255, 255)' });
                        document.getElementById('clear-evo').addEventListener('click', () => padEvo.clear());
                        document.getElementById('form-evolucion').addEventListener('submit', (e) => {
                            if (!padEvo.isEmpty()) {
                                document.getElementById('firma_evo_base64').value = padEvo.toDataURL('image/png');
                            }
                        });
                    }
                    // Canvas para diagnóstico base (Creación / Edición)
                    const canvasDiag = document.getElementById('canvas-firma-paciente');
                    if (canvasDiag) {
                        // Asegurar un ancho mínimo si el contenedor está oculto o re dimensionándose
                        canvasDiag.width = canvasDiag.parentElement.clientWidth || 400;
                        canvasDiag.height = 128;

                        const padDiag = new SignaturePad(canvasDiag, { backgroundColor: 'rgb(255, 255, 255)' });

                        document.getElementById('clear-firma-paciente').addEventListener('click', () => {
                            padDiag.clear();
                            document.getElementById('firma_paciente_base64').value = '';
                        });

                        document.getElementById('form-diagnostico').addEventListener('submit', (e) => {
                            if (padDiag.isEmpty()) {
                                e.preventDefault();
                                alert('El paciente debe firmar antes de guardar la historia clínica.');
                                return false;
                            }
                            // Asignar los datos en base64 justo antes de enviar el formulario
                            document.getElementById('firma_paciente_base64').value = padDiag.toDataURL('image/png');
                        });
                    }
                });
            </script>