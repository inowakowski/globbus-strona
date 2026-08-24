# globbus.pl

Strona firmowa GLOBBUS Travel Agency Sp. z o.o. — czysty HTML, CSS i JavaScript.
**Bez build stepu**: to, co leży w repozytorium, jest dokładnie tym, co widzi przeglądarka.

---

## Struktura

```
index.html          strona główna (jedyna ze zdjęciem hero)
oferta/index.html   usługi i przebieg zamówienia
flota/index.html    opis pojazdów + galeria zdjęć
o-nas/index.html    o firmie
kontakt/index.html  dane kontaktowe + mapa
wsparcie/index.html tablica PFR (link tylko w stopce)
prywatnosc/index.html polityka prywatności
404.html            strona błędu

css/style.css       cały wygląd strony
js/script.js        menu na telefonie, nagłówek, podgląd zdjęć

img/hero.jpg        duże zdjęcie na stronie głównej
img/flota/          zdjęcia pojazdów (do powiększenia po kliknięciu)
img/flota/mini/     miniatury w galerii
img/kierunki/       zdjęcia kierunków na stronie głównej

_headers            nagłówki HTTP i cache (Cloudflare Pages)
_redirects          przekierowania starych adresów (Cloudflare Pages)
robots.txt          zgoda na indeksowanie + wskazanie mapy strony
sitemap.xml         mapa strony dla Google
```

---

## Publikacja na Cloudflare Pages

W panelu Cloudflare: **Workers & Pages → Create → Pages → Connect to Git**, wskaż to
repozytorium i ustaw:

| Pole | Wartość |
|---|---|
| Framework preset | **None** |
| Build command | *(zostaw puste)* |
| Build output directory | `/` |

Od tej pory każdy `git push` na gałąź `main` publikuje stronę automatycznie.

Domenę `globbus.pl` dodaje się w zakładce **Custom domains** danego projektu Pages.

> Plik `CNAME` jest pozostałością po GitHub Pages. Po przejściu na Cloudflare
> nic nie psuje, ale można go usunąć.

### Podgląd lokalny

Otwarcie pliku `index.html` prosto z dysku **nie zadziała** — odnośniki zaczynające
się od ukośnika (`/css/style.css`) wymagają serwera.

Najwygodniej użyć rozszerzenia **Live Server** w VS Code: prawy przycisk na
`index.html` → *Open with Live Server*.

Alternatywnie, jeśli masz zainstalowany Node.js:

```bash
npx serve .
```

---

## Cache — przeczytaj, zanim zmienisz CSS albo JS

Plik `_headers` mówi przeglądarkom, jak długo trzymać pliki. Ustawienia są
dobrane tak, żeby nie dało się przypadkiem wypuścić zepsutej strony:

| Co | Jak długo | Dlaczego |
|---|---|---|
| `/img/*` | rok | zdjęcia się nie zmieniają |
| `/css/*`, `/js/*` | 4 godziny | kompromis wymuszony przez Cloudflare (patrz niżej) |

**Skąd to ostrożne podejście.** Początkowo CSS i JS miały tydzień cache.
Skończyło się tak, że po zmianie w arkuszu stylów odwiedzający dostawali nowy
HTML ze **starym** CSS-em — strona wyglądała na zepsutą, choć pliki na serwerze
były poprawne. Diagnoza zajęła sporo czasu, bo wszystko po stronie serwera
wyglądało dobrze.

**Uwaga: Cloudflare nadpisuje ustawienie z `_headers`.** W pliku stoi
`max-age=0, must-revalidate`, ale serwer oddaje `max-age=14400`, czyli 4 godziny.
Robi to ustawienie **Browser Cache TTL** na poziomie strefy, silniejsze od pliku.

Da się to wyłączyć: w panelu Cloudflare **Caching → Configuration → Browser Cache
TTL** ustaw **Respect Existing Headers**. Wtedy `_headers` zacznie obowiązywać
i poniższy krok z numerkiem przestanie być potrzebny.

### Zmieniasz CSS albo JS? Podbij numer

Dopóki obowiązuje te 4 godziny, po każdej zmianie w `css/style.css` lub
`js/script.js` **podbij numer w odnośnikach we wszystkich 8 plikach HTML**:

```bash
grep -rl "v=3" --include=*.html . | xargs sed -i "s/v=3/v=4/g"
```

Zmiana adresu omija wszystkie zapisane kopie i poprawka trafia do odwiedzających
natychmiast. Bez tego część osób przez cztery godziny zobaczy nowy HTML ze starym
arkuszem stylów — dokładnie to zepsuło kiedyś logo na stronie głównej.

**Uwaga przy zdjęciach:** obrazki mają rok cache. Jeśli podmienisz zdjęcie,
zapisując je pod tą samą nazwą, odwiedzający będą jeszcze długo widzieć stare.
Nowe zdjęcie zapisuj pod **nową nazwą**.

## Jak edytować treść

Wszystkie teksty siedzą wprost w plikach `.html` — otwórz w dowolnym edytorze
i zmień. Miejsca warte uwagi są opisane komentarzami `<!-- ... -->`.

