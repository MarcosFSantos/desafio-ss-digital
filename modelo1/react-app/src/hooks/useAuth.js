import { useContext } from "react";
import AuthContext from "../context/AuthContext";

// Hook que disponibiliza as informações de AuthContext.
const useAuth = () => {
  return useContext(AuthContext);
};

export default useAuth;
