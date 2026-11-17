(() => {
    'use strict';

    const root = document.documentElement;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const started = Date.now();
    let finished = false;
    let revealTimer;
    let cleanupTimer;
    let navigationTimer;
    const cleanup = () => {
        root.classList.remove('is-preloading', 'preloader-exiting');
        root.removeAttribute('aria-busy');
    };
    const show = () => {
        window.clearTimeout(revealTimer);
        window.clearTimeout(cleanupTimer);
        root.classList.remove('preloader-exiting');
        root.classList.add('is-preloading');
        root.setAttribute('aria-busy', 'true');
    };
    const finish = () => {
        if (finished) return;
        finished = true;
        window.clearTimeout(safetyTimer);
        // Give the requested logo reveal a brief moment on fast page loads.
        const remaining = reducedMotion.matches ? 0 : Math.max(0, 600 - (Date.now() - started));
        revealTimer = window.setTimeout(() => {
            root.classList.add('preloader-exiting');
            root.removeAttribute('aria-busy');
            cleanupTimer = window.setTimeout(cleanup, reducedMotion.matches ? 0 : 240);
        }, remaining);
    };
    show();
    const safetyTimer = window.setTimeout(finish, 2500);
    document.addEventListener('DOMContentLoaded', () => {
        if (finished) return;
        const image = document.querySelector('#site-preloader img');
        if (!image || image.complete) {
            finish();
        } else {
            image.addEventListener('load', finish, { once: true });
            image.addEventListener('error', finish, { once: true });
        }
    });
    document.addEventListener('click', event => {
        if (event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;
        const link = event.target.closest('a[href]');
        if (!link || link.hasAttribute('download') || (link.target && link.target !== '_self')) return;
        const destination = new URL(link.href, window.location.href);
        if (destination.origin !== window.location.origin) return;
        if (destination.pathname === window.location.pathname && destination.search === window.location.search) return;
        show();
        // Restore the current page if navigation is cancelled or interrupted.
        window.clearTimeout(navigationTimer);
        navigationTimer = window.setTimeout(cleanup, 4000);
    });
    window.addEventListener('pageshow', event => {
        if (event.persisted) {
            finished = true;
            [safetyTimer, revealTimer, cleanupTimer, navigationTimer].forEach(timer => window.clearTimeout(timer));
            cleanup();
        }
    });
})();
