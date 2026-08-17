<?php requireRole(['admin']); ?>

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
                Gestión de Usuarios y Roles
            </h1>
            <p class="text-xs text-slate-500 mt-1">Crea y administra las cuentas de acceso al sistema.</p>
        </div>
    </div>

    <!-- Formulario Crear Usuario -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80 space-y-4">
        <h2 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3 flex items-center gap-2">
            <i data-lucide="user-plus" class="w-4 h-4 text-indigo-600"></i> Registrar Nuevo Usuario
        </h2>

        <form action="<?= BASE_URL ?>/usuarios/guardar" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nombre Completo</label>
                <input type="text" name="nombre" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Rol de Usuario</label>
                <select name="rol" required class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs focus:outline-none focus:border-indigo-500">
                    <option value="odontologo">Odontólogo</option>
                    <option value="recepcionista">Recepcionista</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition">
                    Crear Usuario
                </button>
            </div>
        </form>
    </div>

    <!-- Tabla de Usuarios Registrados -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <table class="w-full text-left text-xs text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-100 font-bold text-slate-700 uppercase">
                <tr>
                    <th class="p-4">Usuario</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Rol</th>
                    <th class="p-4">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($usuarios as $u): ?>
                    <tr class="hover:bg-slate-50/50">
                        <td class="p-4 font-bold text-slate-800"><?= htmlspecialchars($u['nombre']) ?></td>
                        <td class="p-4"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                                <?= $u['rol'] === 'admin' ? 'bg-purple-50 text-purple-700 border border-purple-200' : '' ?>
                                <?= $u['rol'] === 'odontologo' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' ?>
                                <?= $u['rol'] === 'recepcionista' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' ?>">
                            <?= $u['rol'] ?>
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold
                            <?= $u['estado'] ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' ?>">
                        <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>