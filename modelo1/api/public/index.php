<?php
header("Access-Control-Allow-Origin: *");  // Permite qualquer origem (⚠️ Em produção, restrinja isso)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Se for uma requisição OPTIONS (preflight), responda com 200 e encerre
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

require_once __DIR__."/../src/router.php";
require_once __DIR__."/../src/controller.php";

# Definição de rotas
Router::add(method: "POST", path: "/login", function: ["Controller", "login"]);
Router::add(method: "GET", path: "/check-jwt", function: ["Controller", "checkJWT"]);

# Procura a função da rota atual.
Router::call();
?>
