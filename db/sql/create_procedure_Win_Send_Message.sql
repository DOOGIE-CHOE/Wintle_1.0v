GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Send_Message`(
in _user_sender int,
in _user_receiver int,
in _message varchar(1000),
out _return int)
BEGIN
	
    declare opponent int default 0;
    declare message_group int default 0;
	declare group_sequence int default null;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;

	select count(user_id), msg_group_id into opponent, message_group from message_list 
    where msg_group_id 
    in(select msg_group_id from message_list where msg_group_id in (select msg_group_id from message_list where user_id = _user_sender)
	group by msg_group_id
	having count(user_id) = 2)
	and user_id = _user_receiver;
    
    if opponent = 1 then
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, message_group,_message);
	elseif opponent = 0 then
			select GET_SEQUENCE('message') into group_sequence;
			insert into message_group (msg_group_id, msg_type) values (group_sequence, 1);
            insert into message_list (user_id, msg_group_id) values (_user_sender, group_sequence);
            insert into message_list (user_id, msg_group_id) values (_user_receiver, group_sequence);
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, group_sequence,_message);
	else
		set _return = -1;
    end if;
    commit;
    set _return = 0;
END