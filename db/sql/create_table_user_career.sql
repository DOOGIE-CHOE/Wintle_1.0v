create table user_career(
	user_id int,
	sequence int,
    title varchar(255),
    period varchar(255),
    explanation varchar(255),
    foreign key(user_id) references user_profile(user_id)
);