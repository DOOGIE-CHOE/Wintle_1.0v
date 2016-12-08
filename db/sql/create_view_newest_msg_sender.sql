CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_newest_msg_sender` AS
    SELECT 
        `msg`.`user_id` AS `user_id`,
        `msg`.`msg_group_id` AS `msg_group_id`,
        `msg`.`message` AS `message`,
        `msg`.`is_read` AS `is_read`,
        `msg`.`sent_on` AS `sent_on`
    FROM
        (`user_message` `msg`
        JOIN `view_message_group_last_sent` `msg_group_last` ON ((`msg`.`sent_on` = `msg_group_last`.`sent_on`)))