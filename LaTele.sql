DROP DATABASE IF EXISTS LATELE;
CREATE DATABASE LATELE;
USE LATELE;

CREATE TABLE Usuario(
	nombre  VARCHAR(10)  COLLATE utf8_spanish_ci PRIMARY KEY,
    pass	VARCHAR(8)  COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO Usuario (nombre,pass) VALUES
("Public","asd");

CREATE TABLE Pais(
	id		INT PRIMARY KEY AUTO_INCREMENT,
    nombre	VARCHAR(15)  COLLATE utf8_spanish_ci,
    codigo	VARCHAR(10)  COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO Pais (nombre,codigo) VALUES
("Uruguay","UY"),
("Argentina","AR"),
("Brasil","BR"),
("Venezuela","VZ"),
("Europa","EU"),
("Colombia","CO"),
("Chile","CH"),
("Asia y oriente","AS"),
("USA","US"),
("Bolivia","BO"),
("Mexico","MX");


CREATE TABLE Categoria(
	id			INT PRIMARY KEY AUTO_INCREMENT,
    nombre		VARCHAR(15)   COLLATE utf8_spanish_ci,
    comentario	VARCHAR(100)   COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO Categoria (nombre,comentario) VALUES
("Variedades",""),
("Abierto","Canal abierto"),
("Noticias","Canal de noticias"),
("Deportes",""),
("Dibujos",""),
("Autos",""),
("Musica","Canal de musica"),
("Series",""),
("Documentales",""),
("Radio","");

CREATE TABLE Channel(
  id		INT(3) PRIMARY KEY AUTO_INCREMENT,
  number	INT(3) UNIQUE,
  name		VARCHAR(100) COLLATE utf8_spanish_ci,
  coment	VARCHAR(300)  COLLATE utf8_spanish_ci,
  views		INT(4),
  logo		VARCHAR(300)  COLLATE utf8_spanish_ci,
  country	INT,
  category	INT,
  user		VARCHAR(15)  COLLATE utf8_spanish_ci,
  active	BOOL,
  FOREIGN KEY (country) REFERENCES Pais(id),
  FOREIGN KEY (category) REFERENCES Categoria(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE YouTube(
	id				INT PRIMARY KEY,
	channel			VARCHAR(30)  COLLATE utf8_spanish_ci,
	src 			VARCHAR(200)  COLLATE utf8_spanish_ci,
	yt_nameVideo	VARCHAR(30)  COLLATE utf8_spanish_ci,
	yt_nameChannel	VARCHAR(30)  COLLATE utf8_spanish_ci,
	yt_logo 		VARCHAR(200)  COLLATE utf8_spanish_ci,
	yt_rating		INT(4),
	yt_description	VARCHAR(300)  COLLATE utf8_spanish_ci,
    video			BOOL,
    FOREIGN KEY (id) REFERENCES Channel(id)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE IFrame(
	id				INT PRIMARY KEY,
	src				VARCHAR(200)  COLLATE utf8_spanish_ci,
	tv				BOOL,
    FOREIGN KEY (id) REFERENCES Channel(id)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

CREATE TABLE DirectLink(
	id				INT PRIMARY KEY,
	src				VARCHAR(200)  COLLATE utf8_spanish_ci,
	tv				BOOL,
    placeholder		VARCHAR(200)  COLLATE utf8_spanish_ci,
    FOREIGN KEY (id) REFERENCES Channel(id)    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP PROCEDURE IF EXISTS AltaYouTube; 
DELIMITER //


CREATE PROCEDURE AltaYouTube 
( 	IN in_number		 INT(3),
	IN in_name			 VARCHAR(100),
	IN in_coment		 VARCHAR(300),
	IN in_views			 INT(4),
	IN in_logo			 VARCHAR(300),
	IN in_country		 INT,
	IN in_category		 INT,
	IN in_user			 VARCHAR(15),
	IN in_active		 BOOL,
	IN in_channel		 VARCHAR(30),
	IN in_src 			 VARCHAR(200),
	IN in_yt_nameVideo	 VARCHAR(30),
	IN in_yt_nameChannel VARCHAR(30),
	IN in_yt_logo 		 VARCHAR(200),
	IN in_yt_rating		 INT(4),
	IN in_yt_description VARCHAR(300), 
    IN in_video			 BOOL, 
OUT exito INT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;                
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
			(in_number,in_name,in_coment,in_views,in_logo,in_country,in_category,in_user,in_active);
			INSERT INTO YouTube (id,channel,src,yt_nameVideo,yt_nameChannel,yt_logo,yt_rating,yt_description,video) VALUES
			(@@identity,in_channel,in_src,in_yt_nameVideo,in_yt_nameChannel,in_yt_logo,in_yt_rating,in_yt_description,in_video);
			SET exito = @@identity;        
		END IF;     
    COMMIT;
END//
DELIMITER ;
/*
			INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
			(30,"CANAL NUEVO","Cm nuevo",0,"logonuevo",1,1,"Public",1);
			INSERT INTO YouTube (id,channel,src,yt_nameVideo,yt_nameChannel,yt_logo,yt_rating,yt_description,video) VALUES
			(@@identity,"yt_channel","src","ytnamevdoe","ytnamemchan","ytlogo",0,"description",0);
*/
/*
call AltaYouTube(2,"TN","Canal de noticias argentino", 1012,"tn.jpg",1,1,"Public",true,
"tnChannel","yt.me/tn", "Todo Noticias 24hs","Canal de TN","http://logotn.jpg",6035,"TN en vivo desde argentina nestras redes...",true,@exito);
call altaYouTube(3,"C5N","Canal de noticias argentino", 802,"c5n.jpg",1,1,"Public",true,"c5nChannel","yt.me/c5n", "C5N EN VIVO","Canal de C5N","http://logoc5n.jpg",5420,"Mirá C5N en vivo twitter...",false,@exito);
*/
/*select @exito;*/

DROP PROCEDURE IF EXISTS AltaIFrame; 
DELIMITER //

CREATE PROCEDURE AltaIFrame
( 	IN in_number		INT(3),
	IN in_name			VARCHAR(100),
	IN in_coment		VARCHAR(300),
	IN in_views			INT(4),
	IN in_logo			VARCHAR(300),
	IN in_country		INT,
	IN in_category		INT,
	IN in_user			VARCHAR(15),
	IN in_active		BOOL,
	IN in_src			VARCHAR(200),
	IN in_tv			BOOL, 
OUT exito INT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;                
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
			(in_number,in_name,in_coment,in_views,in_logo,in_country,in_category,in_user,in_active);
			INSERT INTO IFrame(id,src,tv) VALUES
			(@@identity,in_src,in_tv);
			SET exito = @@identity;
		END IF;            
    COMMIT;
END//
DELIMITER ;

                    
/*select @exito;*/
/*call AltaIFrame(5,"Canal 10","El canal uruguayo", 9002,"canal10.jpg",2,2,"Public",true,
					"www.canal10.com.uy/html",false,@exito);*/
/*select @exito;*/

DROP PROCEDURE IF EXISTS AltaDirectLink; 
DELIMITER //

CREATE PROCEDURE AltaDirectLink
( 	IN in_number		INT(3),
	IN in_name			VARCHAR(100),
	IN in_coment		VARCHAR(300),
	IN in_views			INT(4),
	IN in_logo			VARCHAR(300),
	IN in_country		INT,
	IN in_category		INT,
	IN in_user			VARCHAR(15),
	IN in_active		BOOL,
	IN in_src			VARCHAR(200),
	IN in_tv			BOOL,
    IN in_placeholder	VARCHAR(200),
OUT exito INT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;                
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			INSERT INTO Channel (number,name,coment,views,logo,country,category,user,active) VALUES
			(in_number,in_name,in_coment,in_views,in_logo,in_country,in_category,in_user,in_active);
			INSERT INTO DirectLink (id,src,tv,placeholder) VALUES
			(@@identity,in_src,in_tv,in_placeholder);
			SET exito = @@identity;        
		END IF;
    COMMIT;
END//
DELIMITER ;

/*select @exito;*/

DROP PROCEDURE IF EXISTS BajaCanal; 
DELIMITER //
CREATE PROCEDURE BajaCanal (IN in_id INT, OUT exito INT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    START TRANSACTION;
		IF EXISTS
			(SELECT * 
			FROM Channel INNER JOIN YouTube on Channel.id = YouTube.id
			WHERE Channel.id = in_id) 
        THEN
			DELETE FROM YouTube WHERE YouTube.id = in_id;
			DELETE FROM Channel WHERE Channel.id = in_id;
            SET exito = 1;
		ELSEIF EXISTS
			(SELECT * 
			FROM Channel INNER JOIN IFrame on Channel.id = IFrame.id
			WHERE Channel.id = in_id) 
		THEN
			DELETE FROM IFrame WHERE IFrame.id = in_id;
			DELETE FROM Channel WHERE Channel.id = in_id;
            SET exito = 1;        
        ELSEIF EXISTS
			(SELECT * 
			FROM Channel INNER JOIN DirectLink on Channel.id = DirectLink.id
			WHERE Channel.id = in_id) 
		THEN
			DELETE FROM DirectLink WHERE DirectLink.id = in_id;
			DELETE FROM Channel WHERE Channel.id = in_id;
            SET exito = 1;        
		ELSE
			SET exito = -5;
			ROLLBACK;
		END IF;
    COMMIT;
END//
DELIMITER ;
/*
SELECT count(*) FROM Channel INNER JOIN YouTube WHERE Channel.id = 1;
DELETE FROM SELECT * FROM Channel INNER JOIN YouTube WHERE Channel.id = 1;
*/

/*
call BajaCanal(1,@exito);
select @exito;
*/

DROP PROCEDURE IF EXISTS ModificarYouTube; 
DELIMITER //
CREATE PROCEDURE ModificarYouTube
( 	IN in_id			 INT(3),
	IN in_number		 INT(3),
	IN in_name			 VARCHAR(100),
	IN in_coment		 VARCHAR(300),
	IN in_views			 INT(4),
	IN in_logo			 VARCHAR(300),
	IN in_country		 INT,
	IN in_category		 INT,
	IN in_user			 VARCHAR(15),
	IN in_active		 BOOL,
	IN in_channel		 VARCHAR(30),
	IN in_src 			 VARCHAR(200),
	IN in_yt_nameVideo	 VARCHAR(30),
	IN in_yt_nameChannel VARCHAR(30),
	IN in_yt_logo 		 VARCHAR(200),
	IN in_yt_rating		 INT(4),
	IN in_yt_description VARCHAR(300),  
    IN in_video 		 BOOL,  
OUT exito INT)
BEGIN
	DECLARE cu INT DEFAULT 0;
    DECLARE cd INT DEFAULT 0;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Channel INNER JOIN YouTube on YouTube.id = Channel.id WHERE YouTube.id = in_id) THEN
			SET exito = -5; -- no existe el canal
			ROLLBACK;
		END IF;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number AND Channel.id <> in_id) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;               
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			UPDATE Channel SET number=in_number, name=in_name, coment=in_coment, views=in_views, logo=in_logo,
            country=in_country, category=in_category, user=in_user, active=in_active
			WHERE Channel.id = in_id;
			UPDATE YouTube SET 
			channel=in_channel, src=in_src, yt_nameVideo=in_yt_nameVideo, 
            yt_nameChannel=in_yt_nameChannel, yt_logo=in_yt_logo, yt_rating=in_yt_rating, 
            yt_description=in_yt_description, video=in_video
			WHERE id = in_id;
			SET exito = 1; 
		END IF;
    COMMIT;
END//
DELIMITER ;

/*call ModificarYouTube(1,2,"TN 2","Canal de noticias argentino", 1012,"tn.jpg",1,1,"Public",true,
"tnChannel","yt.me/tn", "Todo Noticias 24hs","Canal de TN","http://logotn.jpg",6035,"TN en vivo desde argentina nestras redes...",true,@exito);*/
/*call altaYouTube(2,3,"C5N","Canal de noticias argentino", 802,"c5n.jpg",1,1,"Public",true,"c5nChannel","yt.me/c5n", "C5N EN VIVO","Canal de C5N","http://logoc5n.jpg",5420,"Mirá C5N en vivo twitter...",false,@exito);*/
/*select @exito;*/
DROP PROCEDURE IF EXISTS ModificarDirectLink; 
DELIMITER //
CREATE PROCEDURE ModificarDirectLink
( 	IN in_id			 INT(3),
	IN in_number		 INT(3),
	IN in_name			 VARCHAR(100),
	IN in_coment		 VARCHAR(300),
	IN in_views			 INT(4),
	IN in_logo			 VARCHAR(300),
	IN in_country		 INT,
	IN in_category		 INT,
	IN in_user			 VARCHAR(15),
	IN in_active		 BOOL,
	IN in_src				 VARCHAR(200),
	IN in_tv				 BOOL,
    IN in_placeholder		 VARCHAR(200),
OUT exito INT)
BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Channel INNER JOIN DirectLink on DirectLink.id = Channel.id WHERE DirectLink.id = in_id) THEN
			SET exito = -5; -- no existe el canal
			ROLLBACK;
		END IF;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number AND Channel.id <> in_id) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;                
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			UPDATE Channel SET number=in_number, name=in_name, coment=in_coment, views=in_views, logo=in_logo,
            country=in_country, category=in_category, user=in_user, active=in_active
			WHERE Channel.id = in_id;
			UPDATE DirectLink SET 
			src=in_src, tv=in_tv, placeholder=in_placeholder
			WHERE id = in_id;
			SET exito = 1; 
		END IF;
    COMMIT;
END//
DELIMITER ;

/*call ModificarDirectLink(5,1,"América 2","Canal abierto argentino", 102,"america.jpg",1,2,"Public",true,
"www.srcAmerica.com/html",false,"placeholder.jpg",@exito);*/
/*select @exito;*/

DROP PROCEDURE IF EXISTS ModificarIFrame; 
DELIMITER //
CREATE PROCEDURE ModificarIFrame
( 	IN in_id			 INT(3),
	IN in_number		 INT(3),
	IN in_name			 VARCHAR(100),
	IN in_coment		 VARCHAR(300),
	IN in_views			 INT(4),
	IN in_logo			 VARCHAR(300),
	IN in_country		 INT,
	IN in_category		 INT,
	IN in_user			 VARCHAR(15),
	IN in_active		 BOOL,
	IN in_src			 VARCHAR(200),
	IN in_tv			 BOOL,
OUT exito INT)
BEGIN
	DECLARE cu INT DEFAULT 0;
    DECLARE cd INT DEFAULT 0;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION, SQLWARNING
	BEGIN
		ROLLBACK;
	END;
    
    START TRANSACTION;
		IF NOT EXISTS (SELECT * FROM Channel INNER JOIN IFrame on IFrame.id = Channel.id WHERE IFrame.id = in_id) THEN
			SET exito = -5; -- no existe el canal
			ROLLBACK;
		END IF;
		IF NOT EXISTS (SELECT * FROM Pais WHERE Pais.id = in_country) THEN
			SET exito = -1; -- no existe el pais
			ROLLBACK;
		END IF;
		IF EXISTS (SELECT number FROM Channel WHERE Channel.number = in_number AND Channel.id <> in_id) THEN
			SET exito = -2; -- ya hay un canal con ese numero
			ROLLBACK;
		END IF;        
		IF NOT EXISTS (SELECT * FROM Categoria WHERE Categoria.id = in_category) THEN
			SET exito = -3; -- no existe la categoria
			ROLLBACK;
		END IF;  
		IF NOT EXISTS (SELECT * FROM Usuario WHERE Usuario.nombre = in_user) THEN
			SET exito = -4; -- no existe la categoria
			ROLLBACK;
		ELSE
			UPDATE Channel SET number=in_number, name=in_name, coment=in_coment, views=in_views, logo=in_logo,
            country=in_country, category=in_category, user=in_user, active=in_active
			WHERE Channel.id = in_id;
			UPDATE IFrame SET 
			src=in_src, tv=in_tv
			WHERE id = in_id;
			SET exito = 1; 
		END IF;
    COMMIT;
END//
DELIMITER ;

/*select @exito;*/
/*call ModificarIFrame(3,4,"Canal 10 - 2","El canal uruguayo", 9002,"canal10.jpg",2,2,"Public",true,
					"www.canal12.com.uy/html",false,@exito);*/
/*select @exito;*/

DROP PROCEDURE IF EXISTS ListarCanales;
DELIMITER //
CREATE PROCEDURE ListarCanales()
BEGIN
	SELECT * FROM YouTube inner join CHANNEL on YouTube.id = Channel.id;
    
    SELECT * FROM IFrame inner join CHANNEL on IFrame.id = Channel.id;
    
    SELECT * FROM DirectLink inner join CHANNEL on DirectLink.id = Channel.id;
END//
DELIMITER ;
/*
SELECT * FROM Channel inner join YouTube on Channel.id = YouTube.id WHERE Channel.id = 2;

call ListarCanales();
*/
/*
call AltaYouTube(1,"RadioMundo"	,"", 0,"radiomundo.jpg"	,1,1,"Public",true,"UC18bcMIXfMHgnGDe-YysDJw","", "","","",0,"",false,@exito);
call AltaIFrame	(2,"Artigas TV"	,"", 0,"artigastv.jpg"	,2,2,"Public",true,"http://tv.vera.com.uy/syndication/index.php/sindicacion/play/ANTEL-PLAYLIST/57/100%25/100%25/",true,@exito);
call AltaIFrame	(3,"TNU"	,"", 0,"TNU.jpg"	,2,2,"Public",true,"http://tv.vera.com.uy/syndication/index.php/sindicacion/play/ANTEL-PLAYLIST/80/100%25/100%25/",true,@exito);
call AltaDirectLink(4,"Canal U","", 0,"canalu.jpg",1,2,"Public",true,"http://50.23.204.86:1935/canalu/envivo/playlist.m3u8",true,"placeholder.jpg",@exito);
call AltaYouTube(5,"POP TV"	,"", 0,"poptv.jpg"	,1,1,"Public",true,"UCf_uRkSNbPDBToWyLnnmHHw","", "","","",0,"",false,@exito);
call AltaDirectLink(6,"Canal M","", 0,"canalm.jpg",1,2,"Public",true,"http://wowza.montevideo.com.uy:1936/live/_definst_/mvdstrem/playlist.m3u8",true,"placeholder.jpg",@exito);
call AltaDirectLink(7,"Multivisión","", 0,"canal9multivision.jpg",1,2,"Public",true,"http://panel.dattalive.com:1935/8250/8250/chunklist_w1222584390.m3u8",true,"placeholder.jpg",@exito);
call AltaDirectLink(8,"MaxTV","", 0,"13maxtvdigital.jpg",1,2,"Public",true,"http://coninfo.net:1935/13max/live/chunklist_w1403812025.m3u8",true,"placeholder.jpg",@exito);
call AltaDirectLink(9,"Canal 9","", 0,"canal9litoral.jpg",1,2,"Public",true,"http://streaming.arcast.com.ar:1935/canal9webok/ngrp:canal9webok_all/chunklist_w769121244_b747520.m3u88",true,"placeholder.jpg",@exito);
call AltaYouTube(10,"Canal KZO"	,"", 0,"kzo.jpeg"	,1,1,"Public",true,"UCv0zRACOVWmhu1Ilufm40-w","", "","","",0,"",false,@exito);
call AltaIFrame	(11,"Canal de la ciudad"	,"", 0,"canalDeLaCiudad.jpg"	,2,2,"Public",true,"http://vmf.edge-apps.net/embed/live.php?streamname=gcba_video3-100042&autoplay=true",true,@exito);
call AltaIFrame	(12,"Magazine TV"	,"", 0,"magazinetv.jpg"	,2,2,"Public",true,"http://vmf.edge-apps.net/embed/live.php?streamname=magazine_live01-100083&autoplay=true",true,@exito);
call AltaIFrame	(13,"América TV"	,"", 0,"americatv.jpg"	,2,2,"Public",true,"http://vmf.edge-apps.net/embed/live.php?streamname=americahls-100056&autoplay=true",true,@exito);
call AltaYouTube(14,"Canal 8 San Juan"	,"", 0,""	,1,1,"Public",true,"UC5UKMEIoqvNDMSDz2_6Sn9g","", "","","",0,"",false,@exito);
call AltaYouTube(15,"A24"	,"", 0,"a24.jpg"	,1,1,"Public",true,"UCR9120YBAqMfntqgRTKmkjQ","", "","","",0,"",false,@exito);
call AltaYouTube(16,"TV Pública Argentina"	,"", 0,""	,1,1,"Public",true,"UCs231K71Bnu5295_x0MB5Pg","", "","","",0,"",false,@exito);
call AltaIFrame	(17,"Canal 9 BBAA"	,"", 0,"elnueve.jpg"	,2,2,"Public",true,"http://d1hgdosjnpxc13.cloudfront.net/player_canal9.html",true,@exito);
call AltaYouTube(18,"El Trece"	,"", 0,"eltrece.jpg"	,1,1,"Public",true,"","9h6Vz6ylIdE", "","","",0,"",true,@exito);
call AltaYouTube(19,"TN"	,"", 0,"tn.jpg"	,1,1,"Public",true,"UCj6PcyLvpnIRT_2W_mwa9Aw","vnVeVWYMLIs", "","","",0,"",true,@exito);
call AltaYouTube(20,"C5N"	,"", 0,"c5n.jpg"	,1,1,"Public",true,"UCFgk2Q2mVO1BklRQhSv6p0w","", "","","",0,"",false,@exito);
call AltaDirectLink(21,"Canal  26 Noticias","", 0,"canal26.jpg",1,2,"Public",true,"http://live-edge01.telecentro.net.ar/live/smil:c26.smil/chunklist_w1004560692_b1864000_sleng.m3u8",true,"placeholder.jpg",@exito);


select * from Channel inner join DirectLink;
*/



