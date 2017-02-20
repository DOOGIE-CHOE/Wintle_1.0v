-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER="root"@"localhost" PROCEDURE "Win_Upload_Projectlist"(
in _project_id int,
in _content_id int,
in _start_point int,
in _volume int,
in _sequence int,
out _return int)
this : BEGIN

	/*declare EXIT handler for sqlexception, sqlwarning
    begin
    set _return = -100;
    end;*/

	insert into project_list(project_id, content_id, start_point, volume, sequence) values (_project_id, _content_id, _start_point, _volume, _sequence);
	set _return = 1;
END