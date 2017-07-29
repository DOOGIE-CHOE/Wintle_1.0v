-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER="root"@"localhost" PROCEDURE "Win_Delete_Content"(
in _content_id int,
out _return int)
BEGIN

declare EXIT handler for sqlexception
    begin
    rollback;
    set _return = -100;
    end;

	insert into deleted_content(content_id, user_id, content_title, content_path, comments, upload_date, modified_date, view_count, shared_count)	
	select content_id, user_id, content_title, content_path, comments, upload_date, modified_date, view_count, shared_count from view_all_content_info where content_id = _content_id;

	delete from content_comment where content_id = _content_id;
	delete from content_like where content_id = _content_id;
	delete from content_list where content_id = _content_id;
	delete from hashtag_list where content_id = _content_id;
	
	update project_list set content_id = -1 where content_id = _content_id;
	
	delete from content where content_id = _content_id;

	set _return = 1;

END