**Motto** występuje w dwóch miejscach:
- `index.html` — w sekcji hero (klasa `hero__motto`),
- stopka na **każdej** stronie (klasa `footer-motto`).

**Numer telefonu i e-mail** powtarzają się w nagłówku, stopce i przyciskach.
Najbezpieczniej podmienić je wyszukiwaniem i zamianą w całym katalogu:
`606790468`, `606 790 468`, `biuro@globbus.pl`, `globbus@globbus.pl`.

### Uwaga: nagłówek i stopka są powielone

Przy 6 stronach i braku build stepu nagłówek oraz stopka są skopiowane do
każdego pliku. **Zmieniasz menu albo stopkę? Skopiuj zmianę do wszystkich
plików `.html`.** To świadomy kompromis: w zamian nie ma tu żadnego narzędzia,
które za dwa lata przestanie się instalować.

---

## Jak dodać zdjęcie do galerii

Zdjęcia z telefonu mają po 3–5 MB i **nie wolno ich wrzucać wprost** — strona
przestanie się otwierać na komórce. Każde zdjęcie potrzebuje dwóch wersji:
miniatury i wersji do powiększenia.

W repozytorium leży gotowy skrypt, który robi obie wersje naraz. Korzysta
wyłącznie z bibliotek wbudowanych w Windows — nie trzeba nic instalować.
Uruchom go w PowerShell, w katalogu projektu:

```bash
powershell -ExecutionPolicy Bypass -File .\narzedzia\optymalizuj-zdjecie.ps1 -Zdjecie 'C:\zdjecia\nowy-autokar.jpg' -Nazwa 'setra-10'
```

Skrypt wypisze na koniec gotowy kawałek HTML do wklejenia. Kafelek wygląda tak —
`data-full` wskazuje duże zdjęcie, `src` miniaturę:

```html
<button type="button" data-full="/img/flota/nazwa.jpg">
    <img src="/img/flota/mini/nazwa.jpg" width="700" height="525"
         alt="Opis zdjęcia" loading="lazy" decoding="async">
</button>
```

`alt` opisuje, co widać na zdjęciu — czytają to zarówno Google, jak i osoby
korzystające z czytników ekranu.

---

## Ciasteczka i prywatność

Strona **nie ustawia własnych ciasteczek** i nie ma narzędzi analitycznych.
Jedyny element strony trzeciej to mapa Google na `/kontakt/`.

Mapa nie ładuje się sama — jej adres siedzi w atrybucie `data-src`, a `js/script.js`
wstawia ramkę dopiero po zgodzie. Dzięki temu przed zgodą do Google nie leci żadne
zapytanie. Bez JavaScriptu mapa też się nie wczyta, czyli w razie awarii skryptu
zachowanie jest bezpieczne, a nie odwrotnie.

Baner buduje JavaScript, nie ma go w HTML — inaczej trzeba by go kopiować do ośmiu
plików. Decyzja ląduje w `localStorage` pod kluczem `globbus-zgoda-mapy`
(`tak` / `nie`). Przycisk **Ustawienia ciasteczek** w stopce pozwala ją zmienić.

Oba przyciski w banerze mają celowo **identyczny rozmiar** — odmowa musi być równie
łatwa jak zgoda. Jeśli będziesz zmieniać ten fragment, nie eksponuj „Akceptuję"
kosztem „Odrzucam".

Polityka prywatności to `prywatnosc/index.html`. **Nie jest zatwierdzona prawnie** —
opisuje wiernie, co strona robi technicznie, ale przed traktowaniem jej jako
dokumentu firmy daj ją komuś od RODO. W pliku jest komentarz `UZUPEŁNIJ`
przy okresie przechowywania korespondencji.

## Do uzupełnienia

- [ ] **Liczba miejsc w pojazdach** — w `flota/index.html` czekają dwa komentarze
      `⚠ UZUPEŁNIJ`. To pierwsza rzecz, o którą pytają klienci.
- [ ] **Zdjęcia Heliotur** — cztery zdjęcia (dawne `vacanza-*`) pokazują autokar
      innej firmy, z jej logo i telefonem. Zostały usunięte z galerii. Jeśli to
      pojazd partnera i jest zgoda na publikację, można je przywrócić
      z `globbus-oryginaly-zdjec/` i opisać jako pojazd partnerski.
- [ ] **Statystyki odwiedzin** — stary kod Google Analytics (`UA-174652731-1`)
      został usunięty, bo Universal Analytics przestało zbierać dane w lipcu 2023.
      Cloudflare Pages ma własne, darmowe statystyki (Web Analytics), które nie
      wymagają banera cookies — najprościej włączyć je w panelu Cloudflare.

---

## Oryginały zdjęć

Pełnowymiarowe zdjęcia (52 MB) zostały przeniesione poza repozytorium do
`../globbus-oryginaly-zdjec/`. Są też w historii git — commit sprzed
optymalizacji:

```bash
git log --oneline --diff-filter=D -- img/galeria
```
