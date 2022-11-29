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

// MÉTODO RESPONSÁVEL POR RETORNAR O NOME EXTENSO DO MÊS CORRENTE
function qualMes($mes){
  switch($mes){
    case '01': return 'Janeiro'; break;
    case '02': return 'Fervereiro'; break;
    case '03': return 'Março'; break;
    case '04': return 'Abril'; break;
    case '05': return 'Maio'; break;
    case '06': return 'Junho'; break;
    case '07': return 'Julho'; break;
    case '08': return 'Agosto'; break;
    case '09': return 'Setembro'; break;
    case '10': return 'Outubro'; break;
    case '11': return 'Novembro'; break;
    case '12': return 'Dezembro'; break;
  }
}

// MÉTODO QUE VERIFICAR SE HÁ ALGUM USUÁRIO LOGADO
function verifyLogin($logout) {
  if (!isset($_SESSION['id_user'])) {
    header("Location: $logout");
  }
}

// FORMATA VALOR
function formatValores($value) {
  if (strpos($value, "0") == 0) {
    $value = number_format($value, 2, ',', '.');
    return $value;
  } else {
    $value = str_replace(',', '.', $value);
    $value = number_format($value, 2, ',', '.');
    return $value;
  }
}

// DEFINE MESAGEM DO ALERT
function messageAlert($tipo_alert) {
  switch ($tipo_alert) {
    case 'delete':
      $alert = 'Item deletado com sucesso!';
      break;
    case 'create':
      $alert = 'Item cadastrado com sucesso!';
      break;
    case 'update':
      $alert = 'Item Alterado com sucesso!';
      break;
    case 'null':
      $alert = 'Há campos em branco!';
      break;
    default:
      $alert = 'Tem nada diso não?';
      break;
  }

  return $alert;
}

