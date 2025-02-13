<?php
# Dados para conexão com o banco Postgresql.
$host="postgres"; # endereço do container 'postgres' que contém o banco, acessível pelo network padrão através do nome do container.
$port="5432"; # porta interna do conatiner 'postgres' que contém o banco.
$db=$_ENV["DATABASE_NAME"];
$user=$_ENV["DATABASE_USER"];
$password=$_ENV["DATABASE_PASSWORD"];

# Conexão com o banco Postgresql.
$connection = new pdo(dsn: "pgsql:host=$host;dbname=$db;port=$port;", username: $user, password: $password);

# Executa no banco de dados a query passada como argumento e retorna um array com a resposta.
function execute_query(string $query, array $params = []): array|bool {
    try {
        global $connection;
        $statement = $connection->prepare(query: $query); # Prepara a query.

        # Executa a query com os parâmetros fornecidos.
        $statement->execute(params: $params);

        # Retorna os resultados se a query for um SELECT.
        $uppercase_query = strtoupper(string: trim(string: $query));
        if (str_starts_with(haystack: $uppercase_query, needle: "SELECT")) {
            return $statement->fetchAll();
        }

        # Retorna os resultados se a query for INSERT, UPDATE ou DELETE.
        return true;
    } catch (\Throwable $th) {
        throw $th;
    }
}
?>