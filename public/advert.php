<?php 

// require_once('app/Models/includes.php');
if($_SERVER['HTTP_USER_AGENT'] == "Valve/Steam HTTP Client 1.0 (4000)"){
    die();
}

if(isset($_GET['msg']) && !empty(trim($_GET['msg'])))
{

  extract($_GET);

  if(isset($bad_discord) && $bad_discord == "kvac") {
    die();
  }
  

  if($msg === "waiting_approbate")
  {

  $advert_title = 'En Attente D\'approbation';

  $advert_content = 'Ton compte a été créer avec succèes !<br>
              Un administrateur va valider ton compte !<br>
              Rejoins le discord pour savoir quand tu seras acceptée ! (https://discord.gg/mgdcG8hPnQ)
              <h6><u>Cette Opération prend généralement moins de 3 heures</u></h5>
              <br><br>
              <h1><i class="fa fa-spinner fa-spin"></i></h1>';

  } elseif($msg === "account_created"){
    $advert_title = 'Création de compte';

    $advert_content = 'Nous vous informons que votre compte a été crée avec succès.<br> Vous pouvez désormais vous connecter et utiliser KVacDoor <br>
    N\'oublie pas de rejoindre le discord pour pouvoir te connecter. (https://discord.gg/mgdcG8hPnQ)';
  
    }elseif($msg === "account_not_exist") {

  $advert_title = 'Ton Compte N\'existe Pas';

  $advert_content = 'Il semblerait que tu n\'es pas de compte !<br>
              <a href="register">Clique ici</a> pour en créer un !<br>';

  } elseif($msg === "bad_discord" && isset($_GET['name']) && !empty(trim($_GET['name']))) {

  $advert_title = '🚫 Attention 🚫';

  $advert_content = '<h6>Il semblerait que tu sois présent sur un Discord jugé néfaste !<br>Pour accéder de nouveau à KVacDoor veuillez quitter ce Discord !<br><br>Discord : ' . htmlentities($_GET['name']) . '</h6>';

  } else {
    die();
  }

} else {
  die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KVacDoor - Home</title>
    <meta name="description" content="Garry's Mod advanced server manager, control your servers simply and efficiently with our service">
    <meta name="keywords" content="garry's mod, gmod, hebergeur, panel, manager, advanced, backdoor, servers, hack, superadmin,">

    <link rel="icon" href="/assets/img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="/assets/css/vendor.mrrh3jpe.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/homepage.1clpo02l.css">

    <script src="https://kit.fontawesome.com/647923b639.js"></script>
</head>

<body>

  <header id="header" class="fixed-top">
    <div class="container">

      <div class="logo float-left">

      <a href="/"><img src="/assets/img/logo/purple-pink.png" alt="KVacDoor Logo" class="img-fluid" /></a>

      </div>

      <nav class="main-nav float-right d-none d-lg-block">
        <ul>
          <li><a href="../">Home</a></li>
          <li><a href="https://discord.gg/MrJUbQ72kj">Discord</a></li>
          <li><a href="../login">Login</a></li>
          <li><a href="../register">Register</a></li>
        </ul>
      </nav>
      
    </div>
  </header>

  <section id="intro" class="center-element clearfix">
    <div class="container">
      <div class="row row-eq-height justify-content-center">
        <div class="intro-info">
          <h2><?= $advert_title ?></h2>
          <h4 style="color:white">
              <?= $advert_content ?>  
          </h4>
        </div>
      </div>
    </div>
  </section>

  <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright 2019 - 2023 <strong>KVacDoor</strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <script src="/assets/js/vendor.g7217sno.js"></script>
    <script src="/assets/js/app.gx8gwlqw.js"></script>
</body>

</html>