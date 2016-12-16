create table content_path_list(
	content_id int,
    path_id int,
    primary key(content_id, path_id),
    foreign key (content_id) references content(content_id),
    foreign key(path_id) references content_path(path_id));