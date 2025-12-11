<?php

include("../php/config.php");

try {
  $pdo = new PDO($dsn, $usr, $pass);
  $pdo->exec("set names utf8");
} catch (PDOException $e) {
  echo $e->getMessage();
}

$txt = $pdo->query('SELECT * FROM galery');

$txt->execute();

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
  <title>Galeria - GLOBBUS Travel Agency - Przewóz osób w Toruniu - Przewozy autokarowe</title>
  <!-- <author>Ignacy Nowakowski</author> -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="z najpiękniejszego miasta pod słońscem w każde miejsce na ziemi" />
  <link href='/css/style.css' rel='stylesheet' type='text/css' />
  <link rel="stylesheet" href="/css/material-photo-gallery.css">
  <link rel="shortcut icon" href="/img/globus.svg">
  <meta name="keywords" content="przewozy autokarowe, wycieczki, wynajem autokaru, przewóz osób, wynajem busów, wynajem autobusów, przewozy Toruń, wycieczki Toruń, wynajem autokru Toruń, wynajem busów Toruń, przewóz osób Toruń, przewóz osób za granicę, przewozy zagraniczne Toruń, Toruń busy osobowe, przewozy osobowe osób, transport osobowy busami, usługi transportowe">
</head>

<body>

  <header>
    <a href="https://globbus.pl"><img src="/img/2_globb_white.png" alt="Przewóz osób Toruń. Przewozy autokarowe" id="globbus-mini"></a>
    <nav>
      <ul>
        <li> <a href="https://globbus.pl" aria-current="page" class="btn-main"> Strona Główna </a> </li>
        <li> <a href="https://globbus.pl/galeria" class="btn-main"> Galeria </a> </li>
        <li> <a href="https://globbus.pl/about" class="btn-main"> O nas </a> </li>
        <li> <a href="https://globbus.pl/kontakt" class="btn-main"> Kontakt </a> </li>
        <li> <a href="https://globbus.pl/wsparcie" alt="Tablca odnośnie wsparcia PFR" class="btn-main"> Tablica </a> </li>

        <?php foreach ($motto as $motto) : ?>
          <h2><?= $motto['motto_txt'] ?></h2>
        <?php endforeach ?>
      </ul>
    </nav>
  </header>

  <main>
    <div class="jumbotron">
      <div class="container">

        <?php foreach ($txt as $txt) : ?>
          <h1><?= $txt['txt'] ?></h1>
        <?php endforeach ?>

        <!-- <div class="row-img"> -->
          <div class="column">
          <div class="row-img">
            <img src="/img/galeria/bus/merc-1.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/merc-2.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/merc-3.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/merc-6.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/merc-7.jpg" alt="" onclick="myFunction(this);">
          <!-- </div> -->
          </div>
          <!-- <div class="column"> -->
          <div class="row-img">
            <img src="/img/galeria/bus/setra-1.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/setra-2.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/setra-3-1.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/setra-6.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/setra-7.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/setra-8.jpg" alt="" onclick="myFunction(this);">
          </div>
          <!-- <div class="column"> -->
          <div class="row-img">
            <img src="/img/galeria/bus/vacanza-1.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/vacanza-2.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/vacanza-3.jpg" alt="" onclick="myFunction(this);">
            <img src="/img/galeria/bus/vacanza-4.jpg" alt="" onclick="myFunction(this);">
          </div>

          <!-- <div class="column">
              <img src="/img/galeria/4.jpg" alt="" onclick="myFunction(this);">
            </div>
            <div class="column">
              <img src="/img/galeria/5.jpg" alt="" onclick="myFunction(this);">
            </div> -->
        </div>
        <div class="container-img">
          <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>

          <img id="expandedImg" style="width:80%">

          <!-- <div id="imgtext"></div> -->
        </div>

      
      </div>
    </div>
  </main>
  <!-- <footer>
      <div class="container-footer">
        <p >Toruń 2020</p>
      </div>
    </footer> -->

</body>
<script src="/js/galery.js" asyn></script>

</html>
