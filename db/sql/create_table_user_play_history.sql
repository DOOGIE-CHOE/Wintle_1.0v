create table user_play_history(
	user_id int,
    content_id int,
    played_time int,
    foreign key(user_id) references user(user_id)
);