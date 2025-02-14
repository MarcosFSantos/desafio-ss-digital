<?php
header(header: "Content-Type: application/json");

require_once __DIR__."/../src/router.php";
require_once __DIR__."/../src/controller.php";

# Definição de rotas
Router::add(method: "POST", path: "/login", function: ["Controller", "login"]);
Router::add(method: "GET", path: "/check-jwt", function: ["Controller","checkJWT"]);

# Procura a função da rota atual.
Router::call();
?>