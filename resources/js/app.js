import {
    AlertCircle,
    ArrowLeft,
    ArrowRight,
    ArrowUpRight,
    Camera,
    Check,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    Clock,
    Compass,
    ExternalLink,
    Eye,
    EyeOff,
    Fish,
    FolderOpen,
    Globe,
    Image,
    Images,
    Info,
    LayoutDashboard,
    LogOut,
    Mail,
    Map,
    MapPin,
    Maximize2,
    Menu,
    Moon,
    Pencil,
    Phone,
    Plus,
    Settings,
    Share2,
    ShoppingBag,
    Store,
    Sun,
    Trash2,
    Trees,
    Upload,
    User,
    Utensils,
    Waves,
    X,
    createIcons,
} from 'lucide';

const lucideIcons = {
    AlertCircle,
    ArrowLeft,
    ArrowRight,
    ArrowUpRight,
    Camera,
    Check,
    ChevronDown,
    ChevronLeft,
    ChevronRight,
    Clock,
    Compass,
    ExternalLink,
    Eye,
    EyeOff,
    Fish,
    FolderOpen,
    Globe,
    Image,
    Images,
    Info,
    LayoutDashboard,
    LogOut,
    Mail,
    Map,
    MapPin,
    Maximize2,
    Menu,
    Moon,
    Pencil,
    Phone,
    Plus,
    Settings,
    Share2,
    ShoppingBag,
    Store,
    Sun,
    Trash2,
    Trees,
    Upload,
    User,
    Utensils,
    Waves,
    X,
};

function initIcons() {
    createIcons({ icons: lucideIcons });
}

function initThemeToggle() {
    const root = document.documentElement;
    const buttons = document.querySelectorAll('[data-theme-toggle]');

    const applyTheme = (theme) => {
        const isDark = theme === 'dark';
        root.classList.toggle('dark', isDark);
        localStorage.setItem('psb-theme', theme);
        buttons.forEach((btn) => {
            btn.setAttribute('aria-pressed', String(isDark));
            btn.setAttribute('title', isDark ? 'Beralih ke Mode Terang' : 'Beralih ke Mode Gelap');
        });
    };

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(nextTheme);
        });
    });
}

function initMobileMenu() {
    const toggleBtn = document.querySelector('[data-mobile-menu-toggle]');
    const drawer = document.querySelector('[data-mobile-menu]');
    const closeBtns = document.querySelectorAll('[data-mobile-menu-close]');

    if (!toggleBtn || !drawer) return;

    const setOpen = (open) => {
        drawer.classList.toggle('hidden', !open);
        requestAnimationFrame(() => {
            drawer.classList.toggle('opacity-0', !open);
            drawer.classList.toggle('pointer-events-none', !open);
        });
        toggleBtn.setAttribute('aria-expanded', String(open));
        document.body.classList.toggle('overflow-hidden', open);
    };

    toggleBtn.addEventListener('click', () => {
        const isOpen = toggleBtn.getAttribute('aria-expanded') === 'true';
        setOpen(!isOpen);
    });

    closeBtns.forEach((el) => el.addEventListener('click', () => setOpen(false)));

    drawer.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', () => setOpen(false));
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && toggleBtn.getAttribute('aria-expanded') === 'true') {
            setOpen(false);
        }
    });
}

function initHeaderScroll() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;

    const onScroll = () => {
        const scrolled = window.scrollY > 36;
        header.classList.toggle('is-scrolled', scrolled);
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

function initRevealAnimations() {
    const items = document.querySelectorAll('[data-reveal]');
    if (!items.length) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reducedMotion || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -30px 0px' }
    );

    items.forEach((el) => observer.observe(el));
}

function initHeroParallax() {
    const target = document.querySelector('[data-hero-parallax]');
    if (!target) return;

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let ticking = false;
    window.addEventListener(
        'scroll',
        () => {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(() => {
                const offset = Math.min(window.scrollY * 0.18, 90);
                target.style.transform = `translate3d(0, ${offset}px, 0) scale(1.04)`;
                ticking = false;
            });
        },
        { passive: true }
    );
}

