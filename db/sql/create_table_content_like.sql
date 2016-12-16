create table content_like(
	content_id int,
    user_id int,
    primary key(content_id, user_id),
    foreign key (content_id) references content(content_id)
);