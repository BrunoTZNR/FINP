<?php
    require './../php/db/conexao.php';

    $resultado_estado = '';

    $query = $conn->prepare("SELECT * FROM tb_estado");
    $query->execute();
    
    // MOSTRA OS ESTADOS
    if($query->rowCount() > 0){
        $resultado_estado .= '<option selected hidden></option>';

        while($estado = $query->fetch(PDO::FETCH_ASSOC)){
            $resultado_estado .= '<option value="'.$estado['cod_estado'].'">'.$estado['nm_estado'].'</option>';
        }
    }

    // FAZER CADASTRO
    if(isset($_POST['cadastro'])){
        $nome = clean($_POST['nome']);
        $sobrenome = clean($_POST['sobrenome']);
        $email = clean($_POST['email']);

        $telefone = explode(')' ,str_replace(['(','-'],"",clean($_POST['telefone'])));
        $ddd = $telefone[0];
        $telefone = $telefone[1];

        $senha = sha1(clean($_POST['senha']));
        $dt_nasc = clean($_POST['dt_nasc']);
        $sexo = clean($_POST['sexo']);
        $cep = str_replace('-','', clean($_POST['cep']));
        $cod_estado = clean($_POST['estado']);
        $cidade = clean($_POST['cidade']);
        $rua = clean($_POST['rua']);
        $bairro = clean($_POST['bairro']);
        $numero = clean($_POST['numero']);
        $complemento = clean($_POST['complemento']);

        $dt_cadastro = date('Y-m-d H:i:s');
        $auto = uniqid().date('Y-m-dH:i:s');
        $cod_seguranca = 'teste';
        $ativo = 's';

        if(!empty($_POST['cpf'])){
            // CADASTRO DE PESSOA FISICA
            $cpf = str_replace(['.','-'],'',clean($_POST['cpf']));

            // tb_pf
            $query = $conn->prepare("INSERT INTO tb_pf (cpf) 
                                    VALUES (?)");
            $query->execute([$cpf]);
            $fk_pf = $conn->lastInsertId();
            $fk_pj = NULL;
        }else{
            // CADASTRO DE PESSOA JURIDICA
            $cnpj = str_replace(['.','/','-'],'',clean($_POST['cnpj']));
            $nm_empresa = clean($_POST['nm_empresa']);

            // tb_pj
            $query = $conn->prepare("INSERT INTO tb_pj (cnpj,nm_empresa) 
                                    VALUES (?,?')");
            $query->execute([$cnpj,$nm_empresa]);
            $fk_pj = $conn->lastInsertId();
            $fk_pf = NULL;
        }

        // tb_pessoa
        $query = $conn->prepare("INSERT INTO tb_pessoa (nome,sobrenome,dt_nasc,sexo,fk_pf,fk_pj) 
                                VALUES(?,?,?,?,?,?)");
        $query->execute([$nome,$sobrenome,$dt_nasc,$sexo,$fk_pf,$fk_pj]);
        $fk_pessoa = $conn->lastInsertId();

        // tb_cidade
        $query = $conn->prepare("INSERT INTO tb_cidade (nm_cidade,fk_estado) 
        VALUES (?,?)");
        $query->execute([$cidade,$cod_estado]);
        $fk_cidade = $conn->lastInsertId();

        // tb_endereco
        $query = $conn->prepare("INSERT INTO tb_endereco (cep,rua,bairro,numero,complemento,fk_cidade)
                                VALUES (?,?,?,?,?,?);");
        $query->execute([$cep,$rua,$bairro,$numero,$complemento,$fk_cidade]);
        $fk_endereco = $conn->lastInsertId();

        // tb_user
        $query = $conn->prepare("INSERT INTO tb_user (email,senha,ddd,telefone,auto,cod_seguranca,ativo,dt_cadastro,fk_pessoa,fk_endereco) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)");
        $query->execute([$email,$senha,$ddd,$telefone,$auto,$cod_seguranca,$ativo,$dt_cadastro,$fk_pessoa,$fk_endereco]);

        header('location: ./../index.php?sucess');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Projeto para faculdade FINP - Financeiro pessoal, onde a pessoa pode ter o controle de sua vida financeira">
    <meta name="author" content="BrunoTZNR and Ésoj">

    <title>FINP - CADASTRO</title>

    <link rel="stylesheet" href="../assets/css/cadastrar.css">

    <script src="./../assets/js/viaCep_api.js" defer></script>
    <script src="./../assets/js/cadastro.js" defer></script>
    <!-- FONTSAWESOME - LINK -->
    <script src="https://kit.fontawesome.com/ab587c5cd2.js" crossorigin="anonymous"></script>

</head>
<body class="cadastrar">
    <main class="cadastro">
        <section class="cadastro_container">
            <form method="post" class="form_cadastro">
                <h1 class="cad_title">Cadastro</h1>

                <section class="barra_progressao_cad" style="display: none;">
                    <div></div>
                </section>

                <section class="cad_container">
                    <div class="div_section">
                        <div class="input_container">
                            <input type="text" name="nome" id="nome" maxlength="45" required>
                            <label class="nome_label label_input" for="nome">Nome</label>
                            <!-- <span class="error">Nome inválido!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="text" name="sobrenome" id="sobrenome" maxlength="45" required>
                            <label class="sobrenome_label label_input" for="sobrenome">Sobrenome</label>
                            <!-- <span class="error">Sobrenome inválido!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="email" name="email" id="email" maxlength="200" required>
                            <label class="email_label label_input" for="email">Email</label>
                            <!-- <span class="error">E-mail inválido!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="text" name="telefone" id="telefone" maxlength="14" required>
                            <label class="telefone_label label_input" for="telefone">telefone</label>
                            <!-- <span class="error">Telefone inválido!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="password" name="senha" id="senha" maxlength="100" required>
                            <label class="senha_label label_input" for="senha">Senha</label>
                            <!-- <span class="error">Senha inválida!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="password" name="repete_senha" id="repete_senha" maxlength="100" required>
                            <label class="repete_senha_label label_input" for="repete_senha">Repete senha</label>
                            <!-- <span class="error">Senhas incompatíveis!</span> -->
                        </div>

                        <div class="input_container">
                            <input type="date" name="dt_nasc" id="dt_nasc" maxlength="100" required>
                            <label class="dt_nasc_label label_input" for="dt_nasc">Data de nascimento</label>
                            <!-- <span class="error">Data de nascimento inválida!</span> -->
                        </div>

                        <article class="input_container">
                            <select name="sexo" id="sexo" required>
                                <option selected hidden></option>
                                <option value="f">Feminino</option>
                                <option value="m">Masculino</option>
                                <option value="o">Outro</option>
                                <option value="n">Não informar</option>
                            </select>
                            <label class="sexo_label label_input" for="sexo">Gênero</label>
                            <!-- <span class="error">Gênero inválido!</span> -->
                        </article>
                    </div>

                    <div class="div_section">
                        <article class="tipo_title_container">
                            <input type="radio" name="tipo" id="pf" value="pf" checked>
                            <label class="label_tipo pf" for="pf">Pessoa Fisica</label>
                            <input type="radio" name="tipo" id="pj" value="pf" >
                            <label class="label_tipo pj" for="pj">Pessoa Juridica</label>
                        </article>

                        <section class="pf_container input_container">
                            <input type="text" name="cpf" id="cpf" maxlength="14" required>
                            <label class="cpf_label label_input" for="cpf">CPF</label>
                            <!-- <span class="error">CPF inválido!</span> -->
                        </section>

                        <section class="pj_container input_container" style="display: none;">
                            <article class="input_container">
                                <input type="text" name="cnpj" id="cnpj" maxlength="18">
                                <label class="cnpj_label label_input" for="cnpj">CNPJ</label>
                                <!-- <span class="error">CNPJ inválida!</span> -->
                            </article>

                            <article class="input_container">
                                <input type="text" name="nm_empresa" id="nm_empresa" maxlength="50">
                                <label class="nm_empresa_label label_input" for="nm_empresa">Nome da empresa</label>
                                <!-- <span class="error">Nome da empresa inválido!</span> -->
                            </article>
                        </section>

                        <div class="div_section_compost">
                            <article class="input_container">
                                <input type="text" name="cep" id="cep" maxlength="9" onblur="pesquisacep(this.value);" required>
                                <label class="cep_label label_input" for="cep">CEP</label>
                                <!-- <span class="error">CEP inválido!</span> -->
                            </article>

                            <article class="input_container">
                                <select name="estado" id="estado" required>
                                    <?= $resultado_estado ?>
                                </select>
                                <label class="estado_label label_input" for="estado">Estado</label>
                                <!-- <span class="error">Estado inválido!</span> -->
                            </article>
                        </div>

                        <div class="input_container">
                            <input type="text" name="cidade" id="cidade" maxlength="45" required>
                            <label class="cidade_label label_input" for="cidade">Cidade</label>
                            <!-- <span class="error">Cidade inválida!</span> -->
                        </div>
                        
                        <article class="input_container">
                            <input type="text" name="rua" id="rua" maxlength="100" required>
                            <label class="rua_label label_input" for="rua">Rua</label>
                            <!-- <span class="error">Rua inválida!</span> -->
                        </article>

                        <article class="input_container">
                            <input type="text" name="bairro" id="bairro" maxlength="40" required>
                            <label class="bairro_label label_input" for="bairro">Bairro</label>
                            <!-- <span class="error">Bairro inválido!</span> -->
                        </article>

                        <div class="div_section_compost">
                            <article class="input_container">
                                <input type="text" name="numero" id="numero" maxlength="6" required>
                                <label class="numero_label label_input" for="numero">Número</label>
                                <!-- <span class="error">Número inválido!</span> -->
                            </article>

                            <article class="input_container">
                                <input type="text" name="complemento" id="complemento" maxlength="50" required>
                                <label class="complemento_label label_input" for="complemento">Complemento</label>
                                <!-- <span class="error">Complemento inválido!</span> -->
                            </article>
                        </div>
                        
                    </div>
                </section>

                <section class="enviar_container">
                    <a href="./../index.php">Voltar</a>

                    <input type="submit" value="Cadastrar" name="cadastro">
                </section>
            </form>
        </section>
    </main>
</body>
</html>