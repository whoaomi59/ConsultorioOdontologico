<?php

$fotoExiste =
!empty($usuario['foto']) &&
file_exists(
ROOT_PATH .
'/public/uploads/usuarios/' .
$usuario['foto']
);

$nombre =
$usuario['nombre'] ?? 'Usuario';

$iniciales =
mb_strtoupper(
mb_substr($nombre, 0, 2)
);

$rol =
$usuario['rol'] ?? 'usuario';

$esDoctor =
$rol === 'doctor';

$hoy =
date('Y-m-d');

$mensajeExito =
$_SESSION['exito_perfil'] ?? null;

$mensajeError =
$_SESSION['error_perfil'] ?? null;

unset(
$_SESSION['exito_perfil'],
$_SESSION['error_perfil']
);

?>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- =====================================================
    ENCABEZADO
    ====================================================== -->

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="h-32 bg-gradient-to-r from-indigo-600 via-indigo-500 to-violet-500"></div>

        <div class="px-6 pb-6">

            <div class="-mt-14 flex flex-col md:flex-row md:items-end md:justify-between gap-5">

                <div class="flex items-end gap-4">

                    <?php if ($fotoExiste): ?>

                        <img
                        id="fotoPerfilPrincipal"
                        src="<?= BASE_URL ?>/public/uploads/usuarios/<?= htmlspecialchars($usuario['foto']) ?>"
                        class="w-28 h-28 rounded-3xl object-cover border-4 border-white shadow-xl"
                        >

                    <?php else: ?>

                        <div
                        id="fotoPerfilPrincipal"
                        class="w-28 h-28 rounded-3xl bg-indigo-100 text-indigo-700 border-4 border-white shadow-xl flex items-center justify-center text-3xl font-black"
                        >
                        <?= htmlspecialchars($iniciales) ?>
                    </div>

                <?php endif; ?>

                <div class="pb-1">

                    <div class="flex items-center gap-2 flex-wrap">

                        <h1 class="text-2xl font-black text-slate-900">
                            <?= htmlspecialchars($nombre) ?>
                        </h1>

                        <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-black uppercase">
                            <?= htmlspecialchars($rol) ?>
                        </span>

                    </div>

                    <p class="text-sm text-slate-500 mt-1">
                        <?= htmlspecialchars($usuario['email'] ?? '') ?>
                    </p>

                </div>

            </div>

            <a
            href="<?= BASE_URL ?>/cita/index"
            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold transition"
            >
            <i data-lucide="calendar-days" class="w-4 h-4"></i>
            Ir a mi agenda
        </a>

    </div>

</div>

</div>


<!-- =====================================================
MENSAJES
====================================================== -->

<?php if ($mensajeExito): ?>

    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl p-4 flex items-center gap-3">

        <i data-lucide="check-circle" class="w-5 h-5"></i>

        <span class="text-sm font-semibold">
            <?= htmlspecialchars($mensajeExito) ?>
        </span>

    </div>

<?php endif; ?>


<?php if ($mensajeError): ?>

    <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-2xl p-4 flex items-center gap-3">

        <i data-lucide="alert-circle" class="w-5 h-5"></i>

        <span class="text-sm font-semibold">
            <?= htmlspecialchars($mensajeError) ?>
        </span>

    </div>

<?php endif; ?>


<!-- =====================================================
ESTADÍSTICAS
====================================================== -->

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">

    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Días programados
        </p>

        <p class="text-3xl font-black text-indigo-600 mt-2">
            <?= (int) $estadisticas['dias_programados'] ?>
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Días realizados
        </p>

        <p class="text-3xl font-black text-violet-600 mt-2">
            <?= (int) $estadisticas['dias_realizados'] ?>
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Total citas
        </p>

        <p class="text-3xl font-black text-slate-800 mt-2">
            <?= (int) $estadisticas['total_citas'] ?>
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Pendientes
        </p>

        <p class="text-3xl font-black text-amber-500 mt-2">
            <?= (int) $estadisticas['pendientes'] ?>
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Atendidas
        </p>

        <p class="text-3xl font-black text-emerald-600 mt-2">
            <?= (int) $estadisticas['atendidas'] ?>
        </p>

    </div>


    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

        <p class="text-[10px] font-black uppercase text-slate-400">
            Canceladas
        </p>

        <p class="text-3xl font-black text-rose-600 mt-2">
            <?= (int) $estadisticas['canceladas'] ?>
        </p>

    </div>

