# Przygotowuje zdjęcie do galerii: zmniejsza i kompresuje do formatu JPEG.
# Korzysta wyłącznie z bibliotek wbudowanych w Windows — nic nie trzeba instalować.
#
# Użycie (z katalogu projektu):
#
#   .\narzedzia\optymalizuj-zdjecie.ps1 -Zdjecie 'C:\zdjecia\nowy-autokar.jpg' -Nazwa 'setra-10'
#
# Tworzy dwa pliki:
#   img/flota/setra-10.jpg        — wersja do powiększenia (dłuższy bok 1600 px)
#   img/flota/mini/setra-10.jpg   — miniatura do galerii  (dłuższy bok  700 px)

param(
    # Ścieżka do oryginalnego zdjęcia (np. prosto z telefonu).
    [Parameter(Mandatory = $true)][string]$Zdjecie,

    # Nazwa pliku wynikowego, bez rozszerzenia i bez spacji.
    [Parameter(Mandatory = $true)][string]$Nazwa,

    # Katalog docelowy — domyślnie galeria floty.
    [string]$Katalog = 'img/flota'
)

$ErrorActionPreference = 'Stop'
Add-Type -AssemblyName System.Drawing

if (-not (Test-Path $Zdjecie)) {
    throw "Nie znaleziono pliku: $Zdjecie"
}

$jpeg = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() |
    Where-Object { $_.MimeType -eq 'image/jpeg' }

function Zapisz-Wersje {
    param([string]$Wejscie, [string]$Wyjscie, [int]$DluzszyBok, [int]$Jakosc)

    $katalog = Split-Path -Parent $Wyjscie
    if (-not (Test-Path $katalog)) { New-Item -ItemType Directory -Force -Path $katalog | Out-Null }

    $par = New-Object System.Drawing.Imaging.EncoderParameters(1)
    $par.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter(
        [System.Drawing.Imaging.Encoder]::Quality, [long]$Jakosc)

    $src = [System.Drawing.Image]::FromFile($Wejscie)
    try {
        # Nigdy nie powiększamy — tylko zmniejszamy.
        $skala = [Math]::Min(1.0, $DluzszyBok / [Math]::Max($src.Width, $src.Height))
        $w = [int][Math]::Round($src.Width * $skala)
        $h = [int][Math]::Round($src.Height * $skala)

        $bmp = New-Object System.Drawing.Bitmap($w, $h)
        $bmp.SetResolution(72, 72)
        $g = [System.Drawing.Graphics]::FromImage($bmp)
        $g.CompositingQuality = 'HighQuality'
        $g.InterpolationMode = 'HighQualityBicubic'
        $g.SmoothingMode = 'HighQuality'
        $g.PixelOffsetMode = 'HighQuality'
        $g.Clear([System.Drawing.Color]::White)
        $g.DrawImage($src, (New-Object System.Drawing.Rectangle(0, 0, $w, $h)))
        $g.Dispose()

        $bmp.Save($Wyjscie, $jpeg, $par)
        $bmp.Dispose()
    }
    finally {
        $src.Dispose()
    }

    $kb = [Math]::Round((Get-Item $Wyjscie).Length / 1KB)
    Write-Host ("  {0,-34} {1,5}x{2,-5} {3,6} KB" -f $Wyjscie, $w, $h, $kb)
}

$przed = [Math]::Round((Get-Item $Zdjecie).Length / 1KB)
Write-Host "Oryginal: $przed KB"
Write-Host "Zapisuje:"

Zapisz-Wersje -Wejscie $Zdjecie -Wyjscie "$Katalog/$Nazwa.jpg"      -DluzszyBok 1600 -Jakosc 82
Zapisz-Wersje -Wejscie $Zdjecie -Wyjscie "$Katalog/mini/$Nazwa.jpg" -DluzszyBok 700  -Jakosc 78

Write-Host ""
Write-Host "Gotowe. Dopisz teraz kafelek w flota/index.html:"
Write-Host ""
Write-Host "    <button type=`"button`" data-full=`"/$Katalog/$Nazwa.jpg`">"
Write-Host "        <img src=`"/$Katalog/mini/$Nazwa.jpg`""
Write-Host "             alt=`"OPISZ CO WIDAC NA ZDJECIU`" loading=`"lazy`" decoding=`"async`">"
Write-Host "    </button>"
