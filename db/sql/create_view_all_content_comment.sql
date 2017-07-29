CREATE VIEW `view_all_content_comment` AS
select user.user_name,c_comment_info.*  from view_content_comment as c_comment_info
left join user
on c_comment_info.user_id = user.user_id;