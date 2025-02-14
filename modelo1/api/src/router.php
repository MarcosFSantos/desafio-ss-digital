<?php

class Router
{
    private static $routes = []; # Lista de rotas.

    # Adiciona uma rota à lista de rotas.
    public static function add(String $method, String $path, callable $function):void {
        self::$routes[] = ["method"=> $method, "path"=>$path, "function"=>$function];
    }

    # Chama a função definida para a rota da requisição atual.
    public static function call():void {
        $request_path = parse_url(url: $_SERVER["REQUEST_URI"], component: PHP_URL_PATH); # O caminho que foi usado para acessar a página. Exemplo: '/index'.
        $request_method = $_SERVER["REQUEST_METHOD"]; # Método usado para acessar a página. Exemplo: 'GET', 'HEAD', 'POST', 'PUT'.

        # Ao encontrar a rota com o método e o URI que foi usado para acessar a página, chama a função que foi definida para ela.
        foreach (self::$routes as $route) {
            if ($route["method"] == $request_method && $route["path"] == $request_path) {
                # Evita chamar uma função inválida definida na rota.
                if (!is_callable(value: $route["function"])) {
                    exit();
                }
                # Chama a função definida na rota.
                call_user_func(callback: $route["function"]);
                return;
            }
        }

        # Retorna erro se a rota não for encontrada
        http_response_code(response_code: 404);
        echo json_encode(value: ["error" => "Rota não encontrada"]);
    }
}

?>