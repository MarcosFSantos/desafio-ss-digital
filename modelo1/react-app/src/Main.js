import useAuth from "./hooks/useAuth";

const Main = () => {
  const { tokenInfo, loading } = useAuth();

  // Exibe "Carregando..." enquanto verifica o token
  if (loading) {
    return <p>Carregando...</p>;
  }

  return (
    <div>
      <div class="text-center">
        <main role="main" class="inner cover">
          <h1 class="cover-heading">
            Bem vindo, {tokenInfo?.name || "Usuário"}
          </h1>
          <p class="lead">
            Você está conectado desde{" "}
            {tokenInfo?.login_time || "00:00:00 00/00/0000"}
          </p>
          <p class="lead">
            <a href="index.php" class="btn btn-lg btn-danger">
              Sair
            </a>
          </p>
        </main>
      </div>
    </div>
  );
};

export default Main;
