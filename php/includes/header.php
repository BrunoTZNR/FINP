<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <!-- CSS -->
  <link rel="stylesheet" href="<?=$css?>">

  <!-- JS -->
  <script src="<?=$js?>" defer></script>

  <!-- FONTSAWESOME - LINK -->
  <script src="https://kit.fontawesome.com/ab587c5cd2.js" crossorigin="anonymous"></script>

  <!-- GOOGLE FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,500;0,700;1,500;1,700&family=Ubuntu:ital,wght@0,300;0,500;1,300;1,500&display=swap" rel="stylesheet">

  <title><?=TITLE?></title>
</head>
<body>
  <header class="header">
    <section class="header_container">
      <ul>
        <li class="header_user">
          <i class="fa-solid fa-user fa-xl"></i>

          <ul>
            <li><a class="header_user_acoes" href="<?=$perfil?>">perfil</a></li>
            <li><a class="header_user_acoes" href="<?=$logout?>">sair</a></li>
          </ul>
        </li>
        <li><a class="header_title" href="<?=$home?>">Finp</a></li>
        <li class="header_bao"><?=horario()?></li>
      </ul>
    </section>
  </header>