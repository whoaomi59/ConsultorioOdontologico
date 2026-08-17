<div class="space-y-6">

    <!-- Header y Acción Principal -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Listado de Pacientes</h1>
            <p class="text-xs text-slate-500 mt-1">Gestión integral, historias clínicas y exportación de datos.</p>
        </div>
        <a href="<?= BASE_URL ?>/paciente/crear" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2.5 rounded-xl text-xs shadow-sm transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i>
            <span>Registrar Paciente</span>
        </a>
    </div>

    <!-- Barra de Herramientas: Búsqueda y Exportación -->
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200/80 flex flex-col md:flex-row justify-between gap-4 items-center">
        <!-- Buscador Instantáneo -->
        <div class="relative w-full md:w-96">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-4 h-4"></i>
            </div>
            <input
            type="text"
            id="search-table"
            placeholder="Buscar por documento, nombre o teléfono..."
            class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:outline-none focus:border-indigo-500 transition"
            >
        </div>

        <!-- Botones de Exportación -->
        <div class="flex items-center gap-2 w-full md:w-auto justify-end">
            <a href="<?= BASE_URL ?>/paciente/exportar/pdf" target="_blank" class="inline-flex items-center gap-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 px-3 py-2 rounded-xl text-xs font-semibold border border-rose-200/80 transition">
                <i data-lucide="file-text" class="w-4 h-4"></i>
                <span>Exportar PDF</span>
            </a>
            <a href="<?= BASE_URL ?>/paciente/exportar/excel" class="inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3 py-2 rounded-xl text-xs font-semibold border border-emerald-200/80 transition">
                <i data-lucide="file-spreadsheet" class="w-4 h-4"></i>
                <span>Exportar Excel</span>
            </a>
        </div>
    </div>

    <!-- Tabla de Pacientes -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="pacientes-table">
                <thead class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase text-slate-500 tracking-wider">
                    <tr>
                        <th class="p-4">Documento</th>
                        <th class="p-4">Paciente</th>
                        <th class="p-4">Edad / Condición</th>
                        <th class="p-4">Teléfono</th>
                        <th class="p-4">Correo</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($pacientes as $p): ?>
                        <?php
                        $tipoDoc    = $p['tipo_documento'] ?? 'CC';
                        $nacimiento = new DateTime($p['fecha_nacimiento']);
                        $hoy        = new DateTime();
                        $edad       = $hoy->diff($nacimiento)->y;
                        $esMayor    = $edad >= 18;

                        $searchContext = mb_strtolower($p['documento'] . ' ' . $p['nombre'] . ' ' . $p['apellido'] . ' ' . $p['telefono'] . ' ' . $p['email']);
                        ?>
                        <tr class="paciente-row hover:bg-slate-50/80 transition" data-search="<?= htmlspecialchars($searchContext) ?>">
                            <td class="p-4 font-mono font-semibold text-slate-600">
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded mr-1 font-sans font-bold"><?= htmlspecialchars($tipoDoc) ?></span>
                                <?= htmlspecialchars($p['documento']) ?>
                            </td>
                            <td class="p-4 font-bold text-slate-800 flex items-center gap-2.5">
                                <?php
                                $fotoRutaFisica = ROOT_PATH . '/public/uploads/pacientes/' . $p['foto'];
                                $tieneFoto      = !empty($p['foto']) && file_exists($fotoRutaFisica);
                                ?>

                                <?php if ($tieneFoto): ?>
                                    <img src="<?= BASE_URL ?>/public/uploads/pacientes/<?= htmlspecialchars($p['foto']) ?>"
                                    alt="Foto Paciente"
                                    class="w-8 h-8 rounded-full object-cover border border-slate-200 shadow-2xs">
                                <?php else: ?>
                                    <!-- Foto por Defecto (Avatar Neutral) -->
                                    <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200 shrink-0">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </div>
                                <?php endif; ?>

                                <span><?= htmlspecialchars($p['nombre'] . ' ' . $p['apellido']) ?></span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="font-semibold text-slate-700"><?= $edad ?> años</span>
                                    <?php if ($esMayor): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            Mayor de edad
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                            Menor de edad
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-4 text-slate-600">
                                <?= htmlspecialchars($p['telefono'] ?: 'N/A') ?>
                            </td>
                            <td class="p-4 text-slate-600">
                                <?= htmlspecialchars($p['email'] ?: 'N/A') ?>
                            </td>
                            <td class="p-4 text-center">
                                <div class="inline-flex items-center gap-1 bg-slate-50 p-1 rounded-xl border border-slate-200/60">

                                    <!-- Ver Perfil -->
                                    <a href="<?= BASE_URL ?>/paciente/perfil/<?= $p['id'] ?>" class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-white rounded-lg transition" title="Ver Perfil">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Ver Historia Odontológica -->
                                    <a href="<?= BASE_URL ?>/paciente/historia/<?= $p['id'] ?>" class="p-1.5 text-slate-500 hover:text-emerald-600 hover:bg-white rounded-lg transition" title="Historia Clínica">
                                        <i data-lucide="folder-open" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Editar -->
                                    <a href="<?= BASE_URL ?>/paciente/editar/<?= $p['id'] ?>" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-white rounded-lg transition" title="Editar Paciente">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>

                                    <!-- Eliminar -->
                                    <a href="<?= BASE_URL ?>/paciente/eliminar/<?= $p['id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este paciente y todas sus historias clínicas?');" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-white rounded-lg transition" title="Eliminar Paciente">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    <?php if (empty($pacientes)): ?>
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                <i data-lucide="users" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <span>No hay pacientes registrados aún.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        lucide.createIcons();

        const searchInput = document.getElementById('search-table');
        const rows        = document.querySelectorAll('.paciente-row');

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase().trim();

                rows.forEach(row => {
                    const searchData = row.getAttribute('data-search');
                    if (searchData.includes(query)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });
            });
        }
    });
</script>