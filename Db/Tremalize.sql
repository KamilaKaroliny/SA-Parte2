create database tremalize_db;
use tremalize_db;

/*Tabela de usuarios*/
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
    cep VARCHAR(10) NULL,
    rua VARCHAR(255)  NULL,
    cidade VARCHAR(100)  NULL,
    bairro VARCHAR(100)  NULL,
    numero INT  NULL,
    complemento VARCHAR(255),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foto_perfil VARCHAR(255) DEFAULT 'default.jpg'
);


CREATE TABLE trem (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ultimaManutencao DATE NOT NULL,
    proximaManutencao DATE NOT NULL,
    distancia DECIMAL(10,2) NOT NULL,
    combustivel ENUM('Elétrico', 'Combustão') NOT NULL,
    numeroVagoes INT NOT NULL,
    quantidadeManutencao INT DEFAULT 0,
    combustivelMaximo DECIMAL(10,2) NOT NULL,
    capacidadeMaxima INT NOT NULL
);
    
create table sensor(
    id int AUTO_INCREMENT PRIMARY KEY,
    tipo varchar(225) not null,
    descricao varchar(225) not null,
    status_sensor varchar(225) not null
);
     
create table sensor_data(
   id int AUTO_INCREMENT PRIMARY KEY,
   valor bigint not null,
   data_hora datetime not null,
   id_sensor int not null,
   FOREIGN KEY (id_sensor) REFERENCES sensor (id)
);

     
/*Usuarios inceridos*/
use tremalize_db;
INSERT into usuarios( nome, senha, credencial, email, tipo, data_nascimento, telefone, idade) VALUES
('Icaro', '$2y$10$C1PHSSorIqP0NAj84qC0tO1KJOszl4cfEadt3g1kTZhNPnXmY6AYi','X9Y4Z6A1B4','icaro@administrador.com','ADM','2001-10-22', '4799955282', 24),
('Clodoaldo Kowalski', '$2y$10$0bEiISHnAtiCfCt7WVdWQOtpnPhzzZG6nfuEVAkTpEkG7A5Zv.Hhe', 'X9Y4Z6A1B3','clodoaldo@maquinista.com','USER','1981-10-23','21954321098',71),
('Jarbas Andrade', '$2y$10$DDqAqp/FfIRp7/G8SXL2k.SJ80smRuZ/.Nf4DyurIQba9jyo76uYa',' MSJ870NSHXU6','jarbas@maquinista.com','USER','1991-10-12', '21998565489', 34);


