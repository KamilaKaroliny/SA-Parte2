CREATE DATABASE tremalize_db;
USE tremalize_db;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(125) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    credencial VARCHAR(225) NOT NULL,
    email VARCHAR(225) NOT NULL UNIQUE,
    tipo ENUM('ADM', 'USER') NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    idade INT,
    cep VARCHAR(10),
    rua VARCHAR(255),
    cidade VARCHAR(100),
    bairro VARCHAR(100),
    numero INT,
    complemento VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foto_perfil VARCHAR(255) DEFAULT 'default.jpg'
);

-- Tabela de trens
CREATE TABLE trem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(125) NOT NULL,
    tipo ENUM('CIR', 'CAR', 'TUR') NOT NULL,
    ultimaManutencao DATE NOT NULL,
    proximaManutencao DATE NOT NULL,
    distancia DECIMAL(10,2) NOT NULL,
    combustivel ENUM('Elétrico', 'Combustão') NOT NULL,
    numeroVagoes INT NOT NULL,
    quantidadeManutencao INT DEFAULT 0,
    combustivelMaximo DECIMAL(10,2) NOT NULL,
    capacidadeMaxima INT NOT NULL
);

-- Tabela de marcações
CREATE TABLE marcacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localizacao VARCHAR(225) NOT NULL,
    icone ENUM('Acidente', 'Obras', 'Quebra') NOT NULL
);

-- Tabela de sensores
CREATE TABLE sensor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(225) NOT NULL,
    descricao VARCHAR(225) NOT NULL,
    status_sensor VARCHAR(225) NOT NULL
);

-- Tabela de dados dos sensores
CREATE TABLE sensor_data (
   id INT AUTO_INCREMENT PRIMARY KEY,
   valor BIGINT NOT NULL,
   data_hora DATETIME NOT NULL,
   id_sensor INT NOT NULL,
   FOREIGN KEY (id_sensor) REFERENCES sensor (id)
);

CREATE TABLE relatorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    ano INT NOT NULL,
    mes INT NOT NULL,

    velocidade_media DECIMAL(10,2),
    km_percorridos DECIMAL(10,2),
    tempo_medio_viagem DECIMAL(10,2),
    combustivel_medio DECIMAL(10,2),

    tempo_empresa INT,
    quantidade_viagens INT,
    advertencias INT,

    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- Inserção de usuários
INSERT INTO usuarios (nome, senha, credencial, email, tipo, data_nascimento, telefone, idade, foto_perfil)
VALUES
('Icaro', '$2y$10$C1PHSSorIqP0NAj84qC0tO1KJOszl4cfEadt3g1kTZhNPnXmY6AYi', 'X9Y4Z6A1B4', 'icaro@administrador.com', 'ADM', '2001-10-22', '4799955282', 24, 'foto_69238508108245.46554602.jpeg'),
('Clodoaldo Kowalski', '$2y$10$0bEiISHnAtiCfCt7WVdWQOtpnPhzzZG6nfuEVAkTpEkG7A5Zv.Hhe', 'X9Y4Z6A1B3', 'clodoaldo@maquinista.com', 'USER', '1981-10-23', '21954321098', 71, 'clodoaldo.png'),
('Jarbas Andrade', '$2y$10$DDqAqp/FfIRp7/G8SXL2k.SJ80smRuZ/.Nf4DyurIQba9jyo76uYa', 'MSJ870NSHXU6', 'jarbas@maquinista.com', 'USER', '1991-10-12', '21998565489', 34, 'jarbas.png');

INSERT INTO relatorios 
(id_usuario, ano, mes, velocidade_media, km_percorridos, tempo_medio_viagem, combustivel_medio, tempo_empresa, quantidade_viagens, advertencias)
VALUES
(2, 2025, 1, 68.4, 1320, 2.1, 340, 5, 28, 0),   -- Clodoaldo
(2, 2025, 2, 70.2, 1410, 2.0, 360, 5, 31, 1),
(3, 2025, 1, 74.5, 1500, 1.8, 390, 3, 35, 0),   -- Jarbas
(3, 2025, 2, 73.1, 1470, 1.9, 380, 3, 33, 0);