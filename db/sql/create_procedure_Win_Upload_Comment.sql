-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER="root"@"localhost" PROCEDURE "Win_Upload_Comment"(
in _comment_id int,
in _user_id int,
in _content_id int,
in _comment varchar(1000),
in _content_type varchar(255),
in _comment_type varchar(255),
out _return int)
this : BEGIN
	declare result int default 1;
	declare cmt_num int default 0;
	declare new_comment_id int default 0;

    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;

	start transaction;

	if _content_type = 'content' then

		if _comment_type = 'insert' then
			set new_comment_id = GET_SEQUENCE('comment');
			if new_comment_id <> -1 then
				insert into content_comment(comment_id, user_id, content_id, comment) values(new_comment_id,_user_id,  _content_id, _comment);
			else
				set result = -3;
			end if;
		elseif _comment_type = 'edit' then
			select count(*) into cmt_num from content_comment where comment_id = _comment_id;
			if cmt_num = 1 then
				update content_comment set comment = _comment,  modified_date = current_timestamp  where comment_id = _comment_id;
			else 
				set result = -1;
			end if;
		end if;
	elseif _content_type = 'project' then
		if _comment_type = 'insert' then
			set new_comment_id = GET_SEQUENCE('comment');
			if new_comment_id <> -1 then
				insert into project_comment(comment_id, user_id, project_id, comment) values(new_comment_id, _user_id, _content_id, _comment);
			else
				set result = -3;
			end if;
		elseif _comment_type = 'edit' then
			select count(*) into cmt_num from project_comment where comment_id = _comment_id;
			if cmt_num = 1 then
				update project_comment set comment = _comment, modified_date = current_timestamp where comment_id = _comment_id;
			else 
				set result = -1;
			end if;
		end if;
	else
		set result = -2;
	end if;
	
	set _return = result;
	if result = 1 then
		commit;
	else 
		rollback;
	end if;
END