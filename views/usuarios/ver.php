<div class="max-w-3xl mx-auto space-y-6">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

        <div class="h-28 bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 relative p-6">
            <a href="<?= BASE_URL ?>/usuarios/index" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/20 hover:bg-white/30 backdrop-blur-md text-white rounded-xl text-xs font-semibold transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Volver
            </a>
        </div>

        <div class="px-6 pb-6 relative">

            <div class="flex flex-col sm:flex-row justify-between items-center sm:items-end -mt-14 mb-4 gap-4">
                <div class="relative">
                    <?php if (!empty($usuario['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' . $usuario['foto'])): ?>
                        <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" class="w-28 h-28 rounded-2xl object-cover border-4 border-white shadow-md bg-white">
                    <?php else: ?>
                        <div class="w-28 h-28 rounded-2xl bg-gradient-to-tr from-indigo-500 to-purple-500 text-white font-extrabold flex items-center justify-center text-3xl border-4 border-white shadow-md uppercase">
                            <?= mb_substr($usuario['nombre'], 0, 2) ?>
                        </div>
                    <?php endif; ?>

                    <span class="absolute bottom-1 right-1 w-4 h-4 rounded-full border-2 border-white <?= $usuario['estado'] ? 'bg-emerald-500' : 'bg-rose-500' ?>" title="<?= $usuario['estado'] ? 'Usuario Activo' : 'Usuario Inactivo' ?>"></span>
                </div>

                <div class="flex items-center gap-2">
                    <a href="<?= BASE_URL ?>/usuarios/editar/<?= $usuario['id'] ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition shadow-sm">
                        <i data-lucide="pencil-line" class="w-4 h-4"></i>
                        Editar Perfil
                    </a>
                </div>
            </div>

            <div class="space-y-1 text-center sm:text-left border-b border-slate-100 pb-5">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                    <h1 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($usuario['nombre']) ?></h1>

                    <div class="flex items-center justify-center sm:justify-start gap-2">
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100 flex items-center gap-1">
                            <i data-lucide="shield" class="w-3 h-3 text-indigo-500"></i>
                            <?= htmlspecialchars($usuario['rol']) ?>
                        </span>

                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider <?= $usuario['estado'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' ?>">
                            <?= $usuario['estado'] ? '• Activo' : '• Inactivo' ?>
                        </span>
                    </div>
                </div>

                <p class="text-xs text-slate-500 flex items-center justify-center sm:justify-start gap-1">
                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                    <?= htmlspecialchars($usuario['email']) ?>
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 py-5">

                <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100/80 flex items-center gap-3">
                    <div class="p-2.5 bg-indigo-600 text-white rounded-xl shadow-xs shrink-0">
                        <i data-lucide="log-in" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase text-indigo-400 block tracking-wider">Último Acceso</span>
                        <span class="text-xs font-bold text-indigo-950">
                            <?= !empty($usuario['ultimo_acceso']) ? date('d/m/Y h:i A', strtotime($usuario['ultimo_acceso'])) : 'Sin ingresos registrados' ?>
                        </span>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/70 flex items-center gap-3">
                    <div class="p-2.5 bg-white text-slate-600 rounded-xl border border-slate-200 shrink-0">
                        <i data-lucide="calendar" class="w-5 h-5 text-indigo-500"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Registrado el</span>
                        <span class="text-xs font-bold text-slate-700">
                            <?= !empty($usuario['creado_en']) ? date('d/m/Y', strtotime($usuario['creado_en'])) : 'N/A' ?>
                        </span>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200/70 flex items-center gap-3">
                    <div class="p-2.5 bg-white text-slate-600 rounded-xl border border-slate-200 shrink-0">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400 block tracking-wider">Última Actualización</span>
                        <span class="text-xs font-bold text-slate-700">
                            <?= !empty($usuario['actualizado_en']) ? date('d/m/Y h:i A', strtotime($usuario['actualizado_en'])) : 'Sin cambios' ?>
                        </span>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">

                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="pen-tool" class="w-4 h-4 text-indigo-600"></i>
                        Firma Digital Registrada
                    </h3>

                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 flex flex-col items-center justify-center min-h-[140px] relative group">
                        <?php if (!empty($usuario['firma_base64'])): ?>
                            <img src="<?= $usuario['firma_base64'] ?>" class="max-h-24 max-w-full object-contain filter drop-shadow-xs" alt="Firma Digital">
                            <span class="absolute bottom-2 right-3 text-[10px] text-emerald-600 font-bold bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md flex items-center gap-1">
                                <i data-lucide="check" class="w-3 h-3"></i> Firma Valida
                            </span>
                        <?php else: ?>
                            <div class="text-center space-y-1 text-slate-400">
                                <i data-lucide="signature" class="w-8 h-8 mx-auto stroke-1 text-slate-300"></i>
                                <p class="text-xs font-medium text-slate-500">Sin firma digital asignada</p>
                                <p class="text-[10px] text-slate-400">Puedes adjuntarla editando este perfil.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="key-round" class="w-4 h-4 text-indigo-600"></i>
                        Permisos de Acceso (<?= count($permisos) ?>)
                    </h3>

                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 min-h-[140px]">
                        <?php if (!empty($permisos)): ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($permisos as $p): ?>
                                    <span class="bg-white text-slate-700 px-3 py-1.5 rounded-xl text-xs font-bold border border-slate-200 shadow-2xs capitalize flex items-center gap-1.5">
                                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5 text-emerald-500"></i>
                                        <?= str_replace('_', ' ', htmlspecialchars($p)) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-6 text-slate-400">
                                <i data-lucide="lock" class="w-6 h-6 mx-auto mb-1 text-slate-300"></i>
                                <p class="text-xs">No tiene permisos específicos asignados.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>