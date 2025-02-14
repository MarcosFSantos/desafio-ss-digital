import React, { useState, useEffect, createContext } from "react";
import { checkJWTToken } from "../services/authService";

const AuthContext = createContext(null);

// Provider que captura e disponibiliza as informações do token JWT.
export const AuthProvider = ({ children }) => {
  const [tokenInfo, setTokenInfo] = useState(null);

  // Executa ao montar o componente e quando `setTokenInfo` for alterado.
  useEffect(() => {
    const verifyAuth = async () => {
      const tokenData = await checkJWTToken();
      setTokenInfo(tokenData);
    };
    verifyAuth();
  }, []);

  return (
    <AuthContext.Provider value={{ tokenInfo, setTokenInfo }}>
      {children}
    </AuthContext.Provider>
  );
};

// Exporta o contexto.
export default AuthContext;
