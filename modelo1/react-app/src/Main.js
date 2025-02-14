import useAuth from "./hooks/useAuth";

const Main = () => {
  return (
    <div>
      <div class="text-center">
        <main role="main" class="inner cover">
          <h1 class="cover-heading">Bem vindo, {useAuth?.name}</h1>
          <p class="lead">Você está conectado desde {useAuth?.lastLogin}</p>
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
