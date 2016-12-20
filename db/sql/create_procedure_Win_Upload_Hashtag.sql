GRANT
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Win_Upload_Hashtag`(
in _content_id int,
in _hashtag varchar(255),
out _return int)
this : BEGIN

	declare hashid int default 0;

    declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;
    
	if not exists (select hashtag_id from hashtag where tag_name = _hashtag) then
		set hashid = GET_SEQUENCE('hashtag');
		if hashid = -1 then
			set _return = -1;
			leave this;
		end if;
		INSERT INTO hashtag(hashtag_id, tag_name) values(hashid, _hashtag);
	else
		select hashtag_id into hashid from hashtag where tag_name = _hashtag;
	end if;
    
	INSERT INTO hashtag_list(content_id, hashtag_id) values(_content_id, hashid);
    set _return = 1;
END