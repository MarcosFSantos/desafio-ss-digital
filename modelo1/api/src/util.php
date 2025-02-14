<?php
require_once __DIR__."/database_connection.php";
require_once "vendor/autoload.php"; # Carrega a biblioteca JWT
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

# Contém funções utilizadas pelos controllers.
class Util {
    # Verifica se a senha do usuário passado é a mesma do banco, retorna false para senha incorreta e um array com as infromações do usuário para senha correta. Se o usuário não existir, um novo será criado.
    public static function checkUser(string $email, string $password): array|bool {
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

    # Codifica e retorna um token JWT a partir das informações do usuário.
    public static function encodeJWT($user):String {
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

    # Decodifica o token JWT passado e retorna um array com suas informações.
    public static function decodeJWT(string $token): array {
        $decoded_token = JWT::decode($token, new Key($_ENV["JWT_SECRET"], "HS256"));
        return (array) $decoded_token;
    }
}
?>