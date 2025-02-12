CREATE TABLE IF NOT EXISTS Usuarios (
    Id INT PRIMARY KEY,
    Nome VARCHAR(20) NOT NULL,
    Email VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS Tokens (
    Id INT PRIMARY KEY,
    IdUsuario INT NOT NULL,
    Token VARCHAR(64) NOT NULL,
    ExpiracaoToken TIME NOT NULL,
    FOREIGN KEY (IdUsuario) REFERENCES Usuarios(Id) ON DELETE CASCADE
);