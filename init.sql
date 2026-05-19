USE db_herois;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    senha VARCHAR(50) NOT NULL
);

-- Inserindo o usuário legítimo da Liga da Justiça
INSERT INTO usuarios (usuario, senha) VALUES ('clark_kent', 'krypton123');