<?php
  require './conexao.php';

  $teste = viewCheque($_SESSION['id_user'], '1');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
      background-color: black;
      color: white;
    }
  </style>
</head>
<body>
  <?php echo'<pre>'; print_r($teste); echo '</pre>'?>
</body>
</html>