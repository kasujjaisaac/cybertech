(() => {
    'use strict';

    const hero = document.querySelector('.hero');
    if (hero) {
        const slides = [...hero.querySelectorAll('.hero-slide')];
        const controls = hero.querySelector('.hero-controls');
        const dots = [...hero.querySelectorAll('[data-hero-slide]')];
        const status = hero.querySelector('[data-hero-status]');
        const motion = window.matchMedia('(prefers-reduced-motion: reduce)');
        let current = 0;
        let paused = motion.matches;
        let keyboardFocus = false;
        let timer;
        const stop = () => window.clearInterval(timer);
        const positionControls = () => {
            const visual = slides[current].querySelector('.hero-visual');
            const panel = visual.getBoundingClientRect();
            const section = hero.getBoundingClientRect();
            hero.style.setProperty('--hero-control-top', `${panel.top - section.top + panel.height / 2}px`);
        };
        const show = (index, manual = false) => {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, position) => { slide.hidden = position !== current; });
            dots.forEach((dot, position) => dot.setAttribute('aria-current', String(position === current)));
            status.setAttribute('aria-live', manual ? 'polite' : 'off');
            status.textContent = `Slide ${current + 1} of ${slides.length}`;
            window.requestAnimationFrame(positionControls);
        };
        const schedule = () => {
            stop();
            if (!paused && !document.hidden && !keyboardFocus) {
                timer = window.setInterval(() => show(current + 1), 6500);
            }
        };
        const navigate = index => { show(index, true); schedule(); };
        hero.querySelector('[data-hero-prev]').addEventListener('click', () => navigate(current - 1));
        hero.querySelector('[data-hero-next]').addEventListener('click', () => navigate(current + 1));
        dots.forEach(dot => dot.addEventListener('click', () => navigate(Number(dot.dataset.heroSlide))));
        controls.addEventListener('keydown', event => {
            if (event.key === 'ArrowLeft' || event.key === 'ArrowRight') {
                event.preventDefault();
                navigate(current + (event.key === 'ArrowRight' ? 1 : -1));
            }
        });
        hero.addEventListener('focusin', event => {
            keyboardFocus = event.target.matches(':focus-visible');
            schedule();
        });
        hero.addEventListener('focusout', () => window.setTimeout(() => {
            keyboardFocus = hero.contains(document.activeElement) && document.activeElement.matches(':focus-visible');
            schedule();
        }, 0));
        document.addEventListener('visibilitychange', schedule);
        motion.addEventListener('change', () => { paused = motion.matches; schedule(); });
        controls.hidden = false;
        positionControls();
        if ('ResizeObserver' in window) {
            new ResizeObserver(positionControls).observe(hero);
        } else {
            window.addEventListener('resize', positionControls);
        }
        schedule();
    }

    const menu = document.querySelector('.menu-toggle');
    const nav = document.querySelector('#main-nav');
    const closeMenu = () => {
        nav.classList.remove('is-open');
        menu.setAttribute('aria-expanded', 'false');
        menu.setAttribute('aria-label', 'Open navigation');
    };
    menu.addEventListener('click', () => {
        const open = menu.getAttribute('aria-expanded') !== 'true';
        nav.classList.toggle('is-open', open);
        menu.setAttribute('aria-expanded', String(open));
        menu.setAttribute('aria-label', open ? 'Close navigation' : 'Open navigation');
    });
    nav.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && menu.getAttribute('aria-expanded') === 'true') {
            closeMenu();
            menu.focus();
        }
    });
    window.matchMedia('(max-width: 900px)').addEventListener('change', event => {
        if (!event.matches) closeMenu();
    });
    document.addEventListener('click', event => { if (!event.target.closest('.site-header')) closeMenu(); });

    if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.classList.add('js-motion');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });
        document.querySelectorAll('.reveal').forEach(element => observer.observe(element));
    }

    const solutionDialog = document.querySelector('#solution-dialog');
    const solutionCta = document.querySelector('#solution-cta');
    if (solutionDialog && solutionCta) {
        solutionDialog.setAttribute('aria-labelledby', 'solution-title');
        document.querySelectorAll('[data-solution]').forEach(link => {
            link.addEventListener('click', event => {
                if (typeof solutionDialog.showModal !== 'function') return;
                event.preventDefault();
                document.querySelector('#solution-title').textContent = link.dataset.title;
                document.querySelector('#solution-description').textContent = link.dataset.description;
                solutionCta.href = link.href;
                solutionDialog.showModal();
            });
        });
        solutionCta.addEventListener('click', () => solutionDialog.close());
    }

    const productCards = [...document.querySelectorAll('.product-card')];
    const filters = document.querySelectorAll('[data-filter]');
    filters.forEach(button => {
        button.setAttribute('aria-controls', 'products-grid');
        button.addEventListener('click', () => {
            filters.forEach(filter => {
                filter.setAttribute('aria-pressed', String(filter === button));
                filter.classList.toggle('is-active', filter === button);
            });
            productCards.forEach(card => {
                card.hidden = button.dataset.filter !== 'all' && card.dataset.category !== button.dataset.filter;
                if (!card.hidden) card.classList.add('is-visible');
            });
            const count = productCards.filter(card => !card.hidden).length;
            document.querySelector('#filter-status').textContent = `${count} ${count === 1 ? 'system' : 'systems'} shown`;
        });
    });
    const gallery = [...document.querySelectorAll('[data-gallery]')];
    const galleryDialog = document.querySelector('#gallery-dialog');
    if (galleryDialog && gallery.length) {
        let activePhoto = 0;
        const showPhoto = index => {
            activePhoto = (index + gallery.length) % gallery.length;
            const photo = gallery[activePhoto];
            const image = document.querySelector('#gallery-image');
            image.src = photo.dataset.gallery;
            image.alt = photo.querySelector('img').alt;
            document.querySelector('#gallery-caption').textContent = photo.dataset.caption;
            document.querySelector('#gallery-count').textContent = `${activePhoto + 1} / ${gallery.length}`;
        };
        gallery.forEach((photo, index) => photo.addEventListener('click', event => {
            if (typeof galleryDialog.showModal !== 'function') return;
            event.preventDefault();
            showPhoto(index);
            galleryDialog.showModal();
        }));
        document.querySelector('#gallery-prev').addEventListener('click', () => showPhoto(activePhoto - 1));
        document.querySelector('#gallery-next').addEventListener('click', () => showPhoto(activePhoto + 1));
        galleryDialog.addEventListener('keydown', event => {
            if (event.key === 'ArrowLeft') { event.preventDefault(); showPhoto(activePhoto - 1); }
            if (event.key === 'ArrowRight') { event.preventDefault(); showPhoto(activePhoto + 1); }
        });
    }
    document.querySelectorAll('[data-close-dialog]').forEach(button => {
        button.addEventListener('click', () => button.closest('dialog').close());
    });
    document.querySelectorAll('dialog').forEach(dialog => {
        dialog.addEventListener('click', event => {
            if (event.target !== dialog) return;
            const rect = dialog.getBoundingClientRect();
            if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) dialog.close();
        });
    });
    const form = document.querySelector('#inquiry-form');
    if (form) form.addEventListener('submit', () => {
        const button = form.querySelector('[type="submit"]');
        button.disabled = true;
        button.textContent = 'Sending your enquiry…';
    });
    window.addEventListener('pageshow', () => {
        const button = document.querySelector('.form-submit');
        if (button) { button.disabled = false; button.textContent = 'Send my enquiry'; }
    });
    if (document.querySelector('.form-errors')) {
        document.querySelector('#contact').scrollIntoView();
        const invalidField = document.querySelector('[aria-invalid="true"]');
        if (invalidField) invalidField.focus({ preventScroll: true });
    }
})();
