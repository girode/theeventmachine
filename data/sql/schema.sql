CREATE TABLE agenda (id INT AUTO_INCREMENT, nombre VARCHAR(255), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE agenda_evento (agenda_id INT, evento_id INT, PRIMARY KEY(agenda_id, evento_id)) ENGINE = INNODB;
CREATE TABLE evento (id INT AUTO_INCREMENT, descripcion VARCHAR(255), fecha_inicio DATE, fecha_fin DATE, repetir TINYINT(1), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE agenda_evento ADD CONSTRAINT agenda_evento_evento_id_evento_id FOREIGN KEY (evento_id) REFERENCES evento(id);
ALTER TABLE agenda_evento ADD CONSTRAINT agenda_evento_agenda_id_agenda_id FOREIGN KEY (agenda_id) REFERENCES agenda(id);
