<?php

include("php/config.php");

try {
  $pdo = new PDO($dsn, $usr, $pass);
  $pdo->exec("set names utf8");
} catch (PDOException $e) {
  echo $e->getMessage();
}

$result = $pdo->query('SELECT * FROM home_page');

$txt = $result->fetchAll();

$motto = $pdo->query('SELECT * FROM motto');

$motto->execute();

$pdo = null;
?>
<!DOCTYPE html>
<html lang="pl-PL">

<head>
  <link href='https://fonts.googleapis.com/css?family=Raleway:400, 600' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
  <meta http-equiv="Content-Type" content="text/html" />
  <meta charset="utf-8">
  <meta name="description" content="Firma transportowa z wielolenią tradycją. Oferujemy przewóz osób na najwyższym poziomie. Podrórze naszymi autokarami to czysta przyjemność. Zajmujemy się wynajmem autokarów i busów do przewozów osób na terenie kraju i za granicą. Znajdziesz nas w Toruniu" />
  <title>GLOBBUS Travel Agency - Przewóz osób w Toruniu - Przewozy autokarowe</title>
  <!-- <author>Ignacy Nowakowski</author> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='/css/style.css' rel='stylesheet' type='text/css' />
  <link rel="shortcut icon" href="/img/globus.svg">
  <link rel="alternate" type="application/rss+xml" title="Przewóz i transport  osób - Toruń" href="http://globbus.pl/">
  <meta property="article:tag" content="Przewóz osób Toruń">
  <meta property="article:tag" content="Przewozy autokarowe Toruń">
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-174652731-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-174652731-1');
  </script>
  <meta name="keywords" content="przewozy autokarowe, wycieczki, wynajem autokaru, przewóz osób, wynajem busów, wynajem autobusów, przewozy Toruń, wycieczki Toruń, wynajem autokru Toruń, wynajem busów Toruń, przewóz osób Toruń, przewóz osób za granicę, przewozy zagraniczne Toruń, Toruń busy osobowe, przewozy osobowe osób, transport osobowy busami, usługi transportowe">

</head>

<body>

  <header>
    <a href="https://globbus.pl"><img src="/img/2_globb_white.png" alt="Przewóz osób Toruń. Przewozy autokarowe" id="globbus-mini"></a>
    <nav>
      <ul>
        <li> <a href="https://globbus.pl" aria-current="page" alt="Przewóz osób Toruń. Przewozy autokarowe" class="btn-main"> Strona Główna </a> </li>
        <!-- <li> <a href="https://globbus.pl/galeria" class="btn-main"> Galeria </a> </li> -->
        <li> <a href="https://globbus.pl/about" class="btn-main"> O nas </a> </li>
        <li> <a href="https://globbus.pl/kontakt" alt="Numer telefonu: +48 606 790 468" class="btn-main"> Kontakt </a> </li>
        <li> <a href="https://globbus.pl/wsparcie" alt="Tablca odnośnie wsparcia PFR" class="btn-main"> Tablica „FUNDUSZ WSPARCIA INWESTYCYJNEGO” </a> </li>
        <!-- <li> <a href="https://globbus.pl/tablica.pdf" alt="Tablca odnośnie wsparcia PFR" class="btn-main"> Tablica „FUNDUSZ WSPARCIA INWESTYCYJNEGO” </a> </li> -->
      </ul>
    </nav>
    <img src="/img/plansza_informacyjna_PFR_poziom.png" alt="Plansza informacyjna PFR" id="pfr_home">
    
  </header>
  
  <main>
    <div>
      <div class="container">
        <img src="/img/2_globb.png" alt="Przewóz osób Toruń. Przewozy autokarowe" id="globbus">
        <?php foreach ($motto as $motto) : ?>
          <h2><?= $motto['motto_txt'] ?></h2>
          <?php endforeach ?>
        </div>
      </div>
    </main>
    <section class="supporting">
      <div class="container">
        <?php foreach ($txt as $txt) : ?>
          <div class="col">
            <img src="">
            <h2><?= $txt['header'] ?></h2>
            <p><?= $txt['content'] ?></p>
            
          </div>
          <?php endforeach ?>
        </div>
      </section>

  <!-- <footer>
      <div class="container-footer">
        <p >Toruń 2020</p>
      </div>
    </footer> -->

</body>

</html>
