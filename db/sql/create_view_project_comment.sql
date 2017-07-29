CREATE VIEW `view_project_comment` AS
select 
 usr_prf.user_id,
 usr_prf.profile_photo_path,
 usr_prf.profile_url,
 p_comment.project_id,
 p_comment.comment,
 p_comment.upload_date 
from 
project_comment as p_comment 
left join user_profile as usr_prf 
on usr_prf.user_id = p_comment.user_id