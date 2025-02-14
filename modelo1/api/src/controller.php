<?php
require_once __DIR__."/database_connection.php";
require_once __DIR__."/util.php";

class Controller
{
    # Efetua o login.
    public static function login():void {
        try {
            $raw_data = file_get_contents(filename: "php://input"); # Corpo bruto da requisição em formato de String.
            $data = json_decode(json: $raw_data ,associative: true); # Converte o corpo da requisição em JSON.

            # Retorna
            if($data["email"] && $data["password"]) {
                $email = $data["email"];
                $password = base64_decode(string: $data["password"]);

                # Contém um array com as informações de usuário se o login foi bem-sucedido.
                $user = Util::checkUser(email: $email, password: $password);

                # Se o login foi bem sucedido, cria um token e retorna ao usuário.
                if($user) {
                    # Cria token com as informações do usuário.
                    $token = Util::encodeJWT(user: $user);

                    # Armazena o token no banco de dados.
                    $expires = date(format: 'Y-m-d H:i:s', timestamp: time()+(24*60*60));
                    execute_query(query: "INSERT INTO Tokens (IdUsuario, Token, ExpiracaoToken) VALUES (?, ?, ?)", params: [$user["id"], $token, $expires]);

                    # Retorna o token ao usuário.
                    http_response_code(response_code: 200);
                    echo json_encode(value: ["token"=> $token]);
                } else {
                    # Se o login foi mal-sucedido, retorna erro 401.
                    http_response_code(response_code: 401);
                    echo json_encode(value: ["message"=> "Credenciais inválidas."]);
                }
            } else {
                # Se o login e a senha não foram enviados na requisição, retorna erro 400.
                http_response_code(response_code: 400);
                echo json_encode(value: ["message"=> "Campos enviados incorretos."]);
            }
        } catch (\Throwable $th) {
            http_response_code(500);
            echo json_encode(value: ["message"=> $th->getMessage()]);
        }
    }

    # Checa se o token JWT existe no banco.
    public static function checkJWT():void {
        $headers = getallheaders();

        if($headers['Authorization']) {
            $authorization = trim(string: $headers['Authorization']);
            $token = substr($authorization, strrpos($authorization, " ")+1); # Extrai apenas o token, ignorando oque vem antes;

            # Procura o token no banco de dados
            $database_token = execute_query(query: "SELECT Id FROM Tokens WHERE Token = ?", params: [$token]);

            # Se o token existir no banco e for válido, retorna suas informações.
            if($database_token) {
                # Decodifica o token em um array com suas informações.
                $decoded_token = Util::decodeJWT(token: $token);

                # Retorna as informações do token.
                http_response_code(response_code: 200);
                echo json_encode(value: $decoded_token);
            } else {
                # Se o token não existir no banco e for inválido, retorna erro 401.
                http_response_code(response_code: 401);
                echo json_encode(value: ["message"=> "Token inválido."]);
            }
        } else {
            # Se o token não for enviado na requisição, retorna erro 400.
            http_response_code(response_code: 400);
            echo json_encode(value: ["message"=> "Campos enviados incorretos."]);
        }
    }
}

?>