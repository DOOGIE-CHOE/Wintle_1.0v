GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_User_SignUp`(
in _user_name varchar(50),
in _user_email varchar(40),
in _password varchar(255),
out _return int)
BEGIN 

	declare	result int default 0;
    declare sequence int default 0;
	start transaction;
    
    SELECT count(user_name) as usernumber into result from user where user_name = _user_name;
    
    if result = 0 then
		SELECT count(user_email) as emailnumber into result from user where user_email = _user_email;
        if result = 0 then
				select GET_SEQUENCE('user') into sequence;
                if sequence != -1 then
					insert into user(user_id, user_email, user_name, password) values(sequence, _user_email, _user_name, _password);
                end if;
        end if;
    end if;
    
    if result = 1 or sequence = -1 then
		set _return = -1;
        rollback;
	else
		set _return = 0;
		commit;
    end if;
END
