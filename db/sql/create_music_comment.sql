create table music_comment(
music_id varchar(50),
comment_user_email varchar(40),
comment varchar(255),
update_date timestamp,
foreign key(music_id) references music(music_id)
);