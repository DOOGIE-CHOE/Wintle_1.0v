create table friend_list(
	user_id_1 int,
    user_id_2 int,
    friend_status_index int,
    primary key(user_id_1, user_id_2),
    foreign key(user_id_1) references user(user_id),
    foreign key(user_id_2) references user(user_id)
);