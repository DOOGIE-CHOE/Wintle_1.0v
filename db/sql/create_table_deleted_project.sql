create table deleted_project(
	project_id int,
	upload_date timestamp ,
	view_count int ,
	shared_count int ,
	project_creator int,
	deleted_date timestamp default current_timestamp
)