</div>


<!-- =====================================================
PERFIL + AGENDA
====================================================== -->

<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


    <!-- =================================================
    DATOS PERSONALES
    ================================================== -->

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

        <div class="flex items-center gap-3 mb-6">

            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="user-round" class="w-5 h-5"></i>
            </div>

            <div>

                <h2 class="font-black text-slate-800">
                    Mi información
                </h2>

                <p class="text-xs text-slate-400">
                    Actualiza tus datos personales
                </p>

            </div>

        </div>


        <form
        action="<?= BASE_URL ?>/usuarios/actualizarMiPerfil"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-4"
        >

        <!-- FOTO -->

        <div>

            <label class="block text-xs font-bold text-slate-700 mb-2">
                Fotografía
            </label>

            <div class="flex gap-2">

                <label class="flex-1 cursor-pointer">

                    <div class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-center hover:bg-slate-100 transition">

                        <i data-lucide="upload" class="w-4 h-4 mx-auto mb-1 text-indigo-600"></i>

                        <span class="text-[10px] font-bold text-slate-600">
                            Subir foto
                        </span>

                    </div>

                    <input
                    type="file"
                    name="foto"
                    id="fotoArchivo"
                    accept="image/jpeg,image/png,image/webp"
                    class="hidden"
                    >

                </label>


                <button
                type="button"
                id="btnAbrirCamara"
                class="flex-1 bg-slate-50 border border-slate-200 rounded-xl p-3 text-center hover:bg-slate-100 transition"
                >

                <i data-lucide="camera" class="w-4 h-4 mx-auto mb-1 text-indigo-600"></i>

                <span class="text-[10px] font-bold text-slate-600">
                    Cámara
                </span>

            </button>

        </div>

        <input
        type="hidden"
        name="foto_base64"
        id="foto_base64"
        >

    </div>


    <!-- NOMBRE -->

    <div>

        <label class="block text-xs font-bold text-slate-700 mb-1">
            Nombre completo
        </label>

        <input
        type="text"
        name="nombre"
        value="<?= htmlspecialchars($usuario['nombre'] ?? '') ?>"
        required
        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500"
        >

    </div>


    <!-- EMAIL -->

    <div>

        <label class="block text-xs font-bold text-slate-700 mb-1">
            Correo electrónico
        </label>

        <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($usuario['email'] ?? '') ?>"
        required
        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500"
        >

    </div>


    <!-- PASSWORD -->

    <div>

        <label class="block text-xs font-bold text-slate-700 mb-1">
            Nueva contraseña
        </label>

        <input
        type="password"
        name="password"
        placeholder="Dejar vacío para conservarla"
        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500"
        >

    </div>


    <div class="pt-2">

        <button
        type="submit"
        class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl px-4 py-3 text-xs font-black transition"
        >

        <i data-lucide="save" class="w-4 h-4"></i>

        Guardar cambios

    </button>

</div>

</form>

</div>


<!-- =================================================
AGENDA
================================================== -->

