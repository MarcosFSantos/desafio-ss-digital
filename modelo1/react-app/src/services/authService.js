import Cookies from "js-cookie";

const API_URL = "http://localhost:5000";

// Captura o token da sessão ou do cookie.
export const getToken = () => {
  return sessionStorage.getItem("token") || Cookies.get("token");
};

// Retorna o objeto do endpoint check-jwt.
export const checkJWTToken = async () => {
  const token = getToken();
  if (!token) return null; // Se não houver token, retorna null

  try {
    const response = await fetch(`${API_URL}/check-jwt`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (!response.ok) {
      console.warn(`Token inválido! Código HTTP: ${response.status}`);
      if (response.status === 401) return false; // Token inválido
      return null; // Outros erros
    }

    return await response.json();
  } catch (error) {
    console.error("Erro ao verificar o token:", error);
    return null;
  }
};

// Salva o token no cookie ou sessão
export const saveToken = (token, remember) => {
  removeToken(); // Remove token antigo antes de salvar o novo

  if (remember) {
    Cookies.set("token", token, {
      expires: 7,
      secure: true,
      sameSite: "Strict",
    });
  } else {
    sessionStorage.setItem("token", token);
  }
};

// Remove o token do cookie e da sessão
export const removeToken = () => {
  Cookies.remove("token");
  sessionStorage.removeItem("token");
};

// Efetua login e retorna o token
export const login = async (email, password) => {
  try {
    const response = await fetch(`${API_URL}/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password: btoa(password) }), // Converte senha para base64
    });

    if (!response.ok) {
      console.warn(`Erro no login! Código HTTP: ${response.status}`);

      if (response.status === 401) return false; // Credenciais inválidas
      if (response.status === 400) return null; // Campos inválidos
    }

    const data = await response.json();
    return data.token;
  } catch (error) {
    console.error("Erro ao tentar realizar login:", error.message);
    return null;
  }
};
