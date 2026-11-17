(() => {
    'use strict';

    const root = document.documentElement;
    root.classList.add('js-enabled');
    const preference = window.matchMedia('(prefers-color-scheme: dark)');
    const storageKey = 'cybertech-theme';
    let chosenTheme = 'system';
    try {
        const saved = window.localStorage.getItem(storageKey);
        if (saved === 'light' || saved === 'dark' || saved === 'system') chosenTheme = saved;
    } catch { /* The toggle also works when browser storage is unavailable. */ }

    const applyTheme = theme => {
        root.dataset.theme = theme;
        const dark = theme === 'dark';
        document.querySelectorAll('img[data-dark-src]').forEach(image => {
            const source = dark ? image.dataset.darkSrc : image.dataset.lightSrc;
            if (image.getAttribute('src') !== source) image.setAttribute('src', source);
        });
        document.querySelector('meta[name="theme-color"]')?.setAttribute('content', dark ? '#111318' : '#ffffff');
        document.querySelectorAll('[data-theme-option]').forEach(button => {
            button.setAttribute('aria-pressed', String(button.dataset.themeOption === chosenTheme));
        });
    };

    const applyPreference = () => applyTheme(chosenTheme === 'system' ? (preference.matches ? 'dark' : 'light') : chosenTheme);
    // Apply before the stylesheet loads to avoid flashing the wrong theme.
    applyPreference();
    preference.addEventListener('change', () => {
        if (chosenTheme === 'system') applyPreference();
    });
    document.addEventListener('DOMContentLoaded', () => {
        const control = document.querySelector('.theme-switch');
        if (!control) return;
        applyPreference();
        control.hidden = false;
        control.querySelectorAll('[data-theme-option]').forEach(button => {
            button.addEventListener('click', () => {
                chosenTheme = button.dataset.themeOption;
                applyPreference();
                try { window.localStorage.setItem(storageKey, chosenTheme); } catch { /* Keep the current theme for this visit. */ }
            });
        });
    });
})();
