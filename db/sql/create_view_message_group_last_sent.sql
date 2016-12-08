CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_message_group_last_sent` AS
    SELECT 
        `user_message`.`msg_group_id` AS `msg_group_id`,
        MAX(`user_message`.`sent_on`) AS `sent_on`
    FROM
        `user_message`
    GROUP BY `user_message`.`msg_group_id`