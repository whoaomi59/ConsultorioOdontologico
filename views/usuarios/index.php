<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                Gestión de Usuarios y Roles
            </h1>
            <p class="text-xs text-slate-500 mt-1">Administra las cuentas, fotos de perfil y accesos a los módulos.</p>
        </div>
        <a href="<?= BASE_URL ?>/usuarios/crear" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition shadow-sm">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            Registrar Nuevo Usuario
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-100 font-bold text-slate-700 uppercase">
                    <tr>
                        <th class="p-4">Usuario</th>
                        <th class="p-4">Correo Electrónico</th>
                        <th class="p-4">Rol</th>
                        <th class="p-4">Estado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($usuarios as$u): ?>
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-800 flex items-center gap-3">
                                <?php if (!empty($u['foto']) && file_exists(ROOT_PATH . '/public/uploads/usuarios/' .$u['foto'])): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($u['foto']) ?>" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-sm">
                                <?php else: ?>
                                    <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs border border-indigo-200 uppercase">
                                        <?= mb_substr($u['nombre'], 0, 2) ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <span class="block text-slate-800 text-xs font-bold"><?= htmlspecialchars($u['nombre']) ?></span>
                                    <span class="text-[10px] text-slate-400 font-normal">ID: #<?= $u['id'] ?></span>
                                </div>
                            </td>
                            <td class="p-4"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                    <?= $u['rol'] === 'admin' ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' ?>
                                    <?= $u['rol'] === 'doctor' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' ?>
                                    <?= $u['rol'] === 'recepcionista' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' ?>">
                                <?= htmlspecialchars($u['rol']) ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $u['estado'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' ?>">
                                <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
                            </span>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1">
                                <a href="<?= BASE_URL ?>/usuarios/ver/<?= $u['id'] ?>" title="Ver Perfil" class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/usuarios/editar/<?= $u['id'] ?>" title="Editar Usuario" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/usuarios/eliminar/<?= $u['id'] ?>" onclick="return confirm('¿Eliminar usuario?')" title="Eliminar" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>