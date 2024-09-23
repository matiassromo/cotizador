-- Crear tabla tipo_usuarios con campo estado utilizando CHAR(1)
CREATE TABLE tipo_usuarios (
    id_tipo_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_tipo VARCHAR(50) NOT NULL,
    estado CHAR(1) NOT NULL DEFAULT 'A' -- A = Activo, I = Inactivo
);

-- Crear tabla usuarios
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_tipo_usuario INT,
    FOREIGN KEY (id_tipo_usuario) REFERENCES tipo_usuarios(id_tipo_usuario)
);

-- Insertar 4 tipos de usuario con estado
INSERT INTO tipo_usuarios (nombre_tipo, estado) VALUES 
('Administrador', 'A'),
('Moderador', 'A'),
('Usuario Regular', 'A'),
('Invitado', 'A');

