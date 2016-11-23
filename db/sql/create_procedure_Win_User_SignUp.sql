GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_User_SignUp`(
in _user_name varchar(50),
in _user_email varchar(40),
in _password varchar(255),
out _return varchar(255))
BEGIN 

	declare	name_result int default 0;
    declare email_result int default 0;
    declare sequence int default 0;
    declare url varchar(255);
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;
         
    SELECT count(user_name) into name_result from user where user_name = _user_name;
    
    if name_result = 0 then
		SELECT count(user_email) into email_result from user where user_email = _user_email;
        if email_result = 0 then
				select GET_SEQUENCE('user') into sequence;
                if sequence != -1 then
					insert into user(user_id, user_email, user_name, password) values(sequence, _user_email, _user_name, _password);
					set url = concat(_user_name,'-',sequence);
					insert into user_profile(user_id, profile_url) values(sequence, url);
					insert into user_login_info(user_id) values (sequence);
                end if;
        end if;
    end if;
    
    if name_result = 1 then
		set _return = -1;
        rollback;
	elseif email_result = 1 then
		set _return = -2;
        rollback;
    elseif sequence = -1 then
		set _return = -99;
        rollback;
	else
		set _return = 0;
		commit;
    end if;
    
END