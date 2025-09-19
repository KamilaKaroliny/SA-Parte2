Create database tremalize_db;
use tremalize_db;

create table linha (
    id int AUTO_INCREMENT not null,
    carga varchar(225) not null,
    nome varchar (125) not null,
    distancia int not null,
    tempo_gasto int not null,
    numero_vagao int not null,
    combustivel int not null,
    velocidade int null,
    horarios time not null,
    quantidade_viagens int null,
    ponto_partida varchar(225) not null,
    destino_final varchar (225) not null,
    regioes varchar(225) not null,
    capacidade_maxima int not null,
    numero_estacoes int not null,
    Id_relatorio int not null
   );

create table relatorio_linha(
    id int AUTO_INCREMENT not null,
    data_ultimo_relatorio date not null,
    tempo_medio int  null,
    velocidade_media int  null,
    horarios_frequentes time  null,
    quantidade_viagens int null,
    proxima_manutencao date null,
    ultima_manutencao date null,
    manutencao_dias_atras int not null,
    manutencao_dias_faltando int not null,
    id_linha int not null,
    id_usuario int not null 
    );
    
create table relatorio_usuario(
    id int AUTO_INCREMENT not null,
    data_relatorio_usuario date not null,
    km_percorridos int not null,
   velocidade_media_usuario int not null
    );
    
create table usuarios(
    id int AUTO_INCREMENT PRIMARY KEY,
    nome varchar(125) not null,
    senha varchar(255) not null,
    credencial int not null,
    email varchar (225) not null,
    tipo varchar (5) not null,
    data_nascimento date null,
    telefone int null,
    Idade int null,
    velocidade int null,
    id_tipo_carga varchar(225)  null,
    tempo_viagem int null
    combustivel_
    
);