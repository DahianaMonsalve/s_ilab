--Scripts base de datos del proyecto sin estandarizar
drop DATABASE if exists s_ilabs;

--Creación de la base de datos
create database s_ilabs;
use s_ilabs;

/*Creación de las tablas 
Tabla-1-Usuario*/

create table usuario(
id_usuario int primary key auto_increment,
nombre_usuario varchar(150) not null,
email varchar(100) not null,
contrasena varchar(255) not null,
rol varchar(20) not null
);

--Tabla-2-Permiso
create table permiso(
id_permiso int primary key auto_increment,
descripcion varchar(400) null
);

--Tabla-3-Usuario_permiso
create table usuario_permiso(
id_usuario int not null,
id_permiso int not null
);

--Tabla-4-Inventario
 create table inventario(
id_inventario int primary key auto_increment,
nombre_inventario varchar(150) not null,
fecha_registro date not null,
estado_inventario varchar(20) not null,
id_usuario int
);

--Tabla-5-Insumo
create table insumo(
id_insumo int primary key auto_increment,
nombre_insumo varchar(150) not null,
descripcion varchar(400) null,
cantidad int not null,
stock_minimo int not null,
fecha_vencimiento date not null,
lote varchar(25) not null,
cas varchar(25) null,
marca varchar(25) not null,
estado_insumo varchar(25) not null,
id_inventario int not null
);

--Tabla-6-Alerta
create table alerta(
id_alerta int primary key auto_increment,
tipo_alerta varchar(100) not null,
fecha_activacion date not null,
descripcion varchar(400) null,
id_insumo int not null
);

--Tabla-7-Proveedor
create table proveedor(
id_proveedor int primary key auto_increment,
nombre varchar(50) not null,
email  varchar(100) not null,
contacto varchar(20) null
);

--Tabla-8-Insumo_proveedor
create table insumo_proveedor(
id_insumo int not null,
id_proveedor int not null
);

/*Creación de claves foráneas
Claves foráneas en usuario_permiso*/
alter table usuario_permiso
add constraint
foreign key (id_usuario) references usuario(id_usuario);

alter table usuario_permiso
add constraint
foreign key (id_permiso) references permiso(id_permiso);

--Clave foránea en inventario
alter table inventario
add constraint
foreign key (id_usuario) references usuario(id_usuario);

--Clave foránea en insumo

alter table insumo
add constraint
foreign key (id_inventario) references inventario(id_inventario);

--Clave foránea en alerta
alter table alerta
add constraint
foreign key (id_insumo) references insumo(id_insumo);

--Claves foráneas en insumo_proveedor
alter table insumo_proveedor
add constraint
foreign key (id_insumo) references insumo(id_insumo);

alter table insumo_proveedor
add constraint
foreign key (id_proveedor) references proveedor(id_proveedor);

-- Para evitar duplicados en las tablas intermedias añadimos como PK la combinación de ambas FK
alter table usuario_permiso
add primary key (id_usuario, id_permiso);

alter table insumo_proveedor
add primary key(id_insumo, id_proveedor);
