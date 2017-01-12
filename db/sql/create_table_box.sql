create table box(
	user_id int,
	box_id int,
	content_id int,
	added_date timestamp default current_timestamp,
	foreign key(user_id, box_id) references box_list(user_id, box_id)
);