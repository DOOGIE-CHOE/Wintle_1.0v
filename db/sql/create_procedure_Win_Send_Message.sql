GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Send_Message`(
in _user_sender int,
in _user_receiver int,
in _message varchar(1000),
out _return int)
this : BEGIN

    declare _opponent int default 0;
    declare _message_group_id int default 0;
	declare _group_sequence int default null;
	declare _result int default 0;
    
    
    /*declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    */
	start transaction;
    
	/* check if user exists */
	select count(user_id) into _result from user where user_id = _user_sender or user_id = _user_receiver;
	if _result <> 2 then
		set _return = -1;
        leave this;
	end if;
	
    /* check if there is existing conversation */
	select count(user_id), msg_group_id into _opponent, _message_group_id from message_list 
    where msg_group_id 
    in(select msg_group_id from message_list where msg_group_id in (select msg_group_id from message_list where user_id = _user_sender)
	group by msg_group_id
	having count(user_id) = 2)
	and user_id = _user_receiver;
    
	/*select count(user_id) user_count, msg_group_id into _opponent, _message_group_id from message_list where msg_group_id = (
	select msg_group_id from message_list where user_id = _user_sender)
	and user_id in (_user_receiver, _user_sender)
	group by msg_group_id;
    */
    
    if _opponent = 2 then
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, _message_group_id,_message);
            set _return = 1;
	elseif _opponent = 1 then 
			select GET_SEQUENCE('message') into _group_sequence;
			insert into message_group (msg_group_id, msg_type) values (group_sequence, 1);
            insert into message_list (user_id, msg_group_id) values (_user_sender, group_sequence);
            insert into message_list (user_id, msg_group_id) values (_user_receiver, group_sequence);
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, group_sequence,_message);
			set _return = 1;
	else
		set _return = -2;
        leave this;
    end if;
    
    
    commit;
    
END