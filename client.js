(function injectMobileCSS() { const style = document.createElement('style'); style.textContent = `
@media (max-width: 768px) {
    /* FIX: Agar Layar Lobi Bisa Di-scroll dan Chat Tidak Menutupi */
    #lobby-screen { flex-direction: column !important; overflow-y: auto !important; padding-bottom: 20px !important; }
    .lobby-main { padding: 10px !important; flex: none !important; overflow: visible !important; }
    .lobby-sidebar { display: flex !important; width: 100% !important; height: 350px !important; min-height: 350px !important; border-left: none !important; border-top: 3px solid var(--teal) !important; margin-top: 0px !important; flex-shrink: 0 !important; }

    /* KODE BAWAAN LAINNYA TETAP AMAN */
    .panels-grid { grid-template-columns: 1fr !important; gap: 10px !important; }
    .panel-card { min-height: unset !important; }
    .topbar { padding: 0 10px !important; height: 54px !important; }
    .topbar-center { font-size: 13px !important; letter-spacing: 2px !important; }
    .user-name { font-size: 12px !important; }
    .level-text { font-size: 10px !important; }
    .xp-bar-bg { width: 80px !important; }
    .btn-topbar { font-size: 10px !important; padding: 6px 10px !important; }
    .server-status-badge { display: none !important; }
    .login-box { padding: 28px 20px !important; margin: 0 12px !important; }
    .room-waiting-container { padding: 10px !important; }
    .slots-grid { grid-template-columns: 1fr 1fr !important; gap: 8px !important; }
    .rw-actions { flex-direction: column !important; }
    .btn-rw { padding: 12px !important; }
    #game-ui-top { padding: 8px 12px !important; }
    .timer-display { font-size: 18px !important; }
    .btn-exit { font-size: 10px !important; padding: 8px 12px !important; }
    #round-indicator { font-size: 11px !important; }
    .trash-item { width: 70px !important; height: 70px !important; }
    .icon-good, .icon-bad, .icon-bonus { font-size: 2rem !important; }
    #stats-panel { gap: 8px !important; width: 96% !important; }
    .stat-box { padding: 8px 10px !important; min-width: 70px !important; }
    .stat-val { font-size: 0.9rem !important; }
    .result-box { padding: 24px 16px !important; margin: 0 12px !important; }
} `; document.head.appendChild(style); })();
