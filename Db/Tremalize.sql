create database tremalize_db;
use tremalize_db;

/*Tabela de usuarios*/
create table usuarios(
    id int AUTO_INCREMENT primary key,
    nome varchar (125) not null,
    senha varchar (255) not null,
    credencial varchar(225) not null,
    email varchar(225) not null,
    classificacao ENUM('Administrador', 'Maquinista'),
    data_nascimento date null,
    telefone varchar(20) null,
    idade int not null,
    cep int not null,
    rua varchar(255) not null,
    cidade varchar(100) not null,
    bairro varchar(100) not null,
    numero int not null,
    complemento varchar(255) not null
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


