-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS recrutamento_api;
USE recrutamento_api;

-- Tabela de vagas
CREATE TABLE IF NOT EXISTS vagas (
    id VARCHAR(36) PRIMARY KEY,
    empresa VARCHAR(255) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    CHECK (nivel >= 1 AND nivel <= 5)
);

-- Tabela de pessoas
CREATE TABLE IF NOT EXISTS pessoas (
    id VARCHAR(36) PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    profissao VARCHAR(255) NOT NULL,
    localizacao CHAR(1) NOT NULL,
    nivel INT NOT NULL,
    CHECK (nivel >= 1 AND nivel <= 5)
);

-- Tabela de candidaturas
CREATE TABLE IF NOT EXISTS candidaturas (
    id VARCHAR(36) PRIMARY KEY,
    id_vaga VARCHAR(36) NOT NULL,
    id_pessoa VARCHAR(36) NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY (id_vaga) REFERENCES vagas(id),
    FOREIGN KEY (id_pessoa) REFERENCES pessoas(id),
    UNIQUE (id_vaga, id_pessoa)
);

-- Tabela de distâncias entre localidades
CREATE TABLE IF NOT EXISTS distancias (
    origem CHAR(1) NOT NULL,
    destino CHAR(1) NOT NULL,
    distancia INT NOT NULL,
    PRIMARY KEY (origem, destino)
);

-- Inserção das distâncias conforme o mapa
-- Nota: Precisamos de informações sobre o mapa de distâncias para preencher esta tabela
-- Por enquanto, vamos inserir alguns exemplos fictícios
INSERT INTO distancias (origem, destino, distancia) VALUES
('A', 'B', 5),
('A', 'C', 10),
('B', 'C', 8),
('B', 'D', 12),
('C', 'D', 6),
('C', 'E', 15),
('D', 'E', 7);

-- Inserir também as distâncias no sentido inverso
INSERT INTO distancias (origem, destino, distancia) VALUES
('B', 'A', 5),
('C', 'A', 10),
('C', 'B', 8),
('D', 'B', 12),
('D', 'C', 6),
('E', 'C', 15),
('E', 'D', 7);

-- Inserir distância zero para mesma localidade
INSERT INTO distancias (origem, destino, distancia) VALUES
('A', 'A', 0),
('B', 'B', 0),
('C', 'C', 0),
('D', 'D', 0),
('E', 'E', 0);

