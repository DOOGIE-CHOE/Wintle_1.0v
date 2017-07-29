create table box(
	box_id int,
	content_id int,
	added_date timestamp default current_timestamp,
	primary key(box_id, content_id),
	foreign key(box_id) references box_list(box_id),
	foreign key(content_id) references content(content_id)
);