<?php

CREATE TABLE fac_entidades (
	id int not null primary key auto_increment,
	idk varchar(50) not null unique key,
	
	nombre varchar(255) not null,
	razon_social varchar(255) not null,
	nif varchar(15) not null,
	direccion text not null,


	activo int null default 1,
	alta datetime null,
	ultimo timestamp null default CURRENT_TIMESTAMP,
	visitas int not null default 0
);

CREATE TABLE fac_direcciones (
	id int not null primary key auto_increment
	idk varchar(50) not null unique key,
	id_madre int null default 0,
	idk_madre int null,
	tipo_madre enum('entidad', 'persona fisica'),
	tipo_via varchar(255) null,
	nombre_via varchar(255) not null,
	numero varchar(50) null,
	portal varchar(50) null,
	escalera varchar(50) null,
	piso varchar (50) null,
	puerta varchar (50) null,
	cp varchar(15),
	pais varchar(255) null,
	provincia varchar(255) null,
	poblacion varchar (255) null,
	contacto varchar (255) null,
	alta datetime null,
	ultimo timestamp null default CURRENT_TIMESTAMP,
	activo tinyint null default 0
);