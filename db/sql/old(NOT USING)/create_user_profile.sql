create table user_profile(
user_email varchar(40) primary key,
profile_photo_path varchar(255) default null,
cover_photo_path varchar(255) default null,
profile_upload_date timestamp default '0000-00-00 00:00:00',
cover_upload_date timestamp default '0000-00-00 00:00:00',
profile_url varchar(255) default null,
foreign key(user_email) references user(user_email)
);