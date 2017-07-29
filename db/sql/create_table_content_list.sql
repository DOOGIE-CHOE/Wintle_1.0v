create table content_list(
    user_id int,
    content_id int,
    content_type_id int not null,
    foreign key (content_type_id) references  content_type(content_type_id),
    foreign key (user_id) references user(user_id),
    foreign key (content_id) references content(content_id),
    primary key(user_id, content_id)
);