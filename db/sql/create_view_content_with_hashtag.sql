CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_content_with_hashtag` AS
    SELECT 
        `con`.`user_id` AS `user_id`,
        `con`.`content_id` AS `content_id`,
        `con`.`content_type_name` AS `content_type_name`,
        `con`.`content_title` AS `content_title`,
        `con`.`content_path` AS `content_path`,
        `con`.`comments` AS `comments`,
        `con`.`upload_date` AS `upload_date`,
        `con`.`modified_date` AS `modified_date`,
        `con`.`view_count` AS `view_count`,
        `con`.`shared_count` AS `shared_count`,
        `hashs`.`hashtags` AS `hashtags`
    FROM
        (`view_content_info` `con`
        LEFT JOIN `view_content_hashtag` `hashs` ON ((`con`.`content_id` = `hashs`.`content_id`)))