<div class="space-y-6">

    <!-- Header del Módulo -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 flex items-center gap-2.5">
                <div class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl">
                    <i data-lucide="file-text" class="w-6 h-6"></i>
                </div>
                Historias Clínicas — Odontología
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Busca un paciente por nombre, apellido o número de documento para acceder o registrar su historia clínica y odontograma.
            </p>
        </div>
    </div>

    <!-- Barra de Búsqueda Instantánea -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200/80">
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                <i data-lucide="search" class="w-5 h-5"></i>
            </div>
            <input
            type="text"
            id="search-input"
            placeholder="Escribe el nombre, apellido o documento para filtrar en tiempo real..."
            class="w-full pl-11 pr-10 py-3 bg-slate-50/70 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 transition"
            autofocus
            >
            <button
            type="button"
            id="clear-btn"
            class="hidden absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition"
            >
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    </div>
</div>

<!-- Lista de Pacientes / Resultados -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <span class="text-xs font-semibold text-slate-600" id="search-status">
            Todos los Pacientes Registrados:
        </span>
        <span class="text-xs font-bold bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full border border-indigo-100/50" id="patient-count">
            <?= count($pacientes) ?> <?= count($pacientes) === 1 ? 'paciente' : 'pacientes' ?>
        </span>
    </div>

    <?php if (!empty($pacientes)): ?>
        <div class="divide-y divide-slate-100" id="patients-list">
            <?php foreach ($pacientes as $paciente): ?>
                <?php
                $searchData = mb_strtolower($paciente['nombre'] . ' ' . $paciente['apellido'] . ' ' . $paciente['documento']);

                // Cálculo exacto de la edad
                $edad        = null;
                $esMenorEdad = false;
                if (!empty($paciente['fecha_nacimiento'])) {
                    $nacimiento  = new DateTime($paciente['fecha_nacimiento']);
                    $hoy         = new DateTime();
                    $edad        = $hoy->diff($nacimiento)->y;
                    $esMenorEdad = $edad < 18;
                }
                ?>
                <div class="patient-card p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition" data-search="<?= htmlspecialchars($searchData) ?>">

                    <!-- Info del Paciente -->
                    <div class="flex items-center space-x-4">
                        <!-- Avatar con Iniciales -->
                        <div class="w-11 h-11 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-sm shrink-0 shadow-sm">
                            <?= strtoupper(substr($paciente['nombre'], 0, 1) . substr($paciente['apellido'], 0, 1)) ?>
                        </div>

                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-slate-800 text-sm">
                                    <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido']) ?>
                                </h3>

                                <!-- Insignia Mayor / Menor de Edad -->
                                <?php if ($edad !== null): ?>
                                    <?php if ($esMenorEdad): ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/80">
                                            <i data-lucide="shield-alert" class="w-3 h-3 text-amber-500"></i>
                                            Menor de edad (<?= $edad ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/80">
                                            <i data-lucide="shield-check" class="w-3 h-3 text-blue-500"></i>
                                            Mayor de edad (<?= $edad ?>)
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>

                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-xs text-slate-500">
                                <span class="flex items-center gap-1 font-medium">
                                    <i data-lucide="id-card" class="w-3.5 h-3.5 text-slate-400"></i>
                                    Doc: <strong class="text-slate-700"><?= htmlspecialchars($paciente['documento']) ?></strong>
                                </span>

                                <?php if (!empty($paciente['telefono'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <?= htmlspecialchars($paciente['telefono']) ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($paciente['email'])): ?>
                                    <span class="flex items-center gap-1">
                                        <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <?= htmlspecialchars($paciente['email']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones -->
                    <div class="w-full sm:w-auto flex justify-end">
                        <a href="<?= BASE_URL ?>/historias/ver/<?= $paciente['id'] ?>" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white px-4 py-2.5 rounded-xl text-xs font-semibold border border-indigo-100 hover:border-indigo-600 transition duration-200 shadow-2xs group">
                            <i data-lucide="folder-open" class="w-4 h-4 text-indigo-600 group-hover:text-white transition"></i>
                            <span>Ver Historia Clínica</span>
                        </a>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <!-- Estado Vacío por Búsqueda sin Resultados -->
        <div id="no-results" class="hidden p-12 text-center">
            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i data-lucide="user-x" class="w-6 h-6"></i>
            </div>
            <h3 class="text-sm font-semibold text-slate-700">No se encontraron pacientes</h3>
            <p class="text-xs text-slate-400 mt-1">
                No hay ningún paciente registrado que coincida con el término ingresado.
            </p>
        </div>

    <?php else: ?>
        <!-- Estado Vacío General (Sin Pacientes en la Base de Datos) -->
        <div class="p-12 text-center">
            <div class="w-12 h-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i data-lucide="user-x" class="w-6 h-6"></i>
            </div>
            <h3 class="text-sm font-semibold text-slate-700">No hay pacientes registrados</h3>
            <p class="text-xs text-slate-400 mt-1">
                Aún no existen registros de pacientes en la base de datos.
            </p>
        </div>
    <?php endif; ?>

</div>
</div>

<!-- Script de Búsqueda Instantánea -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        const searchInput  = document.getElementById('search-input');
        const clearBtn     = document.getElementById('clear-btn');
        const patientCards = document.querySelectorAll('.patient-card');
        const noResults    = document.getElementById('no-results');
        const searchStatus = document.getElementById('search-status');
        const patientCount = document.getElementById('patient-count');

        if (!searchInput) return;

        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();

            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }

            let visibleCount = 0;

            patientCards.forEach(card => {
                const searchData = card.getAttribute('data-search');

                if (searchData.includes(query)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            patientCount.textContent = `${visibleCount} ${visibleCount === 1 ? 'paciente' : 'pacientes'}`;

            if (query.length > 0) {
                searchStatus.textContent = 'Resultados filtrados:';
            } else {
                searchStatus.textContent = 'Todos los Pacientes Registrados:';
            }

            if (visibleCount === 0 && patientCards.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });

        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
            searchInput.focus();
        });
    });
</script>