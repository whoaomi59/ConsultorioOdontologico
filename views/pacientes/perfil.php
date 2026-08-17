<?php
$nacimiento = new DateTime($paciente['fecha_nacimiento']);
$hoy        = new DateTime();
$edad       = $hoy->diff($nacimiento)->y;
$esMayor    = $edad >= 18;
?>

<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs">
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
        <div class="flex gap-2">
            <a href="<?= BASE_URL ?>/paciente/editar/<?= $paciente['id'] ?>" class="inline-flex items-center gap-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 px-3.5 py-2 rounded-xl text-xs font-semibold border border-amber-200 transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Editar
            </a>
            <a href="<?= BASE_URL ?>/paciente/index" class="inline-flex items-center gap-1.5 bg-slate-50 hover:bg-slate-100 text-slate-600 px-3.5 py-2 rounded-xl text-xs font-semibold border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Volver
            </a>
        </div>
    </div>

    <!-- Ficha de detalles -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-xs grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Fecha de Nacimiento</label>
            <p class="text-sm font-semibold text-slate-800"><?= date('d/m/Y', strtotime($paciente['fecha_nacimiento'])) ?></p>
        </div>

        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Condición Legal</label>
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold text-slate-800"><?= $edad ?> años</span>
                <?php if ($esMayor): ?>
                    <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-0.5 rounded-md text-xs font-bold">Mayor de edad</span>
                <?php else: ?>
                    <span class="bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-0.5 rounded-md text-xs font-bold">Menor de edad</span>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Teléfono</label>
            <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($paciente['telefono'] ?: 'No registrado') ?></p>
        </div>

        <div>
            <label class="block text-[11px] font-bold uppercase text-slate-400 mb-1">Correo Electrónico</label>
            <p class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($paciente['email'] ?: 'No registrado') ?></p>
        </div>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>