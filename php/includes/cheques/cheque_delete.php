<?php
  require './../../db/conexao.php';

  $logout = './../../logout.php';
  verifyLogin($logout);

  // VER SE O USUÁRIO É PF OU PJ
  $query = $conn->prepare("SELECT fk_pf tipo FROM tb_user u
                          JOIN tb_pessoa p ON p.id_pessoa=u.fk_pessoa
                          WHERE id_user = ?");
  $query->execute([$_SESSION['id_user']]);
  $tipo = $query->fetch(PDO::FETCH_ASSOC);

  // DELETA OS RELACIONAMENTOS DO USUÁRIO
  // RELACIONAMENTO
  $query = $conn->prepare("DELETE p FROM tb_pagamento p
                          JOIN tb_boleto b ON p.id_pagamento=b.fk_pagamento
                          WHERE id_boleto IN(SELECT id_boleto FROM tb_boleto b
                          JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto
                          WHERE fk_user = ? ORDER BY id_boleto)");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO
  $query = $conn->prepare("DELETE b FROM tb_boleto b
                          JOIN tb_user_boleto rub ON b.id_boleto=rub.fk_boleto
                          WHERE fk_user = ?");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO
  $query = $conn->prepare("DELETE c FROM tb_cheque c
                          JOIN tb_user_cheque ruc ON c.id_cheque=ruc.fk_cheque
                          WHERE fk_user = ?");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO
  $query = $conn->prepare("DELETE adm FROM tb_meta m
                          JOIN tb_add_meta adm ON m.id_meta=adm.fk_meta
                          WHERE id_meta IN (SELECT id_meta FROM tb_meta m
                          JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                          WHERE fk_user = ?)");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO META
  $query = $conn->prepare("DELETE m FROM tb_meta m
                          JOIN tb_user_meta rum ON m.id_meta=rum.fk_meta
                          WHERE fk_user = ?");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO PAGAMENTO
  $query = $conn->prepare("DELETE p FROM tb_pagamento p
                          JOIN tb_cartao c ON p.id_pagamento=c.fk_pagamento
                          WHERE id_cartao IN(SELECT id_cartao FROM tb_cartao c
                          JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                          WHERE fk_user = ? ORDER BY id_cartao)");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO CARTÃO
  $query = $conn->prepare("DELETE c FROM tb_cartao c
                          JOIN tb_user_cartao ruc ON c.id_cartao=ruc.fk_cartao
                          WHERE fk_user = ?");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO
  $query = $conn->prepare("DELETE ins FROM tb_instituicao ins
                          JOIN tb_investimento i ON ins.id_instituicao=i.fk_instituicao
                          WHERE id_investimento IN (SELECT id_investimento FROM tb_investimento i 
                          JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                          WHERE fk_user = ? ORDER BY fk_user)");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO INVESTIMENTO
  $query = $conn->prepare("DELETE i FROM tb_investimento i
                          JOIN tb_user_investimento rui ON i.id_investimento=rui.fk_investimento
                          JOIN tb_instituicao ins ON ins.id_instituicao=i.fk_instituicao
                          JOIN tb_status s ON s.id_status=i.fk_status
                          WHERE fk_user = ?");
  $query->execute([$_SESSION['id_user']]);

  // RELACIONAMENTO COM USER - INVESTIMENTO
  $query = $conn->prepare("DELETE u FROM tb_user u
                          JOIN tb_user_investimento rui ON u.id_user=rui.fk_investimento
                          JOIN tb_investimento i ON i.id_investimento=rui.fk_investimento
                          WHERE id_user = ?");
  $query->execute([$_SESSION['id_user']]);

  $query = $conn->prepare("DELETE c,e FROM tb_cidade c
                          JOIN tb_endereco e ON e.fk_cidade=c.id_cidade
                          WHERE id_cidade = ? AND fk_cidade = ?");
  $query->execute([$_SESSION['id_user'], $_SESSION['id_user']]);

  if ($tipo['tipo'] != ''){
    // PF
    // DELETA O USUÁRIO
    $query = $conn->prepare("DELETE p,pf FROM tb_pessoa p
                            JOIN tb_pf pf ON pf.id_pf=p.fk_pf
                            WHERE id_pessoa = ? AND id_pf = ?");
    $query->execute([$_SESSION['id_user'], $_SESSION['id_user']]);
  } else {
    // PJ
    // DELETA O USUÁRIO
    $query = $conn->prepare("DELETE p,pj FROM tb_pessoa p
                            JOIN tb_pj pj ON pj.id_pj=p.fk_pj
                            WHERE id_pessoa = ? AND id_pj = ?");
    $query->execute([$_SESSION['id_user'], $_SESSION['id_user']]);
  }

  // DIRECIONA PARA INDEX COM ALERT DE DELETE
  session_unset();
  session_destroy();
  header("Location: ./../../../index.php?delete");
?>