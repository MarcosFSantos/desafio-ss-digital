import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import { AuthProvider } from "./context/AuthContext";
//import PrivateRoute from "./routes/PrivateRoute";
import LoginEmail from "./LoginEmail";
import LoginPassword from "./LoginPassword";
import Main from "./Main";

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          <Route path="/login" element={<LoginEmail />} />
          <Route path="/login-senha" element={<LoginPassword />} />
          <Route path="*" element={<LoginEmail />} />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
