SELECT  car_list_id,car_name FROM cultrv8_db.car_list
WHERE car_name_display = 1;

SELECT car_name
FROM car_list
WHERE car_list_id = '1';

SELECT *
FROM car_response_list;

SELECT car_response_word1, car_response_word2,car_response_word3, car_response_word4,car_response_word5
FROM car_response_list
WHERE car_list_id = 1

INSERT INTO `cultrv8_db`.`car_response_list`
(
`car_list_id`,
`car_response_word1`,
`car_response_word2`,
`car_response_word3`,
`car_response_word4`,
`car_response_word5`)
VALUES
(
1,
'Innovative',
'Risk Taking',
'Adventurous',
'Dynamic',
'Disorganised');




CREATE TABLE `car_list` (
  `car_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `car_name` varchar(256) DEFAULT NULL,
  `car_name_display` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`car_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;







INSERT INTO `cultrv8_db`.`car_list`
(
`car_name`,
`car_name_display`)
VALUES
('Formula 1 Car',1),
('Family Wagon',1),
('Four Wheel Drive',1),
('Limousine ',1);


UPDATE `cultrv8_db`.`car_list`
SET
`car_name` = 'Limousine'
WHERE `car_list_id` = 4;


UPDATE `cultrv8_db`.`car_list`
SET
`car_name_display` = 1;
WHERE `car_list_id` = 4;