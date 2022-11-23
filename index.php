<?php
    require './php/db/conexao.php';

    $erro = '';
    $email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';

    //CASO NO GET HAJA ALGUM ERRO, DEFINE O ERRO E O EXIBE
    if(isset($_GET['invalid'])){$erro = "<span class='span_erro_login invalid'><p class='p_erro_login'>E-mail e/ou senha incorretos!</p></span>";}
    if(isset($_GET['confirm'])){$erro = "<span class='span_erro_login'><p class='p_erro_login'>Por favor confirmar E-mail</p><a href='' class='reenvio_confirmao_email'>Reenviar confirmação</a></span>";}
    if(isset($_GET['sucess'])){$erro = "<span class='span_erro_login invalid'><p class='p_erro_login'>Usuário cadastrado com sucesso!</p></span>";}
    if(isset($_GET['delete'])){$erro = "<span class='span_erro_login invalid'><p class='p_erro_login'>Usuário deletado com sucesso!</p></span>";}

    //EXECUTA O MÉTODO CASO AS CONDIÇÕES ESTEJAM DE ACORDO
    if(isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['senha'])){
        $email = clean($_POST['email']);
        // $senha = clean($_POST['senha']);
        $senha = sha1(clean($_POST['senha']));

        //QUERY PARA CONSULTAR SE O USUÁRIO ESTÁ CADASTRADO
        $query = $conn->prepare("SELECT id_user, email, senha, ativo FROM tb_user WHERE email=? AND senha=?");
        $query->execute([$email,$senha]);

        if($query->rowCount() > 0){
            $row_return = $query->fetch(PDO::FETCH_ASSOC);

            //TRANSFORMA OS ÍNDICES DO ARRAY EM VARIÁVEIS COM SEUS DEVIDOS VALORES
            extract($row_return);
            
            //COOKIE LEMBRAR DO EMAIL
            if(isset($_POST['lembrar_email'])){
                $validade = strtotime("+1 month");
                setcookie('email', $email, $validade, '/', '', false, true);
            }else{
                $validade = strtotime("-1 month");
                setcookie('email', '', $validade, '/', '', false, true);
            }

            //VERIFICA SE O USUÁRIO ESTÁ COM O CADASTRO ATIVO
            if($ativo == 'n'){
                header('location: index.php?confirm');
            }else{
                $_SESSION['id_user'] = $id_user;

                header('location: ./php/home.php');
            }
        }else{
            //CASO NAO HAJA CONFIRMAÇÃO DO CADASTRO SE DESFAZ DA SESSÃO E RETORNA PARA O LOGIN
            session_unset();
            session_destroy();

            header('location: index.php?invalid');
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>FINP - LOGIN</title>

    <link rel="stylesheet" href="./assets/css/login.css">

    <script src="./assets/js/script.js" defer></script>
    <!-- FONTSAWESOME - LINK -->
    <script src="https://kit.fontawesome.com/ab587c5cd2.js" crossorigin="anonymous"></script>
</head>
<body class="login" onload="erro_login()">
    <main class="login">
        <section class="login_container">
            <!-- IMPRIME A MENSAGEM DE ERRO -->
            <?=$erro?>
            <form class="form_login" method="post">
                <h1>Login</h1>

                <article class="input_container">
                    <input type="email" name="email" id="email" maxlength="200" value="<?=$email?>" required>
                    <label class="email_label login_label" for="email">Email</label>
                    <span class="error"></span>
                </article>

                <article class="input_container">
                    <input type="password" name="senha" id="senha" minlength="5" maxlength="100" required>
                    <label class="senha_label login_label error_field" for="senha">Senha</label>
                    <i class="cadeado fa-solid fa-lock"></i>
                    <span class="error"></span>
                </article>

                <div class="remember_forgot">
                    <div>
                        <label class="remember" for="lembrar_email">Lembrar e-mail</label>
                        <input type="checkbox" name="lembrar_email" id="lembrar_email" <?php if($email != ''){echo "checked";} ?>>
                    </div>

                    <a href="#esqueceu_senha">esqueceu a senha?</a>
                </div>

                <div class="entrar">
                    <a href="./php/cadastro.php">cadastrar-se</a>

                    <input type="submit" value="entrar" name="login">
                </div>
            </form>

            <p class="footer_login">Todos os direitos reservados - &copy;FINP 2022</p>
        </section>
    </main>
</body>
</html>