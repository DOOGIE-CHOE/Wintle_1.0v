GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Upload_Content`(
in _content_title varchar(255),
in _content_path varchar(255),
in _comments varchar(3000),
in _user_id int,
in _content_type varchar(255),
out _return int)
this : BEGIN

    declare c_id int default 0;   
    declare c_type int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;
    
	set c_id = GET_SEQUENCE(_content_type);
    
    if c_id = -1 then
		set _return = -1;
        leave this;
    end if;
    
    if _content_type = 'lyrics' then
		set c_type = 1;
	elseif _content_type = 'audio' then
		set c_type = 2;
	elseif _content_type = 'image' then
		set c_type = 3;
	else
		set c_type = -1;
    end if;
    
	insert into content(content_id, content_title, content_path, comments) values(c_id, _content_title, _content_path, _comments);
    insert into content_list(user_id, content_id, content_type_id) values(_user_id, c_id, c_type);
	set _return = c_id;
    
END