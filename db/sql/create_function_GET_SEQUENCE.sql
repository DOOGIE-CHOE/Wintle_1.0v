DELIMITER $$ 
CREATE DEFINER=`root`@`localhost` FUNCTION `GET_SEQUENCE`(
  sequence_type VARCHAR(255)
) RETURNS int
BEGIN

 declare number int;

 select last_number into number 
 from squence_table 
 where type = sequence_type;
 
 RETURN (sequence);
END