GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Create_Message`(
in _user_sender varchar(50),
in _user_receiver varchar(40),
in _message varchar(1000),
out _return varchar(255))
BEGIN

	declare opponent int default 0;
    declare message_group int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;

	select count(user_id), msg_group_id into opponent, message_group from message_list 
    where msg_group_id 
    in(select msg_group_id from message_list where msg_group_id in (select msg_group_id from message_list where user_id = 1000001012)
	group by msg_group_id
	having count(user_id) = 2)
	and user_id = 1000001013;
    
    
    if opponent = 1 then
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, _message_group,_message);
    end if;
    commit;
    
END