create table music(
	music_id varchar(50) primary key,
    music_path varchar(255),
    image_path varchar(255),
    likes int default '0'
);