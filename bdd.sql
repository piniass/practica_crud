-- Tabla de Usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50),
    contraseña VARCHAR(50),
    rol VARCHAR(50)
);

-- Tabla de Escuderías de F1
CREATE TABLE escuderias (
    codigo_escuderia INT PRIMARY KEY AUTO_INCREMENT,
    nombre_escuderia VARCHAR(50),
    año_creacion INT,
    imagen VARCHAR(50),
    imagen2 BLOB,
    piloto_principal VARCHAR(50)
);
