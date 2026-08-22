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

/* ===================================================================
   Zgoda na ciasteczka podmiotów trzecich
   -------------------------------------------------------------------
   Jedyne, co na tej stronie zapisuje coś na urządzeniu użytkownika, to
   osadzona mapa Google na /kontakt/. Sama strona nie ustawia ciasteczek.

   Zasada: mapa NIE ładuje się, dopóki nie ma zgody. Adres trzymany jest
   w atrybucie data-src, więc dopóki nikt nie kliknie, do Google nie leci
   żadne zapytanie. Baner nie jest ozdobą — realnie blokuje.

   Sam wybór zapisujemy w localStorage. To też jest zapis na urządzeniu,
   ale służy wyłącznie zapamiętaniu decyzji, więc nie wymaga zgody
   (wyjątek dla danych niezbędnych do świadczenia usługi).
   =================================================================== */
(function () {
    'use strict';

    var KLUCZ = 'globbus-zgoda-mapy';
    var TAK = 'tak';
    var NIE = 'nie';

    // localStorage bywa zablokowany (tryb prywatny, ustawienia przeglądarki).
    // Wtedy po prostu działamy bez zapamiętywania, zamiast wywalić się błędem.
    var czytaj = function () {
        try { return window.localStorage.getItem(KLUCZ); } catch (e) { return null; }
    };
    var zapisz = function (v) {
        try { window.localStorage.setItem(KLUCZ, v); } catch (e) { /* trudno */ }
    };

    var mapa = document.querySelector('.map-consent');

    /* --- wczytanie mapy (dopiero po zgodzie) --- */
    var zaladujMape = function () {
        if (!mapa || mapa.querySelector('iframe')) return;

        var ramka = document.createElement('iframe');
        ramka.src = mapa.dataset.src;
        ramka.title = 'Mapa — Szosa Chełmińska 168, Toruń';
        ramka.loading = 'lazy';
        ramka.referrerPolicy = 'no-referrer-when-downgrade';
        ramka.allowFullscreen = true;

        // Zaślepka zostaje w drzewie, tylko chowa ją CSS — dzięki temu
        // po wycofaniu zgody wraca bez przeładowywania strony.
        mapa.classList.add('is-loaded');
        mapa.appendChild(ramka);
    };

    var usunMape = function () {
        if (!mapa) return;
        var ramka = mapa.querySelector('iframe');
        if (ramka) ramka.remove();
        mapa.classList.remove('is-loaded');
        // Ciasteczek już ustawionych przez Google i tak nie skasujemy z naszej
        // strony — usunięcie ramki zatrzymuje dalszą komunikację.
    };

    /* --- baner --- */
    var bar = null;

    var schowajBaner = function () {
        if (bar) bar.hidden = true;
    };

    var zbudujBaner = function () {
        if (bar) { bar.hidden = false; return; }

        bar = document.createElement('div');
        bar.className = 'cookie-bar';
        bar.setAttribute('role', 'region');
        bar.setAttribute('aria-label', 'Zgoda na ciasteczka');
        bar.innerHTML =
            '<div class="cookie-bar__inner">' +
            '<p class="cookie-bar__text">Ta strona nie ustawia własnych ciasteczek. ' +
            'Korzystamy jednak z mapy Google na stronie kontaktu, która zapisuje ciasteczka ' +
            'na Twoim urządzeniu. Mapa wczyta się dopiero, gdy wyrazisz zgodę. ' +
            'Szczegóły w <a href="/prywatnosc/">polityce prywatności</a>.</p>' +
            '<div class="cookie-bar__buttons">' +
            '<button class="btn btn--ghost" type="button" data-zgoda="nie">Odrzucam</button>' +
            '<button class="btn btn--primary" type="button" data-zgoda="tak">Akceptuję</button>' +
            '</div></div>';

        bar.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-zgoda]');
            if (!btn) return;
            var wybor = btn.dataset.zgoda === 'tak' ? TAK : NIE;
            zapisz(wybor);
            schowajBaner();
            if (wybor === TAK) zaladujMape(); else usunMape();
        });

        document.body.appendChild(bar);
    };

    /* --- stan początkowy --- */
    var stan = czytaj();

    if (stan === TAK) {
        zaladujMape();
    } else if (stan !== NIE) {
        // Brak decyzji — pytamy. Baner pokazujemy na każdej stronie,
        // bo zgoda dotyczy całego serwisu, nie tylko strony kontaktu.
        zbudujBaner();
    }

    /* --- przycisk „Pokaż mapę" wprost w zaślepce --- */
    // To również jest wyrażenie zgody, tyle że świadomym kliknięciem
    // dokładnie w tym miejscu, którego dotyczy.
    if (mapa) {
        var przycisk = mapa.querySelector('[data-zgoda-mapa]');
        if (przycisk) {
            przycisk.addEventListener('click', function () {
                zapisz(TAK);
                schowajBaner();
                zaladujMape();
            });
        }
    }

    /* --- możliwość zmiany decyzji: link w stopce --- */
    var dol = document.querySelector('.footer-bottom');
    if (dol) {
        var zmien = document.createElement('button');
        zmien.type = 'button';
        zmien.className = 'cookie-reset';
        zmien.textContent = 'Ustawienia ciasteczek';
        zmien.addEventListener('click', function () {
            zapisz('');
            zbudujBaner();
            bar.scrollIntoView({ block: 'end' });
        });
        var opakowanie = document.createElement('p');
        opakowanie.appendChild(zmien);
        dol.appendChild(opakowanie);
    }
})();
