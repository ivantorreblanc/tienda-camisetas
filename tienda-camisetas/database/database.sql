CREATE DATABASE tienda_master;
use tienda_master;

CREATE TABLE usuarios(
id              int(255) auto_increment NOT NULL,
nombre          VARCHAR(100) NOT NULL,
apellidos       VARCHAR(100),
email           VARCHAR(255) not null,
password        varchar(255) not null,
rol             varchar (20),
imagen          varchar(255),
CONSTRAINT pk_usuarios PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)
)ENGINE=InnoDb;
INSERT INTO usuarios VALUES(NULL, 'Admin', 'Admin', 'admin@admin.com', 'password', 'admin', null);


CREATE TABLE categorias(
id              int(255) auto_increment NOT NULL,
nombre          VARCHAR(100) NOT NULL,
CONSTRAINT pk_categorias PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO categorias VALUES(null, 'Manga Corta');
INSERT INTO categorias VALUES(null, 'Tirantes');
INSERT INTO categorias VALUES(null, 'Manga Larga');
INSERT INTO categorias VALUES(null, 'Sudaderas');

CREATE TABLE productos(
id              int(255) auto_increment NOT NULL,
categoria_id    int(255) not null,
nombre          VARCHAR(100) NOT NULL,
descripcion     text,
precio          float(100,2) not null,
stock           int(255) not null,
oferta          varchar (2),
fecha           date not null,
imagen          varchar(255),

CONSTRAINT pk_productos PRIMARY KEY(id),
CONSTRAINT fk_producto_categoria FOREIGN KEY(categoria_id) REFERENCES categorias(id)

)ENGINE=InnoDb;


CREATE TABLE pedidos(
id              int(255) auto_increment NOT NULL,
usuario_id      int(255) not null,
provincia       varchar(100) not null,
localidad       varchar(100) not null,
direccion       varchar(255) not null,
coste           float(200,2) not null,
estado          varchar (20) not null,
fecha           date not null,
hora            time not null,


CONSTRAINT pk_pedidos PRIMARY KEY(id),
CONSTRAINT fk_pedido_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)

)ENGINE=InnoDb;

CREATE TABLE lineas_pedido(
id              int(255) auto_increment NOT NULL,
pedido_id       int(255) not null,
producto_id     int(100) not null,
unidades        varchar(100) not null,


CONSTRAINT pk_lineas_pedido PRIMARY KEY(id),
CONSTRAINT fk_lineas_pedido_pedidos FOREIGN KEY(pedido_id) REFERENCES pedidos(id),
CONSTRAINT fk_lineas_pedido_producto FOREIGN KEY(producto_id) REFERENCES productos(id)

)ENGINE=InnoDb;

