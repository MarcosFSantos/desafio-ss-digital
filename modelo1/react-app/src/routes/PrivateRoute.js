import { Navigate, Outlet } from "react-router-dom";
import useAuth from "../hooks/useAuth";

// Protetor de rota que redireciona para /login se o tokenJWT estiver ausente.
const PrivateRoute = () => {
  const { tokenInfo, loading } = useAuth();

  if (loading) return <p>Carregando...</p>;

  return tokenInfo ? <Outlet /> : <Navigate to="/login" />;
};

export default PrivateRoute;
