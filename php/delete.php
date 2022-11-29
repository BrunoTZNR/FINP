<?php
  require './db/conexao.php';

  $card = $_GET['card'];
  $id_card = $_GET['id'];

  $logout = './logout.php';

  verifyLogin($logout);

  if ($card == 'boletos') {

  } else if ($card == 'cheques') {
    $return = deleteCheque($_SESSION['id_user'], $id_card);

    header("Location: ./listagem.php?card=$card&$return");
  } else if ($card == 'metas') {
    $return = deleteMeta($_SESSION['id_user'], $id_card);

    header("Location: ./listagem.php?card=$card&$return");
  } else if ($card == 'cartoes') {
    
  } else if ($card == 'investimentos') {
    $return = deleteInvestimento($_SESSION['id_user'], $id_card);

    header("Location: ./listagem.php?card=$card&$return");
  }

  