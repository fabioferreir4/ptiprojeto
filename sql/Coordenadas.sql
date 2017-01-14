DROP TABLE IF EXISTS coordenadas;
CREATE TABLE coordenadas(
	id_coordenadas INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	id_viagem INTEGER NOT NULL,
    latitude VARCHAR(10) NOT NULL,
    longitude VARCHAR(10) NOT NULL,
	CONSTRAINT fk_Coordenadas_Viagem FOREIGN KEY (id_viagem) REFERENCES viagem(id_viagem) ON UPDATE CASCADE ON DELETE CASCADE);
