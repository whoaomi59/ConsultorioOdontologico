<div class="space-y-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200/80">
        <h1 class="text-xl font-bold text-slate-800 flex items-center gap-2">
            <i data-lucide="bar-chart-3" class="w-6 h-6 text-indigo-600"></i> Reportes Generales
        </h1>
        <p class="text-xs text-slate-500 mt-1">Estadísticas y descarga de reportes del sistema.</p>
    </div>

    <!-- Filtros de búsqueda -->
    <form method="GET" action="<?= BASE_URL ?>/reporte/index" class="bg-white p-4 rounded-xl border border-slate-200/80 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Fecha Inicio</label>
            <input type="date" name="fecha_inicio" value="<?= htmlspecialchars($fechaInicio) ?>" class="px-3 py-1.5 text-xs border rounded-lg">
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-600 mb-1">Fecha Fin</label>
            <input type="date" name="fecha_fin" value="<?= htmlspecialchars($fechaFin) ?>" class="px-3 py-1.5 text-xs border rounded-lg">
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold text-xs rounded-lg hover:bg-indigo-700">
            Filtrar
        </button>
        <a href="<?= BASE_URL ?>/reporte/exportarCitasCsv?fecha_inicio=<?= $fechaInicio ?>&fecha_fin=<?= $fechaFin ?>" class="px-4 py-2 bg-emerald-600 text-white font-semibold text-xs rounded-lg hover:bg-emerald-700">
            Exportar Excel (CSV)
        </a>
    </form>
</div>