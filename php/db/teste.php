<?php
require './conexao.php';

$dados = viewUser($_SESSION['id_user']);

echo '<pre>';
print_r($dados);
echo '</pre>';

echo $dados[2]['sexo'];

// switch ($result[2]['sexo']) {
//   case 'f':
//     $result[2]['sexo'] = 'Feminino';
//     break;
//   case 'm':
//     $result[2]['sexo'] = 'Masculino';
//     break;
//   case 'o':
//     $result[2]['sexo'] = 'Outro';
//     break;
//   case 'n':
//     $result[2]['sexo'] = 'Prefiro não informar';
//     break;
// }
