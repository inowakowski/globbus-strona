<?php

include("../php/config.php");
      
try{
    $pdo = new PDO($dsn, $usr, $pass);
    $pdo->exec("set names utf8");
} catch (PDOException $e){
    echo $e->getMessage();
}

$result = $pdo->query('SELECT * FROM about');

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
    <title>O nas - GLOBBUS Travel Agency</title>
    <!-- <author>Ignacy Nowakowski</author> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="z najpiękniejszego miasta pod słońscem w każde miejsce na ziemi" />
    <link href='/css/style.css' rel='stylesheet' type='text/css'/>
    <link rel="shortcut icon" href="/img/globus.svg">
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
            <?php foreach($motto as $motto): ?>
              <h2 class="motto"><?=$motto['motto_txt']?></h2>
            <?php endforeach ?>
          </ul>
        </nav>
    </header>

    <main>
      <div class="jumbotron">  
        <?php foreach($txt as $txt): ?>
        <div class="col">
          <!-- <img src=""> -->
          <p><?=$txt['content']?></p>
          <h4><?=$txt['header']?></h4>
          
        </div>
        <?php endforeach ?>
        <img src="/img/plansza_informacyjna_PFR_poziom.png" alt="Plansza informacyjna PFR">
      </div>

      
    </main>
    <!-- <footer>
      <div class="container-footer">
        <p >Toruń 2020</p>
      </div>
    </footer> -->
    
  </body>
</html>