function initSpotModal() {
    const modal = document.querySelector('[data-spot-modal]');
    if (!modal) return;

    const imgEl = modal.querySelector('[data-spot-modal-image]');
    const catEl = modal.querySelector('[data-spot-modal-category]');
    const titleEl = modal.querySelector('[data-spot-modal-title]');
    const descEl = modal.querySelector('[data-spot-modal-description]');
    const infoWrap = modal.querySelector('[data-spot-modal-info-wrap]');
    const infoEl = modal.querySelector('[data-spot-modal-info]');
    const closeBtns = modal.querySelectorAll('[data-spot-modal-close]');

    const closeModal = () => {
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    document.querySelectorAll('[data-spot-trigger]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const payload = JSON.parse(btn.getAttribute('data-spot-trigger') || '{}');
            if (imgEl) {
                imgEl.src = payload.image || '';
                imgEl.alt = payload.alt || payload.name || '';
                imgEl.style.objectPosition = payload.focal || 'center center';
                imgEl.parentElement.classList.toggle('hidden', !payload.image);
            }
            if (catEl) catEl.textContent = payload.category || '';
            if (titleEl) titleEl.textContent = payload.name || '';
            if (descEl) descEl.textContent = payload.description || '';
            if (infoWrap && infoEl) {
                infoEl.textContent = payload.additional_info || '';
                infoWrap.classList.toggle('hidden', !payload.additional_info);
            }
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });
    });

    closeBtns.forEach((btn) => btn.addEventListener('click', closeModal));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}

