<?php
$nacimiento = new DateTime($paciente['fecha_nacimiento']);
$hoy        = new DateTime();
$edad       = $hoy->diff($nacimiento)->y;
$esMayor    = $edad >= 18;
?>

<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <!-- Encabezado del Perfil -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs gap-4">
        <div class="flex items-center gap-4">
            <?php if (!empty($paciente['foto'])): ?>
                <img src="<?= BASE_URL ?>/public/uploads/pacientes/<?= htmlspecialchars($paciente['foto']) ?>" class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shadow-xs">
            <?php else: ?>
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xl border border-indigo-100">
                    <?= strtoupper(substr($paciente['nombre'], 0, 1) . substr($paciente['apellido'], 0, 1)) ?>
                </div>
            <?php endif; ?>
            <div>
                <h1 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?></h1>
                <p class="text-xs text-slate-500 font-mono mt-0.5"><?= htmlspecialchars($paciente['tipo_documento'] ?? 'CC') ?>: <?= htmlspecialchars($paciente['documento']) ?></p>
            </div>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <a href="<?= BASE_URL ?>/paciente/editar/<?= $paciente['id'] ?>" class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 px-3.5 py-2 rounded-xl text-xs font-semibold border border-amber-200 transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Editar
            </a>
            <a href="<?= BASE_URL ?>/paciente/index" class="flex-1 sm:flex-none inline-flex justify-center items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver
            </a>
        </div>
    </div>

    <!-- Datos Personales -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Fecha de Nacimiento</label>
            <p class="text-sm font-semibold text-slate-800"><?= date('d/m/Y', strtotime($paciente['fecha_nacimiento'])) ?></p>
        </div>
        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Condición Legal</label>
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-slate-800"><?= $edad ?> años</span>
                <?php if ($esMayor): ?>
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-md text-[10px] font-bold">Mayor</span>
                <?php else: ?>
                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-md text-[10px] font-bold">Menor</span>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Teléfono</label>
            <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($paciente['telefono'] ?: 'No registrado') ?></p>
        </div>
        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Correo Electrónico</label>
            <p class="text-sm font-semibold text-slate-800 truncate"><?= htmlspecialchars($paciente['email'] ?: 'No registrado') ?></p>
        </div>
    </div>

    <!-- SECCIÓN DE HISTORIAS MÉDICAS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- 1. Historia Clínica Base & Odontología -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h2 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-indigo-600"></i> Historia Clínica General
                </h2>
                <a href="<?= BASE_URL ?>/historias/ver/<?= $paciente['id'] ?>" class="text-xs text-indigo-600 hover:underline font-semibold">Gestionar &rarr;</a>
            </div>

            <?php if (!empty($historiaBase)): ?>
                <div class="space-y-3 text-xs">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <span class="font-bold text-slate-700 block mb-1">Alerta Médica / Antecedentes relevantes:</span>
                        <p class="text-slate-600"><?= !empty($historiaBase['alerta_medica']) ? htmlspecialchars($historiaBase['alerta_medica']) : 'Ninguna registrada.' ?></p>
                    </div>
                    <?php if(!empty($historiaBase['acudiente_nombre'])): ?>
                        <div>
                            <span class="text-slate-400 uppercase font-bold text-[10px]">Acudiente:</span>
                            <p class="font-medium text-slate-700"><?= htmlspecialchars($historiaBase['acudiente_nombre']) ?> (<?= htmlspecialchars($historiaBase['acudiente_parentesco']) ?>)</p>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-xs text-slate-400 italic py-4 text-center">No se ha registrado la historia clínica base aún.</p>
            <?php endif; ?>

            <!-- Consultas recientes -->
            <div class="pt-2 border-t border-slate-100">
                <span class="text-xs font-bold text-slate-700 block mb-2">Evoluciones Odontológicas (<?= count($consultasOdontologia) ?>)</span>
                <?php if (!empty($consultasOdontologia)): ?>
                    <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                        <?php foreach($consultasOdontologia as $c): ?>
                            <div class="p-2.5 rounded-xl bg-indigo-50/40 border border-indigo-100/60 text-xs">
                                <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                                    <span><?= date('d/m/Y H:i', strtotime($c['fecha_consulta'])) ?></span>
                                    <span class="font-medium text-indigo-600"><?= htmlspecialchars($c['doctor_nombre'] ?? 'Dr.') ?></span>
                                </div>
                                <p class="font-semibold text-slate-800 truncate">Motivo: <?= htmlspecialchars($c['motivo_consulta']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-xs text-slate-400 italic">Sin consultas registradas.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- 2. Historia de Ortodoncia -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <h2 class="font-bold text-slate-800 flex items-center gap-2">
                    <i data-lucide="smile" class="w-4 h-4 text-emerald-600"></i> Historia de Ortodoncia
                </h2>
                <a href="<?= BASE_URL ?>/ortodoncia/ver/<?= $paciente['id'] ?>" class="text-xs text-emerald-600 hover:underline font-semibold">Gestionar &rarr;</a>
            </div>

            <?php if (!empty($historiaOrtodoncia)): ?>
                <div class="space-y-3 text-xs">
                    <div class="bg-emerald-50/40 p-3 rounded-xl border border-emerald-100/60">
                        <span class="font-bold text-emerald-800 block mb-1">Diagnóstico Ortodóncico Registrado</span>
                        <p class="text-slate-600">Tratamiento previo: <strong><?= !empty($historiaOrtodoncia['tratamiento_previo_ortodoncia']) ? 'Sí' : 'No' ?></strong>
                        </p>
                        <p class="text-slate-600 truncate">Observaciones iniciales activas.</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-slate-700 block mb-2">Evoluciones de Ortodoncia (<?= count($evolucionesOrtodoncia) ?>)</span>
                        <?php if (!empty($evolucionesOrtodoncia)): ?>
                            <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                                <?php foreach($evolucionesOrtodoncia as $eo): ?>
                                    <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                        <div class="flex justify-between text-slate-400 text-[10px] mb-1">
                                            <span><?= date('d/m/Y', strtotime($eo['fecha_consulta'])) ?></span>
                                            <span class="font-medium text-emerald-600">$<?= number_format($eo['valor_evolucion'], 2) ?></span>
                                        </div>
                                        <p class="text-slate-700 truncate"><?= htmlspecialchars($eo['descripcion_evolucion']) ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-xs text-slate-400 italic">No hay controles de ortodoncia registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="py-8 text-center space-y-2">
                    <p class="text-xs text-slate-400 italic">Este paciente no cuenta con una historia de ortodoncia abierta.</p>
                    <a href="<?= BASE_URL ?>/ortodoncia/ver/<?= $paciente['id'] ?>" class="inline-block bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-700 transition">Crear Diagnóstico</a>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>