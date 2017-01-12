create table box_list (
	user_id int,
	box_id int,
	box_name varchar(50),
	created_date timestamp default current_timestamp,
	primary key(user_id, box_id),
	foreign key (user_id) references user(user_id)
);