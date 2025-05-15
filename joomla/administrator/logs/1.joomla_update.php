#
#<?php die('Forbidden.'); ?>
#Date: 2025-04-24 06:28:42 UTC
#Software: Joomla! 5.2.6 Stable [ Uthabiti ] 8-April-2025 16:00 GMT

#Fields: datetime	priority clientip	category	message
2025-04-24T06:28:42+00:00	INFO 172.18.0.1	update	Test logging
2025-04-24T06:28:42+00:00	INFO 172.18.0.1	update	Update started by user Admin (875). Old version is 5.2.6.
2025-04-24T06:28:44+00:00	INFO 172.18.0.1	update	Downloading update file from https://update.joomla.org/releases/5.3.0/Joomla_5.3.0-Stable-Update_Package.zip.
2025-04-24T06:28:49+00:00	INFO 172.18.0.1	update	File Joomla_5.3.0-Stable-Update_Package.zip downloaded.
2025-04-24T06:28:50+00:00	INFO 172.18.0.1	update	Starting installation of new version.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Finalising installation.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Start of SQL updates.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	The current database version (schema) is 5.2.3-2025-01-09.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2024-10-13. Query text: ALTER TABLE `#__fields` MODIFY `fieldparams` MEDIUMTEXT NOT NULL;.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2024-10-26. Query text: CREATE TABLE IF NOT EXISTS `#__scheduler_logs` (   `id` int unsigned NOT NULL AU.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2024-12-09. Query text: INSERT INTO `#__action_log_config` (`type_title`, `type_alias`, `id_holder`, `ti.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2025-02-09. Query text: ALTER TABLE `#__action_logs_users` DROP COLUMN `exclude_self` ;.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2025-02-22. Query text: INSERT INTO `#__extensions` (`package_id`, `name`, `type`, `element`, `folder`, .
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2025-03-14. Query text: UPDATE `#__guidedtours` SET `autostart` = 0 WHERE `uid` = 'joomla-whatsnew-5-2';.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2025-03-14. Query text: INSERT INTO `#__guidedtours` (`title`, `description`, `extensions`, `url`, `publ.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Ran query from file 5.3.0-2025-03-14. Query text: INSERT INTO `#__guidedtour_steps` (`title`, `description`, `position`, `target`,.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	End of SQL updates.
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Uninstalling extensions
2025-04-24T06:37:54+00:00	INFO 172.18.0.1	update	Deleting removed files and folders.
2025-04-24T06:38:03+00:00	INFO 172.18.0.1	update	Cleaning up after installation.
2025-04-24T06:38:03+00:00	INFO 172.18.0.1	update	Update to version 5.3.0 is complete.
