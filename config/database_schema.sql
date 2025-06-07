CREATE DATABASE IF NOT EXISTS recrutamento_api;
USE recrutamento_api;

CREATE TABLE IF NOT EXISTS vagas (
    id VARCHAR(36) PRIMARY KEY,
    empresa VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    CHECK (nivel >= 1 AND nivel <= 5)
);

CREATE TABLE IF NOT EXISTS pessoas (
    id VARCHAR(36) PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    profissao VARCHAR(255) NOT NULL,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    CHECK (nivel >= 1 AND nivel <= 5)
);

CREATE TABLE IF NOT EXISTS candidaturas (
    id VARCHAR(36) PRIMARY KEY,
    id_vaga VARCHAR(36) NOT NULL,
    id_pessoa VARCHAR(36) NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (id_vaga) REFERENCES vagas(id),
    FOREIGN KEY (id_pessoa) REFERENCES pessoas(id),
    UNIQUE (id_vaga, id_pessoa)
);

CREATE TABLE IF NOT EXISTS distancias (
    origem CHAR(1) NOT NULL,
    destino CHAR(1) NOT NULL,
    distancia INT NOT NULL,
    PRIMARY KEY (origem, destino)
);


INSERT INTO distancias (origem, destino, distancia) VALUES
-- Distâncias de A
('A', 'B', 5),
-- Distâncias de B
('B', 'A', 5),
('B', 'C', 7),
('B', 'D', 3),
-- Distâncias de C
('C', 'B', 7),
('C', 'E', 4),
-- Distâncias de D
('D', 'B', 3),
('D', 'E', 10),
('D', 'F', 8),
-- Distâncias de E
('E', 'C', 4),
('E', 'D', 10),
-- Distâncias de F
('F', 'D', 8);

INSERT INTO distancias (origem, destino, distancia) VALUES
('A', 'A', 0),
('B', 'B', 0),
('C', 'C', 0),
('D', 'D', 0),
('E', 'E', 0),
('F', 'F', 0);