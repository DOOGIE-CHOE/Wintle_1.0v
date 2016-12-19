GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Upload_Content`(
in _title varchar(255),
in _content_path varchar(1000),
in _comments varchar(255),
in _hashtags varchar(255),
in _user_id int,
in _content_type int,
out _return int)

this : BEGIN

    declare id int default 0;
    
    declare EXIT handler for sqlexception, sqlwarning
    begin
    rollback;
    set _return = -100;
    end;
    
	start transaction;
	
    if _content_type = 1 then
		select GET_SEQUENCE('lyrics') into id;
	elseif _content_type = 2 then
		select GET_SEQUENCE('audio') into id;
	elseif _content_type = 3 then
        select GET_SEQUENCE('image') into id;
	else
		set _return = -1;
        leave this;
    end if;
    
	#insert into content(content_id, content_title, content_path, comments) values(id, _content_title, _content_path, _comments);
    
    select tag_name into _return  from hashtag where tag_name in (_hashtags);
    
    

END