<?php
$nombreUsuario = (string) ($usuario['nombre'] ?? 'Usuario');
$rolUsuario = (string) ($usuario['rol'] ?? 'Sin rol');
$emailUsuario = (string) ($usuario['email'] ?? 'Sin correo registrado');
$usuarioActivo = !empty($usuario['estado']);
$fotoUsuario = (string) ($usuario['foto'] ?? '');
$rutaFotoUsuario = ROOT_PATH . '/public/uploads/usuarios/' . basename($fotoUsuario);
$tieneFotoUsuario = $fotoUsuario !== '' && is_file($rutaFotoUsuario);
$inicialesUsuario = mb_strtoupper(mb_substr(trim($nombreUsuario), 0, 2, 'UTF-8'), 'UTF-8');
$permisosUsuario = is_array($permisos ?? null) ? $permisos : [];
?>
<style>
    .perfil-usuario {
        --pu-ink: #15243b;
        --pu-muted: #718096;
        --pu-line: #e7edf5;
        --pu-blue: #315ee8;
        --pu-teal: #0e9488;
        width: min(100%, 1100px);
        margin-inline: auto;
        color: var(--pu-ink);
    }
    .perfil-usuario * {
        box-sizing: border-box;
    }
    .perfil-usuario .pu-shell {
        overflow: hidden;
        border: 1px solid var(--pu-line);
        border-radius: 28px;
        background: #fff;
        box-shadow: 0 18px 55px rgba(24, 44, 78, 0.09);
    }
    .perfil-usuario .pu-cover {
        position: relative;
        min-height: 190px;
        overflow: hidden;
        padding: 24px;
        color: white;
        background:
            radial-gradient(circle at 82% 25%, rgba(255, 255, 255, 0.18) 0 4%, transparent 4.3% 100%),
            radial-gradient(circle at 88% 40%, rgba(255, 255, 255, 0.08) 0 13%, transparent 13.3% 100%),
            linear-gradient(118deg, #111d38 0%, #2549a5 54%, #087f86 100%);
    }
    .perfil-usuario .pu-cover::before,
    .perfil-usuario .pu-cover::after {
        content: '';
        position: absolute;
        border: 1px solid rgba(255, 255, 255, 0.13);
        border-radius: 50%;
        pointer-events: none;
    }
    .perfil-usuario .pu-cover::before {
        width: 290px;
        height: 290px;
        right: 7%;
        top: -190px;
    }
    .perfil-usuario .pu-cover::after {
        width: 380px;
        height: 380px;
        right: -2%;
        top: -230px;
    }
    .perfil-usuario .pu-back {
        position: relative;
        z-index: 1;
        display: inline-flex;
        align-items: center;
        gap: 9px;
        min-height: 42px;
        padding: 0 15px;
        border: 1px solid rgba(255, 255, 255, 0.28);
        border-radius: 13px;
        color: #fff;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.11);
        backdrop-filter: blur(10px);
        font-size: 13px;
        font-weight: 700;
        transition:
            background 0.2s ease,
            transform 0.2s ease;
    }
    .perfil-usuario .pu-back:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }
    .perfil-usuario .pu-cover-label {
        position: absolute;
        right: 26px;
        bottom: 25px;
        display: flex;
        align-items: center;
        gap: 9px;
        color: rgba(255, 255, 255, 0.83);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.15em;
        text-transform: uppercase;
    }
    .perfil-usuario .pu-cover-label span {
        display: grid;
        place-items: center;
        width: 30px;
        height: 30px;
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.12);
    }
    .perfil-usuario .pu-main {
        padding: 0 30px 30px;
    }
    .perfil-usuario .pu-identity {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 24px;
        margin-top: -53px;
        position: relative;
        z-index: 2;
    }
    .perfil-usuario .pu-avatar-wrap {
        position: relative;
        flex: 0 0 auto;
    }
    .perfil-usuario .pu-avatar {
        display: grid;
        place-items: center;
        width: 124px;
        height: 124px;
        overflow: hidden;
        border: 6px solid #fff;
        border-radius: 27px;
        background: linear-gradient(145deg, #4768e9, #10a59a);
        color: white;
        font-size: 34px;
        font-weight: 850;
        letter-spacing: -0.04em;
        box-shadow: 0 12px 28px rgba(17, 34, 65, 0.2);
        object-fit: cover;
    }
    .perfil-usuario .pu-presence {
        position: absolute;
        right: 5px;
        bottom: 5px;
        width: 19px;
        height: 19px;
        border: 4px solid white;
        border-radius: 50%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }
    .perfil-usuario .pu-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        padding-bottom: 5px;
    }
    .perfil-usuario .pu-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 44px;
        padding: 0 16px;
        border-radius: 13px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease,
            background 0.18s ease;
    }
    .perfil-usuario .pu-btn:hover {
        transform: translateY(-2px);
    }
    .perfil-usuario .pu-btn-primary {
        color: #fff;
        background: linear-gradient(110deg, #315ee8, #426cf0);
        box-shadow: 0 7px 16px rgba(49, 94, 232, 0.2);
    }
    .perfil-usuario .pu-btn-primary:hover {
        box-shadow: 0 11px 22px rgba(49, 94, 232, 0.28);
    }
    .perfil-usuario .pu-btn-light {
        color: #42536b;
        border: 1px solid #dfe7f1;
        background: #fff;
    }
    .perfil-usuario .pu-btn-light:hover {
        background: #f7f9fc;
    }
    .perfil-usuario .pu-title-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 17px;
    }
    .perfil-usuario .pu-name {
        margin: 0;
        font-size: clamp(24px, 3vw, 31px);
        line-height: 1.15;
        letter-spacing: -0.045em;
        font-weight: 850;
        color: #17263f;
        overflow-wrap: anywhere;
    }
    .perfil-usuario .pu-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 27px;
        padding: 4px 10px;
        border-radius: 9px;
        border: 1px solid #dfe7ff;
        background: #f1f5ff;
        color: #3456bb;
        font-size: 10px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }
    .perfil-usuario .pu-pill-state {
        border-color: #b9eed9;
        background: #eafbf3;
        color: #087d55;
    }
    .perfil-usuario .pu-pill-state.inactive {
        border-color: #ffd0d5;
        background: #fff0f1;
        color: #c3374c;
    }
    .perfil-usuario .pu-email {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        color: #708096;
        font-size: 13px;
        overflow-wrap: anywhere;
    }
    .perfil-usuario .pu-divider {
        height: 1px;
        margin: 23px 0;
        background: var(--pu-line);
    }
    .perfil-usuario .pu-section-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
        font-size: 14px;
        font-weight: 850;
        letter-spacing: -0.01em;
        color: #1c2c45;
    }
    .perfil-usuario .pu-heading-icon {
        display: grid;
        place-items: center;
        width: 34px;
        height: 34px;
        flex: 0 0 auto;
        border-radius: 11px;
        color: #315ee8;
        background: #eef3ff;
    }
    .perfil-usuario .pu-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 13px;
        margin-top: 25px;
    }
    .perfil-usuario .pu-stat {
        display: flex;
        align-items: center;
        gap: 13px;
        min-width: 0;
        padding: 16px;
        border: 1px solid #e8edf5;
        border-radius: 17px;
        background: linear-gradient(145deg, #fff, #f9fbfe);
    }
    .perfil-usuario .pu-stat-icon {
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        width: 42px;
        height: 42px;
        border-radius: 13px;
        background: #edf2ff;
        color: #315ee8;
    }
    .perfil-usuario .pu-stat:nth-child(2) .pu-stat-icon {
        background: #e9faf6;
        color: #0e9488;
    }
    .perfil-usuario .pu-stat:nth-child(3) .pu-stat-icon {
        background: #fff5e8;
        color: #c47b17;
    }
    .perfil-usuario .pu-stat-label {
        display: block;
        margin-bottom: 5px;
        color: #8995a7;
        font-size: 9px;
        font-weight: 850;
        letter-spacing: 0.12em;
        text-transform: uppercase;
    }
    .perfil-usuario .pu-stat-value {
        display: block;
        color: #293951;
        font-size: 12px;
        line-height: 1.45;
        font-weight: 800;
        overflow-wrap: anywhere;
    }
    .perfil-usuario .pu-detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 0.9fr) minmax(0, 1.1fr);
        gap: 18px;
        margin-top: 27px;
    }
    .perfil-usuario .pu-panel {
        min-width: 0;
        overflow: hidden;
        border: 1px solid #e5ebf3;
        border-radius: 19px;
        background: #fff;
    }
    .perfil-usuario .pu-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 17px 18px;
        border-bottom: 1px solid #edf1f6;
        background: #fbfcfe;
    }
    .perfil-usuario .pu-panel-body {
        min-height: 172px;
        padding: 18px;
    }
    .perfil-usuario .pu-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 27px;
        height: 27px;
        padding: 0 7px;
        border: 1px solid #dfe7ff;
        border-radius: 9px;
        background: #f1f5ff;
        color: #315ee8;
        font-size: 11px;
        font-weight: 850;
    }
    .perfil-usuario .pu-signature-stage {
        display: grid;
        place-items: center;
        min-height: 130px;
        padding: 18px;
        border: 1px dashed #d8e2ef;
        border-radius: 14px;
        background: linear-gradient(180deg, #fbfdff, #f5f8fc);
    }
    .perfil-usuario .pu-signature-stage img {
        display: block;
        max-width: 100%;
        max-height: 95px;
        object-fit: contain;
    }
    .perfil-usuario .pu-valid {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        color: #07845b;
        font-size: 10px;
        font-weight: 850;
    }
    .perfil-usuario .pu-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 130px;
        color: #8b98aa;
        text-align: center;
    }
    .perfil-usuario .pu-empty-icon {
        display: grid;
        place-items: center;
        width: 42px;
        height: 42px;
        border-radius: 14px;
        background: #eef3f9;
        color: #8290a5;
    }
    .perfil-usuario .pu-empty strong {
        color: #506078;
        font-size: 12px;
    }
    .perfil-usuario .pu-empty span {
        max-width: 240px;
        font-size: 11px;
        line-height: 1.5;
    }
    .perfil-usuario .pu-permissions {
        display: flex;
        flex-wrap: wrap;
        align-content: flex-start;
        gap: 8px;
    }
    .perfil-usuario .pu-permission {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
        padding: 9px 11px;
        border: 1px solid #e2eaf4;
        border-radius: 11px;
        background: #f9fbfe;
        color: #43536b;
        font-size: 11px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }
    .perfil-usuario .pu-permission svg {
        flex: 0 0 auto;
        color: #0e9a72;
    }
    .perfil-usuario a:focus-visible {
        outline: 3px solid rgba(49, 94, 232, 0.35);
        outline-offset: 3px;
    }
    @media (max-width: 760px) {
        .perfil-usuario .pu-main {
            padding: 0 20px 22px;
        }
        .perfil-usuario .pu-stats {
            grid-template-columns: 1fr;
            gap: 9px;
            margin-top: 20px;
        }
        .perfil-usuario .pu-stat {
            padding: 13px 14px;
        }
        .perfil-usuario .pu-detail-grid {
            grid-template-columns: 1fr;
            gap: 14px;
            margin-top: 20px;
        }
        .perfil-usuario .pu-cover {
            min-height: 165px;
            padding: 18px;
        }
        .perfil-usuario .pu-cover-label {
            right: 18px;
            bottom: 18px;
            font-size: 9px;
        }
    }
    @media (max-width: 520px) {
        .perfil-usuario .pu-shell {
            border-radius: 20px;
        }
        .perfil-usuario .pu-identity {
            align-items: center;
            flex-direction: column;
            gap: 12px;
            margin-top: -48px;
        }
        .perfil-usuario .pu-avatar {
            width: 112px;
            height: 112px;
            border-radius: 24px;
        }
        .perfil-usuario .pu-actions {
            width: 100%;
            padding: 0;
        }
        .perfil-usuario .pu-btn {
            flex: 1;
        }
        .perfil-usuario .pu-title-row {
            justify-content: center;
            text-align: center;
        }
        .perfil-usuario .pu-name {
            width: 100%;
            text-align: center;
        }
        .perfil-usuario .pu-email {
            justify-content: center;
            text-align: center;
        }
        .perfil-usuario .pu-divider {
            margin: 19px 0;
        }
        .perfil-usuario .pu-panel-head {
            padding: 14px;
        }
        .perfil-usuario .pu-panel-body {
            padding: 14px;
        }
        .perfil-usuario .pu-cover-label {
            display: none;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        .perfil-usuario *,
        .perfil-usuario *::before,
        .perfil-usuario *::after {
            transition-duration: 0.01ms !important;
        }
    }
</style>
<section class="perfil-usuario" aria-label="Perfil del usuario">
    <div class="pu-shell">
        <header class="pu-cover">
            <a href="<?= BASE_URL ?>/usuarios/index" class="pu-back">
                <i data-lucide="arrow-left" width="16" height="16" aria-hidden="true"></i>
                Volver a usuarios
            </a>
            <div class="pu-cover-label">
                <span>
                    <i data-lucide="user-round-cog" width="16" height="16" aria-hidden="true"></i>
                </span>
                Gestión de usuarios
            </div>
        </header>
        <div class="pu-main">
            <div class="pu-identity">
                <div class="pu-avatar-wrap">
                    <?php if ($tieneFotoUsuario): ?>
                        <img src="<?= BASE_URL ?>/public/uploads/usuarios/<?= rawurlencode(basename($fotoUsuario)) ?>" class="pu-avatar" alt="Foto de <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?>">
                    <?php else: ?>
                        <div class="pu-avatar" role="img" aria-label="Iniciales de <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($inicialesUsuario !== '' ? $inicialesUsuario : 'US', ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                    <span class="pu-presence" style="background:<?= $usuarioActivo ? '#10b981' : '#f43f5e' ?>;" title="<?= $usuarioActivo ? 'Usuario activo' : 'Usuario inactivo' ?>"></span>
                </div>
                <div class="pu-actions">
                    <a href="<?= BASE_URL ?>/usuarios/editar/<?= (int)($usuario['id'] ?? 0) ?>" class="pu-btn pu-btn-primary">
                        <i data-lucide="user-round-pen" width="16" height="16" aria-hidden="true"></i>
                        Editar perfil
                    </a>
                    <a href="<?= BASE_URL ?>/usuarios/index" class="pu-btn pu-btn-light">
                        <i data-lucide="users-round" width="16" height="16" aria-hidden="true"></i>
                        Listado
                    </a>
                </div>
            </div>
            <div class="pu-title-row">
                <h1 class="pu-name"><?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?></h1>
                <span class="pu-pill">
                    <i data-lucide="shield-check" width="13" height="13" aria-hidden="true"></i>
                    <?= htmlspecialchars($rolUsuario, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <span class="pu-pill pu-pill-state <?= $usuarioActivo ? '' : 'inactive' ?>">
                    <i data-lucide="<?= $usuarioActivo ? 'check-circle-2' : 'circle-x' ?>" width="13" height="13" aria-hidden="true"></i>
                    <?= $usuarioActivo ? 'Activo' : 'Inactivo' ?>
                </span>
            </div>
            <div class="pu-email">
                <i data-lucide="mail" width="16" height="16" aria-hidden="true"></i>
                <span><?= htmlspecialchars($emailUsuario, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="pu-stats" aria-label="Fechas importantes">
                <article class="pu-stat">
                    <span class="pu-stat-icon">
                        <i data-lucide="log-in" width="19" height="19" aria-hidden="true"></i>
                    </span>
                    <div>
                        <span class="pu-stat-label">Último acceso</span>
                        <strong class="pu-stat-value"><?= !empty($usuario['ultimo_acceso']) ? date('d/m/Y · h:i A', strtotime($usuario['ultimo_acceso'])) : 'Sin ingresos registrados' ?></strong>
                    </div>
                </article>
                <article class="pu-stat">
                    <span class="pu-stat-icon">
                        <i data-lucide="calendar-check" width="19" height="19" aria-hidden="true"></i>
                    </span>
                    <div>
                        <span class="pu-stat-label">Fecha de registro</span>
                        <strong class="pu-stat-value"><?= !empty($usuario['creado_en']) ? date('d/m/Y', strtotime($usuario['creado_en'])) : 'No disponible' ?></strong>
                    </div>
                </article>
                <article class="pu-stat">
                    <span class="pu-stat-icon">
                        <i data-lucide="history" width="19" height="19" aria-hidden="true"></i>
                    </span>
                    <div>
                        <span class="pu-stat-label">Última actualización</span>
                        <strong class="pu-stat-value"><?= !empty($usuario['actualizado_en']) ? date('d/m/Y · h:i A', strtotime($usuario['actualizado_en'])) : 'Sin cambios registrados' ?></strong>
                    </div>
                </article>
            </div>
            <div class="pu-divider"></div>
            <div class="pu-detail-grid">
                <section class="pu-panel" aria-labelledby="pu-signature-title">
                    <div class="pu-panel-head">
                        <h2 class="pu-section-heading" id="pu-signature-title">
                            <span class="pu-heading-icon">
                                <i data-lucide="signature" width="17" height="17" aria-hidden="true"></i>
                            </span>
                            Firma digital
                        </h2>
                        <?php if (!empty($usuario['firma_base64'])): ?>
                            <span class="pu-count" title="Firma registrada">
                                <i data-lucide="check" width="14" height="14" aria-hidden="true"></i>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="pu-panel-body">
                        <div class="pu-signature-stage">
                            <?php if (!empty($usuario['firma_base64'])): ?>
                                <img src="<?= htmlspecialchars((string)$usuario['firma_base64'], ENT_QUOTES, 'UTF-8') ?>" alt="Firma digital de <?= htmlspecialchars($nombreUsuario, ENT_QUOTES, 'UTF-8') ?>">
                            <?php else: ?>
                                <div class="pu-empty">
                                    <span class="pu-empty-icon">
                                        <i data-lucide="file-signature" width="21" height="21" aria-hidden="true"></i>
                                    </span>
                                    <strong>Sin firma registrada</strong>
                                    <span>Si corresponde, puedes agregarla desde la edición del perfil.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($usuario['firma_base64'])): ?>
                            <div class="pu-valid">
                                <i data-lucide="badge-check" width="15" height="15" aria-hidden="true"></i>
                                Firma registrada en el perfil
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
                <section class="pu-panel" aria-labelledby="pu-permissions-title">
                    <div class="pu-panel-head">
                        <h2 class="pu-section-heading" id="pu-permissions-title">
                            <span class="pu-heading-icon">
                                <i data-lucide="key-round" width="17" height="17" aria-hidden="true"></i>
                            </span>
                            Permisos de acceso
                        </h2>
                        <span class="pu-count"><?= count($permisosUsuario) ?></span>
                    </div>
                    <div class="pu-panel-body">
                        <?php if (!empty($permisosUsuario)): ?>
                            <div class="pu-permissions">
                                <?php foreach ($permisosUsuario as $permiso): ?>
                                    <span class="pu-permission">
                                        <i data-lucide="check-circle-2" width="14" height="14" aria-hidden="true"></i>
                                        <?= htmlspecialchars(ucwords(str_replace('_', ' ', (string)$permiso)), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="pu-empty">
                                <span class="pu-empty-icon">
                                    <i data-lucide="lock-keyhole" width="21" height="21" aria-hidden="true"></i>
                                </span>
                                <strong>Sin permisos específicos</strong>
                                <span>Este usuario no tiene permisos adicionales asignados.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
<script>
    if (window.lucide) {
        window.lucide.createIcons();
    }
</script>
