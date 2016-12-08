CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `view_newest_message` AS
    SELECT 
        `nst_msg`.`user_id` AS `sender_id`,
        `msg`.`user_id` AS `receiver_id`,
        `nst_msg`.`msg_group_id` AS `msg_group_id`,
        `nst_msg`.`message` AS `message`,
        `nst_msg`.`is_read` AS `is_read`,
        `nst_msg`.`sent_on` AS `sent_on`
    FROM
        (`view_newest_msg_sender` `nst_msg`
        LEFT JOIN `message_list` `msg` ON (((`nst_msg`.`msg_group_id` = `msg`.`msg_group_id`)
            AND (`nst_msg`.`user_id` <> `msg`.`user_id`))))