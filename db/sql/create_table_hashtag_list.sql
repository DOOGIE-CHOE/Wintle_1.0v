create table hashtag_list(
	content_id int,
    hashtag_id int,
    primary key(content_id, hashtag_id),
    foreign  key (content_id) references content(content_id),
    foreign key (hashtag_id) references hashtag(hashtag_id)
);