create table content_like(
    content_id int,
    user_id int,
    like_date timestamp default current_timestamp,
    primary key(content_id, user_id),
    foreign key(content_id) references content(content_id),
    foreign key(user_id) references user(user_id)
);