/*-----------------------------------       QUERYS      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DO USUÁRIO PARA PROFILE
function viewUser($id_user) {
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
  if ($row_result['tipo'] == '1') {
    $query = $GLOBALS['conn']->prepare("SELECT email, ddd, telefone, nome, sobrenome, dt_nasc, sexo, cpf, cep, numero, 
                                            complemento, bairro, rua, nm_cidade cidade, cod_estado, nm_estado estado
                                            FROM tb_user u
                                            JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                                            JOIN tb_endereco e ON e.id_endereco=u.fk_endereco
                                            JOIN tb_cidade c ON c.id_cidade=e.fk_cidade
                                            JOIN tb_estado es ON es.cod_estado=c.fk_estado
                                            JOIN tb_pf pf ON pf.id_pf=p.fk_pf
                                            WHERE id_user= ?");
    $query->execute([$id_user]);
    $result = $query->fetch(PDO::FETCH_ASSOC);
  } else {
    // PJ
    $query = $GLOBALS['conn']->prepare("SELECT email, ddd, telefone, nome, sobrenome, dt_nasc, sexo, cnpj, nm_empresa, 
                                            cep, numero, complemento, bairro, rua, nm_cidade cidade, cod_estado, nm_estado estado
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

  switch ($result['sexo']) {
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

// MÉTODO QUE DEFINE OS CAMPOS E OS VALORES DOS MESMOS DA TABELA NA LISTAGEM
function tableContent($id_user, $tipo) {
  $tbody = '';

  if ($tipo == 'boletos') {
    $thead = '<tr>
                <td>descrição</td>
                <td>data</td>
                <td>Status</td>
                <td>Valor</td>
              </tr>';

    $query = $GLOBALS['conn']->prepare("SELECT id_boleto, descricao, dt_vencimento, 
                                        CASE
                                          WHEN fk_status='4' THEN 'Pago'
                                          WHEN fk_status='5' THEN 'Pendente'
                                          WHEN fk_status='7' THEN 'Vencido'
                                        END AS 'status', valor 
                                        FROM tb_boleto b
                                        JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto
                                        WHERE fk_user = ?
                                        ORDER BY id_boleto");
    $query->execute([$id_user]);

    if ($query->rowCount() > 0) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $tbody .= '<tr id="id" class="' . $result['id_boleto'] . ' ' . $tipo . '">
            <td>' . $result['descricao'] . '</td>
            <td>' . date('d/m/Y', strtotime($result['dt_vencimento'])) . '</td>
            <td>' . $result['status'] . '</td>
            <td>R$ '. formatValores($result['valor']) .'</td>
          </tr>';
      }
    } else {
      $tbody = '<tr><td colspan="5">No tiente no uno cadastrado!</td></tr>';
    }
  } else if ($tipo == 'cheques') {
    $thead = '<tr>
                <td>descrição</td>
                <td>data</td>
                <td>tipo</td>
                <td>Valor</td>
              </tr>';

    $query = $GLOBALS['conn']->prepare("SELECT id_cheque, descricao, dt, 
                                          CASE
                                              WHEN fk_status='8' THEN 'Enviado'
                                              WHEN fk_status='9' THEN 'Recebido'
                                          END AS 'status', valor 
                                          FROM tb_cheque c
                                          JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                          WHERE fk_user=?
                                          ORDER BY id_cheque");
    $query->execute([$id_user]);

    if ($query->rowCount() > 0) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $tbody .= '<tr id="id" class="' . $result['id_cheque'] . ' ' . $tipo . '">
            <td>' . $result['descricao'] . '</td>
            <td>' . date('d/m/Y', strtotime($result['dt'])) . '</td>
            <td>' . $result['status'] . '</td>
            <td>R$ ' . formatValores($result['valor']) . '</td>
          </tr>';
      }
    } else {
      $tbody = '<tr><td colspan="5">No tiente no uno cadastrado!</td></tr>';
    }
  } else if ($tipo == 'metas') {
    $thead = '<tr>
                <td>Nome</td>
                <td>Status</td>
                <td>Valor atual</td>
                <td>Valor meta</td>
              </tr>';

    $query = $GLOBALS['conn']->prepare("SELECT id_meta, nome, valor_pretendido, valor_inicial, IFNULL(SUM(valor), 0) valor_adicoes, 
                                        CASE
                                          WHEN fk_status='1' THEN 'Concluído'
                                          WHEN fk_status='7' THEN 'Vencido'
                                          WHEN fk_status='10' THEN 'Andamento'
                                        END AS 'status'
                                        FROM tb_add_meta adm
                                        RIGHT JOIN tb_meta m ON m.id_meta=adm.fk_meta
                                        JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                        WHERE fk_user = ?
                                        GROUP BY id_meta ORDER BY id_meta");
    $query->execute([$id_user]);

    if ($query->rowCount() > 0) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $tbody .= '<tr id="id" class="' . $result['id_meta'] . ' ' . $tipo . '">
            <td>' . $result['nome'] . '</td>
            <td>' . $result['status'] . '</td>
            <td>R$ ' . formatValores($result['valor_inicial'] + $result['valor_adicoes']) . '</td>
            <td>R$ ' . formatValores($result['valor_pretendido']) . '</td>
          </tr>';
      }
    } else {
      $tbody = '<tr><td colspan="5">No tiente no uno cadastrado!</td></tr>';
    }
  } else if ($tipo == 'cartoes') {
    $thead = '<tr>
                <td>nome</td>
                <td>data</td>
                <td>Status</td>
                <td>Valor</td>
              </tr>';

    $query = $GLOBALS['conn']->prepare("SELECT id_cartao, nome, mes_fatura, 
                                        CASE 
                                          WHEN fk_pagamento IS NULL THEN 'Pendente'
                                            ELSE 'Pago'
                                        END AS 'status', valor 
                                        FROM tb_cartao c
                                        JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                                        WHERE fk_user = ?
                                        ORDER BY mes_fatura");
    $query->execute([$id_user]);

    if ($query->rowCount() > 0) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $tbody .= '<tr id="id" class="'. $result['id_cartao'] .' '. $tipo .'">
            <td>'. $result['nome'] .'</td>
            <td>'. date('m/Y', strtotime($result['mes_fatura'])) .'</td>
            <td>'. $result['status'] .'</td>
            <td>R$ '. formatValores($result['valor']) .'</td>
          </tr>';
      }
    } else {
      $tbody = '<tr><td colspan="5">No tiente no uno cadastrado!</td></tr>';
    }
  } else if ($tipo == 'investimentos') {
    $thead = '<tr>
                <td>descrição</td>
                <td>Status</td>
                <td>tipo</td>
                <td>Valor</td>
              </tr>';

    $query = $GLOBALS['conn']->prepare("SELECT id_investimento, nome, 
                                        CASE
                                          WHEN tipo='tesouro_direto' THEN 'Tesouro Direto'
                                          WHEN tipo='fundos' THEN 'Fundos'
                                          WHEN tipo='renda_fixa' THEN 'Renda Fixa'
                                          WHEN tipo='renda_variavel' THEN 'Renda Variável'
                                          WHEN tipo='poupanca' THEN 'Poupança'
                                          WHEN tipo='previdencia_privada' THEN 'Previdência Privada'
                                          WHEN tipo='coe' THEN 'COE'
                                          WHEN tipo='oferta_publica' THEN 'Oferta Pública'
                                          WHEN tipo='produtos_estruturados' THEN 'Produtos Estruturados'
                                        END AS tipo, 
                                        CASE
                                          WHEN fk_status='7' THEN 'Vencido'
                                          WHEN fk_status='3' THEN 'Ativo'
                                        END AS 'status', (qtd_cota * valor_cota) valor 
                                        FROM tb_investimento i
                                        JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                                        WHERE fk_user = ? ORDER BY id_investimento");
    $query->execute([$id_user]);

    if ($query->rowCount() > 0) {
      while ($result = $query->fetch(PDO::FETCH_ASSOC)) {
        $tbody .= '<tr id="id" class="' . $result['id_investimento'] . ' ' . $tipo . '">
            <td>' . $result['nome'] . '</td>
            <td>' . $result['status'] . '</td>
            <td>' . $result['tipo'] . '</td>
            <td>R$ '. formatValores($result['valor']) .'</td>
          </tr>';
      }
    } else {
      $tbody = '<tr><td colspan="5">No tiente no uno cadastrado!</td></tr>';
    }
  } else {
    $tbody = '';
  }

  return [$thead, $tbody];
}

/*-----------------------------------       QUERYS - BOLETO      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS BOLETOS DO USUÁRIO PARA HOME
function contentBoleto($id_user) {
  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor_total 
                                      FROM tb_boleto b 
                                      JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto 
                                      WHERE dt_vencimento LIKE ? AND fk_user = ? AND fk_status = 4");
  $query->execute([date('Y-m') . '-%%', $id_user]);
  $pagos = $query->fetch(PDO::FETCH_ASSOC);

  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor_total 
                                      FROM tb_boleto b 
                                      JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto 
                                      WHERE dt_vencimento LIKE ? AND fk_user = ? AND fk_status = 4");
  $query->execute([date('Y-m') . '-%%', $id_user]);
  $pendentes = $query->fetch(PDO::FETCH_ASSOC);

  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor_total 
                                      FROM tb_boleto b 
                                      JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto 
                                      WHERE dt_vencimento < ? AND fk_user = ? AND fk_status = 7");
  $query->execute([date('Y-m-d'), $id_user]);
  $vencidos = $query->fetch(PDO::FETCH_ASSOC);

  return [$pagos, $pendentes, $vencidos];
}

// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DO BOLETO DO USUÁRIO
function viewBoleto($id_user, $id_boleto) {
  $query = $GLOBALS['conn']->prepare("SELECT descricao, dt_vencimento, cod_barra, obs, 
                                      CASE
                                        WHEN fk_status='4' THEN 'Pago'
                                        WHEN fk_status='5' THEN 'Pendente'
                                        WHEN fk_status='7' THEN 'Vencido'
                                      END AS 'status', valor, fk_pagamento, valor_pg
                                      FROM tb_boleto b
                                      JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto 
                                      LEFT JOIN tb_pagamento pg ON b.fk_pagamento=pg.id_pagamento
                                      WHERE id_boleto = ? AND fk_user = ?");
  $query->execute([$id_boleto, $id_user]);
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $result['valor'] = formatValores($result['valor']);
  $result['valor_pg'] = formatValores($result['valor_pg']);
  $result['dt_vencimento'] = date('d/m/Y', strtotime($result['dt_vencimento']));

  return $result;
}

// MÉTODO QUE ALTUALIZA AS INFORMAÇÕES DO BOLETO
function updateBoleto($id_user, $id_cheque, $fields) {
  $descricao = clean($fields['descricao']);
  $valor = str_replace(',', '.', str_replace('.', '', clean($fields['valor'])));
  $dt = clean($fields['dt']);
  $remetente = clean($fields['remetente']);
  $fk_status = clean($fields['fk_status']);
  $fk_instituicao = clean($fields['instituicao']);

  $query = $GLOBALS['conn']->prepare("UPDATE tb_cheque c  
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque 
                                        JOIN tb_status s ON s.id_status=c.fk_status 
                                        SET c.descricao = ?, c.valor = ?, c.dt = ?, c.remetente = ?, c.fk_status = ?, c.fk_instituicao = ? 
                                        WHERE c.id_cheque = ? AND ruc.fk_user = ?");
  $query->execute([$descricao, $valor, $dt, $remetente, $fk_status, $fk_instituicao, $id_cheque, $id_user]);

  return 'alert=update';
}

// MÉTODO QUE DELETA AS INFORMAÇÕES DO BOLETO
function deleteBoleto($id_user, $id_cheque) {
  $query = $GLOBALS['conn']->prepare("DELETE c FROM tb_cheque c
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                        WHERE id_cheque = ? AND fk_user = ?");
  $query->execute([$id_cheque, $id_user]);

  return 'alert=delete';
}

// MÉTODO QUE CRIA OS BOLETOS
function createBoleto($id_user, $fields) {
  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_cheque (descricao, valor, dt, remetente, dt_cadastro, fk_status, fk_instituicao) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
  $query->execute([$fields['descricao'], $fields['valor'], $fields['dt'], $fields['remetente'], $fields['dt_cadastro'], $fields['fk_status'], $fields['instituicao']]);

  $id_cheque = $GLOBALS['conn']->lastInsertId();

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_user_cheque (fk_user, fk_cheque) 
                                        VALUES (?, ?)");
  $query->execute([$id_user, $id_cheque]);

  return 'alert=create';
}

/*-----------------------------------       QUERYS - CHEQUE      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS CHEQUES DO USUÁRIO PARA HOME
function contentCheque($id_user) {
  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor 
                                      FROM tb_cheque c
                                      JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                      WHERE dt LIKE ? AND fk_user = ? AND fk_status = 8");
  $query->execute([date('Y-m').'-%%', $id_user]);
  $x = $query->fetch(PDO::FETCH_ASSOC);

  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor 
                                      FROM tb_cheque c
                                      JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                      WHERE dt LIKE ? AND fk_user = ? AND fk_status = 9");
  $query->execute([date('Y-m').'-%%', $id_user]);
  $y = $query->fetch(PDO::FETCH_ASSOC);

  return [$x['valor'], $y['valor']];
}

// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS CHEQUES DO USUÁRIO
function viewCheque($id_user, $id_cheque) {
  $query = $GLOBALS['conn']->prepare("SELECT descricao, valor, dt, remetente,
                                        CASE
                                          WHEN fk_status='8' THEN 'Enviado'
                                          WHEN fk_status='9' THEN 'Recebido'
                                        END AS 'status', nm_instituicao
                                        FROM tb_cheque c
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque 
                                        JOIN tb_instituicao ins ON c.fk_instituicao=ins.id_instituicao 
                                        WHERE id_cheque = ? AND fk_user = ?");
  $query->execute([$id_cheque, $id_user]);
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $result['valor'] = formatValores($result['valor']);
  $result['dt'] = date('d/m/Y', strtotime($result['dt']));

  return $result;
}

// MÉTODO QUE ALTUALIZA AS INFORMAÇÕES DO CHEQUE
function updateCheque($id_user, $id_cheque, $fields) {
  $descricao = clean($fields['descricao']);
  $valor = str_replace(',', '.', str_replace('.', '', clean($fields['valor'])));
  $dt = clean($fields['dt']);
  $remetente = clean($fields['remetente']);
  $fk_status = clean($fields['fk_status']);
  $fk_instituicao = clean($fields['instituicao']);

  $query = $GLOBALS['conn']->prepare("UPDATE tb_cheque c  
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque 
                                        SET c.descricao = ?, c.valor = ?, c.dt = ?, c.remetente = ?, c.fk_status = ?, c.fk_instituicao = ? 
                                        WHERE id_cheque = ? AND fk_user = ?");
  $query->execute([$descricao, $valor, $dt, $remetente, $fk_status, $fk_instituicao, $id_cheque, $id_user]);

  return 'alert=update';
}

// MÉTODO QUE DELETA AS INFORMAÇÕES DO CHEQUE
function deleteCheque($id_user, $id_cheque) {
  $query = $GLOBALS['conn']->prepare("DELETE c FROM tb_cheque c
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                        WHERE id_cheque = ? AND fk_user = ?");
  $query->execute([$id_cheque, $id_user]);

  return 'alert=delete';
}

// MÉTODO QUE CRIA OS CHEQUES
function createCheque($id_user, $fields) {
  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_cheque (descricao, valor, dt, remetente, dt_cadastro, fk_status, fk_instituicao) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
  $query->execute([$fields['descricao'], $fields['valor'], $fields['dt'], $fields['remetente'], $fields['dt_cadastro'], $fields['fk_status'], $fields['instituicao']]);

  $id_cheque = $GLOBALS['conn']->lastInsertId();

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_user_cheque (fk_user, fk_cheque) 
                                        VALUES (?, ?)");
  $query->execute([$id_user, $id_cheque]);

  return 'alert=create';
}

/*-----------------------------------       QUERYS - META      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DAS METAS DO USUÁRIO PARA HOME
function contentMeta($id_user) {
  $query = $GLOBALS['conn']->prepare("SELECT nome, valor_pretendido valor_total, valor_inicial, IFNULL(SUM(adm.valor), 0) valor_adicoes
                                      FROM tb_add_meta adm
                                      RIGHT JOIN tb_meta m ON m.id_meta=adm.fk_meta
                                      JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                      WHERE fk_user=? AND fk_status=10
                                      GROUP BY id_meta");
  $query->execute([$id_user]);
  $result = $query->FetchAll(PDO::FETCH_ASSOC);
  for ($k = 0; $k < sizeof($result); $k++) {
    $result[$k]['valor_atual'] = $result[$k]['valor_inicial'] + $result[$k]['valor_adicoes'];
    $result[$k]['percent'] = (float)(100 * $result[$k]['valor_atual']) / (float)$result[$k]['valor_total'];
  }

  return $result;
}

// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DA META DO USUÁRIO
function viewMeta($id_user, $id_meta) {
  $query = $GLOBALS['conn']->prepare("SELECT nome, descricao, dt_inicio, dt_fim, 
                                      CASE
                                        WHEN fk_status='1' THEN 'Concluído'
                                        WHEN fk_status='7' THEN 'Vencido'
                                        WHEN fk_status='10' THEN 'Andamento'
                                      END AS 'status', valor_inicial, valor_pretendido, IFNULL(SUM(adm.valor), 0) valor_adicoes
                                      FROM tb_meta m 
                                      LEFT JOIN tb_add_meta adm ON m.id_meta=adm.fk_meta
                                      JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                      WHERE id_meta = ? AND fk_user = ? GROUP BY id_meta");
  $query->execute([$id_meta, $id_user]);
  $result_x = $query->fetch(PDO::FETCH_ASSOC);

  if ($query->rowCount() > 0) {
    $result_x['valor_atual'] = formatValores($result_x['valor_inicial'] + $result_x['valor_adicoes']);
    $result_x['valor_inicial'] = formatValores($result_x['valor_inicial']);
    $result_x['valor_pretendido'] = formatValores($result_x['valor_pretendido']);
    $result_x['valor_adicoes'] = formatValores($result_x['valor_adicoes']);
    $result_x['dt_inicio'] = date('d/m/Y', strtotime($result_x['dt_inicio']));
    $result_x['dt_fim'] = date('d/m/Y', strtotime($result_x['dt_fim']));
  }

  $query = $GLOBALS['conn']->prepare("SELECT id_add_meta, dt, valor 
                                      FROM tb_add_meta adm 
                                      WHERE fk_meta = ? ORDER BY dt");
  $query->execute([$id_meta]);
  $result_y = $query->FetchAll(PDO::FETCH_ASSOC);
  
  if ($query->rowCount() > 0) {
    for($k = 0; $k < sizeof($result_y); $k++) {
      $result_y[$k]['valor'] = formatValores($result_y[$k]['valor']);
      $result_y[$k]['dt'] = date('d/m/Y', strtotime($result_y[$k]['dt']));
    }
  } else {
    $result_y['null'] = 'Adicionar pagamento';
  }

  return [$result_x, $result_y];
}

// MÉTODO QUE ALTUALIZA AS INFORMAÇÕES DA META
function updateMeta($id_user, $id_meta, $fields) {
  if ($fields['valor_atual'] >= $fields['valor_pretendido']) {
    $status = '1';
  } else if (date('Y-m-d') > $fields['dt_fim']) {
    $status = '7';
  } else {
    $status = '10';
  }

  $query = $GLOBALS['conn']->prepare("UPDATE tb_meta m
                                      JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                      SET m.valor_pretendido = ?, m.valor_inicial = ?, m.dt_inicio = ?, m.dt_fim = ?, 
                                      m.nome = ?, m.descricao = ?, m.fk_status = ?
                                      WHERE id_meta = ? AND fk_user = ?");
  $query->execute([$fields['valor_pretendido'], $fields['valor_inicial'], $fields['dt_inicio'], $fields['dt_fim'], $fields['nome'], 
                  $fields['descricao'], $status, $id_meta, $id_user]);

  return 'alert=update';
}

// MÉTODO QUE DELETA AS INFORMAÇÕES DA META
function deleteMeta($id_user, $id_meta) {
  $query = $GLOBALS['conn']->prepare("DELETE adm FROM tb_add_meta adm
                                      JOIN tb_meta m ON m.id_meta=adm.fk_meta
                                      WHERE id_meta=(SELECT id_meta FROM tb_meta m
                                      JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                      WHERE id_meta = ? AND fk_user = ?)");
  $query->execute([$id_meta, $id_user]);

  $query = $GLOBALS['conn']->prepare("DELETE m FROM tb_meta m
                                      JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                                      WHERE id_meta = ? AND fk_user = ?");
  $query->execute([$id_meta, $id_user]);

  return 'alert=delete';
}

// MÉTODO QUE CRIA AS METAS
function createMeta($id_user, $fields) {
  if (date('Y-m-d') > $fields['dt_fim']) {
    $status = '7';
  } else {
    $status = '10';
  }

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_meta (valor_pretendido, valor_inicial, dt_inicio, dt_fim, nome, descricao, dt_cadastro, fk_status) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  $query->execute([$fields['valor_pretendido'], $fields['valor_inicial'], $fields['dt_inicio'], $fields['dt_fim'], $fields['nome'], 
                  $fields['descricao'], $fields['dt_cadastro'], $status]);

  $id_meta = $GLOBALS['conn']->lastInsertId();

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_user_meta (fk_user, fk_meta) 
                                      VALUES (?, ?)");
  $query->execute([$id_user, $id_meta]);

  return 'alert=create';
}

/*-----------------------------------       QUERYS - CARTÃO      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS CARTÕES DO USUÁRIO PARA HOME
function contentCartao($id_user) {
  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor 
                                      FROM tb_cartao c
                                      JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                                      WHERE mes_fatura LIKE ? AND fk_user = ?");
  $query->execute([date('Y-m').'-%%', $id_user]);
  $result_x = $query->fetch(PDO::FETCH_ASSOC);

  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor), 0) valor 
                                      FROM tb_cartao c
                                      JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                                      WHERE mes_fatura LIKE ? AND fk_user = ?");
  $query->execute([date('Y-m', strtotime("-1 month")).'-%%', $id_user]);
  $result_y = $query->fetch(PDO::FETCH_ASSOC);

  if($result_x['valor'] == 0 && $result_y['valor'] == 0 || ($result_x['valor'] === $result_y['valor']) || $result_y['valor'] == 0){
    $porcentagem = '<p class="card_qtd_valor card_qtd_valor--center">Sem dados para comparação</p>';
  }else{
    if($result_x['valor'] > $result_y['valor']){
      $taxa = (float)($result_x['valor'] - $result_y['valor']) * 100 / (float)$result_y['valor'];
      $porcentagem = '<p class="card_qtd_valor card_qtd_valor--center">Aumento na fatura atual <span class="porcentagem">'.formatValores($taxa).'%</span></p>';
    }else{
      $taxa = (float)($result_y['valor'] - $result_x['valor']) * 100 / (float)$result_y['valor'];
      $porcentagem = '<p class="card_qtd_valor card_qtd_valor--center">Diminuição na fatura atual <span class="porcentagem">'.formatValores($taxa).'%</span></p>';
    }
  }

  $result_y['valor'] = formatValores($result_y['valor']);
  $result_y['mes'] = qualMes(date('m') - 1);
  $result_x['valor'] = formatValores($result_x['valor']);
  $result_x['mes'] = qualMes(date('m'));

  return [$result_x, $result_y, $porcentagem];
}

// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS CARTÕES DO USUÁRIO
function viewCartao($id_user, $id_cartao) {
  $query = $GLOBALS['conn']->prepare("SELECT nome, mes_fatura, 
                                      CASE 
                                        WHEN fk_pagamento IS NULL THEN 'Pendente'
                                          ELSE 'Pago'
                                      END AS 'status', valor, fk_pagamento, valor_pg
                                      FROM tb_cartao c
                                      JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                                      LEFT JOIN tb_pagamento pg ON c.fk_pagamento=pg.id_pagamento
                                      WHERE id_cartao = ? AND fk_user = ?");
  $query->execute([$id_cartao, $id_user]);
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $result['valor'] = formatValores($result['valor']);
  $result['valor_pg'] = formatValores($result['valor_pg']);
  $result['mes_fatura'] = date('d/m/Y', strtotime($result['mes_fatura']));

  return $result;
}

// MÉTODO QUE ALTUALIZA AS INFORMAÇÕES DO CARTÃO
function updateCartao($id_user, $id_cheque, $fields) {
  $descricao = clean($fields['descricao']);
  $valor = str_replace(',', '.', str_replace('.', '', clean($fields['valor'])));
  $dt = clean($fields['dt']);
  $remetente = clean($fields['remetente']);
  $fk_status = clean($fields['fk_status']);
  $fk_instituicao = clean($fields['instituicao']);

  $query = $GLOBALS['conn']->prepare("UPDATE tb_cheque c  
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque 
                                        JOIN tb_status s ON s.id_status=c.fk_status 
                                        SET c.descricao = ?, c.valor = ?, c.dt = ?, c.remetente = ?, c.fk_status = ?, c.fk_instituicao = ? 
                                        WHERE c.id_cheque = ? AND ruc.fk_user = ?");
  $query->execute([$descricao, $valor, $dt, $remetente, $fk_status, $fk_instituicao, $id_cheque, $id_user]);

  return 'alert=update';
}

// MÉTODO QUE DELETA AS INFORMAÇÕES DO CARTÃO
function deleteCartao($id_user, $id_cheque) {
  $query = $GLOBALS['conn']->prepare("DELETE c FROM tb_cheque c
                                        JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                                        WHERE id_cheque = ? AND fk_user = ?");
  $query->execute([$id_cheque, $id_user]);

  return 'alert=delete';
}

// MÉTODO QUE CRIA OS CARTÕES
function createCartao($id_user, $fields) {
  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_cheque (descricao, valor, dt, remetente, dt_cadastro, fk_status, fk_instituicao) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?)");
  $query->execute([$fields['descricao'], $fields['valor'], $fields['dt'], $fields['remetente'], $fields['dt_cadastro'], $fields['fk_status'], $fields['instituicao']]);

  $id_cheque = $GLOBALS['conn']->lastInsertId();

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_user_cheque (fk_user, fk_cheque) 
                                        VALUES (?, ?)");
  $query->execute([$id_user, $id_cheque]);

  return 'alert=create';
}

/*-----------------------------------       QUERYS - INVESTIMENTOS      -----------------------------------*/
// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS INVESTIMENTOS DO USUÁRIO PARA HOME
function contentInvestimento($id_user) {
  $query = $GLOBALS['conn']->prepare("SELECT IFNULL(SUM(valor_cota * qtd_cota), 0) valor_total, COUNT(fk_user) qtd_investimentos 
                                      FROM tb_investimento i
                                      JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                                      WHERE fk_user = ? AND fk_status = 3");
  $query->execute([$id_user]);
  $result_x = $query->fetch(PDO::FETCH_ASSOC);

  $query = $GLOBALS['conn']->prepare("SELECT COUNT(tipo) qtd,  
                                      CASE
                                        WHEN tipo='tesouro_direto' THEN 'Tesouro Direto'
                                        WHEN tipo='fundos' THEN 'Fundos'
                                        WHEN tipo='renda_fixa' THEN 'Renda Fixa'
                                        WHEN tipo='renda_variavel' THEN 'Renda Variável'
                                        WHEN tipo='poupanca' THEN 'Poupança'
                                        WHEN tipo='previdencia_privada' THEN 'Previdência Privada'
                                        WHEN tipo='coe' THEN 'COE'
                                        WHEN tipo='oferta_publica' THEN 'Oferta Pública'
                                        WHEN tipo='produtos_estruturados' THEN 'Produtos Estruturados'
                                      END AS tipo 
                                      FROM tb_investimento i
                                      RIGHT JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                                      WHERE fk_user = ? AND fk_status = 3
                                      GROUP BY tipo ORDER BY tipo");
  $query->execute([$id_user]);
  $result_y = $query->FetchAll(PDO::FETCH_ASSOC);

  for($j=0;$j<sizeof($result_y);$j++){
    $result_y[$j]['percent'] = number_format((float)($result_y[$j]['qtd'] * 100 / $result_x['qtd_investimentos']), 2, '.', ' ').'%';
  }

  $result_x['valor_total'] = formatValores($result_x['valor_total']);

  return [$result_x, $result_y];
}

// MÉTODO QUE RETORNA TODAS AS INFORMAÇÕES DOS INVESTIMENTOS DO USUÁRIO
function viewInvestimento($id_user, $id_investimento) {
  $query = $GLOBALS['conn']->prepare("SELECT nome, dt_investimento, dt_vencimento, qtd_cota, valor_cota, 
                                      valor_rentabilidade, tipo_rentabilidade, id_instituicao, nm_instituicao, 
                                      CASE
                                        WHEN tipo='tesouro_direto' THEN 'Tesouro Direto'
                                        WHEN tipo='fundos' THEN 'Fundos'
                                        WHEN tipo='renda_fixa' THEN 'Renda Fixa'
                                        WHEN tipo='renda_variavel' THEN 'Renda Variável'
                                        WHEN tipo='poupanca' THEN 'Poupança'
                                        WHEN tipo='previdencia_privada' THEN 'Previdência Privada'
                                        WHEN tipo='coe' THEN 'COE'
                                        WHEN tipo='oferta_publica' THEN 'Oferta Pública'
                                        WHEN tipo='produtos_estruturados' THEN 'Produtos Estruturados'
                                      END AS tipo, 
                                      CASE
                                        WHEN fk_status='7' THEN 'Vencido'
                                        WHEN fk_status='3' THEN 'Ativo'
                                      END AS 'status', (qtd_cota * valor_cota) valor_total 
                                      FROM tb_investimento i 
                                      JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento 
                                      JOIN tb_instituicao ins ON ins.id_instituicao=i.fk_instituicao 
                                      WHERE id_investimento = ? AND fk_user = ?");
  $query->execute([$id_investimento, $id_user]);
  $result = $query->fetch(PDO::FETCH_ASSOC);

  $result['valor_cota'] = formatValores($result['valor_cota']);
  $result['valor_rentabilidade'] = formatValores($result['valor_rentabilidade']) .'%';
  $result['valor_total'] = formatValores($result['valor_total']);
  return $result;
}

// MÉTODO QUE ALTUALIZA AS INFORMAÇÕES DO INVESTIMENTO
function updateInvestimento($id_user, $id_investimento, $fields) {
  $nome = clean($fields['nome']);
  $instituicao = clean($fields['instituicao']);
  $tipo = clean($fields['tipo']);
  $tipo_rentabilidade = clean($fields['tipo_rentabilidade']);
  $valor_rentabilidade = str_replace(',', '.', str_replace('%', '', clean($fields['valor_rentabilidade'])));
  $dt_investimento = date('Y-m-d', strtotime(clean($fields['dt_investimento'])));
  $dt_vencimento = date('Y-m-d', strtotime(clean($fields['dt_vencimento'])));;
  $qtd_cota = clean($fields['qtd_cota']);
  $valor_cota = str_replace(',', '.', str_replace('.', '', clean($fields['valor_cota'])));

  if (date('Y-m-d') > $dt_vencimento) {
    $status = '7';
  } else {
    $status = '3';
  }

  $query = $GLOBALS['conn']->prepare("UPDATE tb_investimento i
                                      JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                                      SET i.nome = ?, i.tipo = ?, i.dt_investimento = ?, i.dt_vencimento = ?, i.qtd_cota = ?, i.valor_cota = ?, 
                                      i.valor_rentabilidade = ?, i.tipo_rentabilidade = ?, i.fk_status = ?, i.fk_instituicao = ?
                                      WHERE id_investimento = ? AND fk_user = ?");
  $query->execute([$nome, $tipo, $dt_investimento, $dt_vencimento, $qtd_cota, $valor_cota, $valor_rentabilidade, $tipo_rentabilidade, $status, $instituicao, $id_investimento, $id_user]);

  return 'alert=update';
}

// MÉTODO QUE DELETA AS INFORMAÇÕES DO INVESTIMENTO
function deleteInvestimento($id_user, $id_investimento) {
  $query = $GLOBALS['conn']->prepare("DELETE i FROM tb_investimento i
                                      JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                                      WHERE id_investimento= ? AND fk_user = ?");
  $query->execute([$id_investimento, $id_user]);

  return 'alert=delete';
}

// MÉTODO QUE CRIA OS INVESTIMENTOS
function createInvestimento($id_user, $fields) {
  if (date('Y-m-d') > $fields['dt_vencimento']) {
    $status = '7';
  } else {
    $status = '3';
  }

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_investimento (nome, tipo, dt_investimento, dt_vencimento, qtd_cota, valor_cota, valor_rentabilidade, tipo_rentabilidade, dt_cadastro, fk_status, fk_instituicao) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $query->execute([$fields['nome'], $fields['tipo'], $fields['dt_investimento'], $fields['dt_vencimento'], $fields['qtd_cota'], $fields['valor_cota'], 
                  $fields['valor_rentabilidade'], $fields['tipo_rentabilidade'], $fields['dt_cadastro'], $status, $fields['instituicao']]);

  $id_investimento = $GLOBALS['conn']->lastInsertId();

  $query = $GLOBALS['conn']->prepare("INSERT INTO tb_user_investimento (fk_user,fk_investimento) 
                                      VALUES (?, ?)");
  $query->execute([$id_user, $id_investimento]);

  return 'alert=create';
}