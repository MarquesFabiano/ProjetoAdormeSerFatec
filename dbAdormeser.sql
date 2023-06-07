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

ALTER TABLE usuarios
ADD duracao_sono TIME;


DELIMITER //

CREATE OR REPLACE FUNCTION calcular_duracao_sono(horario_dormir TIME, horario_acordar TIME)
RETURNS VARCHAR(8)
BEGIN
  DECLARE duracao TIME;

  IF horario_acordar >= horario_dormir THEN
    SET duracao = TIMEDIFF(horario_acordar, horario_dormir);
  ELSE
    SET duracao = ADDTIME(TIMEDIFF('24:00:00', horario_dormir), horario_acordar);
  END IF;

  RETURN TIME_FORMAT(duracao, '%H:%i:%s');
END//

DELIMITER ;


DELIMITER //

CREATE TRIGGER calcular_duracao_sono_trigger
BEFORE INSERT ON usuarios
FOR EACH ROW
BEGIN
  SET NEW.duracao_sono = calcular_duracao_sono(NEW.horario_dormir, NEW.horario_acordar);
END//

DELIMITER ;

