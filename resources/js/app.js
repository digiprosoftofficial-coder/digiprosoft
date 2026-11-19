/**
 * DigiProSoft front-end enhancements.
 * Vanilla JS only. Every feature degrades gracefully without JavaScript.
 */

document.documentElement.classList.remove('no-js');

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/* ------------------------------------------------------------------
   Sticky header shadow
   ------------------------------------------------------------------ */
function initHeader() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;

    const update = () => header.toggleAttribute('data-scrolled', window.scrollY > 8);
    update();
    window.addEventListener('scroll', update, { passive: true });
}

/* ------------------------------------------------------------------
   Mobile navigation (accessible dialog-like panel)
   ------------------------------------------------------------------ */
function initMobileNav() {
    const toggle = document.querySelector('[data-nav-toggle]');
    const panel = document.querySelector('[data-nav-panel]');
    const closeBtn = document.querySelector('[data-nav-close]');
    if (!toggle || !panel) return;

    const focusableSelector =
        'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
    let lastFocused = null;

    const open = () => {
        lastFocused = document.activeElement;
        panel.hidden = false;
        // Allow the browser to paint before animating.
        requestAnimationFrame(() => panel.setAttribute('data-open', ''));
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
        const first = panel.querySelector(focusableSelector);
        (closeBtn || first)?.focus();
        document.addEventListener('keydown', onKeydown);
    };

    const close = () => {
        panel.removeAttribute('data-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        const finish = () => {
            panel.hidden = true;
        };
        if (reducedMotion.matches) finish();
        else setTimeout(finish, 220);
        lastFocused?.focus();
    };

    const onKeydown = (event) => {
        if (event.key === 'Escape') {
            event.preventDefault();
            close();
            return;
        }
        if (event.key !== 'Tab') return;
        const focusable = Array.from(panel.querySelectorAll(focusableSelector));
        if (!focusable.length) return;
        const first = focusable[0];
        const last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    };

    toggle.addEventListener('click', () => {
        toggle.getAttribute('aria-expanded') === 'true' ? close() : open();
    });
    closeBtn?.addEventListener('click', close);
    panel.addEventListener('click', (event) => {
        if (event.target.matches('[data-nav-backdrop]') || event.target.closest('a[href]')) close();
    });

    // Close if the viewport grows past the mobile breakpoint.
    const mq = window.matchMedia('(min-width: 1024px)');
    mq.addEventListener('change', (e) => {
        if (e.matches && toggle.getAttribute('aria-expanded') === 'true') close();
    });
}

/* ------------------------------------------------------------------
   Desktop dropdown menus (keyboard + pointer)
   ------------------------------------------------------------------ */
function initDropdowns() {
    const dropdowns = document.querySelectorAll('[data-dropdown]');
    if (!dropdowns.length) return;

    const closeAll = (except) => {
        dropdowns.forEach((d) => {
            if (d !== except) {
                d.removeAttribute('data-open');
                d.querySelector('[data-dropdown-toggle]')?.setAttribute('aria-expanded', 'false');
            }
        });
    };

    dropdowns.forEach((dropdown) => {
        const btn = dropdown.querySelector('[data-dropdown-toggle]');
        if (!btn) return;
        let hoverTimer;

        const setOpen = (state) => {
            dropdown.toggleAttribute('data-open', state);
            btn.setAttribute('aria-expanded', String(state));
        };

        btn.addEventListener('click', (event) => {
            event.preventDefault();
            const isOpen = dropdown.hasAttribute('data-open');
            closeAll(dropdown);
            setOpen(!isOpen);
        });

        dropdown.addEventListener('pointerenter', (e) => {
            if (e.pointerType !== 'mouse') return;
            clearTimeout(hoverTimer);
            closeAll(dropdown);
            setOpen(true);
        });
        dropdown.addEventListener('pointerleave', (e) => {
            if (e.pointerType !== 'mouse') return;
            hoverTimer = setTimeout(() => setOpen(false), 120);
        });
        dropdown.addEventListener('focusout', (e) => {
            if (!dropdown.contains(e.relatedTarget)) setOpen(false);
        });
        dropdown.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                setOpen(false);
                btn.focus();
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('[data-dropdown]')) closeAll();
    });
}

/* ------------------------------------------------------------------
   Reveal on scroll (IntersectionObserver, respects reduced motion)
   ------------------------------------------------------------------ */
function initReveal() {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    if (reducedMotion.matches || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('reveal-visible'));
        return;
    }

    const io = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-visible');
                    io.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.08 }
    );
    items.forEach((el) => io.observe(el));
}

/* ------------------------------------------------------------------
   Dismissible flash messages
   ------------------------------------------------------------------ */
function initDismiss() {
    document.querySelectorAll('[data-dismiss]').forEach((btn) => {
        btn.addEventListener('click', () => btn.closest('[data-dismissible]')?.remove());
    });
}

/* ------------------------------------------------------------------
   Share dialog (native <dialog> so it stacks above the sticky header)
   ------------------------------------------------------------------ */
function initShareDialog() {
    const widgets = document.querySelectorAll('[data-share]');
    if (!widgets.length) return;

    widgets.forEach((widget) => {
        const toggle = widget.querySelector('[data-share-open]');
        const dialog = widget.querySelector('[data-share-dialog]');
        const closeBtn = widget.querySelector('[data-share-close]');
        const copyBtn = widget.querySelector('[data-share-copy]');
        const urlInput = widget.querySelector('[data-share-url]');
        const status = widget.querySelector('[data-share-status]');
        if (!toggle || !dialog || typeof dialog.showModal !== 'function') return;

        let lastFocused = null;
        let copyTimer;

        const open = () => {
            lastFocused = document.activeElement;
            if (!dialog.open) dialog.showModal();
            toggle.setAttribute('aria-expanded', 'true');
            closeBtn?.focus();
        };

        const close = () => {
            if (dialog.open) dialog.close();
        };

        dialog.addEventListener('close', () => {
            toggle.setAttribute('aria-expanded', 'false');
            lastFocused?.focus();
        });

        dialog.addEventListener('click', (event) => {
            const rect = dialog.getBoundingClientRect();
            const inside =
                event.clientX >= rect.left &&
                event.clientX <= rect.right &&
                event.clientY >= rect.top &&
                event.clientY <= rect.bottom;
            if (!inside) close();
        });

        const copyUrl = async () => {
            const value = urlInput?.value ?? '';
            if (!value || !copyBtn) return;

            let copied = false;
            try {
                await navigator.clipboard.writeText(value);
                copied = true;
            } catch {
                urlInput?.select();
                copied = document.execCommand('copy');
            }

            if (!copied) {
                urlInput?.select();
                if (status) status.textContent = 'Select the link and copy it.';
                return;
            }

            const idleLabel = copyBtn.dataset.idleLabel ?? copyBtn.textContent.trim();
            copyBtn.dataset.idleLabel = idleLabel;
            copyBtn.textContent = 'Copied';
            if (status) status.textContent = 'Link copied to clipboard.';
            clearTimeout(copyTimer);
            copyTimer = setTimeout(() => {
                copyBtn.textContent = idleLabel;
                if (status) status.textContent = '';
            }, 2000);
        };

        toggle.addEventListener('click', open);
        closeBtn?.addEventListener('click', close);
        copyBtn?.addEventListener('click', copyUrl);
    });
}

initHeader();
initMobileNav();
initDropdowns();
initReveal();
initDismiss();
initShareDialog();
