CREATE TABLE tasks (
  id INT AUTO_INCREMENT,
  gos VARCHAR(250),
  Name VARCHAR(250),
  Surname VARCHAR(250),
  Patronymic VARCHAR(250),
  description VARCHAR(250),
  marka VARCHAR(250),
  VIN VARCHAR(17),
  Phone VARCHAR(20),
  lead_time DATE NULL,
  PRIMARY KEY (id)
);

INSERT INTO tasks (gos, Name, Patronymic, Surname, description, marka, VIN, Phone, lead_time)
VALUES
  ('А123АА', 'Александр', 'Сергеевич', 'Пушкин', 'Описание описание описание','Toyota', 'VF7SH5FJ0CT513295','+7 (111) 456-7890', NULL),
  ('Е123ЕТ', 'Михаил', 'Юрьевич', 'Лермонтов', 'Описание описание описание','BMW', 'Z8NAJL00050366148' ,'+7 (222) 456-7890', '2023-05-22'),
  ('В123ВВ', 'Лев', 'Николаевич', 'Толстой', 'Описание описание описание','Ford', 'XTA210990Y2766389' ,'+7 (333) 456-7890', '2023-05-29');