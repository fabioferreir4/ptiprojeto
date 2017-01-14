DROP TABLE IF EXISTS viagem;
CREATE TABLE viagem(
	id_viagem INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_user INTEGER NOT NULL,
    id_veiculo INTEGER NOT NULL,
    data_inicio DATE NOT NULL,
    duracao TIME DEFAULT NULL,
    rua_inicio VARCHAR(50) NOT NULL,
    rua_fim VARCHAR(50) DEFAULT NULL,
    distancia DOUBLE DEFAULT NULL,
    velocidade_media FLOAT DEFAULT NULL,
    consumo_medio FLOAT DEFAULT NULL,
    CONSTRAINT fk_Viagem_Utilizador FOREIGN KEY (id_user) REFERENCES utilizador(id_user) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT fk_Viagem_Veiculo FOREIGN KEY (id_veiculo) REFERENCES veiculo(id_veiculo) ON UPDATE CASCADE ON DELETE CASCADE);