<div class="xl:col-span-2 bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="calendar-plus" class="w-5 h-5"></i>
            </div>

            <div>

                <h2 class="font-black text-slate-800">
                    Mi agenda de atención
                </h2>

                <p class="text-xs text-slate-400">
                    Programa los días y horarios en los que atenderás.
                </p>

            </div>

        </div>

    </div>


    <?php if ($esDoctor): ?>

        <!-- FORMULARIO -->

        <form
        action="<?= BASE_URL ?>/usuarios/guardarFechaAtencion"
        method="POST"
        class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-6"
        >

        <div>

            <label class="block text-xs font-bold text-slate-700 mb-1">
                Fecha de atención
            </label>

            <input
            type="date"
            name="fecha"
            min="<?= $hoy ?>"
            required
            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500"
            >

        </div>


        <div>

            <label class="block text-xs font-bold text-slate-700 mb-1">
                Hora de inicio
            </label>

            <input
            type="time"
            name="hora_inicio"
            required
            class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-500"
            >

        </div>


        <div class="flex items-end">

            <button
            type="submit"
            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-4 py-2.5 text-xs font-black transition flex items-center justify-center gap-2"
            >

            <i data-lucide="plus" class="w-4 h-4"></i>

            Agendar fecha

        </button>

    </div>

    </form>


    <!-- LISTA -->

    <div class="space-y-3">

        <?php if (empty($fechasAtencion)): ?>

            <div class="text-center py-12 border-2 border-dashed border-slate-200 rounded-2xl">

                <i data-lucide="calendar-off" class="w-10 h-10 mx-auto text-slate-300"></i>

                <p class="text-sm font-bold text-slate-500 mt-3">
                    No tienes fechas programadas
                </p>

                <p class="text-xs text-slate-400 mt-1">
                    Utiliza el formulario para agregar tu primera fecha.
                </p>

            </div>

        <?php else: ?>

            <?php foreach ($fechasAtencion as $fecha): ?>

                <?php

                $esPasada =
                $fecha['fecha'] < $hoy;

                $fechaFormateada =
                date(
                'd/m/Y',
                strtotime(
                $fecha['fecha']
                )
                );

                $horaFormateada =
                date(
                'h:i A',
                strtotime(
                $fecha['hora_inicio']
                )
                );

                ?>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 rounded-2xl border <?= $esPasada ? 'border-slate-200 bg-slate-50' : 'border-emerald-100 bg-emerald-50/40' ?>">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl <?= $esPasada ? 'bg-slate-200 text-slate-500' : 'bg-emerald-100 text-emerald-700' ?> flex flex-col items-center justify-center">

                            <span class="text-[9px] font-black uppercase">
                                <?= date('M', strtotime($fecha['fecha'])) ?>
                            </span>

                            <span class="text-lg font-black leading-none">
                                <?= date('d', strtotime($fecha['fecha'])) ?>
                            </span>

                        </div>

                        <div>

                            <p class="font-black text-slate-800">
                                <?= htmlspecialchars($fechaFormateada) ?>
                            </p>

                            <p class="text-xs text-slate-500 flex items-center gap-1 mt-1">

                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>

                                <?= htmlspecialchars($horaFormateada) ?>

                            </p>

                        </div>

                    </div>


                    <div class="flex items-center gap-2">

                        <?php if ($esPasada): ?>

                            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-500 text-[10px] font-black uppercase">
                                Realizada
                            </span>

                        <?php else: ?>

                            <span class="px-3 py-1.5 rounded-lg bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase">
                                Programada
                            </span>

                            <a
                            href="<?= BASE_URL ?>/usuarios/eliminarFechaAtencion/<?= (int) $fecha['id'] ?>"
                            onclick="return confirm('¿Deseas eliminar esta fecha de atención?');"
                            class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition"
                            title="Eliminar fecha"
                            >

                            <i data-lucide="trash-2" class="w-4 h-4"></i>

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

    </div>

<?php else: ?>

    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">

        <div class="flex gap-3">

            <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0"></i>

            <div>

                <p class="text-sm font-black text-amber-800">
                    Agenda personal disponible para doctores
                </p>

                <p class="text-xs text-amber-700 mt-1">
                    Actualmente tu usuario tiene el rol
                    <strong><?= htmlspecialchars($rol) ?></strong>.
                </p>

            </div>

        </div>

    </div>

<?php endif; ?>

</div>

</div>


<!-- =====================================================
TRAYECTORIA
====================================================== -->

<div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6">

    <div class="flex items-center gap-3 mb-6">

        <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
            <i data-lucide="chart-no-axes-combined" class="w-5 h-5"></i>
        </div>

        <div>

            <h2 class="font-black text-slate-800">
                Mi trayectoria en el sistema
            </h2>

            <p class="text-xs text-slate-400">
                Resumen de tu actividad y atención registrada.
            </p>

        </div>

    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="rounded-2xl bg-indigo-50 p-5">

            <i data-lucide="calendar-check" class="w-5 h-5 text-indigo-600"></i>

            <p class="text-xs text-indigo-700 font-bold mt-3">
                Fechas programadas
            </p>

            <p class="text-2xl font-black text-indigo-800 mt-1">
                <?= (int) $estadisticas['dias_programados'] ?>
            </p>

        </div>


        <div class="rounded-2xl bg-emerald-50 p-5">

            <i data-lucide="user-check" class="w-5 h-5 text-emerald-600"></i>

            <p class="text-xs text-emerald-700 font-bold mt-3">
                Citas atendidas
            </p>

            <p class="text-2xl font-black text-emerald-800 mt-1">
                <?= (int) $estadisticas['atendidas'] ?>
            </p>

        </div>


        <div class="rounded-2xl bg-amber-50 p-5">

            <i data-lucide="clock-3" class="w-5 h-5 text-amber-600"></i>

            <p class="text-xs text-amber-700 font-bold mt-3">
                Citas pendientes
            </p>

            <p class="text-2xl font-black text-amber-800 mt-1">
                <?= (int) $estadisticas['pendientes'] ?>
            </p>

        </div>


        <div class="rounded-2xl bg-rose-50 p-5">

            <i data-lucide="calendar-x-2" class="w-5 h-5 text-rose-600"></i>

            <p class="text-xs text-rose-700 font-bold mt-3">
                Citas canceladas
            </p>

            <p class="text-2xl font-black text-rose-800 mt-1">
                <?= (int) $estadisticas['canceladas'] ?>
            </p>

        </div>

    </div>

