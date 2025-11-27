CREATE DATABASE IF NOT EXISTS tremalize_db;
USE tremalize_db;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
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
    foto_perfil VARCHAR(255) DEFAULT 'default.jpg',
    feedback  varchar(550) null
);

-- Tabela de trens
CREATE TABLE IF NOT EXISTS trem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(125) NOT NULL,
    tipo ENUM('CIR', 'CAR', 'TUR') NOT NULL,
    ultimaManutencao DATE NULL,
    proximaManutencao DATE NULL,
    distancia DECIMAL(10,2) NULL,
    combustivel ENUM('Elétrico', 'Combustão') NULL,
    numeroVagoes INT NULL,
    quantidadeManutencao INT DEFAULT 0,
    combustivelMaximo DECIMAL(10,2) NULL,
    capacidadeMaxima INT NULL,
    imagem VARCHAR(255) DEFAULT 'default_trem.jpg',
    maquinista INT NULL,
    FOREIGN KEY (maquinista) REFERENCES usuarios(id)
);

CREATE TABLE notificacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem TEXT NOT NULL,
    tipo ENUM('USER', 'TREM') NOT NULL DEFAULT 'TREM',
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    lida TINYINT(1) DEFAULT 0
);

-- Tabela de marcações
CREATE TABLE IF NOT EXISTS marcacao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    localizacao VARCHAR(225) NOT NULL,
    icone ENUM('Acidente', 'Obras', 'Quebra') NOT NULL
);

-- Tabela de sensores
CREATE TABLE IF NOT EXISTS sensor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(225) NOT NULL,
    descricao VARCHAR(225) NOT NULL,
    status_sensor VARCHAR(225) NOT NULL
);

-- Tabela de dados dos sensores
CREATE TABLE IF NOT EXISTS sensor_data (
   id INT AUTO_INCREMENT PRIMARY KEY,
   valor BIGINT NOT NULL,
   data_hora DATETIME NOT NULL,
   id_sensor INT NOT NULL,
   FOREIGN KEY (id_sensor) REFERENCES sensor (id)
);

-- Relatórios de usuários
CREATE TABLE IF NOT EXISTS relatorios_usuarios (
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

-- Relatórios de trens
CREATE TABLE IF NOT EXISTS relatorios_trens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_trem INT NOT NULL,
    ano INT NOT NULL,
    mes INT NOT NULL,
    velocidade_media DECIMAL(10,2),
    km_percorridos DECIMAL(10,2),
    tempo_medio_viagem DECIMAL(10,2),
    combustivel_medio DECIMAL(10,2),
    manutencoes INT,
    incidentes INT,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_trem) REFERENCES trem(id)
);

-- Inserção de usuários
INSERT INTO usuarios (nome, senha, credencial, email, tipo, data_nascimento, telefone, idade, foto_perfil)
VALUES
('Icaro', '$2y$10$C1PHSSorIqP0NAj84qC0tO1KJOszl4cfEadt3g1kTZhNPnXmY6AYi', 'X9Y4Z6A1B4', 'icaro@administrador.com', 'ADM', '2001-10-22', '4799955282', 24, 'icaro.png'),
('Clodoaldo Kowalski', '$2y$10$0bEiISHnAtiCfCt7WVdWQOtpnPhzzZG6nfuEVAkTpEkG7A5Zv.Hhe', 'X9Y4Z6A1B3', 'clodoaldo@maquinista.com', 'USER', '1981-10-23', '21954321098', 71, 'clodoaldo.png'),
('Jarbas Andrade', '$2y$10$DDqAqp/FfIRp7/G8SXL2k.SJ80smRuZ/.Nf4DyurIQba9jyo76uYa', 'MSJ870NSHXU6', 'jarbas@maquinista.com', 'USER', '1991-10-12', '21998565489', 34, 'jarbas.png');

