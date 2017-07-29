create table deleted_content (
	user_id int,
	content_id int,
    content_title varchar(255),
    content_path varchar(3000),
    comments varchar(3000),
    upload_date timestamp, 
    modified_date timestamp default current_timestamp,
	deleted_date timestamp default current_timestamp,
    view_count int,
	shared_count int
);