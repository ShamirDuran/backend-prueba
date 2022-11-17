CREATE DATABASE IF NOT EXISTS prueba;
USE prueba;

CREATE TABLE condiciones_pago (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(15) NOT NULL
);

CREATE TABLE medios_pago (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(40) UNIQUE NOT NULL
);

CREATE TABLE clientes (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    documento VARCHAR(12) UNIQUE NOT NULL,
    nombre VARCHAR(60) NOT NULL,
    apellido1 VARCHAR(60) NOT NULL,
    apellido2 VARCHAR(60) NOT NULL,
    direccion VARCHAR(160) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    correo_electronico VARCHAR(50) NOT NULL,
    ciudad VARCHAR(35) NOT NULL,
    valor_cupo VARCHAR(30) NOT NULL,
    estado CHAR(1) NOT NULL,
    fecha_registro DATETIME NOT NULL,
	condicion_pago_id INT NOT NULL,
	medio_pago_id INT NOT NULL,
    FOREIGN KEY (condicion_pago_id) REFERENCES condiciones_pago(id),
	FOREIGN KEY (medio_pago_id) REFERENCES medios_pago(id)
);


DROP TABLE medios_pago;
DROP TABLE condiciones_pago;
DROP TABLE clientes;

INSERT INTO condiciones_pago(nombre)
VALUES
("Contado"),
("Credito");

INSERT INTO medios_pago(nombre)
VALUES
("Nequi"),
("Bancolombia"),
("BBVA"),
("Davivienda"),
("NU");


 