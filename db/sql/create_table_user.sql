create table user(
	user_id int primary key,
    user_email varchar(40) not null,
    user_name varchar(50) not null,
    password varchar(255),
    authority_id int default 1,
    status_id int default 1,
    sign_up_date timestamp default current_timestamp,
    last_login_date timestamp default current_timestamp,
    login_count int default 0,
	token_id decimal(21,0) default null,
    foreign key(authority_id) references authority_list(authority_id),
    foreign key(status_id) references user_status(status_id)
);