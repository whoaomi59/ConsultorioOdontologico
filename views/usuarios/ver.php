<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200/80 text-center space-y-4">

        <?php if (!empty($usuario['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' . $usuario['foto'])): ?>
            <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>" class="w-24 h-24 mx-auto rounded-full object-cover border-4 border-indigo-50 shadow-md">
        <?php else: ?>
            <div class="w-24 h-24 mx-auto rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-2xl border-4 border-indigo-50 uppercase">
                <?= mb_substr($usuario['nombre'], 0, 2) ?>
            </div>
        <?php endif; ?>

        <div>
            <h2 class="text-xl font-bold text-slate-800"><?= htmlspecialchars($usuario['nombre']) ?></h2>
            <p class="text-xs text-slate-500"><?= htmlspecialchars($usuario['email']) ?></p>
        </div>

        <div class="flex justify-center gap-2 pt-2">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-purple-50 text-purple-700 border border-purple-200">
                <?= htmlspecialchars($usuario['rol']) ?>
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold <?= $usuario['estado'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' ?>">
                <?= $usuario['estado'] ? 'Activo' : 'Inactivo' ?>
            </span>
        </div>

        <div class="border-t border-b py-4 my-4 grid grid-cols-2 gap-4 text-left text-xs bg-slate-50/50 p-4 rounded-xl border border-slate-200/60">
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Fecha de Registro:</span>
                <span class="font-bold text-slate-700">
                    <?= !empty($usuario['creado_en']) ? date('d/m/Y h:i A', strtotime($usuario['creado_en'])) : 'No disponible' ?>
                </span>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase text-slate-400 block">Última Modificación:</span>
                <span class="font-bold text-slate-700">
                    <?= !empty($usuario['actualizado_en']) ? date('d/m/Y h:i A', strtotime($usuario['actualizado_en'])) : 'Sin cambios' ?>
                </span>
            </div>
        </div>

        <div class="text-left space-y-2">
            <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Módulos permitidos:</h3>
            <div class="flex flex-wrap gap-2">
                <?php foreach ($permisos as $p): ?>
                    <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-lg text-xs font-medium border border-indigo-100 capitalize flex items-center gap-1.5">
                        <i data-lucide="check-circle" class="w-3.5 h-3.5 text-indigo-500"></i>
                        <?= $p ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="border-t pt-4 flex justify-between">
            <a href="<?= BASE_URL ?>/usuarios/index" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-medium">Volver a la lista</a>
            <a href="<?= BASE_URL ?>/usuarios/editar/<?= $usuario['id'] ?>" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-xs font-semibold">Editar Perfil</a>
        </div>
    </div>
</div>