create table user_profile(
user_id	int primary key,
introduction varchar(1000) default null,
profile_url varchar(255) default null,
profile_photo_path varchar(255) default null,
cover_photo_path varchar(255) default null,
cover_photo_position varchar(255) default “0px”,
cover_edit_date timestamp default current_timestamp,
profile_upload_date timestamp default current_timestamp,
cover_upload_date timestamp default current_timestamp,
foreign key(user_id) references user(user_id)
);