GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Send_Message`(
in _user_sender int,
in _user_receiver int,
in _message varchar(1000),
out _return int)
this : BEGIN

    declare opponent int default 0;
    declare message_group int default 0;
	declare group_sequence int default null;
	declare result int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;


	/* check if user exists */
	select count(user_id) into result from user where user_id = _user_sender or user_id = _user_receiver;
	if result <> 2 then
		set _return = -1;
        leave this;
	end if;
	
    /* check if there is existing conversation */
	/*select count(user_id), msg_group_id into opponent, message_group from message_list 
    where msg_group_id 
    in(select msg_group_id from message_list where msg_group_id in (select msg_group_id from message_list where user_id = _user_sender)
	group by msg_group_id
	having count(user_id) = 2)
	and user_id = _user_receiver;*/
    
    /*select count(m.msg_group_id), m.msg_group_id into opponent, message_group from message_list m
	inner join message_list n
	on m.msg_group_id = n.msg_group_id
	where m.user_id = 100001002 and
	n.user_id = 100001032;*/
    /* check if there is existing conversation */
    select count(m.msg_group_id), m.msg_group_id into opponent, message_group from message_list m
	inner join message_list n
	on m.msg_group_id = n.msg_group_id
	where m.user_id = _user_sender and
	n.user_id = _user_receiver
	group by m.msg_group_id;
    
    if opponent = 1 then
			insert into user_message (user_id, msg_group_id, message) values(_user_sender, message_group,_message);
            set _return = 1;
	elseif opponent = 0 then
			select GET_SEQUENCE('message') into group_sequence;
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