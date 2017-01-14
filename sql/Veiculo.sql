DROP TABLE IF EXISTS veiculo;
CREATE TABLE veiculo(
	id_veiculo INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_user INTEGER NOT NULL,
    marca_modelo VARCHAR(50) NOT NULL,
    ano VARCHAR(10) DEFAULT NULL,
	cilindrada INTEGER DEFAULT NULL,
    combustivel VARCHAR(20) DEFAULT NULL,
    consumo_medio FLOAT NOT NULL,
	CONSTRAINT fk_Veiculo_Utilizador FOREIGN KEY (id_user) REFERENCES utilizador(id_user) ON UPDATE CASCADE ON DELETE CASCADE);
