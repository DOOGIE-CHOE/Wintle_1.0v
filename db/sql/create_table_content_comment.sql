create table content_comment(
	content_id int,
    comment_id int,
    user_id int not null,
    comments varchar(1000) not null,
    upload_date timestamp default current_timestamp,
    modified_date timestamp default 0,
    primary key(content_id, comment_id),
    foreign key(content_id) references content(content_id)
);