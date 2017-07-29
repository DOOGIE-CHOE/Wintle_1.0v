create table follow_list(
	user_id_1 int,
    user_id_2 int,
    follow_date timestamp default current_timestamp,
    primary key(user_id_1,user_id_2),
    foreign key(user_id_1) references user(user_id),
    foreign key(user_id_2) references user(user_id)
);
