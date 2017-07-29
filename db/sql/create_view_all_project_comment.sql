CREATE VIEW `view_all_project_comment` AS
select user.user_name,p_comment_info.*  from view_project_comment as p_comment_info
left join user
on p_comment_info.user_id = user.user_id;