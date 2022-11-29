<?php
  require './conexao.php';

  $teste = viewInvestimento(1,2);
  $teste['dt_investimento'] = date('Y-m-d', strtotime($teste['dt_investimento']));
  $teste['dt_vencimento'] = date('d/m/Y', strtotime($teste['dt_vencimento']));
  // $teste['dt_vencimento'] = strtotime($teste['dt_investimento']);
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
  <?php echo'<pre>'; var_dump($teste); echo '</pre>'?>
</body>
</html>