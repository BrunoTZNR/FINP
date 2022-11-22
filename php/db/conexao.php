<?php
  session_start(); // INICIA A SESSÃO PEGANDO O ID DO USER

  // ESTABELECE UMA CONEXÃO COM O BANCO DE DADOS
  $host = 'localhost';
  $dbname = 'finp';
  $user = 'root';
  $pass = '';

  try {
    $conn = new PDO("mysql:host={$host};dbname={$dbname};", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "DEU MUITA MERDA. ERROR: " . $e->getMessage();
  }

  // MÉTODO RESPONSÁVEL POR LIMPAR OS CAMPOS INPUT
  function clean($dado) {
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
  }

  // MÉTODO RESPONSÁVEL PELA MENSAGEM 'BÃO SÔ?'
  function horario() {
    global $conn;

    $query = $conn->prepare("SELECT p.nome nome FROM tb_user u 
                            JOIN tb_pessoa p ON p.id_pessoa = u.fk_pessoa 
                            WHERE id_user = ?");
    $query->execute([$_SESSION['id_user']]);
    $name = $query->fetch(PDO::FETCH_ASSOC);

    $horario_function = date('H:i');

    if ($horario_function >= '00:00' && $horario_function < '06:00') {
      /* madrugada */
      echo '<i class="fa-solid fa-bed"></i>Já não é hora de dormir, ' . $name['nome'] . '?';
    } else if ($horario_function >= '06:00' && $horario_function < '12:00') {
      /* manhã */
      echo '<i class="fa-solid fa-mug-saucer"></i>Bom dia, ' . $name['nome'];
    } else if ($horario_function >= '12:00' && $horario_function < '18:00') {
      /* tarde */
      echo '<i class="fa-solid fa-sun"></i>Boa tarde, ' . $name['nome'];
    } else {
      /* noite */
      echo '<i class="fa-solid fa-moon"></i>Boa noite, ' . $name['nome'];
    }
  }

  // MÉTODO QUE VERIFICAR SE HÁ ALGUM USUÁRIO LOGADO
  function verifyLogin($logout) {
    if (!isset($_SESSION['id_user'])){
      header("Location: $logout");
    }
  }

  // MÉTODO RESPONSÁVEL PELO SELECT AO BANCO DE DADOS
  // function select($fields = '*', $table) {
  //   $query = $GLOBALS['conn']->prepare("SELECT $fields FROM $table
  //                                       WHERE ");

  //   return $query;
  // }

  function viewUser($id_user){
    // VERIFICA SE O USER É PF OU PJ
    $query = $GLOBALS['conn']->prepare("SELECT
                                        CASE
                                            WHEN fk_pj IS NULL THEN '1'
                                            WHEN fk_pf IS NULL THEN '0'
                                        END AS tipo
                                        FROM tb_user u
                                        JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                        WHERE id_user = ?");
    $query->execute([$id_user]);
    $row_result = $query->fetch(PDO::FETCH_ASSOC);
    $pf = $row_result['tipo'] == '1' ? 'flex' : 'none';
    $pj = $row_result['tipo'] == '0' ? 'flex' : 'none';

    // PEGA OS DADOS OS USER
    if($row_result['tipo'] == '1'){
        $query = $GLOBALS['conn']->prepare("SELECT email, ddd, telefone, nome, sobrenome, dt_nasc, sexo, cpf, cep, numero, 
                                            complemento, bairro, rua, nm_cidade cidade, nm_estado estado
                                            FROM tb_user u
                                            JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                            JOIN tb_endereco e ON e.id_endereco=u.fk_endereco
                                            JOIN tb_cidade c ON c.id_cidade=e.fk_cidade
                                            JOIN tb_estado es ON es.cod_estado=c.fk_estado
                                            JOIN tb_pf pf ON pf.id_pf=p.fk_pf
                                            WHERE id_user= ?");
        $query->execute([$id_user]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    }else{
        // PJ
        $query = $GLOBALS['conn']->prepare("SELECT email, ddd, telefone, nome, sobrenome, dt_nasc, sexo, cnpj, nm_empresa, 
                                            cep, numero, complemento, bairro, rua, nm_cidade cidade, nm_estado estado
                                            FROM tb_user u
                                            JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                            JOIN tb_endereco e ON e.id_endereco=u.fk_endereco
                                            JOIN tb_cidade c ON c.id_cidade=e.fk_cidade
                                            JOIN tb_estado es ON es.cod_estado=c.fk_estado
                                            JOIN tb_pj pj ON pj.id_pj=p.fk_pj
                                            WHERE id_user=?");
        $query->execute([$id_user]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    }

    switch($result['sexo']){
      case 'f':
        $result['sexo'] = 'Feminino';
        break;
      case 'm':
        $result['sexo'] = 'Masculino';
        break;
      case 'o':
        $result['sexo'] = 'Outro';
        break;
      case 'n':
        $result['sexo'] = 'Prefiro não informar';
        break;
    }

    return [$pf, $pj, $result];
  }