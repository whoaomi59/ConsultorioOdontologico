<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#101d38">
        <title>Iniciar sesión — Clínica Odontológica</title>
        <script src="https://cdn.tailwindcss.com">
        </script>
        <script src="https://unpkg.com/lucide@latest">
        </script>
        <style>
            :root {
                --ink: #17243b;
                --muted: #718096;
                --line: #e4ebf4;
                --blue: #315ee8;
                --teal: #0e9488;
            }
            * {
                box-sizing: border-box;
            }
            body {
                margin: 0;
                min-height: 100vh;
                color: var(--ink);
                background:
                    radial-gradient(ellipse at 12% 8%, rgba(49, 94, 232, 0.1), transparent 34%),
                    radial-gradient(ellipse at 92% 88%, rgba(14, 148, 136, 0.1), transparent 32%), #f3f6fb;
                font-family:
                    Inter,
                    ui-sans-serif,
                    system-ui,
                    -apple-system,
                    BlinkMacSystemFont,
                    'Segoe UI',
                    sans-serif;
            }
            .login-layout {
                width: min(1160px, 100%);
                min-height: min(740px, calc(100vh - 48px));
                margin: 24px auto;
                display: grid;
                grid-template-columns: 1.02fr 0.98fr;
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(228, 235, 244, 0.95);
                border-radius: 30px;
                overflow: hidden;
                box-shadow:
                    0 30px 90px rgba(23, 36, 59, 0.13),
                    0 5px 18px rgba(23, 36, 59, 0.04);
            }
            .brand-panel {
                position: relative;
                isolation: isolate;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                overflow: hidden;
                padding: clamp(30px, 5vw, 58px);
                color: white;
                background: linear-gradient(135deg, #101b33 0%, #1f3d83 52%, #087f86 100%);
            }
            .brand-panel::before {
                content: '';
                position: absolute;
                z-index: -1;
                inset: 0;
                opacity: 0.13;
                background-image: linear-gradient(rgba(255, 255, 255, 0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.3) 1px, transparent 1px);
                background-size: 34px 34px;
                mask-image: linear-gradient(135deg, black, transparent 85%);
            }
            .brand-panel::after {
                content: '';
                position: absolute;
                z-index: -1;
                width: 440px;
                height: 440px;
                right: -170px;
                top: 15%;
                border: 1px solid rgba(255, 255, 255, 0.17);
                border-radius: 50%;
                box-shadow:
                    0 0 0 36px rgba(255, 255, 255, 0.035),
                    0 0 0 76px rgba(255, 255, 255, 0.025);
            }
            .brand-mark {
                width: 54px;
                height: 54px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: 1px solid rgba(255, 255, 255, 0.28);
                border-radius: 18px;
                background: rgba(255, 255, 255, 0.13);
                box-shadow:
                    inset 0 1px 0 rgba(255, 255, 255, 0.2),
                    0 12px 26px rgba(0, 0, 0, 0.12);
                backdrop-filter: blur(10px);
            }
            .eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 9px;
                font-size: 11px;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(255, 255, 255, 0.74);
            }
            .eyebrow-dot {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                background: #65e6d1;
                box-shadow: 0 0 0 5px rgba(101, 230, 209, 0.13);
            }
            .brand-title {
                max-width: 470px;
                margin: 22px 0 18px;
                font-size: clamp(32px, 4.2vw, 51px);
                line-height: 1.07;
                letter-spacing: -0.045em;
                font-weight: 800;
            }
            .brand-title span {
                color: #8ce8dd;
            }
            .brand-copy {
                max-width: 390px;
                font-size: 14px;
                line-height: 1.85;
                color: rgba(255, 255, 255, 0.75);
            }
            .feature-list {
                display: grid;
                gap: 15px;
                margin-top: 34px;
            }
            .feature-item {
                display: flex;
                align-items: center;
                gap: 12px;
                color: rgba(255, 255, 255, 0.9);
                font-size: 12px;
                font-weight: 600;
            }
            .feature-icon {
                width: 34px;
                height: 34px;
                display: grid;
                place-items: center;
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 12px;
                background: rgba(255, 255, 255, 0.09);
            }
            .brand-footer {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-top: 44px;
                color: rgba(255, 255, 255, 0.58);
                font-size: 10px;
            }
            .secure-note {
                display: inline-flex;
                align-items: center;
                gap: 7px;
            }
            .form-panel {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: clamp(28px, 5vw, 66px);
                background: rgba(255, 255, 255, 0.92);
            }
            .form-inner {
                width: 100%;
                max-width: 370px;
            }
            .mobile-brand {
                display: none;
            }
            .form-kicker {
                margin-bottom: 12px;
                color: var(--teal);
                font-size: 10px;
                font-weight: 800;
                letter-spacing: 0.18em;
                text-transform: uppercase;
            }
            .form-title {
                margin: 0;
                color: var(--ink);
                font-size: clamp(27px, 3vw, 35px);
                font-weight: 800;
                line-height: 1.15;
                letter-spacing: -0.04em;
            }
            .form-subtitle {
                margin: 12px 0 30px;
                color: var(--muted);
                font-size: 13px;
                line-height: 1.7;
            }
            .field {
                margin-top: 20px;
            }
            .field-label {
                display: block;
                margin-bottom: 9px;
                color: #34435c;
                font-size: 11px;
                font-weight: 800;
            }
            .input-wrap {
                position: relative;
            }
            .input-icon {
                position: absolute;
                left: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #8a98ad;
                pointer-events: none;
            }
            .field-input {
                display: block;
                width: 100%;
                height: 52px;
                padding: 0 46px 0 44px;
                border: 1px solid #dfe7f1;
                border-radius: 14px;
                outline: none;
                color: #17243b;
                background: #f8fafd;
                font-size: 12px;
                transition:
                    border-color 0.2s,
                    box-shadow 0.2s,
                    background 0.2s;
            }
            .field-input::placeholder {
                color: #a1adbd;
            }
            .field-input:hover {
                border-color: #c8d5e7;
            }
            .field-input:focus {
                border-color: #4770ed;
                background: #fff;
                box-shadow: 0 0 0 4px rgba(49, 94, 232, 0.11);
            }
            .toggle-password {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                width: 32px;
                height: 32px;
                display: grid;
                place-items: center;
                border: 0;
                border-radius: 9px;
                color: #8996aa;
                background: transparent;
                cursor: pointer;
            }
            .toggle-password:hover {
                color: var(--blue);
                background: #edf2ff;
            }
            .submit-button {
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 10px;
                width: 100%;
                min-height: 53px;
                margin-top: 27px;
                border: 0;
                border-radius: 14px;
                color: white;
                background: linear-gradient(105deg, #315ee8, #2849b8 58%, #087f86);
                box-shadow: 0 12px 24px rgba(49, 94, 232, 0.23);
                font-size: 12px;
                font-weight: 800;
                cursor: pointer;
                transition:
                    transform 0.2s,
                    box-shadow 0.2s,
                    filter 0.2s;
            }
            .submit-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 16px 30px rgba(49, 94, 232, 0.28);
                filter: saturate(1.08);
            }
            .submit-button:active {
                transform: translateY(0);
            }
            .submit-button:focus-visible,
            .toggle-password:focus-visible {
                outline: 3px solid rgba(49, 94, 232, 0.35);
                outline-offset: 3px;
            }
            .error-box {
                display: flex;
                align-items: flex-start;
                gap: 10px;
                padding: 13px 14px;
                margin: 0 0 20px;
                border: 1px solid #fecdd3;
                border-radius: 13px;
                color: #be123c;
                background: #fff1f2;
                font-size: 11px;
                line-height: 1.55;
            }
            .form-footnote {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                margin-top: 24px;
                color: #8491a5;
                font-size: 10px;
            }
            .form-divider {
                height: 1px;
                margin-top: 28px;
                background: linear-gradient(90deg, transparent, #e3eaf3, transparent);
            }
            .copyright {
                margin-top: 20px;
                color: #a0aaba;
                text-align: center;
                font-size: 10px;
            }
            @media (max-width: 760px) {
                body {
                    padding: 14px;
                }
                .login-layout {
                    width: 100%;
                    min-height: auto;
                    margin: 0 auto;
                    grid-template-columns: 1fr;
                    border-radius: 24px;
                }
                .brand-panel {
                    display: none;
                }
                .form-panel {
                    padding: 34px 25px 28px;
                }
                .mobile-brand {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 35px;
                }
                .mobile-brand .brand-mark {
                    color: white;
                    background: linear-gradient(135deg, #1d3d85, #087f86);
                    border: 0;
                }
                .mobile-brand-name {
                    color: var(--ink);
                    font-size: 12px;
                    font-weight: 850;
                }
                .mobile-brand-caption {
                    margin-top: 3px;
                    color: var(--muted);
                    font-size: 10px;
                }
                .form-title {
                    font-size: 30px;
                }
                .form-subtitle {
                    margin-bottom: 24px;
                }
            }
            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    transition-duration: 0.01ms !important;
                    animation-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }
            }
        </style>
    </head>
    <body class="min-h-screen flex items-center justify-center p-4">
        <main class="login-layout">
            <section class="brand-panel" aria-label="Presentación del consultorio">
                <div>
                    <div class="brand-mark">
                        <i data-lucide="stethoscope" style="width:27px;height:27px"></i>
                    </div>
                    <div style="margin-top: 30px" class="eyebrow">
                        <span class="eyebrow-dot"></span>
                        Gestión clínica integral
                    </div>
                    <h2 class="brand-title">
                        Una sonrisa sana empieza con una
                        <span>buena gestión.</span>
                    </h2>
                    <p class="brand-copy">Tu espacio de trabajo para organizar pacientes, citas y registros clínicos con una experiencia clara, moderna y segura.</p>
                    <div class="feature-list">
                        <div class="feature-item">
                            <span class="feature-icon">
                                <i data-lucide="calendar-check" style="width:16px;height:16px"></i>
                            </span>
                            Agenda y seguimiento de citas
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">
                                <i data-lucide="clipboard-plus" style="width:16px;height:16px"></i>
                            </span>
                            Historias clínicas centralizadas
                        </div>
                        <div class="feature-item">
                            <span class="feature-icon">
                                <i data-lucide="users-round" style="width:16px;height:16px"></i>
                            </span>
                            Información organizada por paciente
                        </div>
                    </div>
                </div>
                <div class="brand-footer">
                    <span>CLÍNICA ODONTOLÓGICA</span>
                    <span class="secure-note">
                        <i data-lucide="shield-check" style="width:14px;height:14px"></i>
                        Acceso protegido
                    </span>
                </div>
            </section>
            <section class="form-panel">
                <div class="form-inner">
                    <div class="mobile-brand">
                        <div class="brand-mark">
                            <i data-lucide="stethoscope" style="width:25px;height:25px"></i>
                        </div>
                        <div><div class="mobile-brand-name">CLÍNICA ODONTOLÓGICA</div><div class="mobile-brand-caption">Sistema de gestión clínica</div></div>
                    </div>
                    <div class="form-kicker">Portal de acceso</div>
                    <h1 class="form-title">Bienvenido de nuevo</h1>
                    <p class="form-subtitle">Ingresa tus credenciales para continuar con tu jornada.</p>
                    <?php if (!empty($_SESSION['error'])): ?>
                        <div class="error-box" role="alert">
                            <i data-lucide="alert-circle" style="width:17px;height:17px;flex-shrink:0;margin-top:1px"></i>
                            <span><?= htmlspecialchars((string) $_SESSION['error'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['error']); ?></span>
                        </div>
                    <?php endif; ?>
                    <form action="<?= BASE_URL ?>/auth/login" method="POST" autocomplete="on">
                        <div class="field">
                            <label class="field-label" for="email">Correo electrónico</label>
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <i data-lucide="mail" style="width:17px;height:17px"></i>
                                </span>
                                <input id="email" class="field-input" type="email" name="email" required autocomplete="username" placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                        <div class="field">
                            <label class="field-label" for="password">Contraseña</label>
                            <div class="input-wrap">
                                <span class="input-icon">
                                    <i data-lucide="lock-keyhole" style="width:17px;height:17px"></i>
                                </span>
                                <input id="password" class="field-input" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                                <button class="toggle-password" type="button" id="togglePassword" aria-label="Mostrar contraseña" aria-pressed="false">
                                    <i data-lucide="eye" style="width:17px;height:17px"></i>
                                </button>
                            </div>
                        </div>
                        <button class="submit-button" type="submit">
                            <span>Iniciar sesión</span>
                            <i data-lucide="arrow-right" style="width:17px;height:17px"></i>
                        </button>
                    </form>
                    <div class="form-divider"></div>
                    <div class="form-footnote">
                        <i data-lucide="shield-check" style="width:15px;height:15px;color:#0e9488"></i>
                        Tus credenciales se utilizan para acceder al sistema.
                    </div>
                    <div class="copyright">© <?= date('Y'); ?> Clínica Odontológica · Todos los derechos reservados</div>
                </div>
            </section>
        </main>
        <script>
            if (window.lucide) lucide.createIcons();
            
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            
            togglePassword.addEventListener('click', function () {
                const showing = passwordInput.type === 'password';
                passwordInput.type = showing ? 'text' : 'password';
                this.setAttribute('aria-pressed', showing ? 'true' : 'false');
                this.setAttribute('aria-label', showing ? 'Ocultar contraseña' : 'Mostrar contraseña');
                this.innerHTML = showing ? '<i data-lucide="eye-off" style="width:17px;height:17px"></i>' : '<i data-lucide="eye" style="width:17px;height:17px"></i>';
                if (window.lucide) lucide.createIcons();
            });
        </script>
    </body>
</html>
