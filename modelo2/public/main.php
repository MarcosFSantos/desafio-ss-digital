<?php
require_once(__DIR__.'/../src/database_connection.php');
require_once("vendor/autoload.php"); # Carrega a biblioteca JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start(); # Permite a criação de sessões.

# Obtém o token da sessão ou do cookie
$token = $_SESSION["token"] ?? ($_COOKIE["token"] ?? null);

# Se o token for inválido, redireciona para a tela de login
if (!$token || !isValidToken($token)) {
    header(header: "Location: index.php");
    exit();
}

$decoded_token = decodeJWT(token: $token);
$name = $decoded_token["name"] ?? "name";
$password = $decoded_token["email"] ?? "email";
$login_time = $decoded_token["login_time"] ?? date(format: "Y-m-d H:i:s");

# Função para verificar se o token é válido no banco
function isValidToken(string $token): bool {
    if (!$token) return false; # Se o token for nulo ou vazio, já retorna falso.

    $database_token = execute_query(query: "SELECT Id FROM Tokens WHERE Token = ?", params: [$token]);

    return !empty($database_token); # Retorna `true` se encontrou o token no banco, senão `false`.
}

function decodeJWT(string $token): array {
    $decoded_token = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
    return (array) $decoded_token;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boas vindas</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="text-center bg-secondary">
    <main role="main" class="inner cover">
        <h1 class="cover-heading">Bem vindo, <?= $name ?></h1>
        <p class="lead">Você está conectado desde <?= $login_time ?></p>
        <p class="lead">
        <a href="index.php" class="btn btn-lg btn-danger">Sair</a>
        </p>
    </main>
</body>

</html>
