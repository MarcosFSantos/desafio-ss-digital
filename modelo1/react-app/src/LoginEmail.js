import { useNavigate } from "react-router-dom";
import logo from "./logo.svg";
import { useState } from "react";

const LoginEmail = () => {
  const navigate = useNavigate();

  const [email, setEmail] = useState(""); // Email e função para alterar o email. Valor padrão de "".

  // Executada quando botão de submit do formulário é pressionado.
  const handleSubmit = (e) => {
    e.preventDefault();
    navigate("/login-senha", { state: { email } }); // Redireciona para LoginSenha.js passando o email.
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
                <form onSubmit={handleSubmit}>
                  <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          type="email"
                          class="form-control"
                          name="email"
                          id="email"
                          value={email}
                          onChange={(e) => setEmail(e.target.value)}
                          placeholder="name@example.com"
                          required
                        ></input>
                        <label for="email" class="form-label">
                          Email
                        </label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid my-3">
                        <button class="btn btn-primary btn-lg" type="submit">
                          Continuar
                        </button>
                      </div>
                    </div>
                    <div class="col-12">
                      <p class="m-0 text-secondary text-center">
                        Não tem uma conta?{" "}
                        <a href="#!" class="link-primary text-decoration-none">
                          Criar conta
                        </a>
                      </p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default LoginEmail;