</div>

</div>


<!-- =========================================================
MODAL CÁMARA
========================================================= -->

<div
id="modalCamara"
class="fixed inset-0 z-50 hidden bg-slate-950/70 backdrop-blur-sm items-center justify-center p-4"
>

<div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden">

    <div class="p-5 border-b border-slate-200 flex items-center justify-between">

        <div>

            <h3 class="font-black text-slate-800">
                Tomar fotografía
            </h3>

            <p class="text-xs text-slate-400">
                Centra tu rostro y toma la fotografía.
            </p>

        </div>

        <button
        type="button"
        id="btnCerrarCamara"
        class="w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center"
        >

        <i data-lucide="x" class="w-4 h-4"></i>

    </button>

</div>


<div class="p-5">

    <video
    id="videoCamara"
    autoplay
    playsinline
    class="w-full aspect-video bg-slate-950 rounded-2xl object-cover"
    ></video>

<canvas
id="canvasCamara"
class="hidden"
></canvas>

</div>


<div class="p-5 pt-0 flex gap-3">

    <button
    type="button"
    id="btnCapturarFoto"
    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl py-3 text-xs font-black"
    >

    <i data-lucide="camera" class="w-4 h-4 inline-block mr-1"></i>

    Capturar

</button>

</div>

</div>

</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const btnAbrir =
        document.getElementById('btnAbrirCamara');

        const btnCerrar =
        document.getElementById('btnCerrarCamara');

        const btnCapturar =
        document.getElementById('btnCapturarFoto');

        const modal =
        document.getElementById('modalCamara');

        const video =
        document.getElementById('videoCamara');

        const canvas =
        document.getElementById('canvasCamara');

        const campoBase64 =
        document.getElementById('foto_base64');

        const archivo =
        document.getElementById('fotoArchivo');

        let stream = null;


        function detenerCamara() {

            if (stream) {

                stream
                .getTracks()
                .forEach(track => track.stop());

                stream = null;
            }
        }


        btnAbrir?.addEventListener(
        'click',
        async function () {

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            try {

                stream =
                await navigator.mediaDevices
                .getUserMedia({
                    video: true,
                    audio: false
                });

                video.srcObject = stream;

            } catch (error) {

                alert(
                'No fue posible acceder a la cámara.'
                );

                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }
        );


        btnCerrar?.addEventListener(
        'click',
        function () {

            detenerCamara();

            modal.classList.add('hidden');
            modal.classList.remove('flex');

        }
        );


        btnCapturar?.addEventListener(
        'click',
        function () {

            if (!video.videoWidth) {
                return;
            }

            canvas.width =
            video.videoWidth;

            canvas.height =
            video.videoHeight;

            const ctx =
            canvas.getContext('2d');

            ctx.drawImage(
            video,
            0,
            0,
            canvas.width,
            canvas.height
            );

            const imagen =
            canvas.toDataURL(
            'image/jpeg',
            0.90
            );

            campoBase64.value =
            imagen;

            archivo.value = '';

            detenerCamara();

            modal.classList.add('hidden');
            modal.classList.remove('flex');

            alert(
            'Fotografía capturada. Presiona "Guardar cambios" para almacenarla.'
            );
        }
        );


        archivo?.addEventListener(
        'change',
        function () {

            if (this.files.length > 0) {

                campoBase64.value = '';

            }
        }
        );

    });

</script>