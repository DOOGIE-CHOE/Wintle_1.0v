CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_content_hashtag` AS
    SELECT 
        `hlist`.`content_id` AS `content_id`,
        `hlist`.`hashtag_id` AS `hashtag_id`,
        GROUP_CONCAT(`htag`.`tag_name`
            SEPARATOR ',') AS `hashtags`
    FROM
        (`hashtag_list` `hlist`
        JOIN `hashtag` `htag`)
    WHERE
        (`hlist`.`hashtag_id` = `htag`.`hashtag_id`)
    GROUP BY `hlist`.`content_id`