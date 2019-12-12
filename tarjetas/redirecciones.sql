<?php //redirecciones de QR a URLS

Dar de alta una URL, y generar un código QR para esa URL

URL splash (url de llegada, del QR, para contabilizar visitas)
URL destino (url de destino)


CREATE TABLE qr_redir (
	id int not null primary key auto_increment,
	idk varchar(50) not null unique key,
	url_qr varchar(1024) not null,
	activo int null default 1,
	nivel int null default 0, 
	url_destino varchar(1024) not null,
	alta datetime null,
	ultimo timestamp null default CURRENT_TIMESTAMP,
	visitas int not null default 0
);

ALTA

INSERT INTO qr_redir SET 
url_qr = '',
url_destino = '',
activo = 1,
nivel = 0,
alta = CURRENT_TIMESTAMP,
visitas = 0
------
EDITAR

UPDATE qr_redir SET 
url_qr = '',
url_destino = '',
activo = 1,
nivel = 0,
alta = CURRENT_TIMESTAMP,
visitas = 0
WHERE id = ''

------

CREATE TABLE qr_visitas (
	id int not null primary key auto_increment,
	idk varchar(50) not null unique key,
	ip varchar(255) not null,
	nav varchar(1024) not null,
	id_qr int null,
	idk_qr varchar(50) null,
	ultimo timestamp null default CURRENT_TIMESTAMP
);

