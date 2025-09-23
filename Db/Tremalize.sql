create database tremalize_db;
use tremalize_db;

/*Tabela de usuarios*/
create table usuario(
    id int AUTO_INCREMENT primary key,
    nome varchar (125) not null,
    senha varchar (225) not null,
    credencial varchar(225) not null,
    email varchar(225) not null,
    tipo varchar(5) not null,
    data_nascimento date null,
    telefone varchar(20) null,
    idade int null
    );
    
/*Usuarios inceridos*/
use tremalize_db;
INSERT into usuario( nome, senha, credencial, email, tipo, data_nascimento, telefone, idade) VALUES
('Icaro', '1icaro','X9Y4Z6A1B4','icaro@administrador.com','ADM','2001-10-22', 4799955282, 24),
('Clodoaldo Kowalski', '1clodoaldo', 'X9Y4Z6A1B3','clodoaldo@motorista.com','USER','1981-10-23',21954321098,71);




