create table project(
	project_id int,
	upload_date timestamp default current_timestamp,
	view_count int default 0,
	shared_count int default 0,
	project_status_id int,
	primary key(project_id),
	foreign key (project_status_id) references project_status(project_status_id)
);