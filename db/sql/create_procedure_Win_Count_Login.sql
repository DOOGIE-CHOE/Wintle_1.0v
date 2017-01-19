-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Count_Login`(
in _user_id int,
out _return int)
this : BEGIN

	declare count int default 0;

    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;

	select login_count into count from user where user_id = _user_id;

	set count = count + 1;
	
	update user set login_count = count, last_login_date = current_timestamp where user_id = _user_id;

	set _return = 0;
    
END