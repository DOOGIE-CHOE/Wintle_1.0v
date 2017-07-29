GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_User_LogIn`(
in _user_email varchar(40),
in _password varchar(80),
out _return int)
BEGIN 
	
    declare _checkuser int default 0;
    declare _result int default 0;

    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;
         
         
	select count(user_id) into _checkuser from user where user_email = _user_email;
    if _checkuser = 1 then
		select count(user_id) into _result from user where user_email = _user_email and password = _password;
    end if;
    
    
    if _checkuser = 0 then
		set _return = -1;
	elseif _result = 0 then
		set _return = -2;
	else
		set _return = 0;
        commit;
	end if;
    
END