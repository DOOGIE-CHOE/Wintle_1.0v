create table content_comment(
    comment_id int primary key,
    content_id int not null,
    user_id int not null,
    comment varchar(1000) not null,
    upload_date timestamp default current_timestamp,
    modified_date timestamp default current_timestamp,
    foreign key(content_id) references content(content_id),
    foreign key(user_id) references user(user_id)	
);