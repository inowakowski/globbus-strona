/* GLOBBUS Travel Agency — skrypty strony.
   Wszystko jest opcjonalne: bez JavaScriptu strona nadal działa,
   menu jest rozwinięte, a zdjęcia otwierają się jako zwykłe odnośniki. */

(function () {
    'use strict';

    // Zdejmij klasę no-js jak najwcześniej, żeby CSS wiedział, że skrypty działają.
    document.documentElement.classList.remove('no-js');

    /* ---------------------------------------------------------------
       Menu na telefonie
       --------------------------------------------------------------- */
    var toggle = document.querySelector('.nav-toggle');
    var header = document.querySelector('.site-header');

    if (toggle && header) {
        // Czy menu jest rozwinięte, decyduje klasa na nagłówku. Poza szerokością
        // telefonu CSS i tak pokazuje menu zawsze, więc ta klasa nic tam nie psuje.
        var closeMenu = function () {
            header.classList.remove('is-menu-open');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', function () {
            var open = header.classList.toggle('is-menu-open');
            toggle.setAttribute('aria-expanded', String(open));
        });

        // Escape zamyka menu i wraca focusem na przycisk.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && header.classList.contains('is-menu-open')) {
                closeMenu();
                toggle.focus();
            }
        });
    }

    /* ---------------------------------------------------------------
       Nagłówek: przezroczysty nad zdjęciem, pełny po przewinięciu
       --------------------------------------------------------------- */
    var header = document.querySelector('.site-header');

    if (header && header.classList.contains('is-transparent')) {
        var onScroll = function () {
            header.classList.toggle('is-transparent', window.scrollY < 60);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ---------------------------------------------------------------
       Podgląd zdjęć w galerii
       --------------------------------------------------------------- */
    var lightbox = document.querySelector('.lightbox');

    if (lightbox) {
        var lbImage = lightbox.querySelector('img');
        var lbCaption = lightbox.querySelector('.lightbox__caption');
        var lastFocused = null;

        var open = function (src, alt) {
            lastFocused = document.activeElement;
            lbImage.src = src;
            lbImage.alt = alt;
            if (lbCaption) {
                lbCaption.textContent = alt;
            }
            lightbox.hidden = false;
            document.body.style.overflow = 'hidden';
            lightbox.querySelector('.lightbox__close').focus();
        };

        var close = function () {
            lightbox.hidden = true;
            lbImage.removeAttribute('src');
            document.body.style.overflow = '';
            if (lastFocused) {
                lastFocused.focus();
            }
        };

        document.querySelectorAll('.gallery button').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var thumb = btn.querySelector('img');
                // data-full wskazuje wersję w pełnej rozdzielczości.
                open(btn.dataset.full || thumb.src, thumb.alt);
            });
        });

        lightbox.querySelector('.lightbox__close').addEventListener('click', close);

        // Kliknięcie w tło (poza samym zdjęciem) też zamyka.
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                close();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !lightbox.hidden) {
                close();
            }
        });
    }
})();
