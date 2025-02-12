CREATE TABLE IF NOT EXISTS Usuarios (
    IdUsuario INT PRIMARY KEY,
    NomeUsuario VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS Tokens (
    IdToken INT PRIMARY KEY,
    IdUsuario INT NOT NULL,
    Token VARCHAR(64) NOT NULL,
    ExpiracaoToken TIME NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuarios(IdUsuario) ON DELETE CASCADE
);