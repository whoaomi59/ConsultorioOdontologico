<style>
    /* DentalControl · pie de página premium */
    #app-footer {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px 18px;
        padding: 18px clamp(16px, 2.2vw, 30px) !important;
        border-top: 1px solid #e2eaf3 !important;
        color: #7b899d !important;
        background: radial-gradient(ellipse at 90% 0%, rgba(14, 148, 136, 0.055), transparent 36%), linear-gradient(180deg, #ffffff 0%, #f9fbfe 100%) !important;
        font-size: 10px !important;
        line-height: 1.6;
    }
    #app-footer::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        width: min(180px, 30%);
        height: 2px;
        border-radius: 0 4px 4px 0;
        background: linear-gradient(90deg, #315ee8, #0e9488);
    }
    #app-footer .footer-brand {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: #33445f;
        font-weight: 800;
        letter-spacing: 0.025em;
    }
    #app-footer .footer-mark {
        display: inline-grid;
        width: 29px;
        height: 29px;
        place-items: center;
        border: 1px solid #dce7f5;
        border-radius: 10px;
        color: #315ee8;
        background: linear-gradient(145deg, #eef3ff, #e8fbf7);
    }
    #app-footer .footer-note {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #8794a7;
    }
    #app-footer .footer-note svg {
        color: #0e9488;
    }
    @media (max-width: 640px) {
        #app-footer {
            justify-content: center;
            text-align: center;
            padding: 16px !important;
        }
    }
    @media (prefers-reduced-motion: reduce) {
        #app-footer * {
            transition-duration: 0.01ms !important;
        }
    }
</style>
<footer id="app-footer" role="contentinfo">
    <span class="footer-brand">
        <span class="footer-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 3.5c-2.1-1.6-5.7-1.1-7.1 1.3-1.4 2.3-.5 5.1.5 7.1.9 1.8 1.1 4.6 2.4 6.9.7 1.3 2.1 1.8 2.8.2l1.1-3.2c.2-.6.5-.9.8-.9s.6.3.8.9l1.1 3.2c.7 1.6 2.1 1.1 2.8-.2 1.3-2.3 1.5-5.1 2.4-6.9 1-2 1.9-4.8.5-7.1C17.7 2.4 14.1 1.9 12 3.5Z"/>
            </svg>
        </span>
        <span>DentalControl</span>
    </span>
    <span>&copy; <?= date('Y') ?> DentalControl · Sistema de Gestión Odontológica</span>
    <span class="footer-note">
        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 3 19 6v5c0 4.6-3 7.8-7 10-4-2.2-7-5.4-7-10V6l7-3Z"/>
            <path d="m9 12 2 2 4-4"/>
        </svg>
        Gestión clínica integral
    </span>
</footer>
</div>
</body>
</html>
