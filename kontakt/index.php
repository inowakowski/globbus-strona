<?php

include("../php/config.php");

try {
  $pdo = new PDO($dsn, $usr, $pass);
  $pdo->exec("set names utf8");
} catch (PDOException $e) {
  echo $e->getMessage();
}

$result = $pdo->query('SELECT * FROM contact WHERE id BETWEEN 1 AND 4');
$txt = $result->fetchAll();

$zapr = $pdo->query('SELECT * FROM contact WHERE id = 5');
$zapr->execute();

$przez = $pdo->query('SELECT * FROM contact WHERE id = 6');
$przez->execute();

$namef = $pdo->query('SELECT * FROM contact WHERE id = 7');
$namef->execute();

$email = $pdo->query('SELECT * FROM contact WHERE id = 8');
$email->execute();

$phone = $pdo->query('SELECT * FROM contact WHERE id = 9');
$phone->execute();

$mess = $pdo->query('SELECT * FROM contact WHERE id = 10');
$mess->execute();

$sendmess = $pdo->query('SELECT * FROM contact WHERE id = 11');
$sendmess->execute();

$motto = $pdo->query('SELECT * FROM motto');
$motto->execute();

$pdo = null;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="pl-PL" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <link href='https://fonts.googleapis.com/css?family=Raleway:400, 600' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
  <meta http-equiv="Content-Type" content="text/html" />
  <meta charset="utf-8">
  <title>Kontakt - GLOBBUS Travel Agency</title>
  <!-- <author>Ignacy Nowakowski</author> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="z najpiękniejszego miasta pod słońscem w każde miejsce na ziemi" />
  <link href='/css/style.css' rel='stylesheet' type='text/css' />
  <link rel="shortcut icon" href="/img/globus.svg">
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
    <a href="https://globbus.pl"><img src="/img/2_globb_white.png" id="globbus-mini"></a>
    <nav>
      <ul>
        <li> <a href="https://globbus.pl" aria-current="page" class="btn-main"> Strona Główna </a> </li>
        <!-- <li> <a href="https://globbus.pl/galeria" class="btn-main"> Galeria </a> </li> -->
        <li> <a href="https://globbus.pl/about" class="btn-main"> O nas </a> </li>
        <li> <a href="https://globbus.pl/kontakt" class="btn-main"> Kontakt </a> </li>
        <li> <a href="https://globbus.pl/wsparcie" alt="Tablca odnośnie wsparcia PFR" class="btn-main"> Tablica „FUNDUSZ WSPARCIA INWESTYCYJNEGO” </a> </li>
        <!-- <li> <a href="https://globbus.pl/tablica.pdf" alt="Tablca odnośnie wsparcia PFR" class="btn-main"> Tablica „FUNDUSZ WSPARCIA INWESTYCYJNEGO” </a> </li> -->
        <?php foreach ($motto as $motto) : ?>
          <h2><?= $motto['motto_txt'] ?></h2>
        <?php endforeach ?>
      </ul>
    </nav>
  </header>
  <div class="container2">
    <div class="info-content">
      <?php foreach ($zapr as $zapr) : ?>
        <h2><?= $zapr['txt'] ?></h2>
      <?php endforeach ?>
      <?php foreach ($przez as $przez) : ?>
        <h4><?= $przez['txt'] ?></h4><br />
      <?php endforeach ?>
      <?php foreach ($txt as $txt) : ?>
        <h4><?= $txt['txt'] ?></h4>
      <?php endforeach ?>
      <img src="/img/plansza_informacyjna_PFR_pion.png" alt="Plansza informacyjna PFR" id="pft_kontakt">
    </div>


    <section name="form">
      <div class="row">
        <form method="post" name="contactform" id="contactform">

          <?php foreach ($namef as $namef) : ?>
            <h3><?= $namef['txt'] ?></h3>
          <?php endforeach ?>
          <input type="text" name="name" id="name" class="form-control" require="true">

          <?php foreach ($email as $email) : ?>
            <h3><?= $email['txt'] ?></h3>
          <?php endforeach ?>
          <input type="text" name="email" id="email" class="form-control" require="true">


          <?php foreach ($phone as $phone) : ?>
            <h3><?= $phone['txt'] ?></h3>
          <?php endforeach ?>
          <input type="text" name="tel" id="tel" class="form-control">

          <?php foreach ($mess as $mess) : ?>
            <h3><?= $mess['txt'] ?></h3>
          <?php endforeach ?>
          <textarea name="message" id="message" class="textarea-message form-control" rows="5" require="true"></textarea>


          <div class="text-center">
            <?php foreach ($sendmess as $sendmess) : ?>
              <button type="submit" name="submit" value="Send message" onclick="validateForm()" id="button-submit" class="button-style"><?= $sendmess['txt'] ?></button>
            <?php endforeach ?>
          </div>

        </form>

      </div>
    </section>
  </div>
  <script src="/js/script.js" async></script>
</body>

</html>
