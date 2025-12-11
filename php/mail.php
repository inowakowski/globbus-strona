<!DOCTYPE html>
<html lang="pl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <META HTTP-EQUIV="CONTENT-LANGUAGE" CONTENT="PL">
    <title>Wysyłanie... - GLOBBUS Travel Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <author>Ignacy Nowakowski</author> -->
    <!-- Main CSS Stylesheet -->
    <link href='/css/style.css' rel='stylesheet' type='text/css'/>
    
    <!-- Google Web Fonts  -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,300,500,600,700">
    <link href='https://fonts.googleapis.com/css?family=Raleway:400, 600' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sacramento&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="/img/globus.svg">
</head>
<body>
    <header>
        <a href="http://globbus.pl"><img src="/img/2_globb_white.png" id="globbus-mini"></a>
    </header>
<?php

$twojemail = "globbus@globbus.pl"; 
// $twojemail = "kontakt@globbus.pl";



include("/php/config.php");
      
  try{
      $pdo = new PDO($dsn, $usr, $pass);
      $pdo->exec("set names utf8");
  } catch (PDOException $e){
      echo $e->getMessage();
  }
  
  $err = $pdo->query('SELECT * FROM contact WHERE id = 15');
  $err->execute();

  $thx = $pdo->query('SELECT * FROM contact WHERE id = 12');
  $thx->execute();
  
  $txt = $pdo->query('SELECT * FROM contact WHERE id = 13');
  $txt->execute();
  
  $ret = $pdo->query('SELECT * FROM contact WHERE id = 14');
  $ret->execute();
  
  

if (isset($_POST['submit'])) {

            // filtrowanie treści wprowadzonych przez użytkownika
            $temat = "Formularz kontaktowy"; // temat wiadomości
            $name = htmlspecialchars(stripslashes(strip_tags(trim($_POST["name"]))), ENT_QUOTES);
            $email = htmlspecialchars(stripslashes(strip_tags(trim($_POST["email"]))), ENT_QUOTES);
            $message = htmlspecialchars(stripslashes(strip_tags(trim($_POST["message"]))), ENT_QUOTES);
            $tel = htmlspecialchars(stripslashes(strip_tags(trim($_POST["tel"]))), ENT_QUOTES);
			if($tel != ""){ 
				$tel = htmlspecialchars(stripslashes(strip_tags(trim($_POST["tel"]))), ENT_QUOTES);
			}else{
				$tel = "nie podano";
			}
            
            // nagłówki do wyświetlania wiadomości HTML
            $naglowki = "MIME-Version: 1.0" . "\r\n";
            $naglowki .= "Content-type:text/html;charset=utf-8" . "\r\n";


            // całkowita treść wiadomości
            $message = nl2br($message);
            $wiadomosc = <<< KONIEC
                <html>
                    <p><strong>Imię i nazwisko:</strong> $name</p>
                    <p><strong>Telefon:</strong><br /> $tel</p>
                    <p><strong>E-mail:</strong> $email</p>
                    <p><strong>Wiadomość:</strong><br /> $message</p>
                </html>
KONIEC;
            // wysyłanie wiadomości e-mail
            $wynik = mail('<'.$twojemail.'>', $temat, $wiadomosc, $naglowki);

            // komunikat potwierdzający wysłanie wiadomości bądź nie
            if ($wynik) {
                echo '<div class="jumbotron">';
                foreach($thx as $thx){
                    echo '<h1>'.$thx['txt'].'</h1>';
                }
                foreach($txt as $txt){
                    echo '<p><strong>'.$txt['txt'].'</strong></p>';
                }
                foreach($ret as $ret){
                    echo '<p>'.$ret['txt'].'</p>';
                }
                echo '</div>';
            } else {
                echo '<div class="jumbotron">';
                foreach($err as $err){
                    echo '<h2>'.$err['txt'].'</h2>';
                    }
                echo'</div>';
            }
            

        }

        $pdo = null;
?>

<meta http-equiv="refresh" content="10; url=http://globbus.pl" />
    <!-- <footer>
      <div class="container-footer">
        <p >Toruń 2020</p>
      </div>
    </footer> -->
</body>
</html>