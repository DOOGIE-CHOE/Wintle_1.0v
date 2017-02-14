create table project_commnet(
	project_id int,
	user_id int,
	comment varchar(255),
	upload_date timestamp default current_timestamp,
	modified_date timestamp default current_timestamp,
	foreign key(project_id) references project(project_id),
	foreign key(user_id) references user(user_id)
);