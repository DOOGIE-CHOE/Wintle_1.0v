create table user_login_info(
	user_id int primary key,
    sign_up_date timestamp default current_timestamp,
    last_login_date timestamp default current_timestamp,
    login_count int default 0
    
);