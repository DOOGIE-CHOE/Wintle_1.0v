-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER="root"@"localhost" PROCEDURE `Win_Delete_Project`(
in _project_id int,
out _return int)
BEGIN

	declare EXIT handler for sqlexception
	begin
    rollback;
    set _return = -100;
    end;

	insert into deleted_project(project_id, upload_date, view_count, shared_count, project_creator)
	select project_id, upload_date, view_count, shared_count, project_creator from project where project_id = _project_id;

	insert into deleted_project_list(project_id, content_id, start_point, volume, sequence)
	select project_id, content_id, start_point, volume, sequence from project_list where project_id = _project_id;

	delete from project_like where project_id = _project_id;
	delete from project_comment where project_id = _project_id;
	delete from project_list where project_id = _project_id;
	delete from project where project_id = _project_id;

	set _return = 1;

END