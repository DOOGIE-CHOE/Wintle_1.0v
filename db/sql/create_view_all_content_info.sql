CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_all_content_info` AS
    SELECT 
        `cntlist`.`user_id` AS `user_id`,
        `cntlist`.`content_id` AS `content_id`,
        `cntlist`.`content_type_name` AS `content_type_name`,
        `cntlist`.`content_title` AS `content_title`,
        `cntlist`.`content_path` AS `content_path`,
        `cntlist`.`comments` AS `comments`,
        `cntlist`.`upload_date` AS `upload_date`,
        `cntlist`.`modified_date` AS `modified_date`,
        `cntlist`.`view_count` AS `view_count`,
        `cntlist`.`hashtags` AS `hashtags`,
        `prf`.`profile_url` AS `profile_url`,
        `prf`.`profile_photo_path` AS `profile_photo_path`,
        `usr`.`user_name` AS `user_name`
    FROM
        ((`view_content_with_hashtag` `cntlist`
        JOIN `user_profile` `prf`)
        JOIN `user` `usr`)
    WHERE
        ((`cntlist`.`user_id` = `prf`.`user_id`)
            AND (`cntlist`.`user_id` = `usr`.`user_id`))