<?php
require_once("database_connection.php");

session_start(); # Permite a criação de sessões.
# Vai para a página principal caso o token seja válido.
if (isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    if (isValidToken(token: $token)) {
        header(header: "Location: main.php");
        exit();
    }
} elseif (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
    if (isValidToken(token: $token)) {
        header(header: "Location: main.php");
        exit();
    }
}

# Vai para a tela de login caso o cookie com o token seja inexistente ou tenha um token inválido.
header(header: "Location: login_email.php");
exit();

# Retorna o id do token do banco que conrresponder ao passado.
function isValidToken(string $token): bool {
    if (!$token) return false; # Se o token for nulo ou vazio, já retorna falso.

    $database_token = execute_query(query: "SELECT Id FROM Tokens WHERE Token = ?", params: [$token]);

    return !empty($database_token); # Retorna `true` se encontrou o token no banco, senão `false`.
}