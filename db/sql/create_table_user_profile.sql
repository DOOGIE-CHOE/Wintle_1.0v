create table user_profile(
user_id	int primary key,
profile_url varchar(255) default null,
profile_photo_path varchar(255) default null,
cover_photo_path varchar(255) default null,
profile_upload_date timestamp default '0000-00-00 00:00:00',
cover_upload_date timestamp default '0000-00-00 00:00:00',
foreign key(user_id) references user(user_id)
);