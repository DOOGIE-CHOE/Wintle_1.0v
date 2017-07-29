create table project_list(
	project_id int,
	content_id int,
	start_point int default 0,
	volume int default 70,
	sequence int not null,
	foreign key (project_id) references project(project_id),
	foreign key (content_id) references content(content_id)
);