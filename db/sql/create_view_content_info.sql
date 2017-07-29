CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_content_info` AS
    SELECT 
        `cntlst`.`user_id` AS `user_id`,
        `c`.`content_id` AS `content_id`,
        `ctype`.`content_type_name` AS `content_type_name`,
        `c`.`content_title` AS `content_title`,
        `c`.`content_path` AS `content_path`,
        `c`.`comments` AS `comments`,
        `c`.`upload_date` AS `upload_date`,
        `c`.`modified_date` AS `modified_date`,
        `c`.`view_count` AS `view_count`,
        `c`.`shared_count` AS `shared_count`
    FROM
        ((`content` `c`
        JOIN `content_list` `cntlst`)
        JOIN `content_type` `ctype`)
    WHERE
        ((`c`.`content_id` = `cntlst`.`content_id`)
            AND (`cntlst`.`content_type_id` = `ctype`.`content_type_id`))