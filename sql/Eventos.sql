DROP TABLE IF EXISTS eventos;
CREATE TABLE eventos(
	id_eventos     		INTEGER NOT NULL AUTO_INCREMENT,
	id_viagem			INTEGER NOT NULL,
    tipo                VARCHAR(20) NOT NULL,    
    latitude            VARCHAR NOT NULL,
    longitude           VARCHAR NOT NULL,

    CONSTRAINT pk_Eventos
		PRIMARY KEY (id_eventos),
        
	CONSTRAINT fk_Eventos_Viagem
		FOREIGN KEY (id_viagem)
        REFERENCES viagem(id_viagem)
        ON UPDATE CASCADE
        ON DELETE CASCADE
)