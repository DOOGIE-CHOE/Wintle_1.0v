-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER="root"@"localhost" PROCEDURE "Win_Like_Content"(
in _user_id int,
in _content_id int, /* it can be either content_id or project id*/
in _type varchar(255),
out _return int
)
this:BEGIN

	DECLARE done INT DEFAULT FALSE;
	declare _result int;
	declare _c_id int;
	declare my_cursor CURSOR FOR SELECT content_id FROM project_list where project_id = _content_id;
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
	

	/* if it's content */
	if _type != 'project' then
		select count(*) into _result from content_like where content_id = _content_id;

		/* like content or unlike content*/
		if _result = 0 then
			insert into content_like(content_id, user_id) values(_content_id, _user_id);
			set _return = 1;
		elseif _result = 1 then
			delete from content_like where content_id = _content_id;
			set _return = 2;
		else
			set _return = -1;
		end if;
	else 
		select count(*) into _result from project_like where project_id = _content_id;		
		if _result = 0 then
			OPEN my_cursor;
			read_loop: LOOP
				FETCH my_cursor INTO _c_id;
				select count(*) into _result from content_like where content_id = _c_id;
					if _result = 0 then
						insert into content_like(content_id, user_id) values(_c_id, _user_id);
					end if;
				IF done THEN
				LEAVE read_loop;
				END IF;
			END LOOP;
		insert into project_like(project_id, user_id) values(_content_id, _user_id);
		set _return = 1;
		elseif _result = 1 then
			OPEN my_cursor;
			read_loop: LOOP
				FETCH my_cursor INTO _c_id;
					select count(*) into _result from content_like where content_id = _c_id;
					if _result = 1 then
						delete from content_like where content_id = _c_id;
					end if;
				IF done THEN
				LEAVE read_loop;
				END IF;
			END LOOP;
		delete from project_like where project_id = _content_id;
		set _return = 2;
		end if;
	end if;
END