<?php
require_once(__DIR__.'/../src/database_connection.php');
require_once("vendor/autoload.php"); # Carrega a biblioteca JWT
use Firebase\JWT\JWT;

session_start(); # Permite a criação de sessões.
# Chamado quando a tela é atualizada.
if ($_SERVER['REQUEST_METHOD']=="POST") {
    if (isset($_SESSION["email"]) && isset($_POST["password"])) {
        $email = $_SESSION["email"];
        $password = $_POST["password"];
        $remember_me = isset($_POST["rememberMe"]) ? true : false;

        $user = checkUser(email: $email, password: $password);

        if ($user) {
            $token = encodeJWT(user: $user);
            $expires = date('Y-m-d H:i:s', time()+(24*60*60));

            # Armazena o token no banco de dados.
            execute_query(query: "INSERT INTO Tokens (IdUsuario, Token, ExpiracaoToken) VALUES (?, ?, ?)", params: [$user["id"], $token, $expires]);

            # Cria sessão ou cookie do token, dependendo se a opção "Manter conectado" foi selecionada.
            if ($remember_me) {
                setcookie(name: "token", value: $token,expires_or_options: time()+(0*24*60*60));
            } else {
                $_SESSION["token"] = $token;
            }

            # Vai para a tela de boas vindas.
            header(header: "Location: main.php");
            exit();
            
        } else {
            # Se a senha estiver incorreta, retorna a primeira tela de login.
            session_destroy();
            header(header: "Location: index.php");
            exit();
        }

    }
    else if (isset($_POST["email"])) {
        # Armazena o email enviado por login_email.php em sessão.
        $_SESSION["email"] = $_POST["email"];
    }
    else {
        # Quando a tela é acessada de forma errada, redireciona para a primeira tela de login. 
        session_destroy();
        header(header: "Location: login_email.php");
        exit();
    }
}

function checkUser(string $email, string $password): array|bool {
    # Busca o usuário pelo e-mail
    $user = execute_query("SELECT * FROM Usuarios WHERE Email = ?", [$email]);

    # Se o usuário não existir, cria um novo
    if (empty($user)) {
        $username = strstr($email, '@', true); # Extrai o nome antes do @
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); # Hash seguro

        # Insere o novo usuário no banco
        execute_query(query: "INSERT INTO Usuarios (Nome, Email, Senha) VALUES (?, ?, ?)", params: [$username, $email, $hashedPassword]);

        # Busca o usuário recém-criado para retorná-lo
        $user = execute_query(query: "SELECT * FROM Usuarios WHERE Email = ?", params: [$email]);
    }

    # Verifica a senha informada com o hash salvo no banco
    if (!empty($user) && password_verify(password: $password, hash: $user[0]["senha"])) {
        return $user[0]; # Retorna apenas o primeiro usuário encontrado
    } 

    return false;
}

function encodeJWT($user):String {
    $login_time = date(format: "Y-m-d H:i:s"); # Hora atual.
    $expires = time()+(24*60*60); # Duração de um dia para expirar o token.
    # Payload do token.
    $payload = [
        "exp" => $expires,
        "id" => $user['id'],
        "name" => $user["nome"],
        "email"=> $user["email"],
        "login_time"=> $login_time,
    ];
    # Criar token JWT utilizando a chave secreta JWT_SECRET das variáveis de ambiente.
    $token = JWT::encode($payload, $_ENV["JWT_SECRET"], "HS256");
    return $token;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acesse sua conta</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <div class="card border border-light-subtle rounded-3 shadow-sm">
                    <div class="card-body p-3 p-md-4 p-xl-5">
                        <div class="text-center mb-3">
                            <a href="#!">
                                <img src="./assets/bootstrap-logo.svg" alt="Bootstrap Logo" width="175" height="57">
                            </a>
                        </div>
                        <h2 class="fs-6 fw-normal text-center text-secondary mb-4">
                            Acesse sua conta
                        </h2>
                        <form method="POST">
                            <div class="row gy-2 overflow-hidden">
                                <p class="text-justify font-weight-bold text-center"><?= $_SESSION["email"] ?></p>
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                                        <label for="password" class="form-label">Senha</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="rememberMe" id="rememberMe" value="1">
                                            <label class="form-check-label text-secondary" for="rememberMe">
                                                Manter conectado
                                            </label>
                                        </div>
                                        <a href="#!" class="link-primary text-decoration-none">Esqueci minha senha</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-primary btn-lg" type="submit">Logar</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <p class="m-0 text-secondary text-center">
                                        Não tem uma conta? <a href="#!" class="link-primary text-decoration-none">Criar conta</a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
