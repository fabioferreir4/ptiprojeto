DROP TABLE IF EXISTS coordenadas;
CREATE TABLE coordenadas(
	id_coordenadas		INTEGER NOT NULL AUTO_INCREMENT,
	id_viagem			INTEGER NOT NULL,
    latitude			VARCHAR NOT NULL,
    longitude			VARCHAR NOT NULL,
    
    CONSTRAINT pk_Coordenadas
		PRIMARY KEY (id_coordenadas),
        
	CONSTRAINT fk_Coordenadas_Viagem
		FOREIGN KEY (id_viagem)
        REFERENCES viagem(id_viagem)
        ON UPDATE CASCADE
        ON DELETE CASCADE
)