function initGalleryAndLightbox() {
    const filterButtons = document.querySelectorAll('[data-gallery-filter]');
    const tiles = Array.from(document.querySelectorAll('[data-gallery-item]'));
    const lightbox = document.querySelector('[data-lightbox]');

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const category = btn.getAttribute('data-gallery-filter');
            filterButtons.forEach((b) => {
                const active = b === btn;
                b.setAttribute('aria-pressed', String(active));
                b.classList.toggle('bg-ocean', active);
                b.classList.toggle('text-white', active);
                b.classList.toggle('dark:bg-turquoise-bright', active);
                b.classList.toggle('dark:text-charcoal', active);
            });

            tiles.forEach((tile) => {
                const itemCat = tile.getAttribute('data-category');
                const visible = category === 'all' || itemCat === category;
                tile.classList.toggle('hidden', !visible);
            });
        });
    });

    if (!lightbox || !tiles.length) return;

    const imgEl = lightbox.querySelector('[data-lightbox-img]');
    const titleEl = lightbox.querySelector('[data-lightbox-title]');
    const captionEl = lightbox.querySelector('[data-lightbox-caption]');
    const catEl = lightbox.querySelector('[data-lightbox-category]');
    const counterEl = lightbox.querySelector('[data-lightbox-counter]');
    const prevBtn = lightbox.querySelector('[data-lightbox-prev]');
    const nextBtn = lightbox.querySelector('[data-lightbox-next]');
    const closeBtns = lightbox.querySelectorAll('[data-lightbox-close]');

    let activeTiles = [];
    let currentIndex = 0;

    const renderSlide = (index) => {
        if (!activeTiles.length) return;
        currentIndex = (index + activeTiles.length) % activeTiles.length;
        const item = activeTiles[currentIndex];
        const data = JSON.parse(item.getAttribute('data-gallery-item') || '{}');

        if (imgEl) {
            imgEl.src = data.image || '';
            imgEl.alt = data.alt || data.title || '';
        }
        if (titleEl) titleEl.textContent = data.title || '';
        if (captionEl) captionEl.textContent = data.caption || '';
        if (catEl) catEl.textContent = data.category || '';
        if (counterEl) counterEl.textContent = `${currentIndex + 1} / ${activeTiles.length}`;
    };

    const openAtTile = (clickedTile) => {
        activeTiles = tiles.filter((t) => !t.classList.contains('hidden'));
        const idx = activeTiles.indexOf(clickedTile);
        renderSlide(idx >= 0 ? idx : 0);
        lightbox.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    const closeLightbox = () => {
        lightbox.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    tiles.forEach((tile) => {
        tile.addEventListener('click', () => openAtTile(tile));
    });

    prevBtn?.addEventListener('click', () => renderSlide(currentIndex - 1));
    nextBtn?.addEventListener('click', () => renderSlide(currentIndex + 1));
    closeBtns.forEach((btn) => btn.addEventListener('click', closeLightbox));

    document.addEventListener('keydown', (e) => {
        if (lightbox.classList.contains('hidden')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') renderSlide(currentIndex - 1);
        if (e.key === 'ArrowRight') renderSlide(currentIndex + 1);
    });
}

function initAdminHelpers() {
    // Sidebar drawer for mobile admin
    const adminToggle = document.querySelector('[data-admin-sidebar-toggle]');
    const adminSidebar = document.querySelector('[data-admin-sidebar]');
    const adminBackdrop = document.querySelector('[data-admin-backdrop]');

    if (adminToggle && adminSidebar) {
        const setSidebar = (open) => {
            adminSidebar.classList.toggle('-translate-x-full', !open);
            adminBackdrop?.classList.toggle('hidden', !open);
        };
        adminToggle.addEventListener('click', () => {
            const hidden = adminSidebar.classList.contains('-translate-x-full');
            setSidebar(hidden);
        });
        adminBackdrop?.addEventListener('click', () => setSidebar(false));
    }

    // Live image upload preview
    document.querySelectorAll('[data-image-input]').forEach((input) => {
        input.addEventListener('change', (e) => {
            const file = e.target.files?.[0];
            const wrapper = input.closest('[data-image-field]');
            const preview = wrapper?.querySelector('[data-image-preview]');
            const existingInput = wrapper?.querySelector('[data-existing-image-input]');
            const emptyState = wrapper?.querySelector('[data-image-empty]');

            if (!file || !preview) return;

            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
                emptyState?.classList.add('hidden');
                if (existingInput) existingInput.value = '';
            };
            reader.readAsDataURL(file);
        });
    });

    // Existing media library picker inside forms
    document.querySelectorAll('[data-media-pick]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const targetId = btn.getAttribute('data-target-field');
            const path = btn.getAttribute('data-media-path');
            const url = btn.getAttribute('data-media-url');
            const field = document.getElementById(targetId);
            if (!field) return;

            const existingInput = field.querySelector('[data-existing-image-input]');
            const fileInput = field.querySelector('[data-image-input]');
            const preview = field.querySelector('[data-image-preview]');
            const emptyState = field.querySelector('[data-image-empty]');
            const modal = field.querySelector('[data-media-picker-modal]');

            if (existingInput) existingInput.value = path || '';
            if (fileInput) fileInput.value = '';
            if (preview && url) {
                preview.src = url;
                preview.classList.remove('hidden');
            }
            emptyState?.classList.add('hidden');
            modal?.classList.add('hidden');
        });
    });

    document.querySelectorAll('[data-open-media-picker]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const field = btn.closest('[data-image-field]');
            field?.querySelector('[data-media-picker-modal]')?.classList.remove('hidden');
        });
    });

    document.querySelectorAll('[data-close-media-picker]').forEach((btn) => {
        btn.addEventListener('click', () => {
            btn.closest('[data-media-picker-modal]')?.classList.add('hidden');
        });
    });

    // Delete confirmations
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            const msg = form.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus item ini?';
            if (!window.confirm(msg)) {
                e.preventDefault();
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initIcons();
    initThemeToggle();
    initMobileMenu();
    initHeaderScroll();
    initRevealAnimations();
    initHeroParallax();
    initSpotModal();
    initGalleryAndLightbox();
    initAdminHelpers();
});
