CREATE DATABASE SCHOOL;

CREATE TABLE usuario (
    Nome_usuario VARCHAR(255),
    Email VARCHAR(255) NOT NULL,
    Senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (Email, Senha)
);

CREATE TABLE aluno (
   Numero_aluno SERIAL PRIMARY KEY,
   Nome VARCHAR(255),
   Tipo_aluno INT, 
   Curso VARCHAR(255)
);

CREATE TABLE disciplina (
    Numero_disciplina SERIAL PRIMARY KEY,
    Nome_disciplina VARCHAR(255),
    Creditos INT,
    Departamento VARCHAR(255)
);

CREATE TABLE turma (
    Identificacao_turma SERIAL PRIMARY KEY,
    Numero_disciplina INT REFERENCES Disciplina(Numero_disciplina) ON DELETE SET NULL ON UPDATE CASCADE, 
    Nome_disciplina VARCHAR(255),
    Semestre VARCHAR(55),
    Ano INT,
    Professor VARCHAR(255)
);

CREATE TABLE historico_escolar (
    Numero_aluno INT REFERENCES Aluno(Numero_aluno) ON DELETE SET NULL ON UPDATE CASCADE,
    Identificacao_turma INT REFERENCES Turma(Identificacao_turma) ON DELETE SET NULL ON UPDATE CASCADE,
    Nome_aluno VARCHAR(255),
    Nome_disciplina VARCHAR(255),
    Nota FLOAT,
    PRIMARY KEY (Numero_aluno, Identificacao_turma)
);

CREATE TABLE pre_requisito (
    Numero_pre_requisito INT,
    Numero_disciplina INT REFERENCES Disciplina(Numero_disciplina) ON DELETE CASCADE ON UPDATE CASCADE,
    Nome_pre_requisito VARCHAR(255),
    Nome_disciplina VARCHAR(255),
    PRIMARY KEY (Numero_pre_requisito, Numero_disciplina)
);

CREATE TABLE matricula (
    Numero_aluno INT REFERENCES Aluno(Numero_aluno) ON DELETE CASCADE ON UPDATE CASCADE,
    Identificacao_turma INT REFERENCES Turma(Identificacao_turma) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (Numero_aluno, Identificacao_turma)
);