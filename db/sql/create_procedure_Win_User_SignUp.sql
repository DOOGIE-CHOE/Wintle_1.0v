-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_User_SignUp`(
in _user_name varchar(50),
in _user_email varchar(40),
in _password varchar(255),
in _token decimal(21,0),
out _return int)
BEGIN 

    declare email_result varchar(255);
    declare sequence int default 0;
    declare url varchar(255);
	declare token decimal(21,0);
	declare result int default 1;
    
    /*declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;*/
	start transaction;
		SELECT count(user_email) into email_result from user where user_email = _user_email;
		SELECT token_id into token from user where user_email = _user_email;
			if email_result = 0 then
					select GET_SEQUENCE('user') into sequence;
					if sequence != -1 then
						if _token = 0 then
							insert into user(user_id, user_email, user_name, password) values(sequence, _user_email, _user_name, _password);
						elseif _token <> 0 then
							insert into user(user_id, user_email, user_name,token_id) values(sequence, _user_email, _user_name,_token);
						end if;
						set url = concat(_user_name,'-',sequence);
						insert into user_profile(user_id, profile_url) values(sequence, url);
						insert into user_career(user_id) values (sequence);
						set result = 0;
					end if;
			elseif email_result = 1 then
				if token is null and _token <> 0 then
					update user set token_id = _token where user_email = _user_email;
					set result = 0;
				elseif token = _token then
					set result = 0;
				else
					set result = -1;
				end if;
			end if;



	if result = -1 then
		set _return = -1;
		rollback;
	elseif sequence = -1 then
		set _return = -99;
        rollback;
	elseif result = 0 then
		set _return = 0;
		commit;
    end if;
END;