import { useLocation, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import { login, saveToken } from "./services/authService";
import logo from "./logo.svg";

const LoginPassword = () => {
  const navigate = useNavigate();
  const location = useLocation();
  const email = location.state?.email || ""; // Email enviado por LoginEmail.

  const [password, setPassword] = useState(""); // Senha do usuário.
  const [rememberMe, setRememberMe] = useState(false); // "Manter conectado".
  const [message, setMessage] = useState(""); // Mensagem de erro ou sucesso.

  // Se não houver email enviado pelo Navigate, volta para a tela de login.
  useEffect(() => {
    if (!email) {
      navigate("/login");
    }
  }, [email, navigate]);

  const handleLogin = async (e) => {
    e.preventDefault();

    const token = await login(email, password);

    if (token) {
      saveToken(token, rememberMe);
      navigate("/");
    } else if (token === false) {
      setMessage("Credenciais inválidas. Verifique seu email e senha.");
    } else {
      setMessage("Erro inesperado no login!");
    }
  };

  return (
    <div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
            <div class="card border border-light-subtle rounded-3 shadow-sm">
              <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="text-center mb-3">
                  <a href="#!">
                    <img
                      src={logo}
                      alt="React Logo"
                      width="175"
                      height="57"
                    ></img>
                  </a>
                </div>
                <h2 class="fs-6 fw-normal text-center text-secondary mb-4">
                  Acesse sua conta
                </h2>
                <form onSubmit={handleLogin}>
                  <div class="row gy-2 overflow-hidden">
                    <p class="text-justify font-weight-bold text-center">
                      {email}
                    </p>
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          class="form-control"
                          type="password"
                          name="password"
                          id="password"
                          placeholder="Password"
                          value={password}
                          onChange={(e) => setPassword(e.target.value)}
                          required
                        ></input>
                        <label for="password" class="form-label">
                          Senha
                        </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex gap-2 justify-content-between">
                        <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            name="rememberMe"
                            id="rememberMe"
                            value={rememberMe}
                            onChange={(e) => setRememberMe(e.target.value)}
                          ></input>
                          <label
                            class="form-check-label text-secondary"
                            for="rememberMe"
                          >
                            Manter conectado
                          </label>
                        </div>
                        <a href="#!" class="link-primary text-decoration-none">
                          Esqueci minha senha
                        </a>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid my-3">
                        <button class="btn btn-primary btn-lg" type="submit">
                          Logar
                        </button>
                      </div>
                    </div>
                    <div class="col-12">
                      <p class="m-0 text-secondary text-center">
                        Não tem uma conta?
                        <a href="#!" class="link-primary text-decoration-none">
                          Criar conta
                        </a>
                      </p>
                    </div>
                  </div>
                </form>
                <div>
                  <h2 class="fs-6 fw-normal text-center text-secondary mb-4">
                    {message}
                  </h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LoginPassword;
