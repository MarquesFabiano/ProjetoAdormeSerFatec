CREATE DATABASE adormeser

USE adormeser 


CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  senha VARCHAR(100) NOT NULL,
  email VARCHAR(100),
  idade DATE,
  horario_dormir TIME,
  horario_acordar TIME,
  pais VARCHAR(50),
  estado VARCHAR(50)
);

DELIMITER //

CREATE TRIGGER excluir_conta_atual
AFTER DELETE ON usuarios
FOR EACH ROW
BEGIN
  DELETE FROM usuarios WHERE id = OLD.id;
END//

DELIMITER ;