-- Inserção de trens
INSERT INTO trem (nome, tipo, ultimaManutencao, proximaManutencao, distancia, combustivel, numeroVagoes, quantidadeManutencao, combustivelMaximo, capacidadeMaxima, imagem)
VALUES
('Expresso Azul', 'CIR', '2025-10-01', '2026-04-01', 12000.50, 'Elétrico', 8, 3, 500.00, 400, 'expresso_azul.jpg'),
('Carreta Verde', 'CAR', '2025-09-15', '2026-03-15', 15000.00, 'Combustão', 12, 4, 800.00, 600, 'carreta_verde.jpg'),
('Trem Turístico', 'TUR', '2025-08-20', '2026-02-20', 5000.75, 'Elétrico', 5, 2, 300.00, 200, 'trem_turistico.jpg');

-- Inserção de relatórios de usuários
INSERT INTO relatorios_usuarios 
(id_usuario, ano, mes, velocidade_media, km_percorridos, tempo_medio_viagem, combustivel_medio, tempo_empresa, quantidade_viagens, advertencias)
VALUES
(2, 2025, 1, 68.4, 1320, 2.1, 340, 5, 28, 0),
(2, 2025, 2, 70.2, 1410, 2.0, 360, 5, 31, 1),
(3, 2025, 1, 74.5, 1500, 1.8, 390, 3, 35, 0),
(3, 2025, 2, 73.1, 1470, 1.9, 380, 3, 33, 0);

-- Inserção de relatórios de trens
INSERT INTO relatorios_trens 
(id_trem, ano, mes, velocidade_media, km_percorridos, tempo_medio_viagem, combustivel_medio, manutencoes, incidentes)
VALUES
(1, 2025, 1, 90.5, 12000, 3.2, 250, 1, 0),
(1, 2025, 2, 92.3, 12500, 3.0, 260, 0, 1),
(2, 2025, 1, 80.2, 15000, 4.1, 500, 2, 1),
(2, 2025, 2, 82.0, 15500, 4.0, 510, 1, 0),
(3, 2025, 1, 60.7, 5000, 2.5, 120, 0, 0),
(3, 2025, 2, 61.5, 5200, 2.4, 125, 0, 0);


INSERT INTO usuarios 
(nome, senha, credencial, email, tipo, data_nascimento, telefone, idade, foto_perfil, feedback)
VALUES
('Jackson Oliveira', '$2y$10$C1PHSSorIqP0NAj84qC0tO1KJOszl4cfEadt3g1kTZhNPnXmY6AYi', 'X9Y4Z6A1B5', 'jackson@usuario.com', 'USER', '2001-10-22', '4799955282', 24, 'foto_69238508108245.46554602.jpeg', 'Experiência incrível! O trem era muito confortável, os assentos eram espaçosos e a viagem foi super tranquila. Além disso, a pontualidade foi impecável. Com certeza viajarei novamente!'),
('Otávio Ferreira', '$2y$10$0bEiISHnAtiCfCt7WVdWQOtpnPhzzZG6nfuEVAkTpEkG7A5Zv.Hhe', 'X9Y4Z6A1B6', 'otavio@usuario.com', 'USER', '1981-10-23', '21954321098', 71, 'clodoaldo.png', 'Ótimo serviço! A equipe de bordo foi muito atenciosa, e o vagão-restaurante tinha boas opções de comida. Só acho que poderia ter mais tomadas para carregar o celular, mas no geral, foi uma viagem excelente!'),
('Jaqueline Elisabeth', '$2y$10$DDqAqp/FfIRp7/G8SXL2k.SJ80smRuZ/.Nf4DyurIQba9jyo76uYa', 'MSJ870NSHXU7', 'jaqueline@usuario.com', 'USER', '1991-10-12', '21998565489', 34, 'jarbas.png', 'Viagem perfeita! O trem era silencioso e muito limpo. Gostei bastante da paisagem ao longo do trajeto. Cheguei ao destino no horário certo e sem estresse. Super recomendo!'),
('Rodrigo Medeiros', '$2y$10$DDqAqp/FfIRp7/G8SXL2k.SJ80smRuZ/.Nf4DyurIQba9jyo76uYa', 'MSJ870NSHXU8', 'rodrigo@usuario.com', 'USER', '1991-10-12', '21998565489', 34, 'rodrigo.png', 'Gostei muito da experiência! O ar-condicionado estava na temperatura ideal, e os assentos eram confortáveis. A única coisa que poderia melhorar é o Wi-Fi, que às vezes falhava. Fora isso, tudo excelente!');
