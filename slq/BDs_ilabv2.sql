DROP DATABASE IF EXISTS s_ilabs;

-- Creación de la base de datos
CREATE DATABASE s_ilabs;
USE s_ilabs;

-- Creación de las tablas
-- Tabla-1-Usuario
CREATE TABLE usuario (
  id_usuario INT PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario VARCHAR(150) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contrasena VARCHAR(255) NOT NULL,
  rol VARCHAR(20) NOT NULL
);

-- Tabla-2-Permiso
CREATE TABLE permiso (
  id_permiso INT PRIMARY KEY AUTO_INCREMENT,
  descripcion VARCHAR(400) NULL
);

-- Tabla-3-Usuario_permiso
CREATE TABLE usuario_permiso (
  id_usuario INT NOT NULL,
  id_permiso INT NOT NULL
);

-- Tabla-4-Inventario
CREATE TABLE inventario (
  id_inventario INT PRIMARY KEY AUTO_INCREMENT,
  nombre_inventario VARCHAR(150) NOT NULL,
  fecha_registro DATE NOT NULL,
  estado_inventario VARCHAR(20) NOT NULL,
  id_usuario INT
);

-- Tabla-5-Insumo
CREATE TABLE insumo (
  id_insumo INT PRIMARY KEY AUTO_INCREMENT,
  nombre_insumo VARCHAR(150) NOT NULL,
  descripcion VARCHAR(400) NULL,
  cantidad INT NOT NULL,
  stock_minimo INT NOT NULL,
  fecha_vencimiento DATE NOT NULL,
  lote VARCHAR(25) NOT NULL,
  cas VARCHAR(25) NULL,  -- Identificador CAS de la sustancia
  marca VARCHAR(25) NOT NULL,
  estado_insumo VARCHAR(25) NOT NULL,
  id_inventario INT NOT NULL
);

-- Tabla-6-Alerta
CREATE TABLE alerta (
  id_alerta INT PRIMARY KEY AUTO_INCREMENT,
  tipo_alerta VARCHAR(100) NOT NULL,
  fecha_activacion DATE NOT NULL,
  descripcion VARCHAR(400) NULL,
  id_insumo INT NOT NULL
);

-- Tabla-7-Proveedor
CREATE TABLE proveedor (
  id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
  nombre VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  contacto VARCHAR(20) NULL
);

-- Tabla-8-Insumo_proveedor
CREATE TABLE insumo_proveedor (
  id_insumo INT NOT NULL,
  id_proveedor INT NOT NULL
);

-- Claves foráneas en usuario_permiso
ALTER TABLE usuario_permiso
  ADD CONSTRAINT FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);

ALTER TABLE usuario_permiso
  ADD CONSTRAINT FOREIGN KEY (id_permiso) REFERENCES permiso(id_permiso);

-- Clave foránea en inventario
ALTER TABLE inventario
  ADD CONSTRAINT FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);

-- Clave foránea en insumo
ALTER TABLE insumo
  ADD CONSTRAINT FOREIGN KEY (id_inventario) REFERENCES inventario(id_inventario);

-- Clave foránea en alerta
ALTER TABLE alerta
  ADD CONSTRAINT FOREIGN KEY (id_insumo) REFERENCES insumo(id_insumo);

-- Claves foráneas en insumo_proveedor
ALTER TABLE insumo_proveedor
  ADD CONSTRAINT FOREIGN KEY (id_insumo) REFERENCES insumo(id_insumo);

ALTER TABLE insumo_proveedor
  ADD CONSTRAINT FOREIGN KEY (id_proveedor) REFERENCES proveedor(id_proveedor);

-- Evitar duplicados en las tablas intermedias con combinación de claves primarias
ALTER TABLE usuario_permiso
  ADD PRIMARY KEY (id_usuario, id_permiso);

ALTER TABLE insumo_proveedor
  ADD PRIMARY KEY (id_insumo, id_proveedor);
