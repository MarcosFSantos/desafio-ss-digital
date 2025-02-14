import Cookies from "js-cookie";

const API_URL = "localhost:5000";

// Captura o token da sessão ou do cookie.
export const getToken = () => {
  return sessionStorage.getItem("token") || Cookies.get("token");
};

// Retorna o objeto retornado do endpoint check-jwt.
export const checkJWTToken = async () => {
  const token = getToken();
  if (!token) return null; // Retorno explícito se não houver token

  try {
    const response = await fetch(`${API_URL}/check-jwt`, {
      method: "GET",
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (!response.ok) {
      console.warn(`Token inválido! Código HTTP: ${response.status}`);
      return null;
    }

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Erro ao verificar o token:", error);
    return null;
  }
};

// Salva o token no cookie para permanecer quando o navegador for fechado, ou na sessão.
export const saveToken = (token, remember) => {
  if (remember) {
    Cookies.set("token", token, { expires: 7 });
  } else {
    sessionStorage.setItem("token", token);
  }
};
