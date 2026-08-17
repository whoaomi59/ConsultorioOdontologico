<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión — Clínica Odontológica</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg border border-slate-200/80 p-8 space-y-6">
            <div class="text-center space-y-2">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl inline-flex items-center justify-center mb-1">
                    <i data-lucide="shield-check" class="w-6 h-6"></i>
                </div>
                <h1 class="text-2xl font-bold text-slate-800">Bienvenido de nuevo</h1>
                <p class="text-xs text-slate-500">Ingresa tus credenciales para acceder al sistema</p>
            </div>

            <?php if (!empty($_SESSION['error'])): ?>
                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs p-3 rounded-xl flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                    <span><?= $_SESSION['error']; unset($_SESSION['error']); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL ?>/login/autenticar" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Correo Electrónico</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" name="email" required placeholder="correo@ejemplo.com" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Contraseña</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                    </div>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-xs transition shadow-sm">
                    Iniciar Sesión
                </button>
            </form>
        </div>

        <script>lucide.createIcons();</script>
    </body>
</html>