CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_follow_list_info` AS
    SELECT 
        `frl`.`user_id_1` AS `user_id_1`,
        `frl`.`user_id_2` AS `user_id_2`,
        `frl`.`follow_date` AS `follow_date`,
        `u`.`user_name` AS `user_name_1`,
        (SELECT 
                `us`.`user_name`
            FROM
                `user` `us`
            WHERE
                (`us`.`user_id` = `frl`.`user_id_2`)) AS `user_name_2`,
        `up`.`profile_url` AS `profile_url_1`,
        (SELECT 
                `usp`.`profile_url`
            FROM
                `user_profile` `usp`
            WHERE
                (`usp`.`user_id` = `frl`.`user_id_2`)) AS `profile_url_2`,
        `up`.`profile_photo_path` AS `profile_photo_path_1`,
        (SELECT 
                `usp`.`profile_photo_path`
            FROM
                `user_profile` `usp`
            WHERE
                (`usp`.`user_id` = `frl`.`user_id_2`)) AS `profile_photo_path_2`
    FROM
        ((`follow_list` `frl`
        JOIN `user` `u`)
        JOIN `user_profile` `up`)
    WHERE
        ((`frl`.`user_id_1` = `u`.`user_id`)
            AND (`u`.`user_id` = `up`.`user_id`))