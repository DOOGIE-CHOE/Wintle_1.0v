create table project_like(
	project_id int,
	user_id int,
	like_date timestamp default current_timestamp,
	primary key(project_id, user_id),
	foreign key(project_id) references project(project_id),
	foreign key(user_id) references user(user_id